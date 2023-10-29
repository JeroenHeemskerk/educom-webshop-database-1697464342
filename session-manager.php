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

function isCartInitialized()
{
    return isset($_SESSION['cart']);
}

function initializeCart()
{
    $_SESSION['cart'] = [];
}

function getCart()
{
    return $_SESSION['cart'];
}

function addToCart($productId)
{
    $_SESSION['cart'][$productId] = getArrayVar($_SESSION['cart'], $productId, 0) + 1;
}

function removeFromCart($productId)
{
    $cart = $_SESSION['cart'];

    if (!array_key_exists($productId, $cart)) {
        return;
    }

    if ($cart[$productId] > 1) {
        $cart[$productId] = $cart[$productId] - 1;
    } else {
        //verwijder 1 array element
        unset($cart[$productId]);
    }

    $_SESSION['cart'] = $cart;
}
