<?php
/**
* Appie is a class enabling you to access the unofficial Appie (Albert Heijn) API
*
* Example usage:
* $appie = new Appie();
* $appie->login("email@email.com","password");
* $appie->addProduct("Icecream");
*
* @author   Ivo Hunink <hunink.ivo@gmail.com>
* @version  $Revision: 1.0 $
* @access   public
* @see      https://github.com/ivohunink/ 
*/
class Appie {
	private $cookieJar = "";
	private $isLoggedIn = false;
	
	/**
	* Create a new Appie
	*
	* @return (Appie) A new Appie 
	*/
	public function __construct(){
		$this->cookieJar = tempnam('/tmp','ah-cookie');
	}

	/*
	 * function login
	 *
	 * Logs into the Appie API. 
	 * @param (string) $username the user's email address which serves as username
	 * @param (string) $password the password
	 * 
	 * @return Returns (True) when logged in successfully, or (False) when the login attempt was unsuccessful.
	 */
	public function login($username, $password){
		if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
			trigger_error('Appie API: Supplied username "'.$username.'" is not a valid email address', E_USER_WARNING);
		}

		# Prepare and call Appie API
		$url = "https://www.ah.nl/service/loyalty/rest/tokens";
		$data = array (
			'password' => $password,
			'username' => $username,
			'domain' => 'NLD',
			'type' => 'password'
		);
		$response = $this->callAppieAPI($url, $data);

		# Check response
		if($response !== false) {
			if(isset($response->clientId)){
				$this->isLoggedIn = true;
			}
		}
		if(!$this->isLoggedIn){
			trigger_error("Appie API: Not logged in because an invalid username or password was used", E_USER_WARNING);	
		}
		
		# Return
		return $this->isLoggedIn;
	}
	
	/*
	 * function addProduct
	 *
	 * Adds a product to your Appie shopping list. Before you use this function, make sure you're logged in.
	 *
	 * @param (string) $productName The product name of the product you would like to add to your shopping list.
	 * 
	 * @return Returns (True) when the product was added successfully, or (False) when the product wasn't added.
	 */
	public function addProduct ($productName) {
		if ($productName == "") {
			trigger_error('Appie API: No product name supplied', E_USER_WARNING);
			return false;
		}

		$productAddedSuccessful = false;
	
		# Check if user is logged in
		if($this->isLoggedIn){
			# Prepare and call Appie API
			$url = "https://www.ah.nl/service/rest/shoppinglists/0/items";
			$data = '{"quantity":1,"type":"UNSPECIFIED","label":"PROCESSING_UNSPECIFIED","item":{"description":"'.$productName.'"}}';
			$response = $this->callAppieAPI($url, $data);

			# Check response
			if($response !== false) {
				if(isset($response->id)){
					$productAddedSuccessful = true;
				}
			}
		} else {
			trigger_error("Appie API: Before adding a product, please ensure you're logged into Appie", E_USER_WARNING);	
		}
	
		# Return
		return $productAddedSuccessful;
	}

	/*
	 * function getProducts
	 *
	 * Stub for getting products.
	 *
	 * @return Returns (Array) products when successful, or (False) when products couldnt be retreived.
	 */
	public function getProduct () {
		$products = false;
	
		# Check if user is logged in
		if($this->isLoggedIn){
			# Prepare and call Appie API
			$url = "<TODO>"; //TODO
			$data = "<TODO>"; //TODO
			$response = $this->callAppieAPI($url, $data);

			# Check response
			if($response !== false) {
				if(isset($response->id)){ //TODO
					$products = true;
				}
			}
		} else {
			trigger_error("Appie API: Before adding a product, please ensure you're logged into Appie", E_USER_WARNING);	
		}
	
		# Return
		return $products;
	}

	/*
	 * function callAppieAPI
	 *
	 * Calls Appie's API.
	 *
	 * @param (string) $url The Appie API URL to call
	 * @param (Array or string) $data The data (as Array or JSON string) to feed to the Appie API
	 * 
	 * @return Appie's API response as JSON object if the call was successful, or returns (False) is the call was unsuccessful.
	 */
	private function callAppieAPI($url, $data){
		$returnValue = false;

		# Prepare headers for cURL
		$headers = ['Content-Type: application/json'];

		# Prepare JSON
		$jsonData = "";
		if (is_array($data)){
			$jsonData = json_encode($data);
		} else {
			$jsonData = $data;
		}
		
		# Initialize cURL
		$ch = curl_init($url);

		# Set options for cURL
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieJar);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieJar);
		
		# Execute cURL
		$result = curl_exec($ch);
		if (curl_error($ch)) {
			trigger_error("Appie API: cURL error " . curl_error($ch), E_USER_WARNING);	
		} else {
			$returnValue = json_decode($result);
			if($returnValue === null) {
				trigger_error("Appie API: Unvalid JSON response for '$url'. The unofficial Appie API might have changed. Please inform Ivo Hunink via https://github.com/ivohunink/appie-php-api)", E_USER_WARNING);	
			}
		}

		# Close cURL
		curl_close($ch);
	
		# Return	
		return $returnValue;
	}
}
?>
