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


        case 'post_article':

            post_article();
            break;


        case 'post_comment':

            post_comment();
            break;



        case 'admin_connect':

            admin_connect();
            break;



        case 'admin_disconnect':

            admin_disconnect();
            break;



        case 'delete_article':
            delete_article();
            break;


        case 'delete_comment':
            delete_comment();
            break;


        case 'test':
            test();
            break;




        default:
            header('HTTP/1.0 404 NOT FOUND');
            echo $twig->render('404.twig');
            break;

    }



}

else {
    home();

}
