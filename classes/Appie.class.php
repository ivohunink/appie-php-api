<?php
	class Appie {
		private $username = "";
		private $password = "";
		private $cookies = array();
		private $logged_in = false;
		
		/**
		* Call this method to get singleton
		*
		* @return (Appie) singleton.
		*/
		public static function Instance(){
			static $inst = null;
			if ($inst === null) {
				$inst = new Appie();
			}
			return $inst;
		}

		protected function __clone(){}

		private function __construct(){}
	}
?>
