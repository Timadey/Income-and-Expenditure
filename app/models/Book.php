<?php
namespace app\models;

Use app\helpers\Validator;
use app\operations\Database;

class Book extends Database
{
        public ? int $book_id = null;
        public ? int $user_id = null;
        public ? string $book_name = null;
        public ? string $book_desc = null;
        public ? string $book_date = null;

        public function __construct(Database $db, array $columns = [])
        {
                $this->conn = $db->conn;
                $this->book_id = (int) ($columns['book_id'] ?? null);
                $this->user_id = (int) ($columns['user_id'] ?? null);
                $this->book_name = $columns['book_name'] ?? null;
                $this->book_desc = $columns['book_desc'] ?? null;
                $this->book_date = $columns['book_date'] ?? null;
                parent::__construct();
        }

        public function load()
        {
                $where = array ('`user_id`' => ':user_id');
                $value = array (':user_id' => $this->user_id);
                $data = $this->dbGetData(null, "`books`", null, $where, $value); //implement order by date desc in database class

                return $data;
        }

        public function addNewBook()
        {
                $error = [];
                if (!$this->book_name) $error[] = "Book name is required";
                if (!$this->book_desc) $error[] = "Book desc is required";
                if (!empty($error)) return $error;

                $error = $this->validateColumns();
                if (!empty($error)) return $error;

                if ($this->nameExist($this->book_name, $this->user_id)) $error[] = "Duplicate name detected";
                if (!empty($error)) return $error;

                $last_inserted = $this->insertData("`books`", ['`user_id`', '`book_name`', '`book_desc`'], [
                        ':user_id' => $this->user_id,
                        ':bk_name' => $this->book_name,
                        ':bk_desc' => $this->book_desc
                ]);
                
                if (!$last_inserted) return null;
                $this->clear();
                return (int)$last_inserted;
        }

        public function editBook()
        {
                $error = [];
                if (!$this->book_id) $error[] = "Select a book to edit first";
                if (!$this->book_name) $error[] = "Book name is required";
                if (!$this->book_desc) $error[] = "Book desc is required";
                if (!empty($error)) return $error;

                if (!$this->idExist()) $error[] = "Book does not exist";
                if (!empty($error)) return $error;

                $error = $this->validateColumns();
                if (!empty($error)) return $error;

                if ($this->nameExist()) $error[] = "Duplicate name detected";
                if (!empty($error)) return $error;

                $updated = $this->updateData('`books`', ['`book_name` = :bk_name', '`book_desc` = :bk_desc'], 
                ['`book_id` = :bk_id', '`user_id` = :uid'],
                [
                        ':bk_name' => $this->book_name,
                        ':bk_desc' => $this->book_desc,
                        ':bk_id' => $this->book_id,
                        ':uid' => $this->user_id
                ]);

                if ($updated) return true;
                else return ["Oops! We're experiencing technical issues"];
        }

        public function deleteBook()
        {
                $error = [];
                if (!$this->book_id) $error[] = "No book was deleted";
                if (!empty($error)) return $error;
                if (!$this->idExist()) $error[] = "Book does not exist";
                if (!empty($error)) return $error;

                $deleted = $this->deleteData('`books`', ['`book_id` = :bk_id', '`user_id` = :uid'], [':bk_id' => $this->book_id, ':uid' => $this->user_id]);
                if ($deleted != false) return (int) $deleted;
                else return false;
        }

        public function nameExist()
        {
                $exist = $this->dbGetData(['`book_id`'], '`books`', null, [
                        '`book_name`' => ':bk_name',
                        '`user_id`' =>':uid'
                ],[
                        ':bk_name' => $this->book_name,
                        ':uid' => $this->user_id
                ]);
                if ($exist) return $exist[0];
                else return false;
        }

        public function idExist()
        {
                $exist = $this->dbGetData(['`book_name`'], '`books`', null, ['`book_id`' => ':bk_id', '`user_id`' =>':uid'], [':bk_id' => $this->book_id, ':uid' => $this->user_id]);
                if ($exist) return $exist[0];
                else return false;
        }

        public function validateColumns()
        {
                $error = [];
                if ($this->book_id) 
                {
                        if (!is_int($this->book_id)) $error[] = 'Invalid book!';
                }
                if ($this->user_id)
                {
                        if (!is_int($this->user_id)) $error[] = 'Invalid user!';
                }
                if ($this->book_name)
                {
                        if (!Validator::isTextValid($this->book_name, 5, 30)) $error[] = 'Book name can only be alphabets with 5 to 30 characters';
                }
                if ($this->book_desc)
                {
                        if (!Validator::isTextValid($this->book_desc, 5, 200)) $error[] = 'Book description can only be alphabets with 5 to 200 characters';
                }
                if ($this->book_date)
                {
                        if (!Validator::isDateValid($this->book_date)) $error[] = 'Invalid Date!';
                }
                return $error;
        }
        public function clear()
        {
                $this->book_id = null;
                $this->book_name = null;
                $this->book_desc = null;
                $this->book_date = null;
        }

}
?>