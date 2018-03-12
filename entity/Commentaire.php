<?php

require 'Database.php';


/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 12/03/2018
 * Time: 17:59
 */
class Commentaire
{


    private $id;

    private $auteur;

    private $articleId;

    private $texte;



    public function __construct($auteur, $texte, $articleId) {
        $this->auteur = $auteur;
        $this->texte = $texte;
        $this->articleId = $articleId;
    }



    public function getId()
    {
        return $this->id;
    }



    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }



    public function setTexte($texte)
    {
        $this->texte = $texte;

        return $this;
    }


    public function setAuteurId($auteurId)
    {
        $this->auteurId = $auteurId;

        return $this;
    }



    public function getAuteur()
    {
        return $this->auteur;
    }


    public function getTexte()
    {
        return $this->texte;
    }


    public function getArticleId()
    {
        return $this->articleId;
    }


}