<?php

namespace WOOCS\Rates\Aggregators;

include_once WOOCS_PATH . 'classes/Rates/Aggregators/RateProvider.php';

class EcbRateProvider extends RateProvider {
	
	public function __construct( string $base, string $key = '' ) {
		parent::__construct($base, $key);
		$this->name = \esc_html__('ECB', 'woocommerce-currency-switcher');
	}
               
	protected function getApiUrl( string $to ) : string {	
		return 'http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';
	}
	
	protected function doRequest(string $url) {
		$xml_response = [];
		try {
			$response = \wp_remote_get($url);
			$xml_response = \wp_remote_retrieve_body($response);		
		} catch ( \Exception $e ) {
			$this->setError(\esc_html__('It looks like the aggregator server sent an incorrect response.', 'woocommerce-currency-switcher'));
		}
		return $xml_response;
	}	
	protected function parseResponse( $data, string $to ): float {
		$rate = -1;
		try {
			$currency_data = simplexml_load_string($data);
            $rates = array();
			if (empty($currency_data->Cube->Cube)) {			
				$this->setError(sprintf(esc_html__("no data for %s", 'woocommerce-currency-switcher'), $to));
				return $rate;
			}

			foreach ($currency_data->Cube->Cube->Cube as $xml) {
				$att = (array) $xml->attributes();
				$rates[$att['@attributes']['currency']] = floatval($att['@attributes']['rate']);
			}

			if (!empty($rates)) {
				if ($this->base != 'EUR') {
					if ($to != 'EUR' ) {
						if (isset($rates[$to])) {
							$rate = floatval($rates[$to] / $rates[$this->base]);
						} else {
							$this->setError(sprintf(esc_html__("no data for %s", 'woocommerce-currency-switcher'), $to));
						}
					} else {
						$rate = 1 / $rates[$this->base];
					}
				} elseif(isset($rates[$to])) {
					if ($to != 'EUR') {
						$rate = $rates[$to];
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
