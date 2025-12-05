<?php
namespace WOOCS\Rates\Aggregators;

include_once WOOCS_PATH . 'classes/Rates/Aggregators/RateProvider.php';

/**
 * PrivatbankRateProvider
 *
 * @author Pavlo
 */
class PrivatbankRateProvider extends RateProvider{
	
	public function __construct( string $base, string $key = '') {
		parent::__construct($base, $key);
		$this->name = \esc_html__('Private Bank', 'woocommerce-currency-switcher');
	}
	
	protected function doRequest( string $url ) {
		$currency_data = [];
		try{
			if (function_exists('curl_init')) {
				$ch = curl_init();

				curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_URL, $url);
				@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

				$res = curl_exec($ch);
				curl_close($ch);
			} else {
				$res = file_get_contents($url);
			}
			$currency_data = json_decode($res, true);		
		} catch ( \Exception $e ) {
			
		}
		return $currency_data;
	}
	
	protected function getApiUrl( string $to ) : string {
		return 'https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5';
	}
	
	protected function parseResponse( $currency_data, string $to): float {
		$rate = -1;
		try {				
            $rates = array();

			if (!empty($currency_data)) {
				foreach ($currency_data as $c) {
					if ($c['base_ccy'] == 'UAH') {
						$rates[$c['ccy']] = floatval($c['sale']);
					}
				}
			}

			if (!empty($rates)) {

				if ($this->base != 'UAH') {
					if ( $to != 'UAH') {
						if ( isset($rates[$to])) {
							$rate = floatval($rates[$this->base] / $rates[$to]);
						} else {
							$this->setError(sprintf(esc_html__("no data for %s", 'woocommerce-currency-switcher'), $to));
						}
					} else {
						$rate = 1 / (1 / $rates[$this->base]);
					}
				} elseif(isset($rates[$to])) {
					if ( $to != 'UAH') {
						$rate = 1 / $rates[$to];
					} else {
						$rate = 1;
					}
				}
			} else {
				$this->setError(sprintf(esc_html__("no data for %s", 'woocommerce-currency-switcher'), $to));
			}
			
			if ($rate < 0) {
				$this->setError(sprintf(esc_html__("no data for %s", 'woocommerce-currency-switcher'), $to));
			}			
		} catch ( \Exception $e) {
			$this->setError(\esc_html__('It looks like the aggregator server sent an incorrect response.', 'woocommerce-currency-switcher') . $to );
		}
		return $rate;
	}
}
