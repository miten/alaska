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

    private $texte;

    private $date;

    private $id_article;

    /**
     * Commentaire constructor.
     * @param $id
     * @param $auteur
     * @param $texte
     * @param $date
     * @param $id_article
     */



    public function __construct($id, $auteur, $texte, $date, $id_article)
    {
        $this->id = $id;
        $this->auteur = $auteur;
        $this->texte = $texte;
        $this->date = $date;
        $this->id_article = $id_article;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * @param mixed $auteur
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;
    }

    /**
     * @return mixed
     */
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * @param mixed $texte
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getIdArticle()
    {
        return $this->id_article;
    }

    /**
     * @param mixed $id_article
     */
    public function setIdArticle($id_article)
    {
        $this->id_article = $id_article;
    }







}