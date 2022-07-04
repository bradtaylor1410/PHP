<?php
require_once 'wikibetAPI.php';
$wikibetAPI = new wikibetAPI();
$dbNew = $wikibetAPI->db_connect();
$dbRead = $wikibetAPI->db_read();

function findDateTime($day,$cuttime,$starttime=0,$conversion){
    $localDate= date('Y-m-d', strtotime("this ".$day));
    $cutSecs = strtotime($localDate.' '.$cuttime);
    $startSecs = strtotime($localDate.' '.$starttime);
    $now = strtotime(date('Y-m-d H:i:s'));
    if($now >= ($cutSecs+$conversion)){
    $localDate= date('Y-m-d', strtotime("next ".$day));
    $cutSecs = strtotime($localDate.' '.$cuttime);
    $startSecs = strtotime($localDate.' '.$starttime);
    }
    return array($cutSecs,$localDate,$startSecs);
}

   $results = $dbRead->query('select * from lotto inner join lottery using (lottoid) where active = 1', PDO::FETCH_ASSOC);

   foreach ($results as $row) {

     $conversion = ((float)$row["GMT"]*3600);
     $timeResponse =  findDateTime($row["drawDay"],$row["cutting"],$row["drawing"],$conversion);
     $cutoff = date('Y-m-d H:i:s',($timeResponse[0] + $conversion));
     $start = date('Y-m-d H:i:s',($timeResponse[2] + $conversion));
     $localDate = $timeResponse[1];


     $count = 0; // check to see if there is already a lottery created, ie, only one at a time
     $search = $dbRead->query('select draw_id,jackpot,localDate from game where lotteryid='.$row["lotteryid"].' and settled  < 3', PDO::FETCH_ASSOC);
     foreach ($search as $rows) {
       $count++;
       $jackpot = $rows["jackpot"];
       $draw_id = $rows["draw_id"];
       $localDate = $rows["localDate"];
     }
     $jackpot = 1000000; // only for dummy lotteries

      if($count == 0){
        $betCount = 0;

        // failsafe......
        // before we create a new lotto, we need to make sure the previuos entries have been deleted

        $checkFirst = $dbRead->query('SELECT betid FROM bets_'.$row["lotteryid"].' LIMIT 1', PDO::FETCH_ASSOC);
        foreach ($checkFirst as $rows2) {
          $betCount++;
        }

        if($betCount > 0){ // looks like we need to delete some data from last lotto
          $dbNew->query('TRUNCATE TABLE bets_'.$row["lotteryid"]);
        }else if($betCount == 0){

          $dbNew->query('TRUNCATE TABLE bets_'.$row["lotteryid"]);
          $dbNew->query('INSERT INTO `game`(`draw_id`, `cutoff`, `drawn`, `gameName`, `lotteryid`, `localDate`) VALUES ("'.$wikibetAPI->GUID().'","'.$cutoff.'","'.$start.'","'.$row["name"].'","'.$row["lotteryid"].'","'.$localDate.'");');

        }

      }

   }
