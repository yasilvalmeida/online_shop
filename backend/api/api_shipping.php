<?php
    // Import the needed classes
    require_once("mysql_pdo.php");
    require_once("../object/shipping.php");
    // Online Shop API for Shipping CRUD Class
    class OnlineShopShippingAPI
    {
        /* Shipping Actions Begin */
        /* Retrieve all shipping on the database */
        function fetchAllShipping()
        {
            try
            {
                // Select all shipping
                $query = "select * from t_shipping";
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
                    // Create a Shipping object
                    $shipping = new Shipping($row);
                    //Create datatable row
                    $tmp_data[] = array
                    (
                        $shipping->getName(),
                        $shipping->getPrice(),
                        "<div class='span12' style='text-align:center'><a href='javascript:update(".json_encode($shipping).")' class='btn btn-info'><i class='fas fa-edit'></i></a></div>",
                        "<div class='span12' style='text-align:center'><a href='javascript:remove(".$shipping->getId().")' class='btn btn-danger'><i class='far fa-trash-alt'></i></a></div>"
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
        /* Insert new shipping */
        function insertShipping()
        {
            try
            {
                /* Check if for the empty or null name and price parameters */
                if(isset($_POST["name"]) && isset($_POST["price"]))
                {
                    // Get the name from POST request to check
                    $check_data = array(
                        ':name' => $_POST["name"]
                    );
                    // Get the name and price from POST request to insert
                    $form_data = array(
                        ':name'  => $_POST["name"], 
                        ':price' => $_POST["price"]
                    );
                    // Check for existent shipping with the same name in Database
                    $query = "
                            select id 
                            from t_shipping 
                            where name = :name
                            ";
                    // Create object to connect to MySQL using PDO
                    $mysqlPDO = new MySQLPDO();
                    // Prepare the query 
                    $statement = $mysqlPDO->getConnection()->prepare($query);
                    // Execute the query with passed parameter name
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
                        // Create a SQL query to insert an shipping with a new name and price
                        $query = "
                                insert t_shipping(name, price) values(:name, :price);
                                ";
                        // Prepare the query 
                        $statement = $mysqlPDO->getConnection()->prepare($query);
                        // Execute the query with passed parameter name and price
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
                    if(!isset($_POST["name"]) && !isset($_POST["price"]))
                        $data[] = array('result' => 'Missing all parameters for insert an new shipping!');
                    else if(!isset($_POST["name"]))
                        $data[] = array('result' => 'Missing name parameter');
                    else
                        $data[] = array('result' => 'Missing price parameter');
                }
                return $data;
            } 
            catch (PDOException $e) 
            {
                die("Error message: " . $e->getMessage());
            }
        }
        /* Update shipping */
        function updateShipping()
        {
            try
            {
                /* Check if for the empty or null id, name and price parameters */
                if(isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["price"]))
                {
                    // Get the id and name from POST request to check
                    $check_data = array(
                        ':id'    => $_POST["id"],
                        ':name'  => $_POST["name"]
                    );
                    // Get the id, name and price from POST request to update
                    $form_data = array(
                        ':id'    => $_POST["id"],
                        ':name'  => $_POST["name"],
                        ':price' => $_POST["price"]
                    );
                    // Check for existent shipping with the same name but different id in Database
                    $query = "
                            select id 
                            from t_shipping 
                            where id != :id and name = :name
                            ";
                    // Create object to connect to MySQL using PDO
                    $mysqlPDO = new MySQLPDO();
                    // Prepare the query 
                    $statement = $mysqlPDO->getConnection()->prepare($query);
                    // Execute the query with passed parameter id and name
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
                        // Create a SQL query to update an existent shipping with a new name and price with passed id
                        $query = "
                                update t_shipping
                                set name  = :name,
                                    price = :price
                                where id = :id;
                                ";
                        // Prepare the query 
                        $statement = $mysqlPDO->getConnection()->prepare($query);
                        // Execute the query with passed parameter id, name and price
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
                    if(!isset($_POST["id"]) && !isset($_POST["name"]) && !isset($_POST["price"]))
                        $data[] = array('result' => 'Missing all parameters for update an existent shipping!');
                    else if(!isset($_POST["id"]))
                        $data[] = array('result' => 'Missing id parameter');
                        else if(!isset($_POST["name"]))
                        $data[] = array('result' => 'Missing name parameter');
                    else
                        $data[] = array('result' => 'Missing price parameter');
                }
                return $data;
            } 
            catch (PDOException $e) 
            {
                die("Error message: " . $e->getMessage());
            }
        }
        /* Remove shipping */
        function removeShipping()
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
                    // Create a SQL query to remove an existent shipping with passed id
                    $query = "
                            delete from t_shipping
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
        /* Shipping Actions End */
        /**************************/
    }
?>
