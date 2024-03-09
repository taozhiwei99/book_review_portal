<?php
class Connection {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "csci314";

    function get_servername() {
        return $this->servername;
    }

    function get_username() {
        return $this->username;
    }

    function get_password() {
        return $this->password;
    }

    function get_dbname() {
        return $this->dbname;
    }
}



?>