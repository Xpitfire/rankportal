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

    public static function getProducts() {
        $products = array();

        $conn = self::getConnection();
        $cursor = self::query($conn, "SELECT * FROM products;");
        while ($p = self::fetchObject($cursor))
            $products[] = new Product($p->id, $p->productName, $p->vendor, $p->imagePath, $p->userId);

        self::close($cursor);
        self::closeConnection($conn);

        return $products;
    }

    public static function getProduct($productId) {
        $product = null;

        $conn = self::getConnection();
        $cursor = self::query($conn, "SELECT * FROM products WHERE id = ?;", array("$productId"));
        if ($p = self::fetchObject($cursor))
            $product = new Product($p->id, $p->productName, $p->vendor, $p->imagePath, $p->userId);

        self::close($cursor);
        self::closeConnection($conn);

        return $product;
    }

    public static function getRatings($productId) {
        $ratings = array();

        $conn = self::getConnection();
        $cursor = self::query($conn, "SELECT * FROM ratings WHERE productId = ?;", array("$productId"));
        while ($r = self::fetchObject($cursor))
            $ratings[] = new Rating($r->id, $r->comment, $r->rank, $r->createDate, $r->productId);

        self::close($cursor);
        self::closeConnection($conn);

        return $ratings;
    }

    public static function addComment($productId, $userId, $rank, $comment) {
        $conn = self::getConnection();

        $cursor = self::query(
            $conn,
            "INSERT INTO ratings (comment, rank, productId, userId) VALUES (?, ?, ?, ?);",
            array("$comment", "$rank", $productId, $userId));

        self::close($cursor);
        self::closeConnection($conn);
    }

}