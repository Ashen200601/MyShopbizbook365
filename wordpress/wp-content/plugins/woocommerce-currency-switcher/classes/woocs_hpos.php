<?php

use Automattic\WooCommerce\Internal\DataStores\Orders\CustomOrdersTableController as HposController;
use Automattic\WooCommerce\Utilities\OrderUtil;

/**
 * WoocsHpos class 
 * 
 * compatibility functionality with new order tables High-Performance Order Storage (HPOS)
 */
class WoocsHpos {

    private $inabled_hpos = null;
	
	private $woocs = null;

    public function __construct( $woocs ) {
		$this->woocs = $woocs;
    }

    /**
     * Checking if the HPOS option is enabled
     * @return bool
     */
    public function isEnabledHpos(): bool {
		if (!class_exists('Automattic\WooCommerce\Utilities\OrderUtil')) {
			$this->inabled_hpos = false;
		}

        if (null === $this->inabled_hpos) {
            if (OrderUtil::custom_orders_table_usage_is_enabled()) {
                $this->inabled_hpos = true;
            } else {
                $this->inabled_hpos = false;
            }
        }

        return $this->inabled_hpos;
    }

    /**
     * Getting the page ID to place the meta box
     * @return string
     */
    public function getOrderScreenId(): string {
        if (!function_exists('wc_get_container') || !class_exists('Automattic\WooCommerce\Utilities\OrderUtil') ) {
            return '';
        }
        $screen = wc_get_container()->get(HposController::class)->custom_orders_table_usage_is_enabled() ? wc_get_page_screen_id('shop-order') : 'shop_order';
        return $screen;
    }

