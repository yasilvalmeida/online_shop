<?php
    // Order class
    class Order implements JsonSerializable
    {
        private $id;
        private $number;
        private $total;
        private $date;
        private $shipping;
        /* 
        This constructor create a new user object
        */
        function __construct(array $data)
        {
            $this->id       = $data['id'];
            $this->date     = $data['date'];
            $this->shipping = $data['shipping'];
            $this->total    = isset($data['total']) ? $data['total'] : 0;
        }
        // Get Id
        function getId()
        {
            return $this->id;
        }
        // Get Total
        function getTotal()
        {
            return $this->total;
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
