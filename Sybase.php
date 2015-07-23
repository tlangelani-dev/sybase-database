<?php

namespace Tlangelani\Database;

class Sybase {
    
    protected $conn;
    protected $data = array();
    private $fetchTypes = array('ASSOC', 'ARRAY', 'OBJ', 'FIELD', 'ROW');
    private $result;
    
    private $dbHost;
    private $dbName;
    private $dbUser;
    private $dbPass;
    
    public function __construct($dbHost, $dbName, $dbUser, $dbPass) {
        
        $this->dbHost = $dbHost;
        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
        
        $this->connect($this->dbHost);
        $this->selectDB($this->dbName);
    }
    
    /**
     * Select database.
     * @param string $db
     * @return boolean
     */
    public function selectDB($db) {
        $this->dbName = $db;
        return sybase_select_db($this->dbName, $this->conn);
    }
    
    /**
     * Connect to Sybase database server.
     * @param type $host
     * @return resource
     */
    public function connect($host) {
        $this->dbHost = $host;
        $this->conn = sybase_connect($this->dbHost, $this->dbUser, $this->dbPass);
        if (!$this->conn) {
            trigger_error("Sybase Connection Error: " . sybase_get_last_message());
        }
        return $this->conn;
    }
    
    public function getDB() {
        $dbInfo = $this->query('exec sp_helpdb', 'OBJ');
        foreach($dbInfo as $info) {
            $data[] = $info->name;
        }
        return $data;
    }
    
    public function getTables($db) {
        $tables = array();
        $this->selectDB($db);
        $sql = "SELECT name FROM sysobjects WHERE type = 'U' ORDER BY name";
        $data = $this->query($sql);
        foreach($data as $info) {
            $tables[] = $info['name'];
        }
        return $tables;
    }
    
    public function getTableColumns($table) {
        $columns = array();
        $sql = "
            SELECT sc.name
            FROM syscolumns sc
            INNER JOIN sysobjects so ON sc.id = so.id
            WHERE so.name = '$table'
        ";
        $data = $this->query($sql);
        foreach($data as $info) {
            $columns[] = $info['name'];
        }
        return $columns;
    }
    
    public function query($sql, $fetchType = 'ASSOC') {
        
        // clear data array
        $this->data = array();
        
        // send sql query to database
        $this->result = sybase_query($sql, $this->conn);
        
        // fetch results
        if (is_resource($this->result)) {
            $this->fetchResults($fetchType);
        }
        
        return $this->data;
    }
    
    /**
     * This function will fetch results based on user fetch type.
     * @param string $fetchType
     */
    protected function fetchResults($fetchType) {
        
        // check if user fetch type is valid
        if (!in_array($fetchType, $this->fetchTypes)) {
            trigger_error('Sybase Error: Invalid query fetch type: ' . $fetchType);
        }
        
        switch($fetchType) {
            case 'ASSOC':
                while($row = sybase_fetch_assoc($this->result)) {
                    $this->data[] = $row;
                }
                break;
            case 'ARRAY':
                while($row = sybase_fetch_array($this->result)) {
                    $this->data[] = $row;
                }
                break;
            case 'OBJ':
                while($row = sybase_fetch_object($this->result)) {
                    $this->data[] = $row;
                }
                break;
            case 'FIELD':
                while($row = sybase_fetch_field($this->result)) {
                    $this->data[] = $row;
                }
                break;
            case 'ROW':
                while($row = sybase_fetch_row($this->result)) {
                    $this->data[] = $row;
                }
                break;
        }
    }
    
}