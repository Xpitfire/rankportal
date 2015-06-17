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

    /*
    protected function forward($errors = null, $target = '/signup.php') {
        if ($target == null) {
            if (!isset($_REQUEST['page'])) {
                throw new Exception('Missing target for forward.');
            }
            $target = $_REQUEST['page'];
        }

        $_POST['error'] = $errors;
        require($_SERVER['DOCUMENT_ROOT'] . $target);
        exit(0);
    }
    */

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
        } else {
            DataManager::addUser($userName, $password);
            $this->action_login();
        }
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

}