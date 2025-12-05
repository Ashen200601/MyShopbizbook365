<?php
namespace WOOCS\Rates\Aggregators;

include_once WOOCS_PATH . 'classes/Rates/Aggregators/RateProvider.php';

/**
 * RonRateProvider
 *
 * @author Pavlo
 */
class RonRateProvider extends RateProvider {
	
	public function __construct( string $base, string $key = '' ) {
		parent::__construct($base, $key);
		$this->name = \esc_html__('Ron', 'woocommerce-currency-switcher');
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
		return 'https://www.bnr.ro/nbrfxrates.xml';
	}
	
	protected function parseResponse( $data, string $to ): float {
		$rate = -1;
		try {
            $currency_data = simplexml_load_string($data);
            $rates = array();
			if (empty($currency_data->Body->Cube)) {
				$this->setError(\sprintf(\esc_html__("no data for %s", 'woocommerce-currency-switcher'), $to));
			}
			foreach ($currency_data->Body->Cube->Rate as $xml) {
				$att = (array) $xml->attributes();
				$final['rate'] = (string) $xml;
				$rates[$att['@attributes']['currency']] = floatval($final['rate']);
			}
                //***
			if (!empty($rates) && isset($rates[$to])) {
				if ($this->base != 'RON') {
					if ($to != 'RON') {
						if (isset($rates[$to])) {
							$rate = 1 / floatval($rates[$to] / $rates[$this->base]);
						} else {
							$this->setError(\sprintf(\esc_html__("no data for %s", 'woocommerce-currency-switcher'), $to));
						}
					} else {
						$rate = 1 * ($rates[$this->base]);
					}
				} else {
					if ( $to != 'RON' ) {
						if ($rates[$to] < 1) {
							$rate = 1 / $rates[$to];
						} else {
							$rate = $rates[$to];
						}
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