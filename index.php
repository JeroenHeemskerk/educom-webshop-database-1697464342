<?php
include('session-manager.php');

session_start();

if (!isCartInitialized()) {
    initializeCart();
}

// ===================================
// MAIN APP
// ===================================
$page = getRequestedPage();
// Voer business logic (processRequest) uit en krijg juiste data voor pagina terug
$pageData = processRequest($page);
showResponsePage($pageData);

// ===================================
// FUNCTIONS
// ===================================

function getRequestedPage()
{
    $requestType = $_SERVER['REQUEST_METHOD'];

    if ($requestType == "POST") {
        $requestedPage = getPostVar('page', 'home');
    } else {
        $requestedPage = getUrlVar('page', 'home');
    }
    return $requestedPage;
}

function showResponsePage($pageData)
{
    beginDocument();
    showHeadSection();
    showBodySection($pageData);
    endDocument();
};


//input is de route
function processRequest($page)
{
    $pageData = [];

    switch ($page) {
        case 'home':
            $pageData['page'] = $page;
            // ["page" => "home"]
            break;
        case 'about':
            $pageData['page'] = $page;
            break;
        case 'login':
            require_once('login.php');
            $pageData = getLoginData();
            // ["page" => "login", "email" => ""]
            break;
        case 'register':
            require_once('register.php');
            $pageData = doProcessRegisterRequest();
            break;
            // ["page" => "register", "email" => ""]
            break;
        case 'contact':
            require_once('contact.php');
            $pageData = getContactData();
            // ["page" => "register", "email" => ""]
            break;
        case 'logout':
            doLogOut();
            $pageData['page'] = 'home';
            break;
        case 'webshop':
            require_once('webshop.php');
            require_once('product-service.php');
            $pageData = initializeWebshopData();
            $pageData = handleActions($pageData);
            $pageData = getWebshopData($pageData);
            break;
        case 'product':
            require_once('product.php');
            require_once('product-service.php');
            $pageData = initializeProductData();
            $pageData = handleActions($pageData);
            $pageData = getProductData($pageData);
            break;
        case 'shoppingcart':
            require_once('shoppingcart.php');
            require_once('product-service.php');
            $pageData = initializeShoppingcartData();
            $pageData = handleActions($pageData);
            $pageData = getShoppingcartData($pageData);
            break;
        default:
            $pageData['page'] = 'not found';
    }
    //webshop pagina toegevoegd
    $pageData['menu'] = array('home' => 'HOME', 'about' => 'ABOUT', 'contact' => 'CONTACT', 'webshop' => 'WEBSHOP');
    if (isUserLoggedIn()) {
        $pageData['menu']['logout'] = "LOGOUT " . getLoggedInUserName();
        $pageData['menu']['shoppingcart'] = "SHOPPINGCART";
    } else {
        $pageData['menu']['register'] = "REGISTER";
        $pageData['menu']['login'] = "LOGIN";
    }
    return $pageData;
}


// =========================================== 
function doProcessRegisterRequest()
{
    $registerData = getRegisterData();

    if ($registerData['valid']) {

        $email = $registerData['email'];
        $name = $registerData['name'];
        $password = $registerData['password'];

        require_once('database-connection.php');
        try {
            saveUser($email, $name, $password);
            require_once('login.php');
            $registerData = getInitialLoginFormData();
        } catch (Exception $e) {
            logError("registration failed: " . $e->getMessage());
            $registerData['genericErr'] = "Registreren is op dit moment niet mogelijk. Probeer het later nog eens.";
        }
    }
    return $registerData;
}

//===========================================


function getPostVar($key, $default = "")
{
    return getArrayVar($_POST, $key, $default);
};


function getUrlVar($key, $default = '')
{
    return getArrayVar($_GET, $key, $default);
};


function getArrayVar($array, $key, $default = '')
{
    return isset($array[$key]) ? $array[$key] : $default;
    // return isset($_GET['id']) ? ...
}

// ===================================================


function beginDocument()
{
    echo "<!doctype html>
    <html class='entirepage'>";
}

function showHeadSection()
{
    echo '<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/stylesheet.css">
    </head>';
}

function showBodySection($pageData)
{
    echo '    <body>' . PHP_EOL;
    showHeader($pageData['page']);
    showMenu($pageData);
    showGenericError($pageData);
    showGenericMessage($pageData);
    showContent($pageData);
    showFooter();
    echo '    </body>' . PHP_EOL;
}

function endDocument()
{
    echo  '</html>';
}

//============================================== 

function showHeader($pageTitle)
{
    echo '<h1 class="headers">' . $pageTitle . ' page</h1>';
}

function showMenu($data)
{
    echo "<nav>";
    echo "<ul class='menu'>";
    foreach ($data['menu'] as $key => $page) {
        showMenuItem($key, $page);
    }
    echo '</ul>' . PHP_EOL . '</nav>' . PHP_EOL;
}


function showMenuItem($linkName, $buttonText)
{
    echo '<li><a href="index.php?page=' . $linkName . '">' . $buttonText . '</a></li>';
}

function showGenericError($pageData)
{
    echo "</br><span class='error'>" . getArrayVar($pageData, "genericErr") . "</span></br></br>";
}

function showGenericMessage($pageData)
{
    echo "</br><span >" . getArrayVar($pageData, "genericMessage") . "</span></br></br>";
}

function showContent($pageData)
{
    $page = $pageData['page'];

    switch ($page) {
        case 'home':
            require_once('home.php');
            showHomeContent();
            break;
        case 'about':
            require_once('about.php');
            showAboutContent();
            break;
        case 'contact':
            require_once('contact.php');
            showContactContent($pageData);
            break;
        case 'register':
            require_once('register.php');
            showRegisterForm($pageData);
            break;
        case 'login':
            require_once('login.php');
            showLoginForm($pageData);
            break;
        case 'webshop':
            require_once('webshop.php');
            showWebshopContent($pageData);
            break;
        case 'product':
            require_once('product.php');
            showProductContent($pageData);
            break;
        case 'shoppingcart':
            require_once('shoppingcart.php');
            showShoppingCart($pageData);
            break;
        default:
            showPageNotFound();
    }
}

function showFooter()
{
    echo '<footer class="footers">
    <p>&copy; 2023 Laura Bokkers</p>
    </footer>';
}


//============================================== 


function showPageNotFound()
{
    echo 'Page not found';
}

function logError($message)
{
    echo "Logging to logfile: $message";
}
