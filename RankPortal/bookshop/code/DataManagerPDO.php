<?php
require_once 'Entities.php';

class DataManager {

    private static $__connection;

    // --- Auxiliary Functions

    private static function getConnection() {
        if (!isset(self::$__connection))
            self::$__connection = new PDO('mysql:host=localhost;dbname=bookshop;charset=utf8', 'root', '');
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

    public static function getCategories() {
        $categories = array();

        $conn = self::getConnection();
        $cursor = self::query($conn, "SELECT id, name FROM categories;");
        while ($cat = self::fetchObject($cursor))
            $categories[] = new Category($cat->id, $cat->name);
        self::close($cursor);
        self::closeConnection($conn);

        return $categories;
    }

    public static function getBooksForCategory($categoryId) {
        $books = array();

        $conn = self::getConnection();
        $cursor = self::query($conn, "SELECT id, categoryId, title, author, price FROM books WHERE categoryId = ?;", array($categoryId));

        while ($book = self::fetchObject($cursor))
            $books[] = new Book($book->id, $book->categoryId, $book->title, $book->author, $book->price);

        self::close($cursor);
        self::closeConnection($conn);

        return $books;
    }

    public static function getBooksForSearchCriteriaWithPaging($title, $skip, $take) {
        $conn = self::getConnection();

        $cursor = self::query($conn, "SELECT COUNT(*) AS cnt FROM books WHERE title LIKE ?;", array("%$title%"));
        $totalCount = self::fetchObject($cursor)->cnt;
        self::close($cursor);

        $books = array();
        $skip = intval($skip);
        $take = intval($take);
        $cursor = self::query($conn, "SELECT id, categoryId, title, author, price FROM books WHERE title LIKE ? LIMIT ?, ?;", array("%$title%", $skip, $take));
        while ($book = self::fetchObject($cursor))
            $books[] = new Book($book->id, $book->categoryId, $book->title, $book->author, $book->price);

        self::close($cursor);
        self::closeConnection($conn);

        return new PagingResult($books, $skip, $totalCount);
    }

    public static function createOrder($userId, $bookIds, $nameOnCard, $cardNumber) {
        $conn = self::getConnection();

        self::query($conn, 'BEGIN;');

        $userId = intval($userId);
        self::query($conn, "INSERT INTO orders (userId, creditCardNumber, creditCardHolder) VALUES (?, ?, ?);", array($userId, "$cardNumber", "$nameOnCard"));
        $orderId = self::lastInsertId($conn);

        foreach ($bookIds as $bookId) {
            $bookId = intval($bookId);
            self::query($conn, "INSERT INTO orderedBooks (orderId, bookId) VALUES (?, ?);", array($orderId, $bookId));
        }

        self::query($conn, 'COMMIT;');
        self::closeConnection($conn);

        return $orderId;
    }

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
}