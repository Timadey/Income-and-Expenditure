<?php
namespace app\controllers;

Use app\router\Router;
Use app\helpers\Help;
Use app\models\Book;
Use FFI\Exception;


class BookController
{

        /**
         * index - RenderView for Index page
         * @Router: an nstance of Router class
         */
        public static function index(Router $router)
        {
                $book = new Book ($router->dbs, ['user_id' => $_SESSION['user_id']]);
                $data = $book->load();
                return $router->renderView('index', [
                        'page_title' => 'Books',
                        'data' => $data
                ]);
        }

        /**
         * viewBook - RenderView for Book page
         * @Router: an instance of Router class
         */
        public static function viewBook(Router $router)
        {
                if (isset($_GET['book']))
                {
                        $book_id = Help::clean($_GET['book']);

                        /** check if book exist */
                        $book = new Book($router->dbs, ['book_id' => $book_id, 'user_id' => $_SESSION['user_id']]);
                        $exist = $book->idExist();
                        
                        if ($exist === false){
                                return $router->renderView("404", ['page_title' => 'Book doesn\'t exist']);
                                exit();
                        };
                        $book = $exist;

                        /** load transaction for the book */
                        $table = "`transactions`";
                        $join = array ('`books`' => '`book_id`', '`sub_category`' => '`sub_category_id`');
                        $where = array ('`books`.`book_id`' => ':book_id', '`books`.`user_id`' => ':user_id');//, '`sub_category`.`category_id`' => ':book_type');
                        $val = array (':book_id' => $book_id, ':user_id' => $_SESSION['user_id']);//, ':book_type' => $rdata['category_id']);
                        $order = " ORDER BY `transaction_date` DESC";

                        /** Will come back to this pagination later */
                        // $limit = Help::getLimit(3);
                        // $total_row = count($router->dbs->dbGetData(['`transaction_id`'], $table, $join, $where, $val));
                        // exit;
                        $total_row = 20;

                
                        // if total page is greater than 10

                        if (isset($_GET['page_no']) && is_int($_GET['page_no']))
                        {
                                $page_no = $_GET['page_no'];
                        }else $page_no = 1;
                        $pag['next_page'] = $page_no + 1;
                        $pag['prev_page'] = $page_no - 1;
                        $per_page = 3;
                        $offset = $per_page * ($page_no - 1);
                        $total_per_page = ceil($total_row / $per_page);
                        $pag['second_last'] = $total_per_page - 1;
                        $limit = [$offset, $total_per_page];

                        // echo $total_row; exit;
                        try
                        {
                                $transactions = $router->dbs->dbGetData(null, $table, $join, $where, $val, $order); // implement ORDER BY transactions.date DESC";
                        }
                        catch(Exception $err)
                        {
                                $_SESSION['msg'] = help::alert("oops! We're experiencing technical issue at the moment", 0);
                        };
                        
                        return $router->renderView('book/view_book',
                        [
                                'page_title' => $book['book_name'],
                                'book_id' => $book_id,
                                'transactions' => $transactions,
                                'book' => $book,
                                'page_no' => $page_no,
                                'total_page' => $total_per_page,
                                'pag' => $pag
                        ]);
                }
                else
                {
                        header("Location: /");
                };
        }
        /**
         * addBook - RenderView for Book page
         * @Router: an instance of Router class
         */
        public static function editBook(Router $router)
        {
                if (isset($_GET['book_name']) && isset($_GET['book_id']) && isset($_GET['book_desc']))
                {
                        $book_name = Help::clean($_GET['book_name']);
                        $book_id = Help::clean($_GET['book_id']);
                        $book_desc = Help::clean($_GET['book_desc']);
                        $edit = "Edit ".$book_name;

                }
                else if (isset($_POST['edit-book']))
                {
                        $book_name = Help::clean($_POST['book-name']);
                        $book_id = Help::clean($_POST['book-id']);
                        $book_desc = Help::clean($_POST['book-desc']);
                        $edit = "Edit ".$book_name;

                        $book = new Book($router->dbs, [
                                'user_id' => $_SESSION['user_id'],
                                'book_name' => $book_name,
                                'book_id' => $book_id,
                                'book_desc' => $book_desc
                        ]);
                        $error = $book->editBook();

                        if ($error === true)
                        {
                                header("Location: /book?book=$book_id");
                                exit;
                        }
                }
                else 
                {
                        header("Location: /book/add");
                        exit;
                };
               
                return $router->renderView('book/update_book', [
                        'page_title' => $edit,
                        'edit' => $edit,
                        'view_book' => '/book?book='.$book_id,
                        'form_action' => '/book/edit',
                        'error' => $error??null,
                        'book_id' => $book_id,
                        'book_name' => $book_name,
                        'book_desc' => $book_desc,
                        'button_id' => 'btn-edit-book',
                        'button_name' => 'edit-book',
                        'button_label' => 'Edit Book'
                ]);
        }
        public static function addBook(Router $router)
        {
                if (isset($_POST['add-book']))
                {
                        $book_name = Help::clean($_POST['book-name']);
                        $book_desc = Help::clean($_POST['book-desc']);

                        $book = new Book($router->dbs, [
                                'user_id' => $_SESSION['user_id'],
                                'book_name' => $book_name,
                                'book_desc' => $book_desc
                        ]);
                        $error = $book->addNewBook();
                        
                        if (is_int($error))
                        {
                                header("Location: /book?book=$error");
                                exit;
                        }
                        if ($error === null)
                        $error[] = "Oops! We're experencing technical issues";

                }
                return $router->renderView('book/update_book', [
                        'page_title' => 'Add New Book',
                        'edit' => 'Add New Book',
                        'view_book' => '/',
                        'form_action' => '/book/add',
                        'error' => $error??null,
                        'book_id' => '',
                        'book_name' => $book_name ?? '',
                        'book_desc' =>$book_desc ?? '',
                        'button_id' => 'btn-add-book',
                        'button_name' => 'add-book',
                        'button_label' => 'Add Book'
                ]);
        }

        public static function deleteBook(Router $router)
        {
                if (isset($_GET['book']))
                {
                        $book_id = $_GET['book'];

                        $book = new Book ($router->dbs, ['book_id' => $book_id, 'user_id' => $_SESSION['user_id']]);
                        $deleted = $book->deleteBook();
                        if (is_int($deleted))
                        {
                                $_SESSION['msg'] = Help::alert("Book deleted successfully", 1);
                                return header("Location: /");
                        }
                        else if ($deleted === false)
                        {
                                $_SESSION['msg'] = Help::alert("Oops! We are experiencing technical issues", 0);
                                return header("Location: /book/?book=$book_id");
                        }
                        else
                        {
                                $_SESSION['msg'] = Help::alert($deleted[0], 0);
                                return header("Location: /");
                        }

                }
                else return header("Location: /");
        }
}
?>