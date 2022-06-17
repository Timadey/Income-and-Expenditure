<?php
session_start();
require_once "../config.php";
// echo "<p>";
// var_dump($_POST);
// echo "</p>";

if (isset($_POST['add-book'])){
    $book_name = trim($_POST['book-name']);
    $book_desc = trim($_POST['book-desc']);
    $book_type = trim($_POST['book-type']);

    if ($book_name == "" || $book_desc == "" || $book_type == ""){
        $_SESSION['msg'] = "One or more empty field";
        echo
        "<script> 
            history.go(-1);
        </script>";
        exit();
    }
    else if(!$user->isNameValid($book_name, 4, 20))
    {
        $_SESSION['msg'] = "Name must contain only characters greater than 4 and less than 20 characters";
        echo
        "<script> 
            history.go(-1);
        </script>";
        exit();
    }
    else if(!$user->isNameValid($book_desc, 4, 30))
    {
        $_SESSION['msg'] = "Description must contain only characters greater than 4 and less than 30 characters";
        echo
        "<script> 
            history.go(-1);
        </script>";
        exit();
    }
    else{
        try{
            $table = "`books`";
            $col = array ('`user_id`', '`book_name`', '`category_id`', '`description`');
            $val = array (
                ':user_id' => $_SESSION['user_id'],
                ':bk_name' => $book_name,
                ':cat_id' => $book_type,
                ':bk_desc' => $book_type
            );
            $last_added = $dbs->insertData($table, $col, $val);
            if ($last_added)
            {
                echo 
                "<script> 
                alert('Book added successfully. Log a transaction in it.');
                window.location.href = '../index.php';
                </script>";
                exit();
            }
            else{
                $_SESSION['msg'] = "Book not added due to technical issue";
                header ("Location: ..index.php");
                exit();
            }
            // $query = "INSERT INTO `books` (`user_id`, `book_name`, `category_id`, `description`) 
            // VALUE (:user_id, :book_name, :category_id, :description)";

            // $statement = $dbs->prepare($query);
            // $statement->bindValue(':user_id', $uid);
            // $statement->bindValue(':book_name', $book_name);
            // $statement->bindValue(':category_id', $book_type);
            // $statement->bindValue(':description', $book_desc);
            // $statement->execute();
        }
        catch(PDOException $err){
            echo "Error. Cannot add book: ".$err->getMessage();
        };
    };

}elseif (isset($_POST['edit-book'])){
    $book_id = trim($_POST['book-id']);
    $book_name = trim($_POST['book-name']);
    $book_desc = trim($_POST['book-desc']);

    if ($book_name == "" || $book_desc == "" || $book_id == ""){
        $_SESSION['msg'] = "One or more empty field";
        echo
        "<script> 
            history.go(-1;
        </script>";
        exit();
    }
    else if(!$user->isNameValid($book_name, 4, 20))
    {
        $_SESSION['msg'] = "Name must contain only characters greater than 4 and less than 20 characters";
        echo
        "<script> 
            history.go(-1);
        </script>";
        exit();
    }
    else if(!$user->isNameValid($book_desc, 4, 30))
    {
        $_SESSION['msg'] = "Description must contain only characters greater than 4 and less than 30 characters";
        echo
        "<script> 
            history.go(-1);
        </script>";
        exit();
    }else{
        //check if book exist
        try{

            $col = array ("`book_id`");
            $table = "`books`";
            $where = array ('`books`.`book_id`' => ':book_id', '`books`.`user_id`' => ':user_id');
            $val = array (':book_id' => $book_id, ':user_id' => $_SESSION['user_id']);
            try{
                $rdata = $dbs->dbGetData($col, $table, null, $where, $val);
            }
            catch(Exception $err)
            {
                $_SESSION['msg'] = "oops! We're experiencing technical issue at the moment";
            }

            if ($rdata == null){
                echo 
                    "<script> 
                    alert('Book not found!');
                    window.location.href = '../book.php?book=".$book_id."';
                    </script>"; 
                exit();
            };
            // $query = "SELECT `book_id` FROM `books` WHERE books.book_id=:book_id AND books.user_id=:user_id";
            // $statement = $dbs->prepare($query);
            // $statement->bindValue(':book_id', $book_id);
            // $statement->bindValue(':user_id', $uid);
            // $statement->execute();
            // $rdata = $statement->fetch(PDO::FETCH_ASSOC);
    
            // if (!$rdata){
            //     echo 
            //     "<script> 
            //     alert('Book not found!');
            //     window.location.href = '../book.php?book=".$book_id."';
            //     </script>"; 
            // };
        }
        catch(PDOException $err){
            $_SESSION['msg'] = "Oops! Action failed due to technical issues";
            echo 
                "<script> 
                window.location.href = '../book.php?book=".$book_id."';
                </script>"; 
            exit();
        };
        //book exist, update book
        try{
            $table = '`books`';
            $set = array ('`book_name`=:book_name', '`description`=:book_desc');
            $where = array (' `book_id`=:book_id');
            $val = array (
                ':book_name' => $book_name,
                ':book_desc' => $book_desc,
                ':book_id' => $book_id
            );
            $updated = $dbs->updateData($table, $set, $where, $val);
            if ($updated)
            {
                echo 
                "<script> 
                alert('Book updated successfully');
                window.location.href = '../book.php?book=".$book_id."';
                </script>";
            }
            else
            {
                $_SESSION['msg'] = "Oops! Book not edited";
                echo 
                    "<script> 
                    window.location.href = '../book.php?book=".$book_id."';
                    </script>"; 
                exit();
            }
            // $query = "UPDATE `books` SET `book_name`=:book_name, `description`=:book_desc WHERE `book_id`=:book_id";

            // $statement = $dbs->prepare($query);
            // $statement->bindValue(':book_name', $book_name);
            // $statement->bindValue(':book_desc', $book_desc);
            // $statement->bindValue(':book_id', $book_id);
            // $statement->execute();
            
            
        }
        catch(PDOException $err){
            $_SESSION['msg'] = "Oops! Action failed due to technical issues";
            echo 
                "<script> 
                window.location.href = '../book.php?book=".$book_id."';
                </script>"; 
            exit();
        };
    };
}
else{
    header("Location: ../newbook.php");
};

?>