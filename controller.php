<?php

require 'vendor/autoload.php';
require 'model.php';

$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
$twig= new Twig_Environment($loader, ['cache' => false]);



function home(){
    global $twig;
    if (isset($_SESSION)) {
        $twig->addGlobal("session", $_SESSION);
    }
    $articles = getArticles();

    echo $twig->render('articles.twig', array('articles' => $articles));
}


function article(){
    global $twig;
    if (isset($_SESSION)) {
        $twig->addGlobal("session", $_SESSION);
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $article = getArticle($id);
        $commmentaires = getCommentaires($id);

        echo $twig->render('article.twig', array('article' => $article,'commentaires' => $commmentaires));

    }
}



function addArticle() {
    global $twig;
    if (isset($_SESSION)) {
        $twig->addGlobal("session", $_SESSION);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    addArticlee($_POST['titre'], $_POST['texte']);
    }

    echo $twig->render('AddArticle.twig');

}


function myself(){
    global $twig;
    if (isset($_SESSION)) {
        $twig->addGlobal("session", $_SESSION);
    }

    echo $twig->render('aboutme.twig');
}


function delete(){

    global $twig;
    if (isset($_SESSION)) {
        $twig->addGlobal("session", $_SESSION);
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        deleteArticle($id);
        home();

    }
}


function admin_connect() {
    global $twig;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['username'] == 'miten' && $_POST['password'] == 'miten') {
            $_SESSION['statut'] = true;
            $twig->addGlobal("session", $_SESSION);
            home();
            die();
        }
        else {
            echo $twig->render('admin_connect.twig', array('message' => 'MAUVAIS CODE FRERO'));
            die();
        }
    }

    echo $twig->render('admin_connect.twig');

}


function admin_disconnect() {

    session_unset();
    home();

}