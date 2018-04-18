<?php

require 'vendor/autoload.php';
require 'entity/Article.php';
require 'database/ArticleManager.php';
require 'database/CommentaireManager.php';
require 'database/AdminManager.php';
require 'vendor/Pagination/Pagination.php';

$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
$twig= new Twig_Environment($loader, ['cache' => false]);



function home(){
    global $twig;
    if (isset($_SESSION)) {
        $twig->addGlobal("session", $_SESSION);
    }

    $manager = new ArticleManager();
    $articles = $manager->getArticles();

    $pagination = new Pagination($articles, 4, 1);

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['index'])) {

        $page = (int) $_GET['index'];

        if ($page <= $pagination->getPages() AND $page > 0 ) {

            $pagination->setIndex((int)$_GET['index']);
            $pagination->setStart();
        }

        else {
            error('Page introuvable');
            die();
        }

    }

    $articles = (array_slice($articles, $pagination->getStart(), $pagination->getLimit()));


    echo $twig->render('articles.twig', array('articles' => $articles, 'pagination' => $pagination));

}




function article($id){
    global $twig;
    if (isset($_SESSION)) {
        $twig->addGlobal("session", $_SESSION);
    }

        $manager = new ArticleManager();
        $article = $manager->getArticle($id);

        if (!empty($article)) {

            echo $twig->render('article.twig', array('article' => $article));

        }

        else {

            error('Article introuvable');
        }

}



function post_article() {
    global $twig;
    $twig->addGlobal("session", $_SESSION);


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


        if (isset($_POST['article'][0]['texte']) && isset($_POST['article'][0]['titre'])) {

            $article = $_POST['article'][0];
            $article = new Article($article);
            $manager = new ArticleManager();
            $id = $manager->addArticle($article);
            header('Location:?page=article&id='.+ $id);
            die();
        }

        else  {
            error('Action impossible');
        }
    }


    echo $twig->render('post_article.twig');

}




function modify_article(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['article'][0]['texte']) && isset($_POST['article'][0]['titre']) && isset($_POST['article'][0]['article_id'])) {

            $id = $_POST['article'][0]['article_id'];
            $titre = $_POST['article'][0]['titre'];
            $texte = $_POST['article'][0]['texte'];

            $manager = new ArticleManager();
            $article = $manager->getArticle($id);
            $article->setTitre($titre);
            $article->setTexte($texte);

            $manager->updateArticle($article);
            header('Location:?page=article&id='.+ $id);

        }
    }

    else {
        error('Action impossible');
    }


}


function delete_article() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
        $id = $_POST['id'];
        $manager = new ArticleManager();
        $article = $manager->getArticle($id);

        if (!empty($article)) {
            $manager->deleteArticle($article);
        }

        else {

            error('Action impossible');

        }
    }
}



function post_comment() {

    global $twig;
    if (isset($_SESSION)) {
        $twig->addGlobal("session", $_SESSION);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {


        if ($_POST['commentaire'][0]['auteur'] != null  AND  $_POST['commentaire'][0]['texte']  != null ) {

            $manager = new CommentaireManager();
            $commentaire = new Commentaire($_POST['commentaire'][0]);
            $manager->addCommentaire($commentaire);
            header('Location:?page=article&id='.+ $commentaire->getIdArticle());

        }

        else {
            header('Location:?page=article&id='.+ $_POST['commentaire'][0]['id_article']);

        }

    }
}


function advert_comment() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {

            $id = $_POST['id'];
            $managers = new CommentaireManager();
            $commentaire = $managers->getCommentaire($id);

            if (!empty($commentaire)) {

                $commentaire->setSignalement($commentaire->getSignalement()+ 1);
                $managers->advertCommentaire($commentaire);
            }

            else {

                error('Action impossible');
            }



    }

}




function delete_comment() {

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {

            $id = $_POST['id'];
            $managers = new CommentaireManager();
            $commentaire = $managers->getCommentaire($id);

            if (!empty($commentaire)) {

                $managers->deleteCommentaire($commentaire);

            }

            else {

                error('Action impossible');

            }
    }

}





function myself() {

    global $twig;
    if (isset($_SESSION)) {
        $twig->addGlobal("session", $_SESSION);
    }

    echo $twig->render('aboutme.twig');
}



function admin_connect() {
    global $twig;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' AND (!empty($_POST['username'])) AND (!empty($_POST['password']))) {

        $username = stripslashes($_POST['username']);
        $password = stripslashes($_POST['password']);

        $manager = new AdminManager();
        $login = $manager->adminLogin($username, $password);


        if ($login === true) {

            $_SESSION['statut'] = true;
            $twig->addGlobal("session", $_SESSION);
            header('Location:?page=home');
        }

        else {
            echo $twig->render('admin_connect.twig', array('error_message' => 'Identifiants incorrects'));
        }

    }

    else {
        echo $twig->render('admin_connect.twig');
    }

}



function admin_disconnect() {

    unset($_SESSION['statut']);
    header('Location:?page=home');

}



function error($error) {
    global $twig;
    if (isset($_SESSION)) {
        $twig->addGlobal("session", $_SESSION);
    }
    echo $twig->render('error.twig', array('error' => $error));



}