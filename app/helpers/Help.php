<?php
namespace app\helpers;

class Help
{

        /**
         * clean - clean user's form input
         * @input: input to clean
         * Return: the cleaned input
         */
        public static function clean($input)
        {
                $input = htmlspecialchars($input);
                $input = strip_tags($input);
                $input = trim($input);
                return $input;
        }
        /**
         * alert - bootstrap alert messages
         * @msg: alert messages
         * @status: alert status; 0 for failure, 1 for success
         * Return: a bootstrap alert div containing the alert message
         */
        public static function alert (string $msg, int $status)
        {
                if ($status === 0)
                {
                        return ("<div class = 'alert alert-danger' role = 'alert'><strong>$msg</strong></div>");
                }
                else if ($status === 1)
                {
                        return ("<div class = 'alert alert-success' role = 'alert'><strong>$msg</strong></div>");
                }
        }   
}
?>