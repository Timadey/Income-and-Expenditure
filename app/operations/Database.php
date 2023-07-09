<?php

namespace app\operations;

use PDO;

/**
 * Database - Handles repetitive actions done on database
 */
class Database
{
    public  $conn = NULL;
    private $dbHost = NULL;
    private $dbUser = NULL;
    private $dbPassword = NULL;
    private $dbName = NULL;
    public static ?Database $dbs = null;

    /**
     * __construct - Initialize Database connection parameters
     */
    public function __construct()
    {
        $dbHost = __DB_HOST__;
        $dbUser = __DB_USER__;
        $dbPassword = __DB_PASSWORD__;
        $dbName = __DB_NAME__;
        try {
            // $this->conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser,  $dbPassword);
            $this->conn = new PDO("mysql:host=localhost;dbname=budget", 'timothy',  '');
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $err) {
            return null;
        }
        self::$dbs = $this;
    }

    /**
     * dbConnect - Connect to another database
     */
    public function dbConnect($dbHost, $dbUser, $dbPassword, $dbName)
    {
        $this->dbHost = $dbHost;
        $this->dbUser = $dbUser;
        $this->dbPassword = $dbPassword;
        $this->dbName = $dbName;

        try {
            $this->conn = new PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUser, $this->dbPassword);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (\PDOException $err) {
            echo $err->getMessage();
            exit;
            return null;
        }
        self::$dbs = $this;
    }
    /**
     * dbGetData - get row(s) from one or more tables
     * where the 'where parameters' exists.
     * @column: columns to select. Leave blank or NULL if you want to select all (*)
     * @join: array of tables to join and their using columns, leave null if no joined tables are required
     * @from: an associative array of tables where we want to get all the row
     * @where: an asscociative array of the columns to intersect and their placeholder
     * @value: an associative array containing the placeholder and value
     * Return: an associative array containing the fields gotten or NULL if not found
     */
    public function dbGetData(
        array $column = NULL,
        string $from,
        array $join = NULL,
        array $where,
        array $value,
        string $order = null,
        array $limit = null
    ) {
        if ($this->conn == NULL) {
            throw new \Exception("Database connection not found");
        }
        $query = "";
        if ($join != NULL) {
            foreach ($join as $table => $using) {
                $from .= " INNER JOIN " . $table . " USING (" . $using . ")";
            }
        }

        if ($column == NULL) {
            $query = "SELECT * FROM $from WHERE ";
        } else {
            $column = implode(", ", $column);
            $query = "SELECT $column FROM $from WHERE ";
        }

        $where_list = array();
        foreach ($where as $col => $ph) {
            $where_list[] = $col . ' = ' . $ph;
        }
        $where = implode(' AND ', $where_list);
        $query .= $where;
        $query .= $order ?? '';
        $query .= $limit ? " LIMIT " . implode(', ', $limit) : '';
        // echo $query; exit;
        try {
            $q = ($this->conn)->prepare($query);
            $q->execute($value);
            $data = $q->fetchall(\PDO::FETCH_ASSOC);
            if (is_array($data) && !empty($data)) {
                return $data;
            };
            return NULL;
        } catch (\PDOException $err) {
            echo $err->getMessage();
            throw new \Exception("Error Processing Request", 1);
        }
    }
    /**
     * insertData - insert a row into a table
     * @param string table: table to insert into
     * @param array column: columns to insert into
     * @param array values: values to insert
     * Return: lastInsertedId if successful or null otherwise
     */
    public function insertData(string $table, array $columns, array $values)
    {
        if ($this->conn == NULL) {
            return (null);
        }
        $query = "INSERT INTO " . $table . " (";
        $col = implode(", ", $columns);
        $query .= $col . ") VALUES (";
        $phs = array();
        foreach ($values as $ph => $value) {
            $phs[] = $ph;
        }
        $phs = implode(", ", $phs);
        $query .= $phs . ")";
        // echo $query;
        // exit;
        try {
            $q = $this->conn->prepare($query);
            $q->execute($values);
            return ($this->conn->lastInsertId());
        } catch (\PDOException $err) {
            echo ($err->getMessage());
            throw new \Exception("Error Processing Request", 1);
        }
    }
    /**
     * updateData - update a row in a table
     * @param string table: table to update
     * @param array set: a one dim array of the columns to update and their placeholder
     * @param array where: a one dim array of the columns to intersect and their placeholder
     * @param array values: an assoc array containing the placeholder and value
     * Return: true if successful or false otherwise
     */
    public function updateData(string $table, array $set, array $where, array $values)
    {
        if ($this->conn == NULL) {
            return (false);
        }
        $query = "UPDATE " . $table . " SET ";
        $set_list = implode(", ", $set);
        $query .= $set_list . " WHERE ";
        $where_list = implode(' AND ', $where);
        $query .= $where_list;
        //echo $query;
        //exit;
        try {
            $q = $this->conn->prepare($query);
            $q->execute($values);
            return (true);
        } catch (\PDOException $err) {
            return (false);
        }
    }
    /**
     * deleteData - delete a row from a table
     * @table: table to delete from
     * @where: array of columns to intersect row
     * Return: no of row deleted on success or false on failure
     */
    public function deleteData(string $table, array $where, array $values)
    {
        if ($this->conn == NULL) {
            return (false);
        }
        $where_list = implode(" AND ", $where);
        $query = "DELETE FROM " . $table . " WHERE " . $where_list;
        //echo $query;
        try {
            $q = $this->conn->prepare($query);
            $q->execute($values);
            return ($q->rowCount());
        } catch (\PDOException $err) {
            return (false);
        }
    }
}

###########################################################################
// Class Test
//$query = "UPDATE `transactions` SET `amount`=:amount, `sub_category_id`=:sub_cat, `description`=:desc WHERE `transaction_id`=:trans_id";
//insert into users (name, password, email) values (:name, :password, :email)
//connect to database
// $DB_HOST = 'localhost';
// $DB_USER = 'root';
// $DB_PASSWORD = '';
// $DB_NAME ='budget';
// $dbs = new Database($DB_HOST,$DB_USER, $DB_PASSWORD, $DB_NAME);
// $dbs->dbConnect();
// $table = '`transactions`';
// $set = array (
//     '`amount`=:amount',
//     '`sub_category_id`=:sub_cat',
//     '`description` =:desc'
// );
// $where = array ('`transaction_id`=:trans_id');
// $value = array (
//     ':amount' => 7001,
//     ':sub_cat' => 21,
//     ':desc' => "edited desc",
//     'trans_id' => 30
// );
// $dbs->updateData($table, $set, $where, $value);
// $col = array("`first_name`","`last_name`","`email`");
// $fr = "`users`";

// $wh = array(
//     ':first_name' => 'Olawale',
//     ':last_name' => 'Molola',
//     ':email' => 'new@budget.com'
// );
// $dbs->insertData($fr, $col, $wh);
###########################################################################  
