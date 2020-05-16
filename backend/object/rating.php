<?php
    // Rating class
    class Rating implements JsonSerializable
    {
        private $id;
        private $rate;
        private $username;
        private $date;
        /* 
        This constructor create a new user object
        */
        function __construct(array $data)
        {
            $this->id       = $data['id'];
            $this->rate     = $data['rate'];
            $this->username = $data['username'];
            $this->date     = $data['date'];
        }
        // Get Id
        function getId()
        {
            return $this->id;
        }
        // Get Rate
        function getRate()
        {
            return $this->rate;
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
        // Convert object to JSON
        public function jsonSerialize()
        {
            return get_object_vars($this);
        }
    }
?>
