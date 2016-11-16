<?php

class mysql_connector {

    private $mysql;

    public function __construct() {

        $host = 'localhost';
        $username = 'root';
        $password = 'aramok';
        $database = 'aramoknet';
        $this->mysql = @mysqli_connect($host, $username, $password, $database);
        
        if (mysqli_connect_errno()) {
            ?><span class="error"><p>Error:</p>Failed to Connect mysql</span><?php
        }


    }

}
