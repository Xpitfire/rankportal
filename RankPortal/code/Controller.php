<?php
require_once 'Util.php';
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

    protected function action_signup() {
        $user = AuthenticationManager::getAuthenticatedUser();
        if ($user != null)
            $this->forward(array('User already logged in!'));

        $errors = array();

        $userName = isset($_POST['userName']) ? trim($_POST['userName']) : null;
        if ($userName == null || strlen($userName) == 0 || DataManager::getUserForUserName($userName) != null) {
            $errors[] = 'Invalid username or username already in use!';
        }

        $password = isset($_POST['password']) ? trim($_POST['password']) : null;
        if ($password == null || strlen($password) < 6) {
            $errors[] = 'Invalid password! Password must be at least 6 digits long.';
        }
        $password = AuthenticationManager::calculateHash($userName, $password);

        if (count($errors) > 0) {
            $this->forward($errors);
        }

        DataManager::addUser($userName, $password);
        $this->action_login();
    }

    protected function action_login() {
        if (!AuthenticationManager::authenticate($_REQUEST['userName'], $_REQUEST['password']))
            $this->forward(array('No username entry found! SignUp or login with another user.'));
        redirect();
    }

    protected function action_logout() {
        AuthenticationManager::signOut();
        redirect();
    }

    protected function action_showDetails() {
        $errors = array();

        $productId = isset($_REQUEST['productId']) ? trim($_REQUEST['productId']) : null;
        if ($productId == null || strlen($productId) == 0 || !ctype_digit($productId)) {
            $errors[] = 'Invalid product id.';
        }

        if (count($errors) > 0) {
            $this->forward($errors);
        }

        redirect('details.php?productId='.rawurlencode($productId));
    }

    protected function action_addRating() {
        $errors = array();

        $productId = isset($_REQUEST['productId']) ? trim($_REQUEST['productId']) : null;
        if ($productId == null || strlen($productId) == 0 || !ctype_digit($productId)) {
            $errors[] = 'Invalid product id.';
        }

        $userId = isset($_REQUEST['userId']) ? trim($_REQUEST['userId']) : null;
        if ($userId == null || strlen($userId) == 0) {
            $errors[] = 'Invalid user id.';
        }

        $rank = isset($_REQUEST['rank']) ? trim($_REQUEST['rank']) : null;
        if ($userId == null || strlen($rank) == 0 || !ctype_digit($rank) || $rank < 0 || $rank > 5) {
            $errors[] = 'Invalid rank number! Must be a number between 1 and 5.';
        }

        $comment = (isset($_POST['comment']) || (strlen($_POST['comment']) == 0)) ? trim($_POST['comment']) : null;

        if (count($errors) > 0) {
            $this->forward($errors);
        }

        DataManager::addComment($productId, $userId, $rank, $comment);

        redirect('details.php?productId='.rawurlencode($productId));
    }

    protected function action_addProduct() {
        $errors = array();

        $productName = isset($_POST['productName']) ? trim($_POST['productName']) : null;
        if ($productName == null || strlen($productName) == 0) {
            $errors[] = 'Invalid product name.';
        }

        $vendor = isset($_POST['vendor']) ? trim($_POST['vendor']) : null;
        if ($vendor == null || strlen($vendor) == 0) {
            $errors[] = 'Invalid vendor name.';
        }

        $userId = isset($_REQUEST['userId']) ? trim($_REQUEST['userId']) : null;
        if ($userId == null || strlen($userId) == 0 || !ctype_digit($userId)) {
            $errors[] = 'Invalid user id.';
        }

        $imagePath = isset($_POST['imagePath']) ? trim($_POST['imagePath']) : null;

        if (count($errors) > 0) {
            $this->forward($errors);
        }

        $productId = ($imagePath == null || strlen($imagePath) == 0) ? DataManager::addProduct($productName, $vendor, $userId) :
            DataManager::addProduct($productName, $vendor, $userId, $imagePath);

        redirect('success.php?productId='.rawurlencode($productId));
    }

    protected function action_deleteProduct() {
        $user = AuthenticationManager::getAuthenticatedUser();
        if ($user == null)
            $this->forward(array('User not logged in!'));

        $errors = array();

        $productId = isset($_REQUEST['productId']) ? trim($_REQUEST['productId']) : null;
        if ($productId == null || strlen($productId) == 0 || !ctype_digit($productId)) {
            $errors[] = 'Invalid product id';
        }

        if (count($errors) > 0) {
            $this->forward($errors);
        }

        $product = DataManager::getProduct($productId);

        if ($product == null || $product->getUserId() != $user->getId()) {
            $errors[] = 'Authentication error! Cannot delete products from other users!';
            $this->forward($errors);
        }

        DataManager::deleteProduct($productId);
        redirect('products.php');
    }

    protected function action_deleteRating() {
        $user = AuthenticationManager::getAuthenticatedUser();
        if ($user == null)
            $this->forward(array('User not logged in!'));

        $errors = array();

        $ratingId = isset($_REQUEST['ratingId']) ? trim($_REQUEST['ratingId']) : null;
        if ($ratingId == null || strlen($ratingId) == 0 || !ctype_digit($ratingId)) {
            $errors[] = 'Invalid rating id';
        }

        $productId = isset($_REQUEST['productId']) ? trim($_REQUEST['productId']) : null;
        if ($productId == null || strlen($productId) == 0 || !ctype_digit($productId)) {
            $errors[] = 'Invalid product id';
        }

        if (count($errors) > 0) {
            $this->forward($errors);
        }

        $rating = DataManager::getRating($ratingId);

        if ($rating == null || $rating->getUserId() != $user->getId()) {
            $errors[] = 'Authentication error! Cannot delete rating from other users!';
            $this->forward($errors);
        }

        DataManager::deleteRating($ratingId);
        redirect('details.php?productId='.rawurlencode($productId));
    }

}