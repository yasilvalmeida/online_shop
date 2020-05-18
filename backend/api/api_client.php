<?php
    // Import the needed classes
    require_once("mysql_pdo.php");
    require_once("../classes/client.php");
    // Online Shop API for Client CRUD Class
    class OnlineShopClientAPI
    {
        /* Client Actions Begin */
        /* Do the login client */
        function logIn()
        {
            try
            {
                /* Check if for the empty or null username and password parameters */
                if(isset($_POST["username"]) && isset($_POST["password"]))
                {
                    // Get the username and password parameters from POST request
                    $form_data = array(
                        ':username'  => $_POST["username"], 
                        ':password'  => $_POST["password"]
                    );
                    // Get the username parameter from POST request for checking
                    $check_data = array(
                        ':username'  => $_POST["username"]
                    );
                    // Create a SQL query to check if exist this client with this username
                    $query = "
                            select id
                            from t_client 
                            where username = :username
                            ";
                    // Create object to connect to MySQL using PDO
                    $mysqlPDO = new MySQLPDO();
                    // Prepare the query 
                    $statement = $mysqlPDO->getConnection()->prepare($query);
                    // Execute the query with passed parameters username and password
                    $statement->execute($check_data);
                    // Get affect rows in associative array
                    $row = $statement->fetch(PDO::FETCH_ASSOC);
                    // Check if any affected row
                    if($row)
                    {
                        // Create a SQL query to check if match this client with username and password
                        $query = "
                                select id, initial_balance
                                from t_client 
                                where username = :username and password = :password
                                ";
                        // Prepare the query 
                        $statement = $mysqlPDO->getConnection()->prepare($query);
                        // Execute the query with passed parameters username and password
                        $statement->execute($form_data);
                        // Get affect rows in associative array
                        $row1 = $statement->fetch(PDO::FETCH_ASSOC);
                        // Check if any affected row
                        if($row1)
                        {
                            // Create session
                            session_start();
                            // Check if there's any open session
                            if(isset($_SESSION['views']))
                            {
                                // Increment the open session + 1
                                $_SESSION['views']++;
                            }
                            else
                            {
                                // Open new session
                                $_SESSION['views'] = 1;
                            }
                            // Set client info into php session
                            $_SESSION[$_SESSION['views'].'id'] = $row1['id'];
                            $_SESSION[$_SESSION['views'].'username'] = $form_data[':username'];
                            $_SESSION[$_SESSION['views'].'password'] = $form_data[':password'];
                            $_SESSION[$_SESSION['views'].'initial_balance'] = $row1['initial_balance'];
                            // data[] is a associative array that return json
                            $data[] = array('result' => '1');
                        }
                        else{
                            $data[] = array('result' => 'Wrong credentials!');
                        }
                    }
                    else
                    {
                        $data[] = array('result' => 'Username not found in records!');
                    }
                }
                else
                {
                    // Check for missing parameters in POST data
                    if(!isset($_POST["username"]) && !isset($_POST["password"]))
                        $data[] = array('result' => 'Missing all client login parameters!');
                    else if(!isset($_POST["username"]))
                        $data[] = array('result' => 'Missing username parameter!');
                    else
                        $data[] = array('result' => 'Missing password parameter!');
                }
                return $data;
            } 
            catch (PDOException $e) 
            {
                die("Error message: " . $e->getMessage());
            }
        }
        /* Do the sign up client */
        function signUp()
        {
            try
            {
                /* Check if for the empty or null username and password parameters */
                if(isset($_POST["username"]) && isset($_POST["password"]))
                {
                    // Get the username and password parameters from POST request
                    $form_data = array(
                        ':username' => $_POST["username"], 
                        ':password' => $_POST["password"]
                    );
                    // Get the username from POST request for check for existent username
                    $check_data = array(
                        ':username'  => $_POST["username"]
                    );
                    // Create a SQL query to check if exist this client with username and password
                    $query = "
                            select id
                            from t_client 
                            where username = :username
                            ";
                    // Create object to connect to MySQL using PDO
                    $mysqlPDO = new MySQLPDO();
                    // Prepare the query 
                    $statement = $mysqlPDO->getConnection()->prepare($query);
                    // Execute the query with passed parameters username and password
                    $statement->execute($check_data);
                    // Get affect rows in associative array
                    $row = $statement->fetch(PDO::FETCH_ASSOC);
                    // Check if any affected row
                    if($row)
                    {
                        $data[] = array('result' => 'Username already exist!');
                    }
                    else
                    {
                        // Create a SQL query to check if exist this client with username and password
                        $query = "
                                insert into t_client(username, password) 
                                values(:username, :password)
                                ";
                        // Prepare the query 
                        $statement = $mysqlPDO->getConnection()->prepare($query);
                        // Execute the query with passed parameters username and password
                        $statement->execute($form_data);
                        // Get affect rows in associative array
                        $row = $statement->fetch(PDO::FETCH_ASSOC);
                        // data[] is a associative array that return json
                        $data[] = array('result' => '1');
                    }
                }
                else
                {
                    // Check for missing parameters in POST data
                    if(!isset($_POST["username"]) && !isset($_POST["password"]))
                        $data[] = array('result' => 'Missing all client sign up parameters!');
                    else if(!isset($_POST["username"]))
                        $data[] = array('result' => 'Missing username parameter!');
                    else
                        $data[] = array('result' => 'Missing password parameter!');
                }
                return $data;
            } 
            catch (PDOException $e) 
            {
                die("Error message: " . $e->getMessage());
            }
        }
        /* Do the logout client */
        function logOut()
        {
            try
            {
                // Inialize session
                session_start();
                // Check for open session
                if(isset($_SESSION['views']))
                {
                    // Remove info for this views
                    unset($_SESSION[$_SESSION['views'].'id']);
                    unset($_SESSION[$_SESSION['views'].'username']);
                    unset($_SESSION[$_SESSION['views'].'password']);
                    unset($_SESSION[$_SESSION['views'].'balance']);
                    $_SESSION['views'] = $_SESSION['views'] - 1;
                    // data[] is a associative array that return json
                    $data[] = array('result' => '1');
                }
                else{
                    $data[] = array('result' => 'No such session available!');
                }
                return $data;
            } 
            catch (PDOException $e) 
            {
                die("Error message: " . $e->getMessage());
            }
        }
        /* Change Logged Client Information */
        function changeLoggedInfo()
        {
            try
            {
                /* Check if for the empty or null id, username and password parameters */
                if(isset($_POST["id"]) && isset($_POST["username"]) && isset($_POST["password"]))
                {
                    // Get the id, username and password parameters from POST request
                    $form_data = array(
                        ':id'        => $_POST["id"], 
                        ':username'  => $_POST["username"], 
                        ':password'  => $_POST["password"]
                    );
                    // Create a SQL query to update the existent client with a new username and password for this passed id
                    $query = "
                            update t_client
                            set username = :username, password = :password 
                            where id = :id
                            ";
                    // Create object to connect to MySQL using PDO
                    $mysqlPDO = new MySQLPDO();
                    // Prepare the query 
                    $statement = $mysqlPDO->getConnection()->prepare($query);
                    // Execute the query with passed parameter id, username and password
                    $statement->execute($form_data);
                    // Check if any affected row
                    if ($statement->rowCount())
                    {
                        // Create session
                        session_start();
                        // Check for open session
                        if(isset($_SESSION['views']))
                        {
                            // Update new logged client info into session 
                            $_SESSION[$_SESSION['views'].'id'] = $form_data[':id'];
                            $_SESSION[$_SESSION['views'].'username'] = $form_data[':username'];
                            $_SESSION[$_SESSION['views'].'password'] = $form_data[':password'];
                            // data[] is a associative array that return json
                            $data[] = array('result' => '1');
                        }
                        else
                        {
                            $data[] = array('result' => 'No such session available!');
                        }
                    } else
                    {
                        $data[] = array('result' => 'No affected row!');
                    }
                }
                else
                {
                    // Check for missing parameters
                    if(!isset($_POST["id"]) && !isset($_POST["username"]) && !isset($_POST["password"]))
                        $data[] = array('result' => 'Missing all change logged client info parameters!');
                    else if(!isset($_POST["id"]))
                        $data[] = array('result' => 'Missing id parameter!');
                    else if(!isset($_POST["username"]))
                        $data[] = array('result' => 'Missing username parameter!');
                    else
                        $data[] = array('result' => 'Missing password parameter!');
                }
                return $data;
            } 
            catch (PDOException $e) 
            {
                die("Error message: " . $e->getMessage());
            }
        }
        /* Retrieve all clients on the database */
        function fetchAllClient()
        {
            try
            {
                // Select all clients
                $query = "
                        select c.id, c.username, c.password, c.initial_balance, ifnull(round(sum(i.quantity*p.price), 2), 0) as balance
                        from t_client c
                        left join t_order o
                        on c.id = o.t_client_fk
                        left join t_item i
                        on o.id = i.t_order_fk
                        left join t_product p
                        on i.t_product_fk = p.id
                        group by c.id, c.username, c.password, c.initial_balance
                        ";
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
                    // Create a Client object
                    $client = new Client($row);
                    //Create datatable row
                    $tmp_data[] = array
                    (
                        $client->getUsername(),
                        "********",
                        $client->getInitialBalance(),
                        $client->getBalance(),
                        "<div class='span12' style='text-align:center'><a href='javascript:order(".$client->getId().")' class='btn btn-primary'><i class='fas fa-shopping-cart'></i></a></div>",
                        "<div class='span12' style='text-align:center'><a href='javascript:update(".json_encode($client).")' class='btn btn-info'><i class='fas fa-edit'></i></a></div>",
                        "<div class='span12' style='text-align:center'><a href='javascript:remove(".$client->getId().")' class='btn btn-danger'><i class='far fa-trash-alt'></i></a></div>"
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
        /* Retrieve single clients on the database */
        function fetchSingleClient()
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
                    // Create a SQL query to remove an existent client with passed id
                    $query = "
                            select *
                            from t_client
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
                        // Create a Client object
                        $client = new Client($row);
                        $data[] = $client;
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
                        $data[] = array('result' => 'Missing id parameter! ');
                }
                return $data;
            }
            catch (PDOException $e) 
            {
                die("Error message: " . $e->getMessage());
            }
        }
        /* Insert new client */
        function insertClient()
        {
            try
            {
                /* Check if for the empty or null username, password and balance parameters */
                if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["balance"]))
                {
                    // Get the username from POST request to check
                    $check_data = array(
                        ':username' => $_POST["username"]
                    );
                    // Get the username, password and balance from POST request to insert
                    $form_data = array(
                        ':username' => $_POST["username"], 
                        ':password' => $_POST["password"], 
                        ':balance'   => $_POST["balance"]
                    );
                    // Check for existent client with the same username in Database
                    $query = "
                            select id 
                            from t_client 
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
                        // Create a SQL query to insert an new client with a new username, password and balance
                        $query = "
                                insert t_client(username, password, balance) values(:username, :password, :balance);
                                ";
                        // Prepare the query 
                        $statement = $mysqlPDO->getConnection()->prepare($query);
                        // Execute the query with passed parameter username, password and balance
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
                    if(!isset($_POST["username"]) && !isset($_POST["password"]) && !isset($_POST["balance"]))
                        $data[] = array('result' => 'Missing all parameters for insert an new client!');
                    else if(!isset($_POST["username"]))
                        $data[] = array('result' => 'Missing username parameter');
                    else if(!isset($_POST["password"]))
                        $data[] = array('result' => 'Missing password parameter');
                    else
                        $data[] = array('result' => 'Missing balance parameter');
                }
                return $data;
            } 
            catch (PDOException $e) 
            {
                die("Error message: " . $e->getMessage());
            }
        }
        /* Update client */
        function updateClient()
        {
            try
            {
                /* Check if for the empty or null id, username, password and balance parameters */
                if(isset($_POST["id"]) && isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["balance"]))
                {
                    // Get the id and username from POST request to check
                    $check_data = array(
                        ':id'       => $_POST["id"],
                        ':username' => $_POST["username"]
                    );
                    // Get the id, username, password and balance from POST request to update
                    $form_data = array(
                        ':id'       => $_POST["id"],
                        ':username' => $_POST["username"],
                        ':password' => $_POST["password"],
                        ':balance'   => $_POST["balance"]
                    );
                    // Check for existent client with the same username but different id in Database
                    $query = "
                            select id 
                            from t_client 
                            where id != :id and username = :username
                            ";
                    // Create object to connect to MySQL using PDO
                    $mysqlPDO = new MySQLPDO();
                    // Prepare the query 
                    $statement = $mysqlPDO->getConnection()->prepare($query);
                    // Execute the query with passed parameter id and username
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
                        // Create a SQL query to update an existent client with a new username, password and balance with passed id
                        $query = "
                                update t_client
                                set username = :username,
                                    password = :password,
                                    balance  = :balance
                                where id = :id;
                                ";
                        // Prepare the query 
                        $statement = $mysqlPDO->getConnection()->prepare($query);
                        // Execute the query with passed parameter id, username, password and balance
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
                    if(!isset($_POST["id"]) && !isset($_POST["username"]) && !isset($_POST["password"]) && !isset($_POST["balance"]))
                        $data[] = array('result' => 'Missing all parameters for update an existent client!');
                    else if(!isset($_POST["id"]))
                        $data[] = array('result' => 'Missing id parameter');
                        else if(!isset($_POST["username"]))
                        $data[] = array('result' => 'Missing username parameter');
                    else if(!isset($_POST["password"]))
                        $data[] = array('result' => 'Missing password parameter');
                    else
                        $data[] = array('result' => 'Missing balance parameter');
                }
                return $data;
            } 
            catch (PDOException $e) 
            {
                die("Error message: " . $e->getMessage());
            }
        }
        /* Remove client */
        function removeClient()
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
                    // Create a SQL query to remove an existent client with passed id
                    $query = "
                            delete from t_client
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
        /* Client Actions End */
        /**************************/
    }
?>
