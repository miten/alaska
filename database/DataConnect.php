<?php

/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 03/04/2018
 * Time: 19:48
 */
class DataConnect
{


    protected $_db; // Instance de PDO



    public function __construct()

    {

        $db = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->setDb($db);

    }



    protected function setDb(PDO $db)

    {

        $this->_db = $db;

    }


}