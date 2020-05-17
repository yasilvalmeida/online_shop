<?php
    // Import the needed classes
    require_once("mysql_pdo.php");
    require_once("../classes/order.php");
    // Online Shop API for Order CRUD Class
    class OnlineShopOrderAPI
    {
        /* Order Actions Begin */
        /* Retrieve all order on the database to back end */
        function fetchAllOrderBackEnd()
        {
            try
            {
                /* Check if for the empty or null t_client_fk parameters */
                if(isset($_POST["t_client_fk"]))
                {
                    // Get the t_client_fk and t_shipping_fk from POST request to insert
                    $form_data = array(
                        ':t_client_fk'   => $_POST["t_client_fk"]
                    );
                    // Select all orders
                    $query = "
                            select o.id, o.date, s.name as shipping, round(sum(i.quantity*p.price), 2) as total
                            from t_order o 
                            inner join t_shipping s 
                            on o.t_shipping_fk = s.id
                            inner join t_item i
                            on o.id = i.t_order_fk
                            inner join t_product p
                            on i.t_product_fk = p.id
                            where o.t_client_fk = :t_client_fk
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
                        // Create a Order object
                        $order = new Order($row);
                        if(null !== $order->getId())
                        {
                            //Create datatable row
                            $tmp_data[] = array
                            (
                                $order->getId(),
                                $order->getDate(),
                                $order->getShipping(),
                                "<div class='span12' style='text-align:right'>".$order->getTotal()." $</div>",
                                "<div class='span12' style='text-align:center'><a href='javascript:remove(".$order->getId().")' class='btn btn-danger'><i class='far fa-trash-alt'></i></a></div>"
                            );
                        }  
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
                    // Check for missing parameters t_client_fk
                    if(!isset($_POST["t_client_fk"]))
                        $data[] = array('result' => 'Missing t_client_fk parameter');
                }
                return $data;
            } 
            catch (PDOException $e) 
            {
                die("Error message: " . $e->getMessage());
            }
        }
        /* Retrieve all order on the database to front end */
        function fetchAllOrderFrontEnd()
        {
            try
            {
                /* Check if for the empty or null t_client_fk parameters */
                if(isset($_POST["t_client_fk"]))
                {
                    // Get the t_client_fk and t_shipping_fk from POST request to insert
                    $form_data = array(
                        ':t_client_fk'   => $_POST["t_client_fk"]
                    );
                    // Select all orders
                    $query = "
                            select o.id, o.date, s.name as shipping, round(sum(i.quantity*p.price), 2) as total
                            from t_order o 
                            inner join t_shipping s 
                            on o.t_shipping_fk = s.id
                            inner join t_item i
                            on o.id = i.t_order_fk
                            inner join t_product p
                            on i.t_product_fk = p.id
                            where o.t_client_fk = :t_client_fk
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
                        // Create a Order object
                        $order = new Order($row);
                        if(null !== $order->getId())
                        {
                            //Create datatable row
                            $tmp_data[] = array
                            (
                                $order->getId(),
                                $order->getDate(),
                                $order->getShipping(),
                                $order->getTotal(),
                                'Paid'
                            );
                        }  
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
                    // Check for missing parameters t_client_fk
                    if(!isset($_POST["t_client_fk"]))
                        $data[] = array('result' => 'Missing t_client_fk parameter');
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
                /* Check if for the empty or null t_client_fk, t_shipping_fk, itens and totalPrice parameters */
                if(isset($_POST["t_client_fk"]) && isset($_POST["t_shipping_fk"]) && isset($_POST["itens"]) && isset($_POST["totalPrice"]))
                {
                    // Get the t_client_fk and t_shipping_fk from POST request to insert
                    $serverDate = date("Y-m-d h:i:sa");
                    $form_data = array(
                        ':date'          => $serverDate,
                        ':t_client_fk'   => $_POST["t_client_fk"], 
                        ':t_shipping_fk' => $_POST["t_shipping_fk"]
                    );
                    // Bought products id and quantity array
                    $itens = $_POST["itens"];
                    // Create object to connect to MySQL using PDO
                    $mysqlPDO = new MySQLPDO();
                    // Create a SQL query to insert an order with a new username, date and rate
                    $query = "
                                insert t_order(date, t_client_fk, t_shipping_fk) values(:date, :t_client_fk, :t_shipping_fk);
                            ";
                    // Prepare the query 
                    $statement = $mysqlPDO->getConnection()->prepare($query);
                    // Execute the query with passed parameter username, date and rate
                    $statement->execute($form_data);
                    // Check if any affected row
                    if ($statement->rowCount())
                    {
                        // Get the t_client_fk and t_shipping_fk from POST request to insert
                        $form_data = array(
                            ':t_client_fk'   => $_POST["t_client_fk"], 
                            ':t_shipping_fk' => $_POST["t_shipping_fk"]
                        );
                        // Create a SQL query to insert an order with a new username, date and rate
                        $query = "
                                select id
                                from t_order
                                where t_client_fk = :t_client_fk and t_shipping_fk = :t_shipping_fk
                                order by id DESC
                                limit 1
                                ";
                        // Prepare the query 
                        $statement = $mysqlPDO->getConnection()->prepare($query);
                        // Execute the query without paramters
                        $statement->execute($form_data);
                        // Get affect rows in associative array
                        $row = $statement->fetch();
                        // Foreach row in array
                        if (isset($row)) 
                        {
                            $t_order_fk = $row['id'];
                            // Create a SQL query to insert an order with a new username, date and rate
                            $query = "
                                        insert t_item(quantity, t_product_fk, t_order_fk) 
                                        values(:quantity, :t_product_fk, :t_order_fk)
                                    ";
                            // Foreach item
                            foreach($itens as $item)
                            {
                                // Get the item info from the $item in $_POST['item']
                                $form_data = array(
                                    ':t_product_fk' => $item['t_product_fk'],
                                    ':quantity'     => $item['quantity'],
                                    ':t_order_fk'   => $t_order_fk
                                );
                                // Prepare the query 
                                $statement = $mysqlPDO->getConnection()->prepare($query);
                                // Execute the query with passed parameter username, date and rate
                                $statement->execute($form_data);
                            }
                            // Get the t_client_fk and clientBalance to update the actual balance
                            $form_data = array(
                                ':t_client_fk'    => $_POST["t_client_fk"], 
                                ':totalPrice'     => $_POST["totalPrice"]
                            );
                            // Create a SQL query to insert an order with a new username, date and rate
                            $query = "
                                        update t_client
                                        set balance = balance - :totalPrice
                                        where id = :t_client_fk
                                    ";
                            // Prepare the query 
                            $statement = $mysqlPDO->getConnection()->prepare($query);
                            // Execute the query with passed parameter username, date and rate
                            $statement->execute($form_data);
                            // Check if any affected row
                            if ($statement->rowCount()) {
                                // Create session
                                session_start();
                                // Check for open session
                                if(isset($_SESSION['views']))
                                {
                                    // Update new logged client info into session 
                                    $clientBalanceStoredIntoSession = $_SESSION[$_SESSION['views'].'balance'];
                                    $_SESSION[$_SESSION['views'].'balance'] = $clientBalanceStoredIntoSession - $_POST["totalPrice"];
                                    // data[] is a associative array that return json
                                    $data[] = array('result' => '1');
                                }
                                else
                                {
                                    $data[] = array('result' => 'No such session available!');
                                }
                            }
                            else
                                $data[] = array('result' => 'Error update client balance');
                        }
                        else
                            $data[] = array('result' => 'No record found');
                    } 
                    else
                    {
                        $data[] = array('result' => 'No affected row in t_order!');
                    }
                }
                else
                {
                    // Check for missing parameters t_client_fk, t_shipping_fk, itens and totalPrice
                    if(!isset($_POST["t_client_fk"]) && !isset($_POST["t_shipping_fk"]) && !isset($_POST["itens"]) && !isset($_POST["totalPrice"]))
                        $data[] = array('result' => 'Missing all parameters for insert an new order!');
                    else if(!isset($_POST["t_client_fk"]))
                        $data[] = array('result' => 'Missing t_client_fk parameter');
                    else if(!isset($_POST["t_shipping_fk"]))
                        $data[] = array('result' => 'Missing t_shipping_fk parameter');
                    else if(!isset($_POST["itens"]))
                        $data[] = array('result' => 'Missing itens parameter');
                    else
                        $data[] = array('result' => 'Missing totalPrice parameter');
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
                            delete from t_item
                            where t_order_fk = :id;
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
                        // Create a SQL query to remove an existent order with passed id
                        $query = "
                                delete from t_order
                                where id = :id;
                                ";
                        // Prepare the query 
                        $statement = $mysqlPDO->getConnection()->prepare($query);
                        // Execute the query with passed parameter id
                        $statement->execute($form_data);
                        // Check if any affected row
                        if ($statement->rowCount())
                            $data[] = array('result' => '1'); 
                        else
                            $data[] = array('result' => 'No affected row on delete t_order!');
                    } 
                    else
                        $data[] = array('result' => 'No affected row on delete t_item!');
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
