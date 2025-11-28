<?php

declare (strict_types=1);
namespace Syde\Vendor\Inpsyde\PayoneerForWoocommerce\ListSession\ListSession;

use Syde\Vendor\Inpsyde\PayoneerForWoocommerce\Checkout\CheckoutExceptionInterface;
use Syde\Vendor\Inpsyde\PayoneerForWoocommerce\ListSession\Factory\FactoryExceptionInterface;
use Syde\Vendor\Inpsyde\PayoneerForWoocommerce\ListSession\Factory\ListSession\OrderBasedListSessionFactory;
use Syde\Vendor\Inpsyde\PayoneerForWoocommerce\ListSession\Factory\ListSession\WcBasedListSessionFactoryInterface;
use Syde\Vendor\Inpsyde\PayoneerSdk\Api\Entities\ListSession\ListInterface;
use Syde\Vendor\Inpsyde\PayoneerSdk\Api\PayoneerIntegrationTypes;
class ApiListSessionProvider implements ListSessionProvider
{
    /**
     * @var WcBasedListSessionFactoryInterface
     */
    private WcBasedListSessionFactoryInterface $checkoutFactory;
    /**
     * @var OrderBasedListSessionFactory
     */
    private OrderBasedListSessionFactory $listFactory;
    /**
     * @var PayoneerIntegrationTypes::* $integrationType
     */
    private $integrationType;
    /**
     * @var callable
     */
    private $canCreateList;
    /**
     * @var string|null
     */
    private ?string $hostedVersion;
    /**
     * @param WcBasedListSessionFactoryInterface $checkoutFactory
     * @param OrderBasedListSessionFactory $listFactory
     * @param string $integrationType
     * @param callable $canCreateList
     * @param string|null $hostedVersion
     *
     * @psalm-param PayoneerIntegrationTypes::* $integrationType
     */
    public function __construct(WcBasedListSessionFactoryInterface $checkoutFactory, OrderBasedListSessionFactory $listFactory, string $integrationType, callable $canCreateList, string $hostedVersion = null)
    {
        $this->checkoutFactory = $checkoutFactory;
        $this->listFactory = $listFactory;
        $this->integrationType = $integrationType;
        $this->hostedVersion = $hostedVersion;
        $this->canCreateList = $canCreateList;
    }
    /**
     * @param ContextInterface $context
     *
     * @return ListInterface
     *
     * @throws CheckoutExceptionInterface
     * @throws FactoryExceptionInterface
     */
    public function provide(ContextInterface $context): ListInterface
    {
        if (!($this->canCreateList)()) {
            throw new \RuntimeException('Cannot create List session.');
        }
        $order = $context->getOrder();
        if ($order === null) {
            $list = $this->createListFromWcSession($context);
            $context->offsetSet('pristine', \true);
            return $list;
        }
        $list = $this->createListFromOrder($order);
        $context->offsetSet('pristine', \true);
        return $list;
    }
    /**
     * Create a LIST session using WC_Customer and Cart data.
     *
     * @param ContextInterface $context
     *
     * @return ListInterface
     *
     * @throws CheckoutExceptionInterface
     * @throws FactoryExceptionInterface
     */
    protected function createListFromWcSession(ContextInterface $context): ListInterface
    {
        $cart = $context->getCart();
        $customer = $context->getCustomer();
        if ($cart === null) {
            throw new \RuntimeException(sprintf('Cart not found for customer session in %s', __CLASS__));
        }
        if ($customer === null) {
            throw new \RuntimeException(sprintf('WC Customer not found in %s', __CLASS__));
        }
        $totals = $cart->get_total('edit');
        if (!$totals) {
            throw new \RuntimeException(sprintf('Invalid totals amount in %s', __CLASS__));
        }
        return $this->checkoutFactory->createList($customer, $cart, $this->integrationType, $this->hostedVersion);
    }
    /**
     * Create a LIST session using WC_Order data
     *
     * @param \WC_Order $order
     *
     * @return ListInterface
     * @throws FactoryExceptionInterface
     */
    protected function createListFromOrder(\WC_Order $order): ListInterface
    {
        return $this->listFactory->createList($order, $this->integrationType, $this->hostedVersion);
    }
}
