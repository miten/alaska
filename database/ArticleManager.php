<?php



class ArticleManager

{

    private $_db; // Instance de PDO


    public function __construct()

    {

        $db = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->setDb($db);

    }


    public function addArticle(Article $article)

    {

        $q = $this->_db->prepare('INSERT INTO articles(titre, texte, date) VALUES(:titre, :texte, :date)');


        $q->bindValue(':titre', $article->getTitre());

        $q->bindValue(':texte', $article->getTexte());

        $q->bindValue(':date', $article->getDate());

        $q->execute();

    }



    public function deleteArticle(Article $article)

    {

        $this->_db->exec('DELETE FROM articles WHERE id = '.$article->getId());

    }


    public function getArticle($id)

    {

        $id = (int) $id;


        $q = $this->_db->query('SELECT * FROM articles WHERE id = '.$id.' ORDER BY date DESC');

        $donnees = $q->fetch(PDO::FETCH_ASSOC);


        $article = new Article($donnees);

        return $article;

    }


    public function getArticles()

    {

        $articles = [];

        $q = $this->_db->query('SELECT * FROM articles');


        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))

        {

            $articles[] = new Article($donnees);

        }

        return $articles;

    }


    public function updateArticle(Article $article)

    {

        $q = $this->_db->prepare('UPDATE articles SET titre = :titre, texte = :texte WHERE id = :id');

        $q->bindValue(':id', $article->getId(), PDO::PARAM_INT);

        $q->bindValue(':titre', $article->getTitre(), PDO::PARAM_INT);

        $q->bindValue(':texte', $article->getTexte(), PDO::PARAM_INT);


        $q->execute();

    }


    public function setDb(PDO $db)

    {

        $this->_db = $db;

    }






}