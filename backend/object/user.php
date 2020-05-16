<?php
    // User class
    class User implements JsonSerializable
    {
        private $id;
        private $username;
        private $password;
        private $access;
        /* 
        This constructor create a new user object
        */
        function __construct(array $data)
        {
            $this->id       = $data['id'];
            $this->username = $data['username'];
            $this->password = $data['password'];
            $this->access   = $data['access'];
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
        // Get Access
        function getAccess()
        {
            return $this->access;
        }
        // Convert object to JSON
        public function jsonSerialize()
        {
            return get_object_vars($this);
        }
    }
?>
