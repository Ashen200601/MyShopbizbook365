<?php

namespace WOOCS\Rates\Aggregators;

include_once WOOCS_PATH . 'classes/Rates/Aggregators/RateProvider.php';


/**
 * FixerRateProvider
 *
 * @author Pavlo
 */
class FixerRateProvider extends RateProvider {
	
	public function __construct( string $base, string $key = '') {
		parent::__construct($base, $key);
		$this->name = \esc_html__('Currency API', 'woocommerce-currency-switcher');	
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
		$urlFormat = 'http://data.fixer.io/api/latest?base=%1$s&symbolst=%2$s&access_key=%3$s';
		return sprintf($urlFormat, $this->base, $to, $this->key);
	}
	
	protected function parseResponse( $data, string $to): float {
		$rate = -1;
		try {
			if (isset($data['error']) && $data['error']['type']){
				$this->setError(sprintf(esc_html__("Aggregator Error:%s", 'woocommerce-currency-switcher'), $data['error']['type']));
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
