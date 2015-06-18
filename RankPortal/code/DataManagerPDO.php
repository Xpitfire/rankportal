<?php
require_once 'Entities.php';

class DataManager {

    private static $__connection;


    // --- Auxiliary Functions

    private static function getConnection() {
        if (!isset(self::$__connection)) {
            self::$__connection = new PDO('mysql:host=localhost;dbname=rankportal;charset=utf8', 'root', '');
        }
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
            $ratings[] = new Rating($r->id, $r->comment, $r->rank, $r->createDate, $r->productId, $r->userId);

        self::close($cursor);
        self::closeConnection($conn);

        return $ratings;
    }

    public static function getRating($ratingId) {
        $rating = null;

        $conn = self::getConnection();
        $cursor = self::query($conn, "SELECT * FROM ratings WHERE id = ?;", array("$ratingId"));
        if ($r = self::fetchObject($cursor))
            $rating = new Rating($r->id, $r->comment, $r->rank, $r->createDate, $r->productId, $r->userId);

        self::close($cursor);
        self::closeConnection($conn);

        return $rating;
    }

    public static function deleteRating($ratingId) {
        $conn = self::getConnection();

        $cursor = self::query($conn, "DELETE FROM ratings WHERE id = ?;", array($ratingId));

        self::close($cursor);
        self::closeConnection($conn);
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

    public static function addProduct($productName, $vendor, $userId, $imagePath = 'img/placeholder.png') {
        $conn = self::getConnection();

        $cursor = self::query(
            $conn,
            "INSERT INTO products (productName, vendor, imagePath, userId) VALUES (?, ?, ?, ?);",
            array("$productName", "$vendor", "$imagePath", $userId));

        $productId = self::lastInsertId($conn);

        self::close($cursor);
        self::closeConnection($conn);

        return $productId;
    }

    public static function deleteProduct($productId) {
        $conn = self::getConnection();

        $cursor = self::query($conn, "DELETE FROM products WHERE id = ?;", array($productId));

        self::close($cursor);
        self::closeConnection($conn);
    }

    public static function hasSubmittedRating($userId, $productId) {
        $ratings = array();

        $conn = self::getConnection();
        $cursor = self::query($conn, "SELECT * FROM ratings WHERE userId = ? AND productId = ?;", array("$userId", "$productId"));
        if ($r = self::fetchObject($cursor))
            $ratings[] = new Rating($r->id, $r->comment, $r->rank, $r->createDate, $r->productId, $r->userId);

        self::close($cursor);
        self::closeConnection($conn);

        return count($ratings) > 0;
    }

    public static function getProductsForSearchCriteriaWithPaging($productName, $skip, $take) {
        $conn = self::getConnection();

        $cursor = self::query($conn, "SELECT COUNT(*) AS cnt FROM products WHERE productName LIKE ?;", array("%$productName%"));
        $totalCount = self::fetchObject($cursor)->cnt;
        self::close($cursor);

        $products = array();
        $skip = intval($skip);
        $take = intval($take);
        $cursor = self::query($conn, "SELECT * FROM products WHERE productName LIKE ? LIMIT ?, ?;", array("%$productName%", $skip, $take));
        while ($product = self::fetchObject($cursor))
            $products[] = new Product($product->id, $product->productName, $product->vendor, $product->imagePath, $product->userId);

        self::close($cursor);
        self::closeConnection($conn);

        return new PagingResult($products, $skip, $totalCount);
    }


}