<?php

/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 10/04/2018
 * Time: 19:55
 */
class Pagination
{

    public $pages;
    public $start;
    public $limit;
    public $index;


    /**
     * Pagination constructor.
     * @param $pages
     * @param $start
     * @param $limit
     */



    public function __construct($articles, $limit, $index)
    {
        $this->setIndex($index);
        $this->setLimit($limit);
        $this->setPages($articles, $limit);
        $this->setStart();

    }



    /**
     * @return mixed
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param mixed $pages
     */
    public function setPages($articles, $limit)
    {

        $pages = ceil((count($articles)) / $limit);
        $this->pages = $pages;
    }


    /**
     * @return mixed
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param mixed $index
     */
    public function setIndex($index)
    {

        $this->index = $index;
    }





    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param mixed $start
     */
    public function setStart()
    {

        $start  = ($this->getIndex() * $this->getLimit()) -  $this->getLimit();

        $this->start = $start;

    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param mixed $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

}