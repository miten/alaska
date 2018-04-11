<?php

/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 21/03/2018
 * Time: 19:37
 */

require 'entity/Commentaire.php';
require_once 'database/DataConnect.php';

class CommentaireManager extends DataConnect
{



    public function advertCommentaire(Commentaire $commentaire){

        $q = $this->_db->prepare('UPDATE commentaires SET signalement = :signalement WHERE id = :id');

        $q->bindValue(':signalement', $commentaire->getSignalement(), PDO::PARAM_INT);

        $q->bindValue(':id', $commentaire->getId(), PDO::PARAM_INT);


        $q->execute();

    }


    public function addCommentaire(Commentaire $commentaire)

    {


        $q = $this->_db->prepare('INSERT INTO commentaires (auteur, texte, date, id_article, signalement) VALUES(:auteur, :texte, :date, :id_article, :signalement)');


        $q->bindValue(':auteur', $commentaire->getAuteur(), PDO::PARAM_STR);

        $q->bindValue(':texte', $commentaire->getTexte(), PDO::PARAM_STR);

        $q->bindValue(':date', $commentaire->getDate()->format('Y/m/d'));

        $q->bindValue(':id_article', $commentaire->getIdArticle(), PDO::PARAM_INT);

        $q->bindValue(':signalement', $commentaire->getSignalement(), PDO::PARAM_INT);

        $q->execute();

    }






    public function  getCommentaire($id)

    {

        $q = $this->_db->prepare('SELECT * FROM commentaires WHERE id = :id LIMIT 1');

        $q->bindValue(':id', $id, PDO::PARAM_INT);

        $q->execute();

        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        $commentaire = new Commentaire($donnees);

        return $commentaire;

    }



    public function deleteCommentaire(Commentaire $commentaire)

    {

        $q = $this->_db->prepare('DELETE FROM commentaires WHERE id = :id');

        $q->bindValue(':id', $commentaire->getId(), PDO::PARAM_INT);

        $q->execute();

    }




}