    /**
     * Recalculation of the order to another currency
     * 
     * @param int $order_id
     * @param string $selected_currency
     * @return void
     */
    public function recalculateOrder($order_id, $selected_currency = ''): void {
        if (!$selected_currency) {
            $selected_currency = $this->woocs->default_currency;
        }

        //HPOS
        $order = wc_get_order($order_id);
        $order_currency = $order->get_currency();
        $_woocs_order_rate = $order->get_meta('_woocs_order_rate', true);

        //lets avoid recalculation for order which is already in
        if (strtolower($order_currency) === strtolower($selected_currency) OR empty($order_currency)) {
            return;
        }
		
		$this->updateMetaData($order, $selected_currency);

        //***
        $_order_shipping_total = $order->get_shipping_total();
        $order->set_shipping_total($this->recalculateAmount($_order_shipping_total, $_woocs_order_rate, $selected_currency));			

        $_order_total = $order->get_total();
        $order->set_total($this->recalculateAmount($_order_total, $_woocs_order_rate, $selected_currency));

        $_cart_discount_tax = $order->get_discount_tax();
        $order->set_discount_tax($this->recalculateAmount($_cart_discount_tax, $_woocs_order_rate, $selected_currency));

        $_order_shipping_tax = $order->get_shipping_tax();
        $order->set_shipping_tax($this->recalculateAmount($_order_shipping_tax, $_woocs_order_rate, $selected_currency));

        $_cart_discount = $order->get_discount_total();
        $order->set_discount_total($this->recalculateAmount($_cart_discount, $_woocs_order_rate, $selected_currency));

//***
        //hpos
        $line_items = $order->get_items(['line_item', 'shipping', 'tax', 'coupon']);
        if (!empty($line_items) AND is_array($line_items)) {
            foreach ($line_items as $v) {
                //hpos
                $order_item_id = $v->get_id();
                $order_item_type = $v->get_type();

                switch ($order_item_type) {
                    case 'line_item':

                        $subtotal_amount = $v->get_subtotal();
                        $v->set_subtotal($this->recalculateAmount($subtotal_amount, $_woocs_order_rate, $selected_currency));

                        $total_amount = $v->get_total();
                        $v->set_total($this->recalculateAmount($total_amount, $_woocs_order_rate, $selected_currency));

                        $subtotal_tax_amount = $v->get_subtotal_tax();
                        $v->set_subtotal_tax($this->recalculateAmount($subtotal_tax_amount, $_woocs_order_rate, $selected_currency));

                        $total_tax_amount = $v->get_total_tax();
                        $v->set_total_tax($this->recalculateAmount($total_tax_amount, $_woocs_order_rate, $selected_currency));

                        //hpos
                        $_line_tax_data = $v->get_taxes();
                        if (!empty($_line_tax_data) AND is_array($_line_tax_data)) {
                            foreach ($_line_tax_data as $key => $values) {
                                if (!empty($values)) {
                                    if (is_array($values)) {
                                        foreach ($values as $k => $value) {
                                            if (is_numeric($value)) {
												$_line_tax_data[$key][$k]= $this->recalculateAmount($value, $_woocs_order_rate, $selected_currency);
                                            }
                                        }
                                    } else {
                                        if (is_numeric($values)) {
											$_line_tax_data[$key] = $this->recalculateAmount($values, $_woocs_order_rate, $selected_currency);
                                        }
                                    }
                                }
                            }
                        }
                        //hpos
                        $v->set_taxes($_line_tax_data);

                        break;

                    case 'shipping':

                        $total_amount = $v->get_total();
                        $v->set_total($this->recalculateAmount($total_amount, $_woocs_order_rate, $selected_currency));
						
                        //hpos
                        $taxes = $v->get_taxes();
                        if (!empty($taxes) AND is_array($taxes)) {
                            foreach ($taxes as $key => $values) {
                                if (!empty($values)) {
                                    if (is_array($values)) {
                                        foreach ($values as $k => $value) {
                                            if (is_numeric($value)) {
												$taxes[$key][$k] = $this->recalculateAmount($value, $_woocs_order_rate, $selected_currency);
                                            }
                                        }
                                    } else {
                                        if (is_numeric($values)) {
											$taxes[$key] = $this->recalculateAmount($values, $_woocs_order_rate, $selected_currency);
                                        }
                                    }
                                }
                            }
                        }
                        //hpos
                        $v->set_taxes($taxes);
                        break;

                    case 'tax':

                        $tax_total_amount = $v->get_tax_total();
                        $v->set_tax_total($this->recalculateAmount($tax_total_amount, $_woocs_order_rate, $selected_currency));

                        $shipping_tax_total_amount = $v->get_shipping_tax_total();
                        $v->set_shipping_tax_total($this->recalculateAmount($shipping_tax_total_amount, $_woocs_order_rate, $selected_currency));

                        break;
						
					case 'coupon':
						
						$coupon_discount = $v->get_discount(); // Discount amount
						$v->set_discount($this->recalculateAmount($coupon_discount, $_woocs_order_rate, $selected_currency));
						
						
						$coupon_discount_tax  = $v->get_discount_tax();	
						$v->set_discount_tax($this->recalculateAmount($coupon_discount_tax, $_woocs_order_rate, $selected_currency));						

                    default:
                        break;
                }
                $v->save();
            }
        }

//***

        $refunds = $order->get_refunds();
        $order->calculate_taxes();
        if (!empty($refunds)) {
            foreach ($refunds as $refund) {
                $post_id = 0;

                if (method_exists($refund, 'get_id')) {
                    $post_id = $refund->get_id();
                } else {
                    $post_id = $refund->id;
                }

                $amount = $refund->get_amount();
                $refund->set_amount($this->recalculateAmount($amount, $_woocs_order_rate, $selected_currency));

                $amount = $refund->get_total();
                $refund->set_total($this->recalculateAmount($amount, $_woocs_order_rate, $selected_currency));
				
                $refund->set_currency($selected_currency);
                $refund->save();
            }
        }
        $order->save();
    }
	
	public function recalculateAmount($amount, $current_order_rate, $currency_to) {
		
		$decimals = $this->woocs->get_currency_price_num_decimals($currency_to, $this->woocs->price_num_decimals);
		$val = $this->woocs->back_convert($amount, $current_order_rate, $decimals);
		$currencies = $this->woocs->get_currencies();
		
		if ($currency_to !== $this->woocs->default_currency) {
			$val = floatval($val) * floatval($currencies[$currency_to]['rate']);
		}	
		
		return $val;
	}

	public function updateMetaData( $order, $currency_to ){
		
        $currencies = $this->woocs->get_currencies();

        $order->set_currency( $currency_to );
        $order->update_meta_data('_woocs_order_currency', $currency_to);
        $order->update_meta_data('_woocs_order_base_currency', $this->woocs->default_currency);
        $order->update_meta_data('_woocs_order_rate', floatval($currencies[$currency_to]['rate']));
        $order->update_meta_data('_woocs_order_currency_changed_mannualy', time());
	}
	
}
