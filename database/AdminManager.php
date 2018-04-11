<?php


require_once 'database/DataConnect.php';


/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 28/03/2018
 * Time: 14:02
 */
class AdminManager extends DataConnect


{



    public function adminLogin($username, $password){

        $password = md5($password);

        $q = $this->_db->prepare('SELECT username, pass FROM admin WHERE username = :username AND pass = :password');


        $q->bindValue(':username', $username, PDO::PARAM_STR);
        $q->bindValue(':password', $password, PDO::PARAM_STR);

        $q->execute();


        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        if(empty($donnees))
        {
           return false;
        }

        else {
            return true;
        }

    }




}