<?php
    // Product class
    class Product implements JsonSerializable
    {
        protected $id;
        protected $name;
        protected $price;
        protected $quantity;
        protected $unit;
        /* 
        This constructor create a new user object
        */
        function __construct(array $data)
        {
            $this->id       = $data['id'];
            $this->name     = $data['name'];
            $this->price    = $data['price'];
            $this->quantity = $data['quantity'];
            $this->unit     = $data['unit'];
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
        // Get Quantity
        function getQuantity()
        {
            return $this->quantity;
        }
        // Get Unit
        function getUnit()
        {
            return $this->unit;
        }
        // Convert object to JSON
        public function jsonSerialize()
        {
            return get_object_vars($this);
        }
    }
?>
