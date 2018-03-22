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


    public function addCommentaire(Commentaire $commentaire)

    {


        $q = $this->_db->prepare('INSERT INTO commentaires (auteur, texte, date, id_article) VALUES(:auteur, :texte, :date, :id_article)');


        $q->bindValue(':auteur', $commentaire->getAuteur());

        $q->bindValue(':texte', $commentaire->getTexte());

        $q->bindValue(':date', $commentaire->getDate()->format('Y/m/d'));

        $q->bindValue(':id_article', $commentaire->getIdArticle());

        $q->execute();

    }


    public function deleteCommentaire(Commentaire $commentaire)

    {

        $this->_db->exec('DELETE FROM commentaires WHERE id = '.$commentaire->getId());

    }




    public function  getCommentaire($id)

    {

        $id = (int) $id;


        $q = $this->_db->query('SELECT * FROM commentaires WHERE id = '.$id);

        $donnees = $q->fetch(PDO::FETCH_ASSOC);


        $commentaire = new Commentaire($donnees);

        return $commentaire;

    }





    public function getCommentaires($id)

    {

        $commentaires = [];

        $id = (int) $id;

        $q = $this->_db->query('SELECT * FROM commentaires WHERE id_article = '.$id);

        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))

        {

            $commentaires[] = new Commentaire($donnees);

        }


        return $commentaires;

    }



    public function setDb(PDO $db)

    {

        $this->_db = $db;

    }



}