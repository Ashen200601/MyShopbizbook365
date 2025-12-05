<?php

namespace WOOCS\Rates\Aggregators;

include_once WOOCS_PATH . 'classes/Rates/Aggregators/RateProvider.php';

/**
 * Free_converterRateProvider
 *
 * @author Pavlo
 */
class Free_converterRateProvider extends RateProvider {
	
	public function __construct( string $base, string $key = '') {
		parent::__construct($base, $key);
		$this->name = \esc_html__('The Free Currency Converter', 'woocommerce-currency-switcher');	
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
		$urlFormat = 'http://free.currencyconverterapi.com/api/v3/convert?q=%1$s_%2$s&compact=y&apiKey=%3$s';
		return \sprintf($urlFormat, $this->base, $to, $this->key);
	}
	
	protected function parseResponse( $currency_data, string $to): float {
		$rate = -1;
		try {
			$hash = $this->base . "_" . $to;
			if (!empty($currency_data[$hash]['val'])) {
				$rate = $currency_data[$hash]['val'];
			} else {
				$this->setError(\sprintf(\esc_html__("no data for %s", 'woocommerce-currency-switcher'), $to));
			}
	
		} catch (Exception $e) {
			$this->setError(\esc_html__('It looks like the aggregator server sent an incorrect response.', 'woocommerce-currency-switcher') . $to );
		}
		return $rate;
	}
}
