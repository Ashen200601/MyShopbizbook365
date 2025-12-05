<?php

namespace WOOCS\Rates\Aggregators;

include_once WOOCS_PATH . 'classes/Rates/Aggregators/RateProvider.php';

/**
 * Bank_polskiRatePrivider
 *
 * @author Pavlo
 */
class Bank_polskiRateProvider extends RateProvider{
	
	public function __construct( string $base, string $key = '' ) {
		parent::__construct($base, $key);
		$this->name = \esc_html__('Bank Polski', 'woocommerce-currency-switcher');	
	}
	
	protected function getApiUrl( string $to ) : string {
        $table = apply_filters('woocs_bank_polski_table', 'A');		
		return 'http://api.nbp.pl/api/exchangerates/tables/' . $table;
	}
	
	protected function parseResponse( $data, string $to ): float {
		$rate = -1;
		try {
			$rates = array();
			if (!empty($data[0])) {
				foreach ($data[0]['rates'] as $c) {
					$rates[$c['code']] = floatval($c['mid']);
				}
			}
			if (!empty($rates)) {
				if ($this->base != 'PLN') {
					if ($to != 'PLN') {
						if (isset($rates[$to]) ) {
							$rate = floatval($rates[$this->base] / ($rates[$to]));
						} else {
							$this->setError(sprintf(esc_html__("no data for %s", 'woocommerce-currency-switcher'), $to));
						}
					} else {
						$rate = 1 / (1 / $rates[$this->base]);
					}
				} else {
					if ($to != 'PLN') {
						$rate = 1 / $rates[$to];
					} else {
						$rate = 1;
					}
				}
			} else {
				$this->setError(sprintf(esc_html__("no data for %s", 'woocommerce-currency-switcher'), $to));
			}
	
		} catch ( \Exception $e ) {
			$this->setError(\esc_html__('It looks like the aggregator server sent an incorrect response.', 'woocommerce-currency-switcher') . $to );
		}
		return $rate;
	}
}
