<?php

require 'vendor/autoload.php';
require 'model.php';




function home(){
    global $twig;
    echo $twig->render('articles.twig', array('articles' => getArticles()));
}


function article(){
    global $twig;
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        echo $twig->render('article.twig', array('article' => getArticle($id),'commentaires' => getCommentaires($id)));

    }
}


function myself(){
    global $twig;
    echo $twig->render('aboutme.twig');
}
