<?php

namespace WOOCS\Rates\Aggregators;

include_once WOOCS_PATH . 'classes/Rates/Aggregators/RateProvider.php';

/**
 * NatbankRatePrivider
 *
 * @author Pavlo
 */
class NatbankRateProvider extends RateProvider {
	
	public function __construct( string $base, string $key = '' ) {
		parent::__construct($base, $key);
		
		$this->name = \esc_html__('National Bank', 'woocommerce-currency-switcher');		
	}
	
	protected function getApiUrl( string $to ) : string {		
		return 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json';
	}
	
	protected function parseResponse( $data, string $to ): float {
		$rate = -1;
		try {		
			if (!empty($data)) {
				if ( $this->base != 'UAH' ) {

					$def_cur_rate = 0;
					foreach ($data as $item) {
						if ($item["cc"] == $this->base) {
							$def_cur_rate = $item["rate"];
							break;
						}
					}
					if (!$def_cur_rate) {
						$this->setError(\sprintf(\esc_html__("no data for %s", 'woocommerce-currency-switcher'), $to));
					} elseif ($to == 'UAH') {
						$rate = 1 * $def_cur_rate;
					}
					foreach ($data as $item) {
						if ($item["cc"] == $to) {
							if ($to != 'UAH') {
								if (isset($to)) {
									$rate = 1 / floatval($item["rate"] / $def_cur_rate);
								} else {
									$this->setError(\sprintf(\esc_html__("no data for %s", 'woocommerce-currency-switcher'), $to));
								}
							} else {
								$rate = 1 * $def_cur_rate;
							}
						}
					}

				} else {
					if ($to != 'UAH') {
						foreach ($data as $item) {
							if ($item["cc"] == $to) {
								$rate = 1 / $item["rate"];
							}
						}
					} else {
						$rate = 1;
					}
				}
				if ($rate < 0 ){
					$this->setError(\sprintf(\esc_html__("no data for %s", 'woocommerce-currency-switcher'), $to));
				}
			} else {
				$this->setError(\esc_html__('It looks like the aggregator server sent an incorrect response.', 'woocommerce-currency-switcher') . $to );
			}	
		
		} catch ( \Exception $e ) {
			$this->setError(\esc_html__('It looks like the aggregator server sent an incorrect response.', 'woocommerce-currency-switcher') . $to );
		}
		return $rate;
	}
	
}