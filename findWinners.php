<?php
require_once 'apis/wikibetAPI.php';
$wikibetAPI = new wikibetAPI();
$dbNew = $wikibetAPI->db_connect();
$dbRead = $wikibetAPI->db_read();

$now = date("Y-m-d H:i:s");

$lotteries = $dbRead->query('select draw_id,lotteryid from game where settled = 2 and risq_active =1 order by drawn limit 1', PDO::FETCH_ASSOC);
foreach ($lotteries as $next) {
  $settleBets=array();

  $results = $dbRead->query('select (select count(*) from prize where lottoid = l.lottoid ) as p_total,draw_id,query,result,payout,tier from game inner join lottery l using (lotteryid) inner join lotto using (lottoid) inner join prize p on (p.lottoid = l.lottoid) inner join prizes using(draw_id,tier_match) where draw_id = "'.$next["draw_id"].'"', PDO::FETCH_ASSOC);
  $count = $results->rowCount();
  foreach ($results as $rows) {

    if($count != $rows["p_total"]){ // we dont have all the payouts

      exit();

    }
    $splitNums = explode('|',$rows["result"]);
    if(isset($splitNums[1])){
      $vars = array(
        '$table' => 'bets_'.$next["lotteryid"],
        '$numbers' => $splitNums[0],
        '$power' => $splitNums[1],
      );
    }else{
      $vars = array(
        '$table' => 'bets_'.$next["lotteryid"],
        '$numbers' => $splitNums[0]
      );
    }

    $query = strtr($rows["query"], $vars);

    $findwinners = $dbRead->query($query, PDO::FETCH_ASSOC);
    if(isset($findwinners)){
      foreach ($findwinners as $row) {

       $dbNew->query('UPDATE bets SET betReturn = "'.$rows["payout"].'",betTier="'.$rows["tier"].'" where betid = "'.$row["betid"].'" and draw_id = "'.$next["draw_id"].'"', PDO::FETCH_ASSOC);

      }
    }

  }

  $dbNew->query('UPDATE lottoTransactions SET finalised = "'.$now.'" where draw_id = "'.$next["draw_id"].'"', PDO::FETCH_ASSOC);
  $dbNew->query('UPDATE game SET settled = "3" where draw_id = "'.$next["draw_id"].'"', PDO::FETCH_ASSOC);

}

