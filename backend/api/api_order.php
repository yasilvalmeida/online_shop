<?php
    // Import the needed classes
    require_once("mysql_pdo.php");
    require_once("../classes/order.php");
    // Online Shop API for Order CRUD Class
    class OnlineShopOrderAPI
    {
        /* Order Actions Begin */
        /* Retrieve all order on the database */
        function fetchAllOrder()
        {
            try
            {
                // Select all orders
                $query = "select * from t_order";
                // Create object to connect to MySQL using PDO
                $mysqlPDO = new MySQLPDO();
                // Prepare the query 
                $statement = $mysqlPDO->getConnection()->prepare($query);
                // Execute the query without paramters
                $statement->execute();
                // Get affect rows in associative array
                $rows = $statement->fetchAll();
                // Foreach row in array
                foreach ($rows as $row) 
                {
                    // Create a Order object
                    $order = new Order($row);
                    //Create datatable row
                    $tmp_data[] = array
                    (
                        $order->getUsername(),
                        $order->getDate(),
                        $order->getRate(),
                        "<div class='span12' style='text-align:center'><a href='javascript:remove(".$order->getId().")' class='btn btn-danger'><i class='far fa-trash-alt'></i></a></div>"
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
                return $data;
            }
            catch (PDOException $e) 
            {
                die("Error message: " . $e->getMessage());
            }
        }
        /* Insert new order */
        function insertOrder()
        {
            try
            {
                /* Check if for the empty or null username, date and rate parameters */
                if(isset($_POST["username"]) && isset($_POST["date"]) && isset($_POST["rate"]))
                {
                    // Get the username from POST request to check
                    $check_data = array(
                        ':username' => $_POST["username"]
                    );
                    // Get the username, date and rate from POST request to insert
                    $form_data = array(
                        ':username'     => $_POST["username"], 
                        ':date'    => $_POST["date"],
                        ':rate'     => $_POST["rate"]
                    );
                    // Check for existent order with the same username in Database
                    $query = "
                            select id 
                            from t_order
                            where username = :username
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
                        // Create a SQL query to insert an order with a new username, date and rate
                        $query = "
                                insert t_order(username, date, rate) values(:username, :date, :rate);
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
                    if(!isset($_POST["username"]) && !isset($_POST["date"]) && !isset($_POST["rate"]))
                        $data[] = array('result' => 'Missing all parameters for insert an new order!');
                    else if(!isset($_POST["username"]))
                        $data[] = array('result' => 'Missing username parameter');
                    else if(!isset($_POST["date"]))
                        $data[] = array('result' => 'Missing date parameter');
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
        /* Remove order */
        function removeOrder()
        {
            try
            {
                /* Check if for the empty or null id parameters */
                if(isset($_POST["id"]))
                {
                    // Get the id from POST request to remove
                    $form_data = array(
                        ':id' => $_POST["id"]
                    );
                    // Create a SQL query to remove an existent order with passed id
                    $query = "
                            delete from t_order
                            where id = :id;
                            ";
                    // Create object to connect to MySQL using PDO
                    $mysqlPDO = new MySQLPDO();
                    // Prepare the query 
                    $statement = $mysqlPDO->getConnection()->prepare($query);
                    // Execute the query with passed parameter id
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
                else
                {
                    // Check for missing parameters
                    if(!isset($_POST["id"]))
                        $data[] = array('result' => 'Missing id parameter!');
                }
                return $data;
            } 
            catch (PDOException $e) 
            {
                die("Error message: " . $e->getMessage());
            }
        }
        /* Order Actions End */
        /***********************/
    }
?>
