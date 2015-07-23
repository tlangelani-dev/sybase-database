<?php

namespace Tlangelani\Database;

class Sybase {
    
    protected $conn;
    
    private $dbHost;
    private $dbName;
    private $dbUser;
    private $dbPass;
    
    public function __construct($dbHost, $dbName, $dbUser, $dbPass) {
        $this->dbHost = $dbHost;
        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
        $this->conn = sybase_connect($this->dbHost, $this->dbUser, $this->dbPass);
        if (!$this->conn) {
            trigger_error("Sybase Connection Error: " . sybase_get_last_message());
        }
        $this->selectDB($this->dbName);
    }
    
    public function selectDB($db) {
        $this->dbName = $db;
        return sybase_select_db($this->dbName, $this->conn);
    }
    
    public function connect() {
        
    }
    
    public function query() {
        
    }
}