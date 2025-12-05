<?php

namespace WOOCS\Rates\Aggregators;

include_once WOOCS_PATH . 'classes/Rates/Aggregators/RateProvider.php';
/**
 * MnbRateProvider
 *
 * @author Pavlo
 */
class MnbRateProvider extends RateProvider {
	
	public function __construct( string $base, string $key = '' ) {
		parent::__construct($base, $key);
		$this->name = \esc_html__('MNB', 'woocommerce-currency-switcher');	
	}
	
	protected function getApiUrl( string $to ) : string {
		return 'http://www.mnb.hu/arfolyamok.asmx?wsdl';
	}
	
	protected function doRequest(string $url) {
		
		$client = new \SoapClient($url);
		$response = $client->GetCurrentExchangeRates(null)->GetCurrentExchangeRatesResult;
		return $response;
	}
	
	protected function parseResponse( $response, string $to ): float {
		$rate = -1;
		try {
			$xml = \simplexml_load_string($response);
			$rate_base = 0;
			$rate_curr = 0;
			if ('HUF' == $to ) {
				$rate_curr = 1;
			}
			foreach ($xml->Day->Rate as $rate_elm) {
				if ((string) $rate_elm->attributes()->curr == $this->base && 'HUF' != $this->base ) {
					$rate_base = (int) $rate_elm->attributes()->unit / (float) str_replace(',', '.', $rate_elm);
				}
				if ((string) $rate_elm->attributes()->curr == $to && 'HUF' != $to) {
					$rate_curr = (int) $rate_elm->attributes()->unit / (float) str_replace(',', '.', $rate_elm);
				}
			}
			if ('HUF' == $this->base && $rate_curr) {
				$rate = $rate_curr;
			} elseif ($rate_base && $rate_curr) {
				$rate = $rate_curr / $rate_base;
			} else {
				$this->setError(sprintf(esc_html__("no data for %s", 'woocommerce-currency-switcher'), $to));
			}
		} catch ( \Exception $e) {
			$this->setError(\esc_html__('It looks like the aggregator server sent an incorrect response.', 'woocommerce-currency-switcher') . $to );
		}
		return $rate;
	}
}
