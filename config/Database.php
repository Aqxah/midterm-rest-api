<?php

    // This connect function is used to connect to PostgreSQL on Render
    
    class Database {
        private $DBHOST;
        private $DBPORT;
        private $DBNAME;
        private $DBUSER;
        private $DBPASS;
        private $conn;

        public function __construct() {
            $this->DBUSER = getenv('DBUSER');
            $this->DBPASS = getenv('DBPASS');
            $this->DBNAME = getenv('DBNAME');
            $this->DBHOST = getenv('DBHOST');
            $this->DBPORT = getenv('DBPORT');
        }

        public function connect() {
            if ($this->conn) {
                return $this->conn;
            } else {
                $dsn = "pgsql:host={$this->DBHOST};port={$this->DBPORT};dbname={$this->DBNAME};";

                try {
                    $this->conn = new PDO($dsn, $this->DBUSER, $this->DBPASS);
                    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    return $this->conn;
                } catch(PDOException $e) {
                    echo 'Connection Error: ' . $e->getMessage();
                }
            }
        }
    }
    
    // PHPAdmin MySQL Connect
    /*
    class Database {
        // DB Params
        private $host = 'localhost';
        private $db_name = 'quotesdb';
        private $username = 'root';
        private $password = '';
        private $conn;

        // DB Connect
        public function connect() {
            $this->conn = null;

            try {
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo 'Connection Error: ' . $e->getMessage();
            }
            return $this->conn;
        }
    }
    */
    