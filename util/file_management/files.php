<?php
interface File {
	// Returns the HTML output that would properly display the file,
	// including any work needed to move the file visible.
	public function toHTML();
	// Returns the index in file ordering that the file should be displayed.
	public function getIndex();
	// Returns the Viewer's name of the file.
	public function getName();
	// Returns the file's permanent path on-server.
	public function getPath();
	// Returns the database entry ID of the file, for use as a final resort
	// for sorting.
	public function getID();
}

class TestFile implements File {
	
	public int $val;
	
	public function __construct(int $val) {
		$this->val = $val;
	}
	
	public function toHTML(){ 
		return $this->val . " ";
	}
	
	public function getIndex(){
		return $this->val;
	}
	
	public function getName(){
		return "a";
	}
	
	public function getPath(){
		return "\\none";
	}

	public function getID(){
		return 42;
	}
	
	public function __toString() {
		return $this->val;
	}
	
}
?>