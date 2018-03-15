<?php

require 'controller.php';
require 'vendor/autoload.php';


if (isset($_GET['page'])) {

    $page = $_GET['page'];

    session_start();

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


        case 'addArticle':

            addArticle();
            break;



        case 'admin_connect':

            admin_connect();
            break;



        case 'admin_disconnect':

            admin_disconnect();
            break;




        case 'delete':
            delete();
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
