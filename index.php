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
            if ($_SERVER['REQUEST_METHOD'] === 'GET' AND (!empty($_GET['id']))) {
                $id = $_GET['id'];
                article($id);
            }
            else {
                error('Article introuvable');
            }

            break;



        case 'post_article':
            if (isset($_SESSION['statut']) && $_SESSION['statut'] === true) {
                post_article();
            }
            else {
                error('Seul l\'administrateur peut accèder a cette page');
            }
            break;




        case 'modify_article':
            if (isset($_SESSION['statut']) && $_SESSION['statut'] === true) {
                modify_article();
            }
            else {
                error('Seul l\'administrateur peut effectuer cette action');
            }
            break;




        case 'delete_article':
            if (isset($_SESSION['statut']) && $_SESSION['statut'] === true) {
                delete_article();
            }
            else {
                error('Seul l\'administrateur peut effectuer cette action');
            }
            break;




        case 'post_comment':

            post_comment();
            break;



        case 'delete_comment':

            if (isset($_SESSION['statut']) && $_SESSION['statut'] === true) {
                delete_comment();
            }
            else {
                error('Seul l\'administrateur peut effectuer cette action');
            }
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



        case 'myself':
            myself();
            break;


        case 'test':
            test();
            break;





        default:
            error('perdu ?');
            break;

    }

}

else {
    home();

}
