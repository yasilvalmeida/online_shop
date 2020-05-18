<?php
    // Client class
    class Client implements JsonSerializable
    {
        private $id;
        private $username;
        private $password;
        private $balance;
        private $initialBalance;
        /* 
        This constructor create a new user object
        */
        function __construct(array $data)
        {
            $this->id              = $data['id'];
            $this->username        = $data['username'];
            $this->password        = $data['password'];
            $this->initialBalance  = $data['initial_balance'];
            $this->balance         = $data['balance'];            
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
        // Get Initial Balance
        function getInitialBalance()
        {
            return $this->initialBalance;
        }
        // Convert object to JSON
        public function jsonSerialize()
        {
            return get_object_vars($this);
        }
    }
?>
