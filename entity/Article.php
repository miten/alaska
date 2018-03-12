<?php



class Article {


    private $id;

    private $titre;

    private $texte;

    /**
     * Article constructor.
     * @param $id
     * @param $titre
     * @param $texte
     */


    public function __construct($titre, $texte)
    {
        $this->setTitre($titre);
        $this->setTexte($texte);
    }


    public function hydrate(array $rows) {
        $this->setId($rows['titre']);
        $this->setTitre($rows['texte']);
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
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param mixed $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
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






    public function getExtrait() {

        $texte = '<p>' .substr($this->getTexte(),0,5). '...</p>';

        return $texte;
    }








}