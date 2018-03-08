<?php
require 'vendor/autoload.php';


//routing

$page = 'home';

if (isset($_GET['page'])) {
    $page = $_GET['p'];
}



//BDD

function getArticles() {

    $pdo = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $articles = $pdo->query('SELECT * FROM blog');
    return $articles;

}


//Rendu du template

$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');

$twig = new Twig_Environment($loader, ['cache' => false]);



switch ($page) {
    case 'home':
        echo $twig->render('home.twig', ['articles' => getArticles()]);
        break;

    case 'myself':
        echo $twig->render('myself.twig');
        break;

    default:
        header('HTTP/1.0 404 NOT FOUND');
        echo $twig->render('404.twig');
        break;

}
