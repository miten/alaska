<?php

/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 28/03/2018
 * Time: 14:02
 */
class AdminManager
{

    private $_db; // Instance de PDO


    public function __construct()

    {

        $db = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->setDb($db);

    }


    public function adminLogin($username, $password){

        $password = md5($password);

        $q = $this->_db->query("SELECT username, pass FROM admin WHERE username = '".$username."' AND  pass = '".$password."'");
        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        if($donnees != null )
        {
           return true;
        }

        else {
            return false;
        }

    }

    public function setDb(PDO $db)

    {

        $this->_db = $db;

    }


}