<?php
//本日取得
function getToday($date = 'Y-m-d') {
    //DateTimeの取得
		$today = new DateTime();
		return $today->format($date);
}
 
//本日かどうかチェック
function isToday($year, $month, $day) {
 
	$today = getToday('Y-n-j');
	if ($today == $year."-".$month."-".$day) {
 		return true;
	}else{ 
  return false;
  }
}
 
//今週の日曜日の日付を返す
function getSunday() {
 
	$today = new DateTime();
	//format('w')→0 (日曜)から 6 (土曜)
	$w = $today->format('w');
	$ymd = $today->format('Y-m-d');
 
	$next_prev = new DateTime($ymd);
	$next_prev->modify("-{$w} day");
	return $next_prev->format('Ymd');
 
}

 
//今週月曜日の日付を返す
function getMonday() {
 
	$today = new DateTime();
	//format('w')→0 (日曜)から 6 (土曜)
	$w = $today->format('w');
	$ymd = $today->format('Y-m-d');
 
	if ($w == 0) {
		$d = 6;
	}else{
		//0（日曜）+1
		$d = $w - 1 ;
	}
	$next_prev = new DateTime($ymd);
	$next_prev->modify("-{$d} day");
	return $next_prev->format('Ymd'); 
}
 
//N日（週）+か-する関数
function getNthDay($year, $month, $day, $n) { 
	$next_prev = new DateTime($year.'-'.$month.'-'.$day);
	$next_prev->modify($n);
	return $next_prev->format('Ymd');
}
 
//週間カレンダー表示
if (isset($_GET['date'])) {
	//年月日取得 html内次週/前週リンクから取得
	$year_month_day = $_GET['date']; 
}else{
	//今週日曜日取得
	$year_month_day = getSunday();
}


//年月日に変数で取得
/*
$rest = substr("abcdef", 0, -1);  // "abcde" を返す
$rest = substr("abcdef", 2, -1);  // "cde" を返す
$rest = substr("abcdef", 4, -4);  // false を返す
$rest = substr("abcdef", -3, -1); // "de" を返す
*/
$year  = substr($year_month_day, 0, 4); 
$month = substr($year_month_day, 4, 2); 
$day   = substr($year_month_day, 6, 2);
//sprintf() %：,01:,d:Int型 
$month = sprintf("%01d", $month);
$day   = sprintf("%01d", $day);
 
$next_week = getNthDay($year, $month, $day, '+1 week');
$pre_week  = getNthDay($year, $month, $day, '-1 week');
 
$table = NULL;
//週間の日付出力
$table .= '<td class="today"></td>'.PHP_EOL;
for ($i = 0; $i < 7; $i++) { 
	$ymd = getNthDay($year, $month, $day, '+'.$i.' day');
	$y = substr($ymd, 0, 4); 
	$m = substr($ymd, 4, 2); 
	$d = substr($ymd, 6, 2); 
	$n = sprintf("%01d", $m);
	$j = sprintf("%01d", $d);
	$t = $j.'日';
 
	if (isToday($y, $n, $j)){
		$table .= '<td class="today">'.$t.'</td>'.PHP_EOL; 
	}else{
	  $table .= '<td>'.$t.'</td>'.PHP_EOL; 
	}
}

////ステータス反映
	//予約上限
	$capacity =3;//
	$mark_available = "●";
	$mark_unavailable = "×";

	//時刻表
	$startHour = 9;//
	$startMin = 30;//
	$endHour = 21;//
	$endMin = 0;//

	if($startMin==30){
		$timeTable[] = $startHour.":".$startMin;
		$startHour++;
	}

	for($i = $startHour; $i < $endHour; $i++){
		$timeTable[] = $i.":"."00";
		$timeTable[] = $i.":"."30";
	}

	if($endMin==30){
		$timeTable[] = $endHour.":"."00";
	}
	//配列要素の数をカウント
	$elementsNumber_timeTable = count($timeTable);
	//予約表のコマ（時間帯）の数だけループ
	for($loop_i = 0; $loop_i < $elementsNumber_timeTable; $loop_i++){ 
		//デモ用変数//
		$reservationN[0] = 2;
		$reservationN[1] = 3;
		$reservationN[2] = 0;
		$reservationN[3] = 1;
		$reservationN[4] = 0;
		$reservationN[5] = 3;
		$reservationN[6] = 0;
		//

		//表示する予約表の一行（日曜日から土曜日）を表示
		$statusTable[$loop_i] = NULL;
		$statusTable[$loop_i] .="<tr>".PHP_EOL;
		$statusTable[$loop_i] .= "<td>$timeTable[$loop_i]</td>".PHP_EOL;
		//日曜日から土曜日のループ
		for($loop_j = 0; $loop_j < 7; $loop_j++){
			//select結果の行数をカウント//where reservationTime＝$timeTable[$loop_i]（時刻）&&reservationDate={$ymd = getNthDay($year, $month, $day, '+'.$loop_j.' day')（日付）;}//
			$reservationNumber[$loop_j]	= $reservationN[$loop_j];//$reservationN[6]→データベースから取得
			$status[$loop_j] = ($reservationNumber[$loop_j]<$capacity);
			

			if($status[$loop_j]){
				//a href にリンクを代入
				$statusTable[$loop_i] .= '<td>'.'<a href="">'.$mark_available.'<a href="">'.'</td>'.PHP_EOL;
			}else{
				$statusTable[$loop_i] .= '<td>'.$mark_unavailable.'</td>'.PHP_EOL;
			}
		}
		$statusTable[$loop_i] .="</tr>".PHP_EOL;	
	}
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="./css/style.css" type="text/css">
    <title>カレンダー</title>
  </head>
  <body>
		<!--コンテンツ：開始-->
    <div id="contents">
    <table class="cal">
      <tr>
        <th colspan="2"><a href="<?php $_SERVER['SCRIPT_NAME'];?>?date=<?php echo $pre_week;?>">&laquo; 前週</a></td>
        <th colspan="3"><?php echo $year;?> 年 <?php echo $month;?> 月</td>
        <th colspan="2"><a href="<?php $_SERVER['SCRIPT_NAME'];?>?date=<?php echo $next_week;?>">次週 &raquo;</a></td>
      </tr>
      <tr>
        <?php echo $table;?>
      </tr>
      <tr>
				<td></td>
        <td>日</td>
        <td>月</td>
        <td>火</td>
        <td>水</td>
        <td>木</td>
        <td>金</td>
        <td>土</td>
			</tr>
        <?php for($loop_i = 0; $loop_i < $elementsNumber_timeTable; $loop_i++){echo $statusTable[$loop_i];}?>
		</table>
		</div>
		<!--コンテンツの終了-->
		<!--フッターの開始-->
    <footer id="footer">
      <p>Copyright c2020 managementUI form All Rights Reserved.</p>
    </footer>
    <!--フッターの終了-->
  </body>
</html>