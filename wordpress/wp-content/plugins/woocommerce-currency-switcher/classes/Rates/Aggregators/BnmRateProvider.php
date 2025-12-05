<?php

namespace WOOCS\Rates\Aggregators;

include_once WOOCS_PATH . 'classes/Rates/Aggregators/RateProvider.php';

/**
 * BnmRateProvider
 *
 * @author Pavlo
 */
class BnmRateProvider extends RateProvider{
	
	public function __construct( string $base, string $key = '' ) {
		parent::__construct($base, $key);
		$this->name = \esc_html__('Bnm', 'woocommerce-currency-switcher');
	}
	
	protected function getApiUrl( string $to ) : string {	
		return sprintf('http://www.bnm.md/en/official_exchange_rates?get_xml=1&date=%s', date('d.m.Y'));
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
			$currencies_data = simplexml_load_string($data);
			if (isset($currencies_data->Valute)) {

				$rate1 = 0;
				$rate2 = 0;
				if ('MDL' == $to) {
					$rate2 = 1;
				}
				foreach ($currencies_data->Valute as $xml_item) {
					if ($xml_item->CharCode == $to && 'MDL' != $to) {
						$rate2 = $xml_item->Nominal / $xml_item->Value;
					}
					if ($xml_item->CharCode == $this->base && 'MDL' != $this->base) {
						$rate1 = $xml_item->Nominal / $xml_item->Value;
					}
				}
				if ('MDL' == $this->base && $rate2) {
					$rate = $rate2;
				} elseif ($rate2 && $rate1) {
					$rate = $rate2 / $rate1;
				} else {
					$this->setError(sprintf(esc_html__("no data for %s", 'woocommerce-currency-switcher'), $to ));
				}
			}
			
		} catch ( \Exception $e ) {
			$this->setError(\esc_html__('It looks like the aggregator server sent an incorrect response.', 'woocommerce-currency-switcher') . $to );
		}
		return $rate;
	}
}
