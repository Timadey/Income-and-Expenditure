<?php
namespace app\helpers;

class Validator
{
        public static function isTextValid ($text, $min, $max)
        {
                if (strlen($text) > $min && strlen($text) < $max)
                {
                        if (!preg_match("/^[a-zA-Z- ']*$/", $text)) return false;
                        else return true;
                }
                else {
                        return false;
                }
        }

        public static function isNumberValid ($num)
        {
                if (preg_match("/^[a-zA-Z- ']*$/", $num)) return true;
                else return false;
        }

        public static function isDateValid($date)
        {
                
        }
}
?>