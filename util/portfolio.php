<?php

include_once "file_management/file_red_black_tree.php";
include_once "database_checks.php";

class Portfolio {
    private $tree;
    private $student;

    // TODO: Make User class that will contain information about the current session user.
    public function __construct(DisplayStudent $student){
        $this->student = $student;
        $this->tree = FileTree::OrderingTree();
        $filesFromDB = queryDisplayFileList($this->student);
        if ($filesFromDB == null) { 
            return;
        }
        while ($row = $filesFromDB->fetch_assoc())
        {
            $file = FileFactory::build($this->student, $row);
            if ($file !== null) {
                $this->tree->insert($file);
            }            
        }
    }

    public function displayPortfolio(){
        // Add any decorators here that need to surround the HTML output.
        $this->tree->inorder(new OutputHTMLVisitor());
    }

    
}
?>