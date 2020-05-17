<?php
    // Import the needed classes
    require_once("mysql_pdo.php");
    require_once("../classes/product.php");
    // Online Shop API for Product CRUD Class
    class OnlineShopProductAPI
    {
        /* Product Actions Begin */
        /* Retrieve all product back end on the database */
        function fetchAllProductBackEnd()
        {
            try
            {
                // Select all product
                $query = "select * from t_product";
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
                    // Create a Product object
                    $product = new Product($row);
                    //Create datatable row
                    $tmp_data[] = array
                    (
                        $product->getName(),
                        $product->getPrice(),
                        $product->getQuantity(),
                        $product->getUnit(),
                        "<div class='span12' style='text-align:center'><a href='javascript:rating(".$product->getId().")' class='btn btn-primary'><i class='far fa-star'></i></a></div>",
                        "<div class='span12' style='text-align:center'><a href='javascript:update(".json_encode($product).")' class='btn btn-info'><i class='fas fa-edit'></i></a></div>",
                        "<div class='span12' style='text-align:center'><a href='javascript:remove(".$product->getId().")' class='btn btn-danger'><i class='far fa-trash-alt'></i></a></div>"
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
        /* Retrieve all product front end on the database */
        function fetchAllProductFrontEnd()
        {
            try
            {
                // Select all product
                $query = "select * from t_product";
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
                    // Create a Product object
                    $product = new Product($row);
                    //Create datatable row
                    $tmp_data[] = array
                    (
                        $product->getId(),
                        $product->getName(),
                        $product->getPrice(),
                        $product->getQuantity(),
                        $product->getUnit()
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
        /* Retrieve single product on the database */
        function fetchSingleProduct()
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
                    // Create a SQL query to remove an existent product with passed id
                    $query = "
                            select *
                            from t_product
                            where id = :id;
                            ";
                    // Create object to connect to MySQL using PDO
                    $mysqlPDO = new MySQLPDO();
                    // Prepare the query 
                    $statement = $mysqlPDO->getConnection()->prepare($query);
                    // Execute the query without paramters
                    $statement->execute($form_data);
                    // Get affect rows in associative array
                    $row = $statement->fetch();
                    // Check if there's any record for this id
                    if($row) 
                    {
                        // Create a Product object
                        $product = new Product($row);
                        $data[] = $product;
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
        /* Retrieve all product by group on the database */
        function fetchAllProductByGroup()
        {
            try
            {
                /* Check if for the empty or null id parameters */
                if(isset($_POST["offset"]) && isset($_POST["limit"]))
                {
                    // Get the id from POST request to remove
                    $form_data = array(
                        ':offset' => $_POST["offset"] - 1,
                        ':limit'  => $_POST["limit"]
                    );
                    // Select all product
                    $query = "
                            select *
                            from t_product
                            limit :offset, :limit"
                            ;
                    // Create object to connect to MySQL using PDO
                    $mysqlPDO = new MySQLPDO();
                    // Prepare the query 
                    $statement = $mysqlPDO->getConnection()->prepare($query);
                    // Execute the query with paramters
                    $statement->bindValue(':limit', $form_data[':limit'], PDO::PARAM_INT);
                    $statement->bindValue(':offset', $form_data[':offset']*$form_data[':limit'], PDO::PARAM_INT);
                    $statement->execute();
                    // Get affect rows in associative array
                    $rows = $statement->fetchAll();
                    // Foreach row in array
                    foreach ($rows as $row) 
                    {
                        // Create a Product object
                        $product = new Product($row);
                        //Create datatable row
                        $tmp_data[] = $product;                        
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
                else
                {
                    // Check for missing parameters
                    if(!isset($_POST["offset"]) && !isset($_POST["limit"]))
                        $data[] = array('result' => 'Missing offset and limit parameter!');
                    else if(!isset($_POST["offset"]))
                        $data[] = array('result' => 'Missing offset parameter!');
                    else
                        $data[] = array('result' => 'Missing limit parameter!');
                }
            }
            catch (PDOException $e) 
            {
                die("Error message: " . $e->getMessage());
            }
        }
        /* Insert new product */
        function insertProduct()
        {
            try
            {
                /* Check if for the empty or null name, price, quantity and unit parameters */
                if(isset($_POST["name"]) && isset($_POST["price"]) && isset($_POST["quantity"]) && isset($_POST["unit"]))
                {
                    // Get the name from POST request to check
                    $check_data = array(
                        ':name' => $_POST["name"]
                    );
                    // Get the name, price, quantity and unit from POST request to insert
                    $form_data = array(
                        ':name'     => $_POST["name"], 
                        ':price'    => $_POST["price"],
                        ':quantity' => $_POST["quantity"],
                        ':unit'     => $_POST["unit"]
                    );
                    // Check for existent product with the same name in Database
                    $query = "
                            select id 
                            from t_product
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
                        // Create a SQL query to insert an product with a new name, price, quantity and unit
                        $query = "
                                insert t_product(name, price, quantity, unit) values(:name, :price, :quantity, :unit);
                                ";
                        // Prepare the query 
                        $statement = $mysqlPDO->getConnection()->prepare($query);
                        // Execute the query with passed parameter name, price, quantity and unit
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
                    if(!isset($_POST["name"]) && !isset($_POST["price"]) && !isset($_POST["quantity"]) && !isset($_POST["unit"]))
                        $data[] = array('result' => 'Missing all parameters for insert an new product!');
                    else if(!isset($_POST["name"]))
                        $data[] = array('result' => 'Missing name parameter');
                    else if(!isset($_POST["price"]))
                        $data[] = array('result' => 'Missing price parameter');
                    else if(!isset($_POST["quantity"]))
                        $data[] = array('result' => 'Missing quantity parameter');
                    else
                        $data[] = array('result' => 'Missing unit parameter');
                }
                return $data;
            } 
            catch (PDOException $e) 
            {
                die("Error message: " . $e->getMessage());
            }
        }
        /* Update product */
        function updateProduct()
        {
            try
            {
                /* Check if for the empty or null id, name, price, quantity and unit parameters */
                if(isset($_POST["id"]) && isset($_POST["name"]) && isset($_POST["price"]) && isset($_POST["quantity"]) && isset($_POST["unit"]))
                {
                    // Get the id and name from POST request to check
                    $check_data = array(
                        ':id'    => $_POST["id"],
                        ':name'  => $_POST["name"]
                    );
                    // Get the id, name, price, quantity and unit from POST request to update
                    $form_data = array(
                        ':id'       => $_POST["id"],
                        ':name'     => $_POST["name"],
                        ':price'    => $_POST["price"],
                        ':quantity' => $_POST["quantity"],
                        ':unit'     => $_POST["unit"],
                    );
                    // Check for existent product with the same name but different id in Database
                    $query = "
                            select id 
                            from t_product 
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
                        // Create a SQL query to update an existent product with a new name, price, quantity and unit with passed id
                        $query = "
                                update t_product
                                set name     = :name,
                                    price    = :price,
                                    quantity = :quantity,
                                    unit     = :unit
                                where id = :id;
                                ";
                        // Prepare the query 
                        $statement = $mysqlPDO->getConnection()->prepare($query);
                        // Execute the query with passed parameter id, username, password and access
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
                    if(!isset($_POST["id"]) && !isset($_POST["name"]) && !isset($_POST["price"]) && !isset($_POST["quantity"]) && !isset($_POST["unit"]))
                        $data[] = array('result' => 'Missing all parameters for update an existent product!');
                    else if(!isset($_POST["id"]))
                        $data[] = array('result' => 'Missing id parameter');
                    else if(!isset($_POST["name"]))
                        $data[] = array('result' => 'Missing name parameter');
                    else if(!isset($_POST["price"]))
                        $data[] = array('result' => 'Missing price parameter');
                    else if(!isset($_POST["quantity"]))
                        $data[] = array('result' => 'Missing quantity parameter');
                    else
                        $data[] = array('result' => 'Missing unit parameter');
                }
                return $data;
            } 
            catch (PDOException $e) 
            {
                die("Error message: " . $e->getMessage());
            }
        }
        /* Remove product */
        function removeProduct()
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
                    // Create a SQL query to remove an existent product with passed id
                    $query = "
                            delete from t_product
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
        /* Product Actions End */
        /***********************/
    }
?>
