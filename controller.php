<?php

require 'vendor/autoload.php';
require 'entity/Article.php';
require 'database/ArticleManager.php';
require 'database/CommentaireManager.php';
require 'database/AdminManager.php';

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
        $commmentaires = $manage->getCommentaires($article);

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


        switch(true) {

            case ($_POST['commentaire'][0]['auteur'] == null  ||  $_POST['commentaire'][0]['texte']  == null ):
                article($_POST['commentaire'][0]['id_article']);
                break;

            case ($_POST['commentaire'][0]['auteur'] != null  &&  $_POST['commentaire'][0]['texte']  != null ):
                $manager = new CommentaireManager();
                $commentaire = new Commentaire($_POST['commentaire'][0]);
                $manager->addCommentaire($commentaire);
                article($commentaire->getIdArticle());
                break;
        }

    }

}


function advert_comment() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (isset($_POST['id'])) {
            $id = $_POST['id'];


            $managers = new CommentaireManager();
            $commentaire = $managers->getCommentaire($id);
            $commentaire->setSignalement($commentaire->getSignalement()+ 1);
            $managers->advertCommentaire($commentaire);

        }

    }

}


function myself(){
    global $twig;
    if (isset($_SESSION)) {
        $twig->addGlobal("session", $_SESSION);
    }

    echo $twig->render('aboutme.twig');
}



function delete_comment()
{

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $managers = new CommentaireManager();
            $commentaire = $managers->getCommentaire($id);
            $managers->deleteCommentaire($commentaire);
            die();
        }

    }

}


function delete_article(){


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $manager = new ArticleManager();
            $article = $manager->getArticle($id);

            $managers = new CommentaireManager();
            $managers->deleteArticleCommentaires($article);
            $manager->deleteArticle($article);


        }
    }
}



function admin_connect() {
    global $twig;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $username = stripslashes($_POST['username']);
        $password = stripslashes($_POST['password']);

        $manager = new AdminManager();
        $result = $manager->adminLogin($username, $password);


        switch(true) {

            case ($result):
                $_SESSION['statut'] = true;
                $twig->addGlobal("session", $_SESSION);
                home();
                break;

            case ($username == null  ||  $password == null ):
                echo $twig->render('admin_connect.twig', array('error_message' => 'Champs manquant'));
                break;

            case ($result == false):
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
    global $twig;
    echo $twig->render('test.twig');
}