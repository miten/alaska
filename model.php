<?php


function getArticles() {

    $db = new Database();
    $data = $db->query('SELECT * FROM articles');
    return $data;


}




function getArticle($id) {
    $db = new Database();
    $data = $db->queryOne('SELECT * FROM articles WHERE id='.$id.'', Article::class);
    return $data;
}



function addArticle($titre, $texte) {

    $db = new Database();
    $sql = "INSERT INTO articles (titre, texte) VALUES ('$titre', '$texte')";

    $db->getPDO()->exec($sql);


}




function deleteArticle($id) {

    $db = new Database();
    $sql = 'DELETE FROM articles WHERE id='.$id.'';
    $db->getPDO()->exec($sql);

}




function getComment($id_article) {
    $db = new Database();
    $commentaires = $db->query('SELECT * FROM commentaires WHERE id_article='.$id_article.'');
    return $commentaires;


}



function deleteComment($id) {

    $db = new Database();
    $sql = 'DELETE FROM commentaires WHERE id='.$id.'';
    $db->getPDO()->exec($sql);

}



function addComment($auteur, $texte, $id_article) {

    $db = new Database();
    $date = new DateTime();
    $date = $date->format('Y-m-d H:i:s');
    $sql = "INSERT INTO commentaires (auteur, texte, date, id_article) VALUES ('$auteur', '$texte', '$date', '$id_article')";
    $db->getPDO()->exec($sql);


}