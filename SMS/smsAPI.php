<?php
class smsAPI
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


    public function sendSMS($provider,$content) {


  		if($provider == 1){

  			$ch = curl_init('https://api.smsbroadcast.com.au/api-adv.php');

  		}else{

  			$ch = curl_init('<insert new provider>');
  		}

          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $output = curl_exec ($ch);
          curl_close ($ch);
          return $output;
    }


    public function prepareSMS($productId,$provider,$sendTestMobs,$message) {


      $db = $this->db_connect();


      $username = '<username>';
      $password = '<password>';
      $source    = 'reNet'; 
      $mobile=$sendTestMobs;
      $content='username='.rawurlencode($username).'&password='.rawurlencode($password).'&to='.rawurlencode($mobile).'&from='.rawurlencode($source).'&message='.rawurlencode($message); 



      $smsOutput = $this->sendSMS($provider,$content);
      $status = explode(":",$smsOutput);

      if($status[0] == 'OK'){

      $mobs = explode(",",$status[1]); // loop through all the mobile numbers
      foreach ($mobs as $mob) {

        // insert the list of mobiles into the table 
        $db->query('INSERT INTO `smsLog`(`id`, `smsId`, `providerId`, `productId`, `mobile`, `messageStatus`,`sent`) 
        VALUES (NULL, "'.$status[2].'", "'.$provider.'","'.$productId.'","'.$mob.'",1, CURRENT_TIMESTAMP);');


      }

      }else{

        // possibly also log some sort of error
        $db->query('INSERT INTO `smsLog`(`id`, `smsId`, `providerId`, `productId`, `mobile`, `messageStatus`,`sent`) 
        VALUES (NULL, "'.$status[2].'", "'.$provider.'","'.$productId.'","'.$mob.'",0, CURRENT_TIMESTAMP);');


      }




    }




}


