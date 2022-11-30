<?php

include_once "./file_management/file_red_black_tree.php";

class Portfolio {
    private FileTree $tree;
    private User $user;

    private static FileFactory $f_fctry = new FileFactory();

    // TODO: Make User class that will contain information about the current session user.
    public function __construct(User $user){
        $this->user = $user;
        $filesFromDb = 
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