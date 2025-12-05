<?php

namespace WOOCS\Rates\Aggregators;

include_once WOOCS_PATH . 'classes/Rates/Aggregators/RateProvider.php';

/**
 * OpenexchangeratesRateProvider
 *
 * @author Pavlo
 */
class OpenexchangeratesRateProvider extends RateProvider {
	
	public function __construct( string $base, string $key = '') {
		parent::__construct($base, $key);
		$this->name = \esc_html__('Open Exchange Rates', 'woocommerce-currency-switcher');
	}
	
	public function getRate(string $to): float {
		$this->resetError();
		if (!$this->key){
			$this->setError(\esc_html__('This aggregator requires a license code', 'woocommerce-currency-switcher'));
			return -1;
		}
		return parent::getRate($to);		
	}
	
	protected function getApiUrl( string $to ) : string {
		$urlFormat = "https://openexchangerates.org/api/latest.json?base=%s&symbolst=%s&app_id=%s";		
		return sprintf($urlFormat, $this->base, $to, $this->key);
	}
	
	protected function parseResponse( $data, string $to): float {
		
		$rate = -1;
		try {

			if (isset($data['error']) && $data['description']){
				$this->setError(sprintf(esc_html__("Aggregator Error:%s", 'woocommerce-currency-switcher'), $data['description']));
				return $rate;
			}
			if (isset($data['rates'][$to])){
				$rate = $data['rates'][$to];
			} else {
				$this->setError(sprintf(esc_html__("no data for %s", 'woocommerce-currency-switcher'), $to));		
			}	
		} catch (Exception $e) {
			$this->setError(\esc_html__('It looks like the aggregator server sent an incorrect response.', 'woocommerce-currency-switcher') . $to );
		}
		return $rate;
	}
}
