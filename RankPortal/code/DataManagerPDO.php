<?php
require_once 'Entities.php';

class DataManager {

    private static $__connection;


    // --- Auxiliary Functions

    private static function getConnection() {
        if (!isset(self::$__connection))
            self::$__connection = new PDO('mysql:host=localhost;dbname=rankportal;charset=utf8', 'root', '');
        return self::$__connection;
    }

    private static function query($connection, $query, $parameters = array()) {
        $statement = $connection->prepare($query);
        foreach ($parameters as $name => $value) {
            $statement->bindValue(
                is_int($name) ? $name + 1 : $name,
                $value,
                PDO::PARAM_INT
            );
        }
        $statement->execute();
        return $statement;
    }

    private static function lastInsertId($connection) {
        return $connection->lastInsertId();
    }

    private static function fetchObject($cursor) {
        return $cursor->fetchObject();
    }

    private static function close($cursor) {
        $cursor->closeCursor();
    }

    private static function closeConnection($connection) {
        // nothing to do
    }


    // --- DATA Functions

    public static function getUserForId($userId) {
        $user = null;
        $conn = self::getConnection();
        $userId = intval($userId);

        $cursor = self::query($conn, "SELECT id, userName, passwordHash FROM users WHERE id = ?", array($userId));
        if ($u = self::fetchObject($cursor))
            $user = new User($u->id, $u->userName, $u->passwordHash);

        self::close($cursor);
        self::closeConnection($conn);
        return $user;
    }

    public static function getUserForUserName($userName) {
        $user = null;

        $conn = self::getConnection();
        $cursor = self::query($conn, "SELECT id, userName, passwordHash FROM users WHERE userName LIKE ?;", array("$userName"));
        if ($u = self::fetchObject($cursor))
            $user = new User($u->id, $u->userName, $u->passwordHash);
        self::close($cursor);
        self::closeConnection($conn);

        return $user;
    }

    public static function addUser($userName, $password) {
        $conn = self::getConnection();

        $cursor = self::query($conn, "INSERT INTO users (userName, passwordHash) VALUES (?, ?);", array("$userName", "$password"));

        self::close($cursor);
        self::closeConnection($conn);
    }

}