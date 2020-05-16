<?php
    // Order class
    class Order implements JsonSerializable
    {
        private $id;
        private $number;
        private $username;
        private $date;
        private $shipping;
        /* 
        This constructor create a new user object
        */
        function __construct(array $data)
        {
            $this->id       = $data['id'];
            $this->number   = $data['number'];
            $this->username = $data['username'];
            $this->date     = $data['date'];
            $this->shipping = $data['shipping'];
        }
        // Get Id
        function getId()
        {
            return $this->id;
        }
        // Get Number
        function getNumber()
        {
            return $this->number;
        }
        // Get Username
        function getUsername()
        {
            return $this->username;
        }
        // Get Date
        function getDate()
        {
            return $this->date;
        }
        // Get Shipping
        function getShipping()
        {
            return $this->shipping;
        }
        // Convert object to JSON
        public function jsonSerialize()
        {
            return get_object_vars($this);
        }
    }
?>
