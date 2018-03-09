<?php

require 'controller.php';



if (isset($_GET['page'])) {

    $page = $_GET['page'];

    switch ($page) {
        case 'home':
            home();
            break;


        case 'article':
            article();
            break;


        case 'myself':
            myself();
            break;




        case 'delete':

            if (isset($_GET['id']) && ($admin === 1 )) {
                $id = $_GET['id'];
                deleteArticle($id);

            }
            break;



        default:
            header('HTTP/1.0 404 NOT FOUND');
            echo $twig->render('404.twig');
            break;

    }



}

else {
    echo ("error");
}
