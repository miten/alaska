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

        $manager = new ArticleManager();
        $article = $manager->getArticle($id);


        if (empty($article)) {
            echo $twig->render('error.twig', array('error' => 'Article introuvable'));
        }

        else {

            echo $twig->render('article.twig', array('article' => $article));

        }

    }


}



function post_article() {
    global $twig;
    if (isset($_SESSION)) {
        $twig->addGlobal("session", $_SESSION);
    }



    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['statut'] === true) {


        if (isset($_POST['article'][0]['texte']) && isset($_POST['article'][0]['titre'])) {

            $article = $_POST['article'][0];

            $manager = new ArticleManager();
            $article = new Article($article);
            $manager->addArticle($article);
            return home();
        }

        else  {
            echo $twig->render('error.twig', array('error' => 'Action impossible'));
        }
    }

    if (isset($_SESSION['statut']) && $_SESSION['statut'] === true) {

        echo $twig->render('post_article.twig');
    }

    else {
        echo $twig->render('error.twig', array('error' => 'Seul l\'administrateur peut accèder a cette page'));
    }


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

        else {

            global $twig;
            echo $twig->render('error.twig', array('error' => 'Action impossible'));

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

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['statut'] === true) {

        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $managers = new CommentaireManager();
            $commentaire = $managers->getCommentaire($id);
            $managers->deleteCommentaire($commentaire);
            die();
        }

    }

    else {
        global $twig;
        echo $twig->render('error.twig', array('error' => 'Action impossible'));
    }



}

function modify_article(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['statut'] === true) {
        if (isset($_POST['article'][0]['texte']) && isset($_POST['article'][0]['titre']) && isset($_POST['article'][0]['article_id'])) {

            $id = $_POST['article'][0]['article_id'];
            $titre = $_POST['article'][0]['titre'];
            $texte = $_POST['article'][0]['texte'];

            $manager = new ArticleManager();
            $article = $manager->getArticle($id);
            $article->setTitre($titre);
            $article->setTexte($texte);

            $manager->updateArticle($article);
            return article($id);
        }
    }

    else {
        global $twig;
        echo $twig->render('error.twig', array('error' => 'Action impossible'));
    }


}



function delete_article(){
    global $twig;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['statut'] === true) {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $manager = new ArticleManager();
            $article = $manager->getArticle($id);

            $manager->deleteArticle($article);


        }

        else {

            echo $twig->render('error.twig', array('error' => 'Action impossible'));


        }
    }

    else {

        echo $twig->render('error.twig', array('error' => 'Action impossible'));
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

    unset($_SESSION['statut']);
    home();

}