<?php
class wikibetAPI
{

    public function db_connect() {
    static $db; // to avoid more than 1

      if(!isset($db)) {

        $host = getenv('MYSQL_DSN');
        $user = getenv('MYSQL_USER');
        $password = getenv('MYSQL_PASSWORD');
          try
        {

          $db = new PDO($host, $user, $password);

        }
        catch (PDOException $e)
          {    
            echo 'Oops, there was an unexpected error. Please try again.';
            exit();
          }
        return $db;
      }else{
        return $db;
      }
    }


    public function db_read() {
    static $db; // to avoid more than 1

      if(!isset($db)) {

        $host = getenv('MYSQL_DSN_READ');
        $user = getenv('MYSQL_USER');
        $password = getenv('MYSQL_PASSWORD');
          try
        {

          $db = new PDO($host, $user, $password);

        }
        catch (PDOException $e)
          {    
            echo 'Oops, there was an unexpected error. Please try again.';
            exit();
          }
        return $db;
      }else{
        return $db;
      }
    }



    function GUID(){ //generates valid version 4 UUIDs

      if (function_exists('com_create_guid') === true)

        { 

        return trim(com_create_guid(), '{}');

        }

      return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
     }


}
