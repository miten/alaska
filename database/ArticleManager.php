<?php

require_once 'database/DataConnect.php';


class ArticleManager extends DataConnect

{



    public function getArticle($id)

    {

        $q = $this->_db->prepare('SELECT * FROM articles WHERE id = :id LIMIT 1');

        $q->bindValue(':id', $id, PDO::PARAM_INT);

        $q->execute();

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

        $q = $this->_db->prepare("SELECT * FROM articles ORDER BY DATE ASC");

        $q->execute();

        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))

        {
            $article = new Article($donnees);
            $article->setCommentaires();
            $articles[] = $article;

        }

        return $articles;

    }





    public function addArticle(Article $article) {


        $q = $this->_db->prepare('INSERT INTO articles(titre, texte, date) VALUES(:titre, :texte, :date)');

        $q->bindValue(':titre', $article->getTitre());

        $q->bindValue(':texte', $article->getTexte());

        $q->bindValue(':date', $article->getDate()->format('Y/m/d'));

        $q->execute();

        $id = $this->_db->lastInsertId();

        return $id;
    }




    public function deleteArticle(Article $article)

    {

        $q = $this->_db->prepare('DELETE FROM commentaires WHERE id_article = :id;DELETE FROM articles WHERE id = :id ');

        $q->bindValue(':id', $article->getId(), PDO::PARAM_INT);

        $q->execute();

    }





    public function updateArticle(Article $article)

    {

        $q = $this->_db->prepare('UPDATE articles SET titre = :titre, texte = :texte WHERE id = :id');

        $q->bindValue(':id', $article->getId(), PDO::PARAM_INT);

        $q->bindValue(':titre', $article->getTitre(), PDO::PARAM_STR);

        $q->bindValue(':texte', $article->getTexte(), PDO::PARAM_STR);


        $q->execute();

    }



    public function setCommentaires(Article $article)

    {

        $commentaires = [];


        $q = $this->_db->prepare('SELECT * FROM commentaires WHERE id_article = :id ORDER BY date ASC');

        $q->bindValue(':id', $article->getId(), PDO::PARAM_INT);

        $q->execute();

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

}