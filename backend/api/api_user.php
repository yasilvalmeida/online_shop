<?php
    // Import the needed classes
    require_once("mysql_pdo.php");
    require_once("../object/user.php");
    // Online Shop API for User CRUD Class
    class OnlineShopUserAPI
    {
        /* User Actions Begin */
        /* Do the login */
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
                    // Create a SQL query to check if exist this user with username and password
                    $query = "
                            select id, access 
                            from t_user 
                            where username = :username and password = :password
                            ";
                    // Create object to connect to MySQL using PDO
                    $mysqlPDO = new MySQLPDO();
                    // Prepare the query 
                    $statement = $mysqlPDO->getConnection()->prepare($query);
                    // Execute the query with passed parameters username and password
                    $statement->execute($form_data);
                    // Get affect rows in associative array
                    $row = $statement->fetch(PDO::FETCH_ASSOC);
                    // Check if any affected row
                    if($row)
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
                        // Set user info into php session
                        $_SESSION[$_SESSION['views'].'id'] = $row['id'];
                        $_SESSION[$_SESSION['views'].'username'] = $form_data[':username'];
                        $_SESSION[$_SESSION['views'].'password'] = $form_data[':password'];
                        $_SESSION[$_SESSION['views'].'access'] = $row['access'];
                        // data[] is a associative array that return json
                        $data[] = array('result' => '1');
                    }
                    else
                    {
                        $data[] = array('result' => 'Wrong credentials!');
                    }
                }
                else
                {
                    // Check for missing parameters in POST data
                    if(!isset($_POST["username"]) && !isset($_POST["password"]))
                        $data[] = array('result' => 'Missing all user login parameters!');
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
        /* Do the logout */
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
                    unset($_SESSION[$_SESSION['views'].'access']);
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
        /* Change Logged User Information */
        function changeLoggedUserInfo()
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
                    // Check for existent data in Database
                    $query = "
                            select access
                            from t_user 
                            where id = ?
                            ";
                    // Create object to connect to MySQL using PDO
                    $mysqlPDO = new MySQLPDO();
                    // Prepare the query 
                    $statement = $mysqlPDO->getConnection()->prepare($query);
                    // Execute the query with passed parameter id
                    $statement->execute([$form_data[':id']]);
                    // Get affect rows in associative array
                    $row = $statement->fetch(PDO::FETCH_ASSOC);
                    // Check if any affected row
                    if($row)
                    {
                        // Create a SQL query to update the existent user with a new username and password for this passed id
                        $query = "
                                update t_user
                                set username = :username, password = :password 
                                where id = :id
                                ";
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
                                // Update new logged user info into session 
                                $_SESSION[$_SESSION['views'].'id'] = $form_data[':id'];
                                $_SESSION[$_SESSION['views'].'username'] = $form_data[':username'];
                                $_SESSION[$_SESSION['views'].'password'] = $form_data[':password'];
                                $_SESSION[$_SESSION['views'].'access'] = $row['access'];
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
                        $data[] = array('result' => 'Invalid user id!');
                }
                else
                {
                    // Check for missing parameters
                    if(!isset($_POST["id"]) && !isset($_POST["username"]) && !isset($_POST["password"]))
                        $data[] = array('result' => 'Missing all change logged user info parameters!');
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
        /* Retrieve all users on the database */
        function fetchAllUser()
        {
            try 
            {
                // Select all users
                $query = "select * from t_user";
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
                    // Create a User object
                    $user = new User($row);
                    //Create datatable row
                    $tmp_data[] = array
                    (
                        $user->getUsername(),
                        "********",
                        $user->getAccess(),
                        "<div class='span12' style='text-align:center'><a href='javascript:update(".json_encode($user).")' class='btn btn-info'><i class='fas fa-edit'></i></a></div>",
                        "<div class='span12' style='text-align:center'><a href='javascript:remove(".$user->getId().")' class='btn btn-danger'><i class='far fa-trash-alt'></i></a></div>"
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
        /* Insert new user */
        function insertUser()
        {
            try
            {
                /* Check if for the empty or null username, password and access parameters */
                if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["access"]))
                {
                    // Get the username from POST request to check
                    $check_data = array(
                        ':username' => $_POST["username"]
                    );
                    // Get the username, password and access from POST request to insert
                    $form_data = array(
                        ':username' => $_POST["username"], 
                        ':password' => $_POST["password"], 
                        ':access'   => $_POST["access"]
                    );
                    // Check for existent user with the same username in Database
                    $query = "
                            select id 
                            from t_user 
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
                        // Create a SQL query to insert an new user with a new username, password and access
                        $query = "
                                insert t_user(username, password, access) values(:username, :password, :access);
                                ";
                        // Prepare the query 
                        $statement = $mysqlPDO->getConnection()->prepare($query);
                        // Execute the query with passed parameter username, password and access
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
                    if(!isset($_POST["username"]) && !isset($_POST["password"]) && !isset($_POST["access"]))
                        $data[] = array('result' => 'Missing all parameters for insert an new user!');
                    else if(!isset($_POST["username"]))
                        $data[] = array('result' => 'Missing username parameter');
                    else if(!isset($_POST["password"]))
                        $data[] = array('result' => 'Missing password parameter');
                    else
                        $data[] = array('result' => 'Missing access parameter');
                }
                return $data;
            } 
            catch (PDOException $e) 
            {
                die("Error message: " . $e->getMessage());
            }
        }
        /* Update user */
        function updateUser()
        {
            try
            {
                /* Check if for the empty or null id, username, password and access parameters */
                if(isset($_POST["id"]) && isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["access"]))
                {
                    // Get the id and username from POST request to check
                    $check_data = array(
                        ':id'       => $_POST["id"],
                        ':username' => $_POST["username"]
                    );
                    // Get the id, username, password and access from POST request to update
                    $form_data = array(
                        ':id'       => $_POST["id"],
                        ':username' => $_POST["username"],
                        ':password' => $_POST["password"],
                        ':access'   => $_POST["access"]
                    );
                    // Check for existent user with the same username but different id in Database
                    $query = "
                            select id 
                            from t_user 
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
                        // Create a SQL query to update an existent user with a new username, password and access with passed id
                        $query = "
                                update t_user
                                set username = :username,
                                    password = :password,
                                    access = :access
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
                    if(!isset($_POST["id"]) && !isset($_POST["username"]) && !isset($_POST["password"]) && !isset($_POST["access"]))
                        $data[] = array('result' => 'Missing all parameters for update an existent user!');
                    else if(!isset($_POST["id"]))
                        $data[] = array('result' => 'Missing id parameter');
                        else if(!isset($_POST["username"]))
                        $data[] = array('result' => 'Missing username parameter');
                    else if(!isset($_POST["password"]))
                        $data[] = array('result' => 'Missing password parameter');
                    else
                        $data[] = array('result' => 'Missing access parameter');
                }
                return $data;
            } 
            catch (PDOException $e) 
            {
                die("Error message: " . $e->getMessage());
            }
        }
        /* Remove user */
        function removeUser()
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
                    // Create a SQL query to remove an existent user with passed id
                    $query = "
                            delete from t_user
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
        /* User Actions End */
        /**************************/
    }
?>
