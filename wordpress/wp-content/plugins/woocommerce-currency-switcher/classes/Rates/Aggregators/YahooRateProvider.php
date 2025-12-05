<?php

namespace WOOCS\Rates\Aggregators;

include_once WOOCS_PATH . 'classes/Rates/Aggregators/RateProvider.php';

/**
 * Yahoo provider
 *
 * @author Pavlo
 */
class YahooRateProvider extends RateProvider {
	
	public function __construct( string $base, string $key = '' ) {
		parent::__construct($base, $key);
		$this->name = \esc_html__('Yahoo', 'woocommerce-currency-switcher');
	}
	
	protected function getApiUrl( string $to ) : string {
		$urlFormat = 'https://query1.finance.yahoo.com/v8/finance/chart/%1$s%2$s=X?symbol=%1$s%2$s&period1=%3$d&period2=%4$d'
				. '&interval=1d&includePrePost=false&lang=en-US&region=US&corsDomain=finance.yahoo.com';
		$date = time();
		return sprintf($urlFormat, $this->base,  $to, $date - 60 * 86400 , $date);
	}
	
	protected function parseResponse( $data, string $to ): float {
		$rate = -1;
		try {
			$result = isset($data['chart']['result'][0]['indicators']['quote'][0]['open']) ? $data['chart']['result'][0]['indicators']['quote'][0]['open'] : ( isset($data['chart']['result'][0]['meta']['previousClose']) ? array($data['chart']['result'][0]['meta']['previousClose']) : array() );

			if (count($result) && is_array($result)) {
				$rate = end($result);
			} else {
				$this->setError(\esc_html__('There is no data for these currencies:', 'woocommerce-currency-switcher') . $this->base . "/" . $to  );
			}		
		} catch ( \Exception $e ) {
			$this->setError(\esc_html__('It looks like the aggregator server sent an incorrect response.', 'woocommerce-currency-switcher') . $to );
		}
		return $rate;
	}
	
}
