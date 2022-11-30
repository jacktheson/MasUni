<?php

interface Visitor {
	public function visit(File $f);
}

class OutputHTMLVisitor implements Visitor {
	public function visit(File $f) {
		echo $f->toHTML();
	}
}