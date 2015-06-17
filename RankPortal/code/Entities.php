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

class User extends Entity {
    private $userName;
    private $passwordHash;

    public function __construct($id, $userName, $passwordHash) {
        parent::__construct($id);
        $this->userName = $userName;
        $this->passwordHash = $passwordHash;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function getPasswordHash() {
        return $this->passwordHash;
    }

}

class Product extends Entity {
	private $productName;
	private $vendor;
	private $imagePath;
    private $userId;

    public function __construct($id, $productName, $vendor, $imagePath, $userId) {
        parent::__construct($id);
        $this->productName = $productName;
        $this->vendor = $vendor;
        $this->imagePath = $imagePath;
        $this->userId = $userId;
    }
	
	public function getProductName() {
		return $this->productName;
	}
	
	public function getVendor() {
		return $this->vendor;
	}
	
	public function getImagePath() {
		return $this->imagePath;
	}

    public function getUserId() {
        return $this->userId;
    }

}

class Rating extends Entity {
    private $comment;
    private $rank;
    private $createDate;
    private $productId;

    public function __construct($id, $comment, $rank, $createDate, $productId) {
        parent::__construct($id);
        $this->comment = $comment;
        $this->rank = $rank;
        $this->createDate = $createDate;
        $this->productId = $productId;
    }

    public function getComment() {
        return $this->comment;
    }

    public function getRank() {
        return $this->rank;
    }

    public function getCreateDate() {
        return $this->createDate;
    }

    public function getProductId() {
        return $this->productId;
    }

}