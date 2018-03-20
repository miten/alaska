<?php

require 'vendor/autoload.php';
require 'model.php';
require 'entity/Article.php';

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




function article($id = null){
    global $twig;
    if (isset($_SESSION)) {
        $twig->addGlobal("session", $_SESSION);
    }


    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $idd = $_GET['id'];
    }


    if (isset($id)||isset($idd)) {
        $id = $id ?: $idd;
        $article = getArticle($id);
        $article = array_values($article)[0];
        $commmentaires = getCommentaires($article->getId());


        echo $twig->render('article.twig', array('article' => $article,'commentaires' => $commmentaires));

    }
    else {
        echo "Article non trouvé";
    }

}



function post_article() {
    global $twig;
    if (isset($_SESSION)) {
        $twig->addGlobal("session", $_SESSION);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    addArticle($_POST['titre'], $_POST['texte']);
    }

    echo $twig->render('AddArticle.twig');

}




function post_comment() {

    global $twig;
    if (isset($_SESSION)) {
        $twig->addGlobal("session", $_SESSION);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        addComment($_POST['auteur'], $_POST['texte'], $_POST['id_article']);
        article($_POST['id_article']);
    }

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

        switch(true) {

            case ($_POST['username'] == 'miten' && $_POST['password'] == 'miten'):
                $_SESSION['statut'] = true;
                $twig->addGlobal("session", $_SESSION);
                home();
                break;

            case ($_POST['username'] == null  ||  $_POST['password'] == null ):
                echo $twig->render('admin_connect.twig', array('error_message' => 'Champs manquant'));
                break;

            case ($_POST['username'] != 'miten' || $_POST['password'] != 'miten'):
                echo $twig->render('admin_connect.twig', array('error_message' => 'Identifiants incorrects'));
                break;
        }
    }

    else {
        echo $twig->render('admin_connect.twig');
    }

}



function admin_disconnect() {

    session_unset();
    home();

}




function test() {

}