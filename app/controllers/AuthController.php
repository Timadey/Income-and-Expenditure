<?php 
namespace app\controllers;
Use app\operations\Account;
Use app\router\Router;
Use app\helpers\Help;

class AuthController
{
        public static function login(Router $router)
        {
                if (isset($_SESSION['user_id']) && isset($_SESSION['email']) && isset($_SESSION['name'])){
                        echo $router->renderView("auth/logged_in_as",['page_title' => 'You are logged in'], 'layouts/auth_layout');
                }
                else if (isset($_COOKIE['user_id']) && isset($_COOKIE['email']) && isset($_COOKIE['name'])){
                        $_SESSION['user_id'] = $_COOKIE['user_id'];
                        $_SESSION['email'] = $_COOKIE['email'];
                        $_SESSION['name'] = $_COOKIE['name'];
                        echo $router->renderView("auth/logged_in_as",['page_title' => 'You are logged in'], 'layouts/auth_layout');
                }

                echo $router->renderView('auth/login', [
                        'page_title' => 'Login',
                        'error' => '',
                        'email' => ''
                ], 'layouts/auth_layout');
        }

        public static function register(Router $router)
        {
                if (isset($_SESSION['user_id']) && isset($_SESSION['email']) && isset($_SESSION['name'])){
                        echo $router->renderView("auth/logged_in_as",['page_title' => 'You are logged in',], 'layouts/auth_layout');
                }
                else if (isset($_COOKIE['user_id']) && isset($_COOKIE['email']) && isset($_COOKIE['name'])){
                        $_SESSION['user_id'] = $_COOKIE['user_id'];
                        $_SESSION['email'] = $_COOKIE['email'];
                        $_SESSION['name'] = $_COOKIE['name'];
                        echo $router->renderView("auth/logged_in_as",['page_title' => 'You are logged in'], 'layouts/auth_layout');
                }

                echo $router->renderView('auth/register', [
                        'page_title' => 'Register',
                        'error' => '',
                        'email' => '',
                        'first_name' => '',
                        'last_name' => ''
                ], 'layouts/auth_layout');
        }

        public static function auth(Router $router)
        {
                if ($_SERVER['REQUEST_METHOD'] == 'POST')
                {
                        if (isset($_POST["login"]))
                        {
                                $email = help::clean($_POST['email']);
                                $password = ($_POST['password']);
                                $user = new Account($router->dbs);
                                $data = $user->login($email, $password);
                                if ($data === true)
                                {
                                        $_SESSION['user_id'] = $user->getUid();
                                        $_SESSION['email'] = $user->getEmail();
                                        $_SESSION['name'] = $user->getUname();
                                        $_SESSION['login'] = $user->getLogin();
                                        echo header("Location: /");
                                }
                                else $router->renderView('auth/login', [
                                        'page_title' => 'Login',
                                        'error' => $data,
                                        'email' => $email
                                ], 'layouts/auth_layout');
                        }
                        else if (isset($_POST['register']))
                        {
                                $first_name = help::clean($_POST["first-name"]);
                                $last_name = help::clean($_POST["last-name"]);
                                $email = help::clean($_POST["email"]);
                                $password = $_POST["password"];

                                $user = new Account($router->dbs);
                                $data = $user->addAccount($first_name, $last_name, $email, $password);
                                if (!is_array($data))
                                {
                                        $_SESSION['msg'] = 'Registration Successful. Please Login.';
                                        echo header("Location: /login");
                                }
                                else $router->renderView('auth/register', [
                                        'page_title' => 'Register',
                                        'error' => $data,
                                        'email' => $email,
                                        'first_name' => $first_name,
                                        'last_name' => $last_name
                                ], 'layouts/auth_layout');
                        }
                }
                
                
        }

        
        public static function logout()
        {
                if (!isset($_SESSION["email"]) && !isset($_SESSION["user_id"]) && !isset($_SESSION["email"])){
                        echo header("Location: /login");
                };
                if (isset($_SESSION["name"]) && isset($_SESSION["user_id"]) && isset($_SESSION["email"])){
                        $_SESSION = array();
                        session_destroy(); 
                };
                if(isset($_COOKIE["email"]) && (isset($_COOKIE["user_id"])) && (isset($_COOKIE["email"]))){
                        setcookie(session_name(), "", time()-3600);
                        setcookie("name", "", time()-3600);
                        setcookie("user_id", "", time()-3600);
                        setcookie("email", "", time()-3600);
                };
                echo header("Location: /login");
        }
}