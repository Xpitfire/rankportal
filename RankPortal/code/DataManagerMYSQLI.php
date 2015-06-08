<?php
require_once 'Entities.php';

class DataManager {

    // --- Auxiliary Functions

    private static function getConnection() {
        $conn = new mysqli('localhost', 'root', '', 'bookshop');
        if (mysqli_connect_errno())
            die('Unable to connect to database.');
        return $conn;
    }

    private static function query($connection, $query) {
        $res = $connection->query($query);
        if (!$res)
            die("Error in query $query: " . $connection->error);
        return $res;
    }

    private static function lastInsertId($connection) {
        return mysqli_insert_id($connection);
    }

    private static function fetchObject($cursor) {
        return $cursor->fetch_object();
    }

    private static function close($cursor) {
        $cursor->close();
    }

    private static function closeConnection($connection) {
        $connection->close();
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
        $categoryId = intval($categoryId);
        $cursor = self::query($conn, "SELECT id, categoryId, title, author, price FROM books WHERE categoryId = $categoryId;");

        while ($book = self::fetchObject($cursor))
            $books[] = new Book($book->id, $book->categoryId, $book->title, $book->author, $book->price);

        self::close($cursor);
        self::closeConnection($conn);

        return $books;
    }

    public static function getBooksForSearchCriteriaWithPaging($title, $skip, $take) {
        $conn = self::getConnection();

        $title = $conn->real_escape_string($title);
        $cursor = self::query($conn, "SELECT COUNT(*) AS cnt FROM books WHERE title LIKE '%$title%';");
        $totalCount = self::fetchObject($cursor)->cnt;
        self::close($cursor);

        $books = array();
        $skip = intval($skip);
        $take = intval($take);
        $cursor = self::query($conn, "SELECT id, categoryId, title, author, price FROM books WHERE title LIKE '%$title%' LIMIT $skip, $take;");
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
        $nameOnCard = $conn->real_escape_string($nameOnCard);
        $cardNumber = $conn->real_escape_string($cardNumber);
        self::query($conn, "INSERT INTO orders (userId, creditCardNumber, creditCardHolder) VALUES ($userId, '$cardNumber', '$nameOnCard');");
        $orderId = self::lastInsertId($conn);

        foreach ($bookIds as $bookId) {
            $bookId = intval($bookId);
            self::query($conn, "INSERT INTO orderedBooks (orderId, bookId) VALUES ($orderId, $bookId);");
        }

        self::query($conn, 'COMMIT;');
        self::closeConnection($conn);

        return $orderId;
    }

    public static function getUserForId($userId) {
        $user = null;
        $conn = self::getConnection();
        $userId = intval($userId);

        $cursor = self::query($conn, "SELECT id, userName, passwordHash FROM users WHERE id = $userId");
        if ($u = self::fetchObject($cursor))
            $user = new User($u->id, $u->userName, $u->passwordHash);

        self::close($cursor);
        self::closeConnection($conn);
        return $user;
    }

    public static function getUserForUserName($userName) {
        $user = null;

        $conn = self::getConnection();
        $userName = $conn->real_escape_string($userName);
        $cursor = self::query($conn, "SELECT id, userName, passwordHash FROM users WHERE userName LIKE '$userName';");
        if ($u = self::fetchObject($cursor))
            $user = new User($u->id, $u->userName, $u->passwordHash);
        self::close($cursor);
        self::closeConnection($conn);

        return $user;
    }
}