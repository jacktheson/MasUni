<?php
interface FileComparator {
	public function compareTo(File $f1, File $f2);
}

class FileOrderingComparator implements FileComparator {
	public function compareTo(File $f1, File $f2){
		if ($f1->getIndex() != $f2->getIndex()) {
			if($f1->getIndex() < $f2->getIndex()) {
				return -1; 
			} else return 1;
		} 
		$nameOrd = strcmp($f1->getName(), $f2->getName());
		if ($nameOrd != 0) {
			return $nameOrd;
		}
		return ($f1->getID() < $f2->getID()) ? -1 : 1;
	}
}