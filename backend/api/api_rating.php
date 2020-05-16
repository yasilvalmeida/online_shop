<?php
    // Import the needed classes
    require_once("mysql_pdo.php");
    require_once("../object/rating.php");
    // Online Shop API for Rating CRUD Class
    class OnlineShopRatingAPI
    {
        /* Rating Actions Begin */
        /* Retrieve all backend rating on the database */
        function fetchAllRating()
        {
            try
            {
                /* Check if for the empty or null id parameters */
                if(isset($_POST["t_product_fk"]))
                {
                    // Get the t_product_fk from POST request to select
                    $form_data = array(
                        ':t_product_fk' => $_POST["t_product_fk"]
                    );
                    // Select all rating
                    $query = "
                            select id, rate, username, date
                            from t_rating
                            where t_product_fk = :t_product_fk
                            ";
                    // Create object to connect to MySQL using PDO
                    $mysqlPDO = new MySQLPDO();
                    // Prepare the query 
                    $statement = $mysqlPDO->getConnection()->prepare($query);
                    // Execute the query without paramters
                    $statement->execute($form_data);
                    // Get affect rows in associative array
                    $rows = $statement->fetchAll();
                    // Foreach row in array
                    foreach ($rows as $row) 
                    {
                        // Create a Rating object
                        $rating = new Rating($row);
                        //Create datatable row
                        $tmp_data[] = array
                        (
                            $rating->getUsername(),
                            $rating->getDate(),
                            $rating->getRate()
                        );  
                    }
                    // Export into DataTable json format if there's any record in $tmp_data
                    if(isset($tmp_data) && count($tmp_data) > 0)
                    {
                        $data = array
                        (
                            "data" => $tmp_data
                        );
                    }
                    else
                    {
                        $data = array
                        (
                            "data" => array()
                        );
                    }
                }
                else
                {
                    // Check for missing parameters
                    if(!isset($_POST["t_product_fk"]))
                        $data[] = array('result' => 'Missing t_product_fk parameter!');
                }
                return $data;
            }
            catch (PDOException $e) 
            {
                die("Error message: " . $e->getMessage());
            }
        }
        /* Insert new rating */
        function insertRating()
        {
            try
            {
                /* Check if for the empty or null username and rate parameters */
                if(isset($_POST["t_product_fk"]) && isset($_POST["username"]) && isset($_POST["rate"]))
                {
                    // Get the username from POST request to check
                    $check_data = array(
                        ':username'     => $_POST["username"],
                        ':t_product_fk' => $_POST["t_product_fk"],
                    );
                    // Get the username, date and rate from POST request to insert
                    $form_data = array(
                        ':t_product_fk' => $_POST["t_product_fk"], 
                        ':username'     => $_POST["username"], 
                        ':date'         => date("Y-m-d h:i:sa"),
                        ':rate'         => $_POST["rate"]
                    );
                    // Check for existent rating with the same username in Database
                    $query = "
                            select id 
                            from t_rating
                            where username = :username and t_product_fk = :t_product_fk
                            ";
                    // Create object to connect to MySQL using PDO
                    $mysqlPDO = new MySQLPDO();
                    // Prepare the query 
                    $statement = $mysqlPDO->getConnection()->prepare($query);
                    // Execute the query with passed parameter username
                    $statement->execute($check_data);
                    // Get affect rows in associative array
                    $row = $statement->fetch(PDO::FETCH_ASSOC);
                    // Check if any affected row
                    if($row)
                    {
                        $data[] = array('result' => 'This record already exists!');
                    }
                    else
                    {
                        // Create a SQL query to insert an rating with a new username, date and rate
                        $query = "
                                insert t_rating(username, date, rate, t_product_fk) values(:username, :date, :rate, :t_product_fk);
                                ";
                        // Prepare the query 
                        $statement = $mysqlPDO->getConnection()->prepare($query);
                        // Execute the query with passed parameter username, date and rate
                        $statement->execute($form_data);
                        // Check if any affected row
                        if ($statement->rowCount())
                        {
                            $data[] = array('result' => '1');
                        } 
                        else
                        {
                            $data[] = array('result' => 'No affected row!');
                        }
                    }
                }
                else
                {
                    // Check for missing parameters
                    if(!isset($_POST["t_product_fk"]) && !isset($_POST["username"]) && !isset($_POST["rate"]))
                        $data[] = array('result' => 'Missing all parameters for insert an new rating!');
                    else if(!isset($_POST["t_product_fk"]))
                        $data[] = array('result' => 'Missing t_product_fk parameter');
                    else if(!isset($_POST["username"]))
                        $data[] = array('result' => 'Missing username parameter');
                    else
                        $data[] = array('result' => 'Missing rate parameter');
                }
                return $data;
            } 
            catch (PDOException $e) 
            {
                die("Error message: " . $e->getMessage());
            }
        }
        /* Rating Actions End */
        /***********************/
    }
?>