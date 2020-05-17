<?php
    // Import the neeeded class
    require_once('api_user.php');
    require_once('api_shipping.php');
    require_once('api_product.php');
    require_once('api_rating.php');
    require_once('api_client.php');
    require_once('api_order.php');

    // Create a Online Shop API for User CRUD
    $onlineShopUserAPI = new OnlineShopUserAPI();

    // Create a Online Shop API for Shipping CRUD
    $onlineShopShippingAPI = new OnlineShopShippingAPI();

    // Create a Online Shop API for Product CRUD
    $onlineShopProductAPI = new OnlineShopProductAPI();

    // Create a Online Shop API for Rating CRUD
    $onlineShopRatingAPI = new OnlineShopRatingAPI();

    // Create a Online Shop API for Client CRUD
    $onlineShopClientAPI = new OnlineShopClientAPI();

    // Create a Online Shop API for Order CRUD
    $onlineShopOrderAPI = new OnlineShopOrderAPI();

    /**********************/
    
    /* User Actions Begin */
    // Perform login action
    if($_GET["action"] == 'logIn')
    {
        $data = $onlineShopUserAPI->logIn();
        $data = $data[0];
    }
    // Perform logout action
    else if($_GET["action"] == 'logOut')
    {
        $data = $onlineShopUserAPI->logOut();
        $data = $data[0];
    }
    // Perform change logged user info action
    else if($_GET["action"] == 'changeLoggedUserInfo')
    {
        $data = $onlineShopUserAPI->changeLoggedUserInfo();
        $data = $data[0];
    }
    // Perform fetch all users action
    else if($_GET["action"] == 'fetchAllUser')
    {
        $data = $onlineShopUserAPI->fetchAllUser();
    }
    // Perform insert user action
    else if($_GET["action"] == 'insertUser')
    {
        $data = $onlineShopUserAPI->insertUser();
        $data = $data[0];
    }
    // Perform update user action
    else if($_GET["action"] == 'updateUser')
    {
        $data = $onlineShopUserAPI->updateUser();
        $data = $data[0];
    }
    // Perform remove user action
    else if($_GET["action"] == 'removeUser')
    {
        $data = $onlineShopUserAPI->removeUser();
        $data = $data[0];
    }
    /* User Action End */

    /*************************/

    /* Shipping Action Begin */
    // Perform fetch all shipping action
    else if($_GET["action"] == 'fetchAllShipping')
    {
        $data = $onlineShopShippingAPI->fetchAllShipping();
    }
    // Perform fetch all shipping to select action
    else if ($_GET["action"] == 'fetchAllShippingToSelect')
    {
        $data = $onlineShopShippingAPI->fetchAllShippingToSelect();
    }
    // Perform insert shipping action
    else if($_GET["action"] == 'insertShipping')
    {
        $data = $onlineShopShippingAPI->insertShipping();
        $data = $data[0];
    }
    // Perform update shipping action
    else if($_GET["action"] == 'updateShipping')
    {
        $data = $onlineShopShippingAPI->updateShipping();
        $data = $data[0];
    }
    // Perform remove shipping action
    else if($_GET["action"] == 'removeShipping')
    {
        $data = $onlineShopShippingAPI->removeShipping();
        $data = $data[0];
    }
    /* Shipping Action End */

    /***********************/
    
    /* Product Action Begin */
    // Perform fetch all product front end action
    else if($_GET["action"] == 'fetchAllProductFrontEnd')
    {
        $data = $onlineShopProductAPI->fetchAllProductFrontEnd();
    }
    // Perform fetch all product back end action
    else if($_GET["action"] == 'fetchAllProductBackEnd')
    {
        $data = $onlineShopProductAPI->fetchAllProductBackEnd();
    }
    // Perform fetch single product action
    else if($_GET["action"] == 'fetchSingleProduct')
    {
        $data = $onlineShopProductAPI->fetchSingleProduct();
        $data = $data[0];
    }
    // Perform fetch group of product action
    else if($_GET["action"] == 'fetchAllProductByGroup')
    {
        $data = $onlineShopProductAPI->fetchAllProductByGroup();
    }
    // Perform insert product action
    else if($_GET["action"] == 'insertProduct')
    {
        $data = $onlineShopProductAPI->insertProduct();
        $data = $data[0];
    }
    // Perform update product action
    else if($_GET["action"] == 'updateProduct')
    {
        $data = $onlineShopProductAPI->updateProduct();
        $data = $data[0];
    }
    // Perform remove product action
    else if($_GET["action"] == 'removeProduct')
    {
        $data = $onlineShopProductAPI->removeProduct();
        $data = $data[0];
    }
    /* Product Action End */

    /************************/

    /* Rating Action Begin */
    // Perform fetch all rating action
    else if($_GET["action"] == 'fetchAllRating')
    {
        $data = $onlineShopRatingAPI->fetchAllRating();
    }
    // Perform remove rating action
    else if($_GET["action"] == 'insertRating')
    {
        $data = $onlineShopRatingAPI->insertRating();
        $data = $data[0];
    }
    /* Rating Action End */

    /***********************/

    /* Client Actions Begin */
    // Perform login action
    else if($_GET["action"] == 'logInClient')
    {
        $data = $onlineShopClientAPI->logIn();
        $data = $data[0];
    }
    // Perform login action
    else if($_GET["action"] == 'signUpClient')
    {
        $data = $onlineShopClientAPI->signUp();
        $data = $data[0];
    }
    // Perform logout action
    else if($_GET["action"] == 'logOutClient')
    {
        $data = $onlineShopClientAPI->logOut();
        $data = $data[0];
    }
	// Perform change logged client info action
	else if($_GET["action"] == 'changeLoggedClientInfo')
	{
		$data = $onlineShopClientAPI->changeLoggedInfo();
		$data = $data[0];
	}
    // Perform fetch all client action
    else if($_GET["action"] == 'fetchAllClient')
    {
        $data = $onlineShopClientAPI->fetchAllClient();
    }
    // Perform fetch single client action
    else if($_GET["action"] == 'fetchSingleClient')
    {
        $data = $onlineShopClientAPI->fetchSingleClient();
		$data = $data[0];
    }
    // Perform insert client action
    else if($_GET["action"] == 'insertClient')
    {
        $data = $onlineShopClientAPI->insertClient();
        $data = $data[0];
    }
    // Perform update client action
    else if($_GET["action"] == 'updateClient')
    {
        $data = $onlineShopClientAPI->updateClient();
        $data = $data[0];
    }
    // Perform remove client action
    else if($_GET["action"] == 'removeClient')
    {
        $data = $onlineShopClientAPI->removeClient();
        $data = $data[0];
    }
    /* Client Action End */

    /*********************/

    /* Order Action Begin */
    // Perform fetch all rating action
    else if($_GET["action"] == 'fetchAllOrder')
    {
        $data = $onlineShopOrderAPI->fetchAllOrder();
    }
    // Perform remove rating action
    else if($_GET["action"] == 'removeOrder')
    {
        $data = $onlineShopOrderAPI->removeOrder();
        $data = $data[0];
    }
    /* Order Action End */

    /***********************/

    // No action to perform
    else
    {
        $data = array('result' => 'No action to perform!');
    }
    // Convert data[] to json
    echo json_encode($data);
?>