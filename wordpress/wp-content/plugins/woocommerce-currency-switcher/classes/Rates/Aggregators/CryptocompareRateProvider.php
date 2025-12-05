<?php

namespace WOOCS\Rates\Aggregators;

include_once WOOCS_PATH . 'classes/Rates/Aggregators/RateProvider.php';

/**
 * CryptocompareRateProvider
 *
 * @author Pavlo
 */
class CryptocompareRateProvider extends RateProvider {
	
	public function __construct( string $base, string $key = '' ) {
		parent::__construct($base, $key);
		$this->name = \esc_html__('Crypto Compare', 'woocommerce-currency-switcher');
	}
	
	protected function getApiUrl( string $to ) : string {
		$urlFormat = 'https://min-api.cryptocompare.com/data/price?fsym=%s&tsyms=%s';		
		return sprintf($urlFormat, $this->base,  $to );
	}
	
	protected function parseResponse( $data, string $to ): float {
		
		$rate = -1;
		try {
			if(isset($data['Response']) &&  'Error' == $data['Response'] && $data["Message"]){
				$this->setError(sprintf(esc_html__("Aggregator Error:%s", 'woocommerce-currency-switcher'), $data["Message"]));
				return $rate;				
			}
			if (count($data) && isset($data[$to])) {
				$rate = $data[$to];
			} else {
				$this->setError(\sprintf(\esc_html__("no data for %s", 'woocommerce-currency-switcher'), $to));
			}		
		} catch ( \Exception $e ) {
			$this->setError(\esc_html__('It looks like the aggregator server sent an incorrect response.', 'woocommerce-currency-switcher') . $to );
		}
		return $rate;
	}
	
}