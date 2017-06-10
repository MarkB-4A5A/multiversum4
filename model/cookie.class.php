<?php

class CookieHandler {
	public $cookieName;

	public function __construct($cookieName) {
		$this->cookieName = $cookieName;
	}

	public function cookieIsset() {
		//Checks if the cookie with this name had been set, if not it returns false.
		if(isset($_COOKIE[$this->cookieName])) {
			return true;
		} else {
			return false;
		}
	}

	public function SetCookie($array) {
		//Sets cookie with an enitial value
		//if the cookie had not been set before, its setting a new cookie
		if(!$this->cookieIsset()) {
			$cookieValue = serialize($array);
			SetCookie($this->cookieName, $cookieValue, time() + 100000000000);
		} else {
			return false;
		}
	}

	public function readCookie() {
		// Returns a array with all the values in this cookie (In array form not serialized form)
		return unserialize($_COOKIE[$this->cookieName]);
	}

	public function readCookieItem($itemValue) {
		$cookieValue = unserialize($_COOKIE[$this->cookieName][$itemValue]);
		if(isset($cookieValue))	 {
			return unserialize($_COOKIE[$this->cookieName][$itemValue]);
		} else {
			return false;
		}
		
	}

	public function deleteCookieItem($index) {
		// Deletes specific cookie value in the array
		if($this->cookieIsset()){
			$currentCookie = unserialize($_COOKIE[$this->cookieName]);

			foreach($currentCookie as $key => $value) {
				if(array_key_exists($index, $currentCookie) || $key == $index) {
					unset($currentCookie[$index]);
				}
			}

			$updatedCookie = serialize($currentCookie);
			setCookie($this->cookieName, $updatedCookie, time() + 100000000000);
		} else {
			return 0;
		}
	}

	public function deleteMultipleCookieItems($array) {
		$currentCookie = unserialize($_COOKIE[$this->cookieName]);

		foreach($currentCookie as $key => $value) {
			foreach($array as $index) {
				if($key == $index) {
					unset($currentCookie[$index]);
				}		
			}
		}

		setCookie($this->cookieName, $currentCookie, time() + 100000000000);		
	}

	public function updateCookie($array) {
		// updates the cookie by unserializing the cookie,then adding the array to te cookie, then serializing back and returning the result (wich is in serialized form so you need to but ut back to actually read it.).

		//unserialize the cookie value so we can add more items to the array.
		$currentCookie = unserialize($_COOKIE[$this->cookieName]);
		
		//Add the items to the cookie value.
		foreach($array as $key => $value) {
			$currentCookie[$key] = $value;
		}

		//serialize the updated array back so we can use it to store it in the cookie
		$updatedCookie = serialize($currentCookie);

		//set the new cookie (wich is now replaced and set again.)
		setCookie($this->cookieName, $updatedCookie, time() + 100000000000);

		//Return the updated array so you can use it.
		return $updatedCookie;
	}

	public function unsetCookie() {
		setCookie($this->cookieName, '', time() - 1000000);		
	}
}