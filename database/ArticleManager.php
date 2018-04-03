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

        $q->bindValue(':date', $article->getDate()->format('Y/m/d'));

        $q->execute();

    }



    public function deleteArticle(Article $article)

    {

        $id = $article->getId();

        $this->_db->exec('DELETE FROM commentaires WHERE id_article = '.$id);

        $this->_db->exec('DELETE FROM articles WHERE id = '.$id);

    }


    public function getArticle($id)

    {

        $id = (int) $id;


        $q = $this->_db->query('SELECT * FROM articles WHERE id = '.$id.' LIMIT 1');

        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        if (empty($donnees)) {
            return false;
        }

        else {
            $article = new Article($donnees);
            $article->setCommentaires();
            return $article;
        }

    }


    public function getArticles()

    {

        $articles = [];

        $q = $this->_db->query('SELECT * FROM articles ORDER BY DATE DESC');


        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))

        {
            $article = new Article($donnees);
            $article->setCommentaires();
            $articles[] = $article;

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



    public function setCommentaires(Article $article)

    {

        $commentaires = [];

        $id = $article->getId();

        $q = $this->_db->query('SELECT * FROM commentaires WHERE id_article = '.$id.' ORDER BY date ASC') ;

        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))

        {

            $commentaire = new Commentaire($donnees);

            $commentaires[] =  $commentaire;

            if ($commentaire->getSignalement() > 2) {
                $article->setSignaledCommentaires(true);
            }

        }

        return $commentaires;

    }




    public function setDb(PDO $db)

    {

        $this->_db = $db;

    }






}