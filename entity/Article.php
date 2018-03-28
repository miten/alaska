<?php



class Article  {


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


    public function __construct(array $rows)
    {

        if (!isset ($rows['id'])) {
            $this->titre = ($rows['titre']);
            $this->texte = ($rows['texte']);
            $this->setDate(new DateTime);
        }

        else {
            $this->hydrate($rows);
        }
    }




    public function hydrate(array $rows) {
        $this->setId($rows['id']);
        $this->setTitre($rows['titre']);
        $this->setTexte($rows['texte']);
        $this->setdate($rows['date']);
    }




    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }



    /**
     * @param DateTime $date
     */
    public function setDate($date)
    {
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




}