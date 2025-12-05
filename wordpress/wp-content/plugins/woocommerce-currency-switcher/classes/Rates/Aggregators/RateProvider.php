<?php

namespace WOOCS\Rates\Aggregators;

/**
 * Abstract class for rate aggregator
 *
 * @author Pavlo
 */
abstract class RateProvider {
	
	protected string $name = '';
	protected string $lastError = '';
	protected string $base = '';
	protected string $key = '';


	public function __construct( string $base, string $key = ''){
		$this->base = $base;
		$this->key = $key;
	}
	
	public function getRate( string $to ) : float {
		$this->resetError();
		$url = $this->getApiUrl( $to );
		$response = $this->doRequest( $url );
		return $this->parseResponse( $response, $to );
	}
	
	public function getName(): string {
		return $this->name;
	}
	
	protected function doRequest( string $url ) {
		$data = [];
		try {
			$response = \wp_remote_get($url);
			$json_response = \wp_remote_retrieve_body($response);
			$data = json_decode($json_response, true);	
		} catch ( \Exception $e ) {
			$this->setError(\esc_html__('It looks like the aggregator server sent an incorrect response.', 'woocommerce-currency-switcher'));
		}
		
		return $data;
	}
	abstract protected function parseResponse( $response, string $to ) : float;
	abstract protected function  getApiUrl(string $to) : string;
	protected function setError(string $m) {
		$this->lastError = $m;
	}
	public function resetError() {
		$this->lastError = '';
	}
	public function getLastError(): string {
		return $this->lastError;
	}
}
