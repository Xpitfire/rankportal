<?php
require_once 'Util.php';
require_once 'ShoppingCart.php';
require_once 'DataManager.php';
require_once 'AuthenticationManager.php';

class Controller {
	private static $instance = false;
	
	public static function getInstance() {
		if (!self::$instance) {
			self::$instance = new Controller();
		}
		return self::$instance;
	}
	
	public function handlePostRequest() {
		if ($_SERVER['REQUEST_METHOD'] != 'POST') {
			throw new Exception('Controller can only handle POST requests.');
		}
		elseif (!isset($_REQUEST['action'])) {
			throw new Exception('Action not specified.');
		}
		
		$method = 'action_'.$_REQUEST['action'];
		return $this->$method();
	}
	
	protected function forward($errors = null, $target = null) {
		if ($target == null) {
			if (!isset($_REQUEST['page'])) {
				throw new Exception('Missing target for forward.');
			}
			$target = $_REQUEST['page'];
		}
		
		require($_SERVER['DOCUMENT_ROOT'] . $target);
		exit(0);
	}
	
	protected function action_addToCart() {
		ShoppingCart::add($_REQUEST['bookId']);
		redirect();
	}
	
	protected function action_removeFromCart() {
		ShoppingCart::remove($_REQUEST['bookId']);
		redirect();
	}
	
	protected function action_placeOrder() {
        $user = AuthenticationManager::getAuthenticatedUser();
        if ($user == null)
            $this->forward(array('Not logged in!'));

		$errors = array();
		
		if (ShoppingCart::size() == 0) {
			$this->forward(array('No items in cart.'));
		}
		
		$nameOnCard = isset($_POST['nameOnCard']) ? trim($_POST['nameOnCard']) : null;
		if ($nameOnCard == null || strlen($nameOnCard) == 0) {
			$errors[] = 'Invalid name on card.';
		}
		$cardNumber = isset($_POST['cardNumber']) ? str_replace(' ', '', $_POST['cardNumber']) : null;
		if ($cardNumber == null || strlen($cardNumber) != 16 || !ctype_digit($cardNumber)) {
			$errors[] = 'Invalid card number. Card number must be 16 digits.';
		}
		
		if (count($errors) > 0) {
			$this->forward($errors);
		}
		
		$orderId = DataManager::createOrder($user, ShoppingCart::getAll(), $nameOnCard, $cardNumber);
		
		ShoppingCart::clear();
		redirect('success.php?orderId='.rawurlencode($orderId));
	}
	
	protected function action_login() {
		if (!AuthenticationManager::authenticate($_REQUEST['userName'], $_REQUEST['password']))
			$this->forward(array('Not logged in!'));
		redirect();
	}
	
	protected function action_logout() {
		AuthenticationManager::signOut();
		redirect();
	}
	
}