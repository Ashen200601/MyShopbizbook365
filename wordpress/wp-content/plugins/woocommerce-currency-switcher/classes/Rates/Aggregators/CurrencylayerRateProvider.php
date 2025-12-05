<?php

namespace WOOCS\Rates\Aggregators;

include_once WOOCS_PATH . 'classes/Rates/Aggregators/RateProvider.php';

/**
 * CurrencylayerRateProvider
 *
 * @author Pavlo
 */
class CurrencylayerRateProvider extends RateProvider {
	
	public function __construct( string $base, string $key = '') {
		parent::__construct($base, $key);
		$this->name = \esc_html__('Currency layer', 'woocommerce-currency-switcher');
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
		$urlFormat = 'http://apilayer.net/api/live?source=%s&currencies=%s&access_key=%s&format=1';
		
		return sprintf($urlFormat, $this->base, $to, $this->key);
	}
	
	protected function parseResponse( $currency_data, string $to): float {
		$rate = -1;
		try {		

			if (isset($currency_data['quotes']) && $currency_data['quotes'][$this->base . $to]){
				$rate = $currency_data['quotes'][$this->base . $to];
			} elseif(isset($currency_data['error']) && isset($currency_data['error']['type']) ) {
				$this->setError(sprintf(esc_html__("Aggregator Error:%s", 'woocommerce-currency-switcher'), $currency_data['error']['type']));			
			} else {
				$this->setError(sprintf(esc_html__("no data for %s", 'woocommerce-currency-switcher'), $to));	
			}
	
		} catch (Exception $e) {
			$this->setError(\esc_html__('It looks like the aggregator server sent an incorrect response.', 'woocommerce-currency-switcher') . $to );
		}
		return $rate;
	}
}
