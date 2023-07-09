<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);
session_start();
// echo '<pre>';
// var_dump ($_SERVER);
// echo "</pre>"; exit;

//  $_SESSION['user_id'] = 6;
//  $_SESSION['email'] = 'tim@budget.com';
//  $_SESSION['name'] = "Timothy";

require_once __DIR__.'/../config/config.php';
require_once __DIR__.'/../vendor/autoload.php';

use app\controllers\AuthController;
use app\router\Router;
use app\controllers\BookController;
use app\controllers\TransactionController;
use app\operations\Database;
use app\operations\Account;

$dbs = new Database();
$dbs->dbConnect($DB_HOST,$DB_USER, $DB_PASSWORD,$DB_NAME);
$user = new Account ($dbs);

$router = new Router($dbs);

$router->get('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'register']);
$router->post('/login', [AuthController::class, 'auth']);
$router->post('/register', [AuthController::class, 'auth']);
$router->get('/logout', [AuthController::class, 'logout']);



$auth = ['/login', '/register', '/logout'];
if (in_array($_SERVER['REQUEST_URI'], $auth))
{
        $router->resolve();
        exit;
}

require_once __DIR__.'/session.php';

$router->get('/', [BookController::class, 'index']);
$router->get('/book', [BookController::class, 'viewBook']);
$router->get('/book/add', [BookController::class, 'addBook']);
$router->post('/book/add', [BookController::class, 'addBook']);
$router->get('/book/edit', [BookController::class, 'editBook']);
$router->post('/book/edit', [BookController::class, 'editBook']);
$router->get('/book/delete', [BookController::class, 'deleteBook']);

$router->get('/transaction/addnew', [TransactionController::class, 'transactionType']);
$router->get('/transaction/add', [TransactionController::class, 'buildTransactionForm']);
$router->post('/transaction/add', [TransactionController::class, 'addTransaction']);
$router->post('/transaction/edit', [TransactionController::class, 'editTransaction']);

$router->resolve();
?>
