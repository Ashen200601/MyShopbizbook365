<?php

namespace WOOCS\Rates\Aggregators;

include_once WOOCS_PATH . 'classes/Rates/Aggregators/RateProvider.php';

/**
 * Free_ecbRateProvider
 *
 * @author Pavlo
 */
class RfRateProvider extends RateProvider {
	
	public function __construct( string $base, string $key = '' ) {
		parent::__construct($base, $key);
		$this->name = \esc_html__('RF', 'woocommerce-currency-switcher');                
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
	
	protected function getApiUrl( string $to ) : string {
		$urlFormat = 'http://www.cbr.ru/scripts/XML_daily_eng.asp?date_req=%1$s';
        $date = date('d/m/Y');
		return sprintf($urlFormat, $date);
	}
	
	protected function parseResponse( $data, string $to ): float {
		$rate = -1;
		try {
			$xml = \simplexml_load_string($data);
            $xml = $this->objectToArray($xml);
            $rates = array();
            $nominal = array();
//***
			if (isset($xml['Valute'])) {
				if (!empty($xml['Valute'])) {
					foreach ($xml['Valute'] as $value) {
						$rates[$value['CharCode']] = floatval(str_replace(',', '.', $value['Value']));
						$nominal[$value['CharCode']] = $value['Nominal'];
					}
				}
			}

			if (!empty($rates)) {
				if ($this->base != 'RUB') {
					if ($to != 'RUB') {
						if (isset($rates[$to])) {
							$rate = $nominal[$to] * floatval($rates[$this->base] / $rates[$to] / $nominal[$this->base]);
						} else {
							$this->setError(\sprintf(\esc_html__("no data for %s", 'woocommerce-currency-switcher'), $to));
						}
					} else {
						if ($nominal[$this->base] >= 10) {
							$rate = (1 / (1 / $rates[$this->base])) / $nominal[$this->base];
						} else {
							$rate = 1 / (1 / $rates[$this->base]);
						}
					}
				} else {
					if ($to != 'RUB') {
						$rate = $nominal[$to] / $rates[$to];
					} else {
						$rate = 1;
					}
				}
			} else {
				$this->setError(\sprintf(\esc_html__("no data for %s", 'woocommerce-currency-switcher'), $to));
			}
	
		} catch ( \Exception $e ) {
			$this->setError(\esc_html__('It looks like the aggregator server sent an incorrect response.', 'woocommerce-currency-switcher') . $to );
		}
		return $rate;
	}
	
    private function objectToArray($object) : array {
		$data = json_decode(json_encode($object), 1);
        return $data ? $data : array();
    }	
}
