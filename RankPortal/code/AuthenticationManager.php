<?php
require_once 'Util.php';
require_once 'DataManager.php';

SessionContext::create();

class AuthenticationManager {
	
	public static function authenticate($userName, $password) {
		$user = DataManager::getUserForUserName($userName);
		if ($user != null && $user->getPasswordHash() == self::calculateHash($userName, $password)) {
			$_SESSION['user'] = $user->getId();
			return true;
		}
		self::signOut();
		return false;
	}

    public static function calculateHash($userName, $password) {
        return hash('sha1', "$userName|$password");
    }
	
	public static function signOut() {
		unset($_SESSION['user']);
	}
	
	public static function isAuthenticated() {
		return isset($_SESSION['user']);
	}
	
	public static function getAuthenticatedUser() {
		return self::isAuthenticated() ? DataManager::getUserForId($_SESSION['user']) : null;
	}
	
}