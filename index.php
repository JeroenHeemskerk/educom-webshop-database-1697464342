<?php
include('session-manager.php');
include('validations.php');
include('login.php');
include('home.php');
include('about.php');
include('contact.php');
include('register.php');
include('file-repository.php');
include('user-service.php');
include('form-fields.php');
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
            $pageData = getLoginData();
            // ["page" => "login", "email" => ""]
            break;
        case 'register':
            $pageData = doProcessRegisterRequest();
            break;
            // ["page" => "register", "email" => ""]
            break;
        case 'contact':
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

    return $pageData;
};

// =========================================== 
function doProcessRegisterRequest()
{
    $registerData = getRegisterData();

    if ($registerData['valid']) {

        $email = $registerData['email'];
        $name = $registerData['name'];
        $password = $registerData['password'];

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
    showMenu();
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

function showMenu()
{
    echo '<nav>
          <ul class="menu">';
    showMenuItem('home', 'HOME');
    showMenuItem('about', 'ABOUT');
    showMenuItem('contact', 'CONTACT');
    if (isUserLoggedIn()) {
        showMenuItem('logout', 'LOGOUT ' . getLoggedInUserName());
    } else {
        showMenuItem('login', 'LOGIN');
        showMenuItem('register', 'REGISTER');
    }
    echo '</ul>
        </nav>';
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
            showHomeContent();
            break;
        case 'about':
            showAboutContent();
            break;
        case 'contact':
            showContactContent($pageData);
            break;
        case 'register':
            showRegisterForm($pageData);
            break;
        case 'login':
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
