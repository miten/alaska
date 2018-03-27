<?php

require 'vendor/autoload.php';
require 'entity/Article.php';
require 'database/ArticleManager.php';
require 'database/CommentaireManager.php';


$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
$twig= new Twig_Environment($loader, ['cache' => false]);



function home(){
    global $twig;
    if (isset($_SESSION)) {
        $twig->addGlobal("session", $_SESSION);
    }
    $manager = new ArticleManager();
    $articles = $manager->getArticles();

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
    }

        $manager = new ArticleManager();
        $article = $manager->getArticle($id);


        $manage = new CommentaireManager();
        $commmentaires = $manage->getCommentaires($id);

        echo $twig->render('article.twig', array('article' => $article,'commentaires' => $commmentaires));



}



function post_article() {
    global $twig;
    if (isset($_SESSION)) {
        $twig->addGlobal("session", $_SESSION);
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $manager = new ArticleManager();
        $article = new Article($_POST['article'][0]);
        $manager->addArticle($article);
        home();
    }

    echo $twig->render('AddArticle.twig');


}




function post_comment() {

    global $twig;
    if (isset($_SESSION)) {
        $twig->addGlobal("session", $_SESSION);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $manager = new CommentaireManager();
        $commentaire = new Commentaire($_POST['commentaire'][0]);
        $manager->addCommentaire($commentaire);
        article($commentaire->getIdArticle());

    }

}



function myself(){
    global $twig;
    if (isset($_SESSION)) {
        $twig->addGlobal("session", $_SESSION);
    }

    echo $twig->render('aboutme.twig');
}



function delete_comment(){

    global $twig;
    if (isset($_SESSION)) {
        $twig->addGlobal("session", $_SESSION);
    }


    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $manager = new CommentaireManager();
            $commentaire = $manager->getCommentaire($id);
            $id_article = $commentaire->getIdArticle();
            $manager->deleteCommentaire($commentaire);
            article($id_article);
        }

    }

}




function delete_article(){

    global $twig;
    if (isset($_SESSION)) {
        $twig->addGlobal("session", $_SESSION);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $manager = new ArticleManager();
            $article = $manager->getArticle($id);
            $manager->deleteArticle($article);
            home();

        }
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

    $ahah = new CommentaireManager();
    $ahah = $ahah->getCommentaire(58);
    var_dump($ahah);

}