<?php

require 'vendor/autoload.php';
require 'model.php';
require 'entity/Article.php';

$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
$twig = new Twig_Environment($loader, ['cache' => false]);



function home(){
    global $twig;
    $articles = getArticles();

    echo $twig->render('articles.twig', array('articles' => $articles));
}


function article(){
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        global $twig;
        $article = getArticle($id);
        $commmentaires = getCommentaires($id);

        echo $twig->render('article.twig', array('article' => $article,'commentaires' => $commmentaires));

    }
}

function addArticle() {
    global $twig;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    addArticlee($_POST['titre'], $_POST['texte']);
    }

    echo $twig->render('AddArticle.twig');

}



function myself(){
    global $twig;
    echo $twig->render('aboutme.twig');
}
