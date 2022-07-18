<?php
namespace app\controllers;

Use app\router\Router;
Use app\helpers\Help;
Use app\models\Book;
Use app\models\Transaction;
Use FFI\Exception;


class TransactionController
{
        public static function transactionType(Router $router)
        {
                if (isset($_GET['book']))
                {
                        $book_id = Help::clean($_GET['book']);
                        $book = new Book ($router->dbs, ['book_id' => $book_id, 'user_id' => $_SESSION['user_id']]);
                        $exist= $book->idExist();
                        if (!$exist)
                        {
                                $_SESSION['msg'] = Help::alert("That book does not exist", 0);
                                echo header("Location: /");
                        }
                        
                        return $router->renderView('transaction/transaction_type', [
                                'page_title' => 'Edit '.$exist['book_name'],
                                'book' => $exist,
                                'book_id' =>$book_id
                        ]); exit;
                }
                else header("Loaction: /");
        }

        public static function buildTransactionForm(Router $router)
        {
                if (isset($_GET['book']) && isset($_GET['cat']))
                {
                        $book_id = Help::clean($_GET['book']);
                        $category_id = Help::clean($_GET['cat']);

                        /** check if book exist */
                        $book = new Book ($router->dbs, ['book_id' => $book_id, 'user_id' => $_SESSION['user_id']]);
                        $exist= $book->idExist();
                        if (!$exist)
                        {
                                $_SESSION['msg'] = Help::alert("That book does not exist", 0);
                                echo header("Location: /");
                        }

                        /** check if category exist */
                        $cat_name = $router->dbs->dbGetData(["`category_name`"], "`category`", null, ['`category_id`' => ':cat_id'], [':cat_id' => $category_id]);
                        $cat_name = $cat_name[0]['category_name'];
                        if ($cat_name == NULL)
                        {
                                $_SESSION['msg'] = Help::alert("That category does not exist", 0);
                                echo header("Location: /book?book=$book_id");
                        };

                        /** get all sub category for the current category */
                        $sub_categories = $router->dbs->dbGetData(["`sub_category`.`sub_category_id`", "`sub_category`.`sub_category_name`"],
                        "`sub_category`", null, ['`category_id`'=> ':category_id'], [':category_id' => $category_id]);

                        return $router->renderView('transaction/update_transaction', [
                                'page_title' => $page_title?? 'Add New Transaction',
                                'error' => '',
                                'cat' => $category_id,
                                'cat_name' => $cat_name,
                                'transaction_id' => '',
                                'transaction_amount' => '',
                                'transaction_desc' => '',
                                'book' => $exist,
                                'book_id' => $book_id,
                                'sub_categories' => $sub_categories,
                                'method' => '/transaction/add',
                                'button_label' => "Log $cat_name",
                                'button_id' => 'btn-log-transaction',
                                'button_name' => 'log-transaction'
                        ]);
                }
                else header("Location: /");
        }

        public static function addTransaction(Router $router)
        {
                if (isset($_POST['log-transaction']))
                {
                        $book_id = Help::clean($_POST['book-id']);
                        $amount = Help::clean($_POST['transaction-amount']);
                        $sub_category_id = Help::clean($_POST['sub-category-id']);
                        $desc = Help::clean($_POST['transaction-desc']);
                        $category_id = Help::clean($_POST['category-id']);

                        

                        /** check if book exist */
                        $book = new Book ($router->dbs, ['book_id' => $book_id, 'user_id' => $_SESSION['user_id']]);
                        $exist= $book->idExist();
                        if (!$exist)
                        {
                                $_SESSION['msg'] = Help::alert("That book does not exist", 0);
                                echo header("Location: /");
                        }

                        /** check if category exist */
                        $cat_name = $router->dbs->dbGetData(["`category_name`"], "`category`", null, ['`category_id`' => ':cat_id'], [':cat_id' => $category_id]);
                        $cat_name = $cat_name[0]['category_name'];
                        if ($cat_name == NULL)
                        {
                                $_SESSION['msg'] = Help::alert("That category does not exist", 0);
                                echo header("Location: /book?book=$book_id");
                        }

                        /**
                         * confirm this category id exist and it corresponding sub category
                        */
                        $sub_categories = $router->dbs->dbGetData(['`sub_category_id`', '`sub_category_name`'], '`sub_category`', null,
                        ['category_id' =>':cat_id'], [':cat_id' => $category_id]);

                        if (!$sub_categories)
                        {
                                $_SESSION['msg'] = Help::alert("That category doesn't exist", 0);
                                echo header("Location: /");
                        }

                        $transaction = new Transaction($router->dbs, [
                                'user_id' => $_SESSION['user_id'],
                                'book_id' => $book_id,
                                'sub_category_id' => $sub_category_id,
                                'transaction_amount' => $amount,
                                'transaction_desc' => $desc,
                                'type' => 1
                        ]);
                        $error = $transaction->addTransaction();
                        
                        if (is_array($error))
                        {
                                return $router->renderView('transaction/update_transaction', [
                                        'page_title' =>'Add New Transaction',
                                        'error' => $error,
                                        'cat' => $category_id,
                                        'cat_name' => $cat_name,
                                        'transaction_id' =>'',
                                        'transaction_amount' => $amount,
                                        'transaction_desc' => $desc,
                                        'book' => $exist,
                                        'book_id' => $book_id,
                                        'sub_categories' => $sub_categories,
                                        'sub_category_id' => $sub_category_id,
                                        'method' => '/transaction/add',
                                        'button_label' => "Log $cat_name",
                                        'button_id' => 'btn-log-transaction',
                                        'button_name' => 'log-transaction'
                                ]);
                        }
                        else
                        {
                                $_SESSION['msg'] = Help::alert("Transaction added successfully", 1);
                                echo header("Location: /book?book=$book_id");
                        }

                }
                else header("Location: /");
        }

