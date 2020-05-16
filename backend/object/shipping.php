<?php
    // Shipping class
    class Shipping implements JsonSerializable
    {
        private $id;
        private $name;
        private $price;
        /* 
        This constructor create a new user object
        */
        function __construct(array $data)
        {
            $this->id    = $data['id'];
            $this->name  = $data['name'];
            $this->price = $data['price'];
        }
        // Get Id
        function getId()
        {
            return $this->id;
        }
        // Get Name
        function getName()
        {
            return $this->name;
        }
        // Get Price
        function getPrice()
        {
            return $this->price;
        }
        // Convert object to JSON
        public function jsonSerialize()
        {
            return get_object_vars($this);
        }
    }
?>
