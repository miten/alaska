<?php

require 'Database.php';



function getArticles() {

    $db = new Database();
    $data = $db->query('SELECT * FROM articles');
    return $data;


}


function getArticle($id) {
    $db = new Database();
    $data = $db->query('SELECT * FROM articles WHERE id='.$id.'');
    return $data;
}



function deleteArticle($id) {

    $db = new Database();
    $data = $db->query('SELECT * FROM articles WHERE id='.$id.'');
    return $data;

}





function getCommentaires($id) {
    $db = new Database();
    $commentaires = $db->query('SELECT * FROM commentaires WHERE id='.$id.'');
    return $commentaires;


}


function addArticlee($titre, $texte) {

    $db = new Database();
    $sql = "INSERT INTO articles (titre, texte) VALUES ('$titre', '$texte')";

    $db->getPDO()->exec($sql);



}