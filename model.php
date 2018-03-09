<?php


$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
$twig = new Twig_Environment($loader, ['cache' => false]);

$pdo = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);



function getArticles() {

    global $pdo;
    $articles = $pdo->query('SELECT * FROM articles');
    return $articles;

}


function getArticle($id) {

    global $pdo;
    $article = $pdo->query('SELECT * FROM articles WHERE id='.$id.'');
    return $article;

}



function deleteArticle($id) {

    global $pdo;
    $article = $pdo->query('DELETE FROM blog where id= '.$id.'');
    return $article;

}




function getCommentaires($id) {

    global $pdo;
    $commentaires = $pdo->query('SELECT * FROM commentaires WHERE id='.$id.'');
    return $commentaires;

}