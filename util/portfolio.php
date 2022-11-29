<?php

include_once "./file_managment/file_comparator.php";
include_once "./file_management/file_red_black_tree.php";
include_once "./file_management/files.php";
include_once "./file_management/visitor.php";

class Portfolio {
    private FileTree $tree;
    private User $user;

    private static FileFactory $f_fctry = new FileFactory();

    // TODO: Make User class that will contain information about the current session user.
    public function __construct(User $user, $filesFromDB){
        $this->user = $user;
        while ($row = $filesFromDB-> fetch_assoc())
        {
            $file = this->f_fctry->build($row);
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