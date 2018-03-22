<?php



class Article {


    private $id;

    private $titre;

    private $texte;

    private $date;

    /**
     * Article constructor.
     * @param $id
     * @param $titre
     * @param $texte
     */


    public function __construct(array $rows) {

        if (isset($rows['id'])) {
        $this->id = ($rows['id']);
    }
        $this->titre = ($rows['titre']);
        $this->texte = ($rows['texte']);
        $this->setDate();
    }


    public function hydrate(array $rows) {
        $this->setId($rows['id']);
        $this->setTitre($rows['titre']);
        $this->setTexte($rows['texte']);
        $this->setDate();
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {

        return  $this->date->format('Y-m-d H:i:s');



    }

    /**
     * @param DateTime $date
     */
    public function setDate()
    {
        $date = new DateTime();
        $date->format('Y-m-d H:i:s');
        $this->date = $date;
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


    public function getCommentairesArticle()

    {

        $id = (int) $this->getId();

        $q = $this->_db->query('SELECT * FROM articles WHERE id = '.$id);

        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        $commentaire = new Commentaire($donnees);

        return $commentaire;

    }




}