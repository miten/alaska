<?php

/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 21/03/2018
 * Time: 19:37
 */

require 'entity/Commentaire.php';


class CommentaireManager
{



    private $_db; // Instance de PDO


    public function __construct()

    {

         $db = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->setDb($db);

    }


    public function advertCommentaire(Commentaire $commentaire){
        $signalement = (int) $commentaire->getSignalement();
        $id = (int) $commentaire->getId();

        $q = $this->_db->prepare('UPDATE commentaires SET signalement = '.$signalement.' WHERE id = '.$id);
        $q->execute();

    }


    public function addCommentaire(Commentaire $commentaire)

    {


        $q = $this->_db->prepare('INSERT INTO commentaires (auteur, texte, date, id_article, signalement) VALUES(:auteur, :texte, :date, :id_article, :signalement)');


        $q->bindValue(':auteur', $commentaire->getAuteur());

        $q->bindValue(':texte', $commentaire->getTexte());

        $q->bindValue(':date', $commentaire->getDate()->format('Y/m/d'));

        $q->bindValue(':id_article', $commentaire->getIdArticle());

        $q->bindValue(':signalement', $commentaire->getSignalement());

        $q->execute();

    }






    public function  getCommentaire($id)

    {


        $id = (int) $id;

        $q = $this->_db->query('SELECT * FROM commentaires WHERE id = '.$id);

        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        $commentaire = new Commentaire($donnees);

        return $commentaire;

    }



    public function deleteCommentaire(Commentaire $commentaire)

    {
        $id = $commentaire->getId();

        $this->_db->exec('DELETE FROM commentaires WHERE id = '.$id);

    }



    public function setDb(PDO $db)

    {

        $this->_db = $db;

    }



}