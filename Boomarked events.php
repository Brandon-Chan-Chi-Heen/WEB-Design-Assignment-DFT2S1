<?php require_once('add bookmarked.php'); ?>
<html>
    
    <head>
        <meta name =" viewport" content="width=device-width, initial-scale=1.0">
        <title> Show Bookmarks event
        </title>
        <link href="style1.css" rel="stylesheet" type="text/css" />
    </head>
    
    <body>
        <?php require_once(''); ?>
        <?php require_once(''); ?>
        <main>
            
            <div id="main">
                <?php
                if(isset($_SESSION['bookmarks event'])){
                    foreach($_SESSION['bookmarks event']as $item)
                }
            </div>
        </main>
    </body>
</html>

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author User
 */
class newPHPClass {
    //put your code here
}
