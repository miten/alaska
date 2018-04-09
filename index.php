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


        case 'advert_comment':

            advert_comment();
            break;



        case 'admin_connect':

            admin_connect();
            break;



        case 'admin_disconnect':

            admin_disconnect();
            break;



        case 'modify_article':
            modify_article();
            break;



        case 'delete_article':
            delete_article();
            break;


        case 'delete_comment':
            delete_comment();
            break;


        case 'order_articles':
            order_articles();
            break;


        default:
            echo $twig->render('error.twig', array('error' => 'Perdu ?'));
            break;

    }



}

else {
    home();

}
