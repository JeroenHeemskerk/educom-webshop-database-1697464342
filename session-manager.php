<?php

    function doLoginUser($name){
        $_SESSION['name'] = $name;
    }

    function isUserLoggedIn() {
        return isset($_SESSION['name']);
    }

    function getLoggedInUserName(){
        return $_SESSION['name'];
    }

    function doLogOut(){
        session_unset();
    }
