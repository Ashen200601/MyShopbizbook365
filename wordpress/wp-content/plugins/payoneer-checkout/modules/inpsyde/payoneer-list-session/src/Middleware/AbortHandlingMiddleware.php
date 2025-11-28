<?php

declare (strict_types=1);
namespace Syde\Vendor\Inpsyde\PayoneerForWoocommerce\ListSession\Middleware;

use Syde\Vendor\Inpsyde\PayoneerForWoocommerce\Checkout\CheckoutExceptionInterface;
use Syde\Vendor\Inpsyde\PayoneerForWoocommerce\Checkout\HashProvider\CheckoutHashProvider;
use Syde\Vendor\Inpsyde\PayoneerForWoocommerce\ListSession\ListSession\ContextInterface;
use Syde\Vendor\Inpsyde\PayoneerForWoocommerce\ListSession\ListSession\ListSessionProvider;
use Syde\Vendor\Inpsyde\PayoneerForWoocommerce\ListSession\ListSession\ListSessionProviderMiddleware;
use Syde\Vendor\Inpsyde\PayoneerSdk\Api\Command\ResponseValidator\InteractionCodeFailureInterface;
use Syde\Vendor\Inpsyde\PayoneerSdk\Api\Entities\ListSession\ListInterface;
/**
 * This middleware prevents new tries to create a LIST session when the first try failed with
 * the ABORT response code.
 *
 * For classic and block checkouts, it prevents new tries until the same WooCommerce session
 * is used with the same total amount, country and currency.
 *
 * For Pay for Order page, it prevents new tries during the same HTTP request only. The reasoning
 * behind this is that this may cause us just a few List creation tries: it may happen when
 * Pay for Order page is used, and we receive ABORT, and the page is reloaded
 * (since there is no AJAX checkout updates on that page). So this sub-sub-subset of cases doesn't
 * worth adding extra logic and storing extra data.
 */
class AbortHandlingMiddleware implements ListSessionProviderMiddleware
{
    protected const LIST_ABORTED_CHECKOUT_HASH_KEY = 'payoneer_checkout_list_aborted_checkout_hash';
    protected array $listCreationFailedFromOrders = [];
    protected CheckoutHashProvider $checkoutHashProvider;
    public function __construct(CheckoutHashProvider $checkoutHashProvider)
    {
        $this->checkoutHashProvider = $checkoutHashProvider;
    }
    /**
     * @param ContextInterface $context
     * @param ListSessionProvider $next
     *
     * @return ListInterface
     *
     * @throws CheckoutExceptionInterface
     */
    public function provide(ContextInterface $context, ListSessionProvider $next): ListInterface
    {
        $order = $context->getOrder();
        if ($order !== null) {
            return $this->provideBasedOnOrder($order, $context, $next);
        }
        return $this->provideBasedOnWcSession($context, $next);
    }
    /**
     * @param \WC_Order $order
     * @param ContextInterface $context
     * @param ListSessionProvider $next
     *
     * @return ListInterface
     * @throws \Exception
     */
    protected function provideBasedOnOrder(\WC_Order $order, ContextInterface $context, ListSessionProvider $next): ListInterface
    {
        if (in_array($order->get_id(), $this->listCreationFailedFromOrders, \true)) {
            throw new \RuntimeException('Rejecting LIST session creation because previous try with the same order got "ABORT"');
        }
        try {
            return $next->provide($context);
        } catch (\Exception $exception) {
            if ($this->isAbortException($exception)) {
                /**
                 * todo: consider persisting this ID somewhere, maybe in transients.
                 *      Another option is to add to order meta a hash of amount, currency
                 *      and country, similarly to what we do for checkout cases.
                 */
                $this->listCreationFailedFromOrders[] = $order->get_id();
            }
            throw $exception;
        }
    }
    /**
     * @param ContextInterface $context
     * @param ListSessionProvider $next
     *
     * @return ListInterface
     *
     * @throws CheckoutExceptionInterface
     */
    protected function provideBasedOnWcSession(ContextInterface $context, ListSessionProvider $next): ListInterface
    {
        $failedCheckoutHash = wc()->session->get(self::LIST_ABORTED_CHECKOUT_HASH_KEY);
        if ($failedCheckoutHash === $this->checkoutHashProvider->provideHash()) {
            throw new \RuntimeException('Rejecting LIST session creation because previous try with the same checkout hash got "ABORT"');
        }
        try {
            return $next->provide($context);
        } catch (\Exception $exception) {
            if ($this->isAbortException($exception)) {
                wc()->session->set(self::LIST_ABORTED_CHECKOUT_HASH_KEY, $this->checkoutHashProvider->provideHash());
            }
            throw $exception;
        }
    }
    protected function isAbortException(\Throwable $exception): bool
    {
        do {
            $previous = $exception->getPrevious();
            $exception = $previous ?: $exception;
        } while ($previous instanceof \Throwable);
        return $exception instanceof InteractionCodeFailureInterface && $exception->getInteractionCode() === 'ABORT';
    }
}
