<?php
class CheChe {
	private $mmc;
	public function CheChe() {
		$this->mmc = memcache_init ();
	}
	public function statue() {
		return $this->mmc;
	}
	public function getvalue() {
		return memcache_get ( $this->mmc, "floor" );
		;
	}
	public function setvalue($key, $value) {
		memcache_set ( $this->mmc, '{$key}', '{$value}' );
	}
	public function play($keyword) {
		if ($this->getvalue ()) {
			switch ($keyword) {
				case '上楼' :
					$value = memcache_get ( $this->mmc, 'floor' ) + 1;
					memcache_set ( $this->mmc, 'floor', '{$value}' );
					return true;
				case '下楼' :
					$value = memcache_get ( $this->mmc, 'floor' ) - 1;
					memcache_set ( $this->mmc, 'floor', '{$value}' );
					return true;
				default :
					return false;
			}
		} else {
			if ($keyword == "上楼游戏") {
				if (memcache_get ( $this->mmc, "floor" ) != 1) {
					return true;
				} else {
					$this->setvalue ( "floor", 1 );
					return false;
				}
			}
		}
	}
}

?>