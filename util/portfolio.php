<?php

include_once "./file_managment/file_comparator.php";
include_once "./file_management/file_red_black_tree.php";
include_once "./file_management/files.php";
include_once "./file_management/visitor.php";

class Portfolio {
    private FileTree $tree;
    private str $name;

    public function __construct($filesFromDB){

    }

    public function displayPortfolio(){
        $this->tree->inorder(new OutputHTMLVisitor());
    }
}
?>