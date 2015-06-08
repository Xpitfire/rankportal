<?php 

class Entity {
	private $id;
	
	public function getId() {
		return $this->id;
	}
	
	public function __construct($id) {
		$this->id = $id;
	}
}

class Category extends Entity {
	private $name;
	
	public function getName() {
		return $this->name;
	}
	
	public function __construct($id, $name) {
		parent::__construct($id);
		$this->name = $name;
	}
}

class Book extends Entity {
	private $categoryId;
	private $title;
	private $author;
	private $price;
	
	public function getCategoryId() {
		return $this->categoryId;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function getAuthor() {
		return $this->author;
	}
	
	public function getPrice() {
		return $this->price;
	}
	
	public function __construct($id, $categoryId, $title, $author, $price) {
		parent::__construct($id);
		$this->categoryId = $categoryId;
		$this->title = $title;
		$this->author = $author;
		$this->price = $price;
	}
}

class User extends Entity {
	private $userName;
	private $passwordHash;
	
	public function getUserName() {
		return $this->userName;
	}
	
	public function getPasswordHash() {
		return $this->passwordHash;
	}
	
	public function __construct($id, $userName, $passwordHash) {
		parent::__construct($id);
		$this->userName = $userName;
		$this->passwordHash = $passwordHash;
	}
}