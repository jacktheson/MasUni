<?php
include_once "file_comparator.php";
include_once "files.php";
include_once "visitor.php";

class Node {
	public $left = null;
	public $right = null;
	public $color;
	public $val;
	
	const RED = true;
	const BLACK = false;

	public function __construct(File $nval){
		$this->val = $nval;
		$this->color = self::RED;
		$this->left = null;
		$this->right = null;
	}
	
	public function isRed(){
		return $this->color == self::RED;
	}
	
	public function setBlack() {
		$this->color = self::BLACK;
	}
	
	public function setRed() {
		$this->color = self::RED;
	}

	public function __toString() {
		return $this->val->__toString() . " " . strval($this->color);
	}
}

class FileTree 
{
	
	private $root = null;
	private $comp;
	
	public function __construct(FileComparator $compare){
		$this->root = null;
		$this->comp = $compare;
	}
	
	public function insert(File $f) {
		$this->root = $this->__insert($this->root, $f);
		$this->root->setBlack();
	}
	
	function __insert(Node $parent = null, File $file){
		if ($parent === null){
			return new Node($file);
		}
		
		$compVal = $this->comp->compareTo($file, $parent->val);
		if ($compVal < 0) {
			$parent->left = $this->__insert($parent->left, $file);
		} else if ($compVal > 0) {
			$parent->right = $this->__insert($parent->right, $file);
		} else {
			$parent->val = $file;
		}
		
		if ($this->__isRed($parent->right) and !($this->__isRed($parent->left))){
			$parent = $this->__rotateLeft($parent);
		}
		if ($this->__doubleRed($parent->left)) {
			$parent = $this->__rotateRight($parent);
		}
		if ($this->__isRed($parent->left) and $this->__isRed($parent->right)) {
			$parent = $this->__flipColor($parent);
		}
		
		return $parent;
	}
	
	function __flipColor(Node $n) {
		$n->setRed();
		if ($n->left !== null) $n->left->setBlack();
		if ($n->right!== null) $n->right->setBlack();
		return $n;
	}
	
	function __doubleRed(Node $n = null){
		if ($n === null) { return false; }
		return $this->__isRed($n) and $this->__isRed($n->left);
	}
	
	function __isRed(Node $n = null) {
		if ($n === null) {
			return false;
		}
		return $n->isRed();
	}
	
	function __rotateLeft(Node $n) {
		$newRoot = $n->right;
		$n->right = $newRoot->left;
		$newRoot->left = $n;
		
		$newRoot->color = $n->color;
		$n->setRed();
		return $newRoot;
	}
	
	function __rotateRight(Node $n){
		$newRoot = $n->left;
		$n->left = $newRoot->right;
		$newRoot->right = $n;
		
		$newRoot->color = $n->color;
		$n->setRed();
		return $newRoot;
	}
	
	public function inorder(Visitor $v) {
		$this->__inorder($v, $this->root);
	}
	
	function __inorder(Visitor $v, Node $r = null){
		if ($r === null) return;
		$this->__inorder($v, $r->left);
		$v->visit($r->val);
		$this->__inorder($v, $r->right);
		
	}

	public static function OrderingTree(){
		return new FileTree(new FileOrderingComparator());
	}
}