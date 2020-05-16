<?php
    // Client class
    class Client implements JsonSerializable
    {
        private $id;
        private $username;
        private $password;
        private $balance;
        /* 
        This constructor create a new user object
        */
        function __construct(array $data)
        {
            $this->id       = $data['id'];
            $this->username = $data['username'];
            $this->password = $data['password'];
            $this->balance  = $data['balance'];
        }
        // Get Id
        function getId()
        {
            return $this->id;
        }
        // Get Username
        function getUsername()
        {
            return $this->username;
        }
        // Get Password
        function getPassword()
        {
            return $this->password;
        }
        // Get Balance
        function getBalance()
        {
            return $this->balance;
        }
        // Convert object to JSON
        public function jsonSerialize()
        {
            return get_object_vars($this);
        }
    }
?>
