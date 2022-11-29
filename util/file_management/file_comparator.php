<?php
interface FileComparator {
	public function compareTo(File $f1, File $f2);
}

class FileOrderingComparator implements FileComparator {
	public function compareTo(File $f1, File $f2){
		$indOrd = $f1->getIndex() <=> $f2->getIndex();
		if ($indOrd != 0) {
			return $indOrd;
		} 
		$nameOrd = strcmp($f1->getName(), $f2->getName());
		if ($nameOrd != 0) {
			return $nameOrd;
		}
		return $f1->getID() <=> $f2->getID();
	}
}
?>