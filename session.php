<?php
//dont touch
if (!isset($_SESSION['user_id']) && !isset($_SESSION['email']) && !isset($_SESSION['name'])){
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['email']) && isset($_COOKIE['name'])){
        $_SESSION['user_id'] = $_COOKIE['user_id'];
        $_SESSION['email'] = $_COOKIE['email'];
        $_SESSION['name'] = $_COOKIE['name'];
        echo $router->renderView("auth/logged_in_as",['page_title' => 'You are logged in'], 'layouts/auth_layout');
    }
    else 
    {
        echo header("Location: /login");
    }
}else{
    if (!isset($_COOKIE['user_id']) && !isset($_COOKIE['email']) && !isset($_COOKIE['name'])){
        setcookie('user_id', $_SESSION['user_id'], time()+(60 * 60 * 24 * 2));
        setcookie('email', $_SESSION['email'], time()+(60 * 60 * 24 * 2));
        setcookie('name', $_SESSION['name'], time()+(60 * 60 * 24 * 2));
    };
};
?>