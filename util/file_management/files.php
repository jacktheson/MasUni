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

abstract class FileImplementation implements File {

	protected $filePath;
	protected $fileID;
	protected $filePosition;
	protected $fileName;

	public function __construct($fileID, $fileName, $filePosition, $filePath){
		$this->fileID = $fileID;
		$this->fileName = $fileName;
		$this->filePosition = $filePosition;
		$this->filePath = $filePath;
	}

	public function getName(){
		return $this->fileName;
	}

	public function getPath(){
		return $this->filePath;
	}

	public function getIndex() {
		return $this->filePosition;
	}

	public function getID() {
		return $this->fileID;
	}
}

class ImageFile extends FileImplementation {
	public function toHTML() {
		$image = "../../MasUni/" . $this->filePath;
		// Read image path, convert to base64 encoding
		$imageData = base64_encode(file_get_contents($image));

		// Format the image SRC:  data:{mime};base64,{data};
		$src = 'data: '.mime_content_type($image).';base64,'.$imageData;

		// Echo out a sample image
		echo '<center><img src="' . $src . '"></center>';
		
	}
}

class VideoFile extends FileImplementation {

	public function toHTML() {

		$vid = "../../MasUni/" . $this->filePath;
		// Read video path, convert to base64 encoding
		$vidData = base64_encode(file_get_contents($vid));
		
		// Format the video SRC:  data:{mime};base64,{data};
		$src = 'data: '.mime_content_type($vid).';base64,'.$vidData;
		
		// Echo out a sample video
		echo '<center><video width="600" controls> <source src="' . $src . '"></center>';
		
	}
}

class TestFile implements File {
	
	public $val;

	public function __construct($val) {
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
		return $this->val->__toString();
	}
	
}

class FileFactory {
	public static function build(DisplayStudent $student, $fileInfo) {
		$stuFolder = $student->getFilepath() . "/";
		switch ($fileInfo["media_type"]) {
			case "image":
				return new ImageFile(
					$fileInfo["fileID"],
					$fileInfo["display_name"],
					$fileInfo["position"],
					$stuFolder . $fileInfo["file_name"]
				);
			case "video":
				return new VideoFile(
					$fileInfo["fileID"],
					$fileInfo["display_name"],
					$fileInfo["position"],
					$stuFolder . $fileInfo["file_name"]
				);
			case "pdf":
				return new PDFFile(
					$fileInfo["fileID"],
					$fileInfo["display_name"],
					$fileInfo["position"],
					$stuFolder . $fileInfo["file_name"]
				);
			default:
				return null;
		}
	}
}