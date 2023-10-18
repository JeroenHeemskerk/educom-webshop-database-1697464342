<?php
include('session-manager.php');

session_start();

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
        default:
            showPageNotFound();
    }

    $pageData['menu'] = array('home' => 'HOME', 'about' => 'ABOUT', 'contact' => 'CONTACT');
    if (isUserLoggedIn()) {
        $pageData['menu']['logout'] = "LOGOUT " . getLoggedInUserName();
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

        require_once('file-repository.php');
        saveUser($email, $name, $password);
        require_once('login.php');
        $registerData = getInitialLoginFormData();
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
    <link rel="stylesheet" href="CSS/stylesheet.css">
    </head>';
}

function showBodySection($pageData)
{
    echo '    <body>' . PHP_EOL;
    showHeader($pageData['page']);
    showMenu($pageData);
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
    echo '<nav>';
    echo '<ul class="menu">';
    foreach ($data['menu'] as $key => $page) {
        showMenuItem($key, $page);
    }
    echo '</ul>' . PHP_EOL . '</nav>' . PHP_EOL;
}


function showMenuItem($linkName, $buttonText)
{
    echo '<li><a href="index.php?page=' . $linkName . '">' . $buttonText . '</a></li>';
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
