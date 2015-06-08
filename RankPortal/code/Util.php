<?php
function escape($string) {	
	return nl2br(htmlentities($string));
}

function action($action, $params = null) {
	$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : $_SERVER['REQUEST_URI'];
	$res = 'controller.php?action='.rawurlencode($action).'&page='.rawurlencode($page);
	if (is_array($params)) {
		foreach ($params as $name => $value) {
			$res .= '&'.rawurlencode($name).'='.rawurlencode($value);
		}
	}
	echo $res;
}

function redirect($page = null) {
	if ($page == null) {
		$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : $_SERVER['REQUEST_URI'];
	}
	header("Location: $page");
}

class SessionContext {
	private static $isCreated = false;
	
	public static function create() {
		if (!self::$isCreated) {
			self::$isCreated = session_start();
		}
		return self::$isCreated;
	}
}

class PagingResult {
	private $result;
	private $offset;
	private $totalCount;
	
	public function getResult() {
		return $this->result;
	}
	
	public function getOffset() {
		return $this->offset;
	}
	
	public function getTotalCount() {
		return $this->totalCount;
	}
	
	public function getPositionOfFirst() {
		return $this->getOffset() + 1;
	}
	
	public function getPositionOfLast() {
		return $this->getOffset() + sizeof($this->result);
	}
	
	public function __construct($result, $offset, $totalCount) {
		$this->result = $result;
		$this->offset = $offset;
		$this->totalCount = $totalCount;
	}
}