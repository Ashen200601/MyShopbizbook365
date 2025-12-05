<?php

namespace WOOCS\Rates;

/**
 * Control rates
 *
 * @author Pavlo
 */
class ExchangeRateLimiter {
	
	private $ratesFloor = null;
	
	private $ratesCeiling = null;
	
	private string $floorKey = 'woocs_rate_floor';
	
	private string $ceilingKey = 'woocs_rate_ceiling';
	
	public function __construct() {
		add_action('woocs_before_settings_update', array($this, 'updateRateLimites'));
	}
	
	public function getValidatedRate ( $rate, string $currency) : float {
		
		$floor = $this->getFloorByCurrency($currency);
		$ceiling = $this->getCeilingByCurrency($currency);
		
		if ($floor !== null && (float)$rate < $floor) {
			$rate = $floor;
		}
		
		if ($ceiling !== null && (float)$rate > $ceiling) {
			$rate = $ceiling;
		}
		
		return (float)$rate;
	}

	public function getFloorByCurrency( string $currency) {
		$floorLimites = $this->getRatesFloor();
		if (isset($floorLimites[$currency]) && $floorLimites[$currency] > 0 ){
			return (float)$floorLimites[$currency];
		}
		return null;
	}

	public function getCeilingByCurrency( string $currency) {
		$ceilingLimites = $this->getRatesCeiling();
		if (isset($ceilingLimites[$currency]) && $ceilingLimites[$currency] > 0 ){
			return (float)$ceilingLimites[$currency];
		}
		return null;
	}
	
	public function  updateRateLimites() : void {
		if(isset($_POST[$this->floorKey])) {
			update_option($this->floorKey, wc_clean($_POST[$this->floorKey]), false);
		}
		if(isset($_POST[$this->ceilingKey])) {
			update_option($this->ceilingKey, wc_clean($_POST[$this->ceilingKey]), false);
		}				
	}
	
	private function getRatesFloor() : array {
		if ($this->ratesFloor === null) {
			$this->ratesFloor = get_option($this->floorKey, []);
		}
		
		return $this->ratesFloor;
	}

	private function getRatesCeiling() : array {
		if ($this->ratesCeiling === null) {
			$this->ratesCeiling = get_option($this->ceilingKey, []);
		}
		return $this->ratesCeiling;
	}
	
	public function getFloorKey() : string {
		return $this->floorKey;
	} 

	public function getCeilingKey() : string {
		return $this->ceilingKey;
	} 	
	
}
