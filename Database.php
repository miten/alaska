<?php

class Database {


    private $db_name;
    private $db_user;
    private $db_pass;
    private $db_host;
    private $pdo;



    public function __construct($db_name = 'blog', $db_user = 'root', $db_pass = '', $db_host = 'localhost') {

        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;

    }


    public function getPDO() {


        $pdo = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo = $pdo;
        return $pdo;

    }


    public function query($statement) {

        $req = $this->getPDO()->query($statement);
        $data = $req->fetchAll(PDO::FETCH_CLASS);
        return $data;

    }


    public function queryOne($statement, $class) {

        $req = $this->getPDO()->query($statement);
        $data = $req->fetchAll(PDO::FETCH_CLASS, $class);

        return $data;

    }





}