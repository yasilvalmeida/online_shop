<?php
    // Online Shop MySQL PDO Connection Class
    class MySQLPDO
    {
        private $connection;
        private $hostname;
        private $database;
        private $username;
        private $password;
        /* 
        This constructor set the global variable with the required information and 
        call the function that create the connection to the database
        */
        function __construct()
        {
            $this->hostname = "localhost";
            $this->database = "shop_db";
            $this->charset = "utf8";
            $this->username = "shop_sa";
            $this->password = "Shop*2020@";
            $this->database_connection();
        }
        /* This function create an mysql database connection */
        function database_connection()
        {
            try
            {
                $this->connection = new PDO("mysql:host=$this->hostname;dbname=$this->database", $this->username, $this->password);     
            }
            catch(PDOException $e)
            {
                echo "Connexao falhada: ".$e->getMessage();
            }
        }
        // Get MySQL PDO Connection 
        function getConnection()
        {
            return $this->connection;
        }
    }
?>