        public static function editTransaction(Router $router)
        {
                if ($_SERVER['REQUEST_METHOD'] == "POST")
                {
                        $book_id = Help::clean($_POST['book-id']);
                        $trans_amount = Help::clean($_POST['transaction-amount']);
                        $trans_id = Help::clean($_POST['transaction-id']);
                        $trans_desc = Help::clean($_POST['transaction-desc']);
                        $sub_category_id = Help::clean($_POST['sub-category-id']);
                        $category_id = Help::clean($_POST['category-id']);

                        /** check if book exist */
                        $book = new Book ($router->dbs, ['book_id' => $book_id, 'user_id' => $_SESSION['user_id']]);
                        $exist= $book->idExist();
                        if (!$exist)
                        {
                                $_SESSION['msg'] = Help::alert("That book does not exist", 0);
                                echo header("Location: /");
                        }

                        /** check if category exist */
                        $cat_name = $router->dbs->dbGetData(["`category_name`"], "`category`", null, ['`category_id`' => ':cat_id'], [':cat_id' => $category_id]);
                        $cat_name = $cat_name[0]['category_name'];
                        if ($cat_name == NULL)
                        {
                                $_SESSION['msg'] = Help::alert("That category does not exist", 0);
                                echo header("Location: /book?book=$book_id");
                        };

                        /** get all sub category for the current category */
                        $sub_categories = $router->dbs->dbGetData(["`sub_category`.`sub_category_id`", "`sub_category`.`sub_category_name`"],
                        "`sub_category`", null, ['`category_id`'=> ':category_id'], [':category_id' => $category_id]);

                        if (isset($_POST['edit-transaction']))
                        {
                                $transaction = new Transaction($router->dbs, [
                                'user_id' => $_SESSION['user_id'],
                                'sub_category_id' => $sub_category_id,
                                'transaction_amount' => $trans_amount,
                                'transaction_desc' => $trans_desc,
                                'transaction_id' => $trans_id
                                ]);

                                $error = $transaction->editTransaction();

                                if (!is_array($error))
                                {
                                        $_SESSION['msg'] = Help::alert("Transaction edited successfully", 1);
                                        echo header("Location: /book?book=$book_id");
                                }
                        }

                        return $router->renderView('transaction/update_transaction', [
                                'page_title' => 'Edit Transaction',
                                'error' => $error ?? '',
                                'cat' => $category_id,
                                'cat_name' => $cat_name,
                                'transaction_id' => $trans_id,
                                'transaction_amount' => $trans_amount,
                                'transaction_desc' => $trans_desc,
                                'book' => $exist,
                                'book_id' => $book_id,
                                'sub_categories' => $sub_categories,
                                'sub_category_id' => $sub_category_id,
                                'method' => '/transaction/edit',
                                'button_label' => "Edit $cat_name",
                                'button_id' => 'btn-edit-transaction',
                                'button_name' => 'edit-transaction'
                        ]);
                }
                else header("Location: /");
        }
}


?>