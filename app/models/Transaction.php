<?php

namespace app\models;

use app\helpers\Validator;
use app\models\Book;
use app\operations\Database;

class Transaction extends Book
{
        public ? int $transaction_id = null;
        public ? int $sub_category_id = null;
        public ? float $transaction_amount = null;
        public ? string $transaction_desc = null;

        public function __construct(Database $db, array $columns)
        {
                parent::__construct($db, $columns);
                if ($columns)
                {
                        $this->sub_category_id = (int) ($columns['sub_category_id'] ?? null);
                        $this->transaction_id = (int) ($columns['transaction_id'] ??  null);
                        $this->transaction_amount = (float) ($columns['transaction_amount'] ?? null);
                        $this->transaction_desc = (string) ($columns['transaction_desc'] ?? null);
                }
                
        }

        public function addTransaction()
        {
                $error = [];
                if (!$this->book_id) $error[] = "Select a book to edit first";
                if (!$this->transaction_amount) $error[] = "Transaction amount is required";
                if (!$this->transaction_desc) $error[] = "Transaction description is required";
                if (!$this->sub_category_id) $error[] = "Invalid category";
                if (!empty($error)) return $error;

                if (!$this->idExist()) $error[] = "Book does not exist";
                if (!empty($error)) return $error;

                $error = $this->validateColumns();
                if (!empty($error)) return $error;

                $col = array ("`user_id`", "`book_id`", "`sub_category_id`", "`transaction_amount`", "`transaction_desc`");
                $val = array (
                        ':user_id' => $this->user_id,
                        ':book_id' => $this->book_id,
                        ':sub_cat_id' => $this->sub_category_id,
                        ':amount' => $this->transaction_amount,
                        ':desc' => $this->transaction_desc
                );
                $insert_id = $this->insertData("`transactions`", $col, $val);

                if ($insert_id > 0) return (int) $insert_id;
                else return ["Oops! We are experiencing some technical issues"];

        }

        public function editTransaction()
        {
                $error = [];
                if (!$this->transaction_id) $error[] = "This transaction can't be found";
                if (!$this->transaction_amount) $error[] = "Transaction amount is required";
                if (!$this->transaction_desc) $error[] = "Transaction description is required";
                if (!$this->sub_category_id) $error[] = "Invalid category";
                if (!empty($error)) return $error;

                if (!$this->transExist()) $error[] = "Transaction does not exist";
                if (!empty($error)) return $error;

                $error = $this->validateColumns();
                if (!empty($error)) return $error;

                $set = [
                        '`transaction_amount`=:amount',
                        '`sub_category_id`=:sub_cat',
                        '`transaction_desc` =:desc'
                ];
                $where = ['`transaction_id`=:trans_id'];
                $value = [
                        ':amount' => $this->transaction_amount,
                        ':sub_cat' => $this->sub_category_id,
                        ':desc' => $this->transaction_desc,
                        'trans_id' => $this->transaction_id
                ];
                $updated = $this->updateData('`transactions`', $set, $where, $value);

                if ($updated) return true;
                else return ["Oops! We are experiencing some technical issues"];
        }

        public function transExist()
        {
                $val = [':trans_id' => $this->transaction_id, ':uid' => $this->user_id];
                $trans_exist = $this->dbGetData(['`transaction_id`'], '`transactions`', null, 
                ['transaction_id' =>':trans_id', 'user_id' => ':uid'], $val);

                if ($trans_exist) return $trans_exist[0];
                else return false;

        }

        public function validateColumns()
        {
                $error = [];
                if ($this->book_id) 
                {
                        if (!is_int($this->book_id) || $this->book_id < 0) $error[] = 'Invalid book!';
                }
                if ($this->user_id)
                {
                        if (!is_int($this->user_id)) $error[] = 'Invalid user!';
                }
                if ($this->sub_category_id) 
                {
                        if (!is_int($this->sub_category_id)) $error[] = 'Invalid category!';
                }
                if ($this->transaction_amount)
                {
                        if (!is_float($this->transaction_amount) || $this->transaction_amount < 0) $error[] = 'Transaction amount must be numbers only';
                }
                if ($this->transaction_desc)
                {
                        if (!Validator::isTextValid($this->transaction_desc, 5, 200)) $error[] = 'Transaction description can only be alphabets with 5 to 200 characters';
                }
                return $error;
        }
}
?>