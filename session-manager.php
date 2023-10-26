<?php

function doLoginUser($user)
{
    $_SESSION['name'] = $user['name'];
    $_SESSION['id'] = $user['id'];
}

function isUserLoggedIn()
{
    return isset($_SESSION['name']);
}

function getLoggedInUserName()
{
    return $_SESSION['name'];
}

function getLoggedInUserId()
{
    return $_SESSION['id'];
}

function doLogOut()
{
    session_unset();
}
