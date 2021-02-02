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
	$w = $today->format('w');
	$ymd = $today->format('Y-m-d');
 
	$next_prev = new DateTime($ymd);
	$next_prev->modify("-{$w} day");
	return $next_prev->format('Ymd');
 
}
echo getSunday()."<br>";//

function getpy() {//
 
	$today = new DateTime();
	$y = $today->format('y');
	$ymd = $today->format('Y-m-d');
 
	$next_prev = new DateTime($ymd);
	$next_prev->modify("-{$y} day");
	return $next_prev->format('Ymd');
 
}//
echo getpy()."<br>";//
function getww() {//
 
	$today = new DateTime();
  $w = $today->format('w'); 
  return $w;
}//
echo getww()."<br>";//

function getyy() {//
 
	$today = new DateTime();
  $y = $today->format('y'); 
  return $y;
}//
echo getyy()."<br>";//
 
//今週月曜日の日付を返す
function getMonday() {
 
	$today = new DateTime();
	$w = $today->format('w');
	$ymd = $today->format('Y-m-d');
 
	if ($w == 0) {
		$d = 6;
	}else{
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
	//年月日取得
	$year_month_day = $_GET['date']; 
}else{
			//今週日曜日取得
			$year_month_day = getSunday();
}
 
//年月日に変数で取得
$year  = substr($year_month_day, 0, 4); 
$month = substr($year_month_day, 4, 2); 
$day   = substr($year_month_day, 6, 2); 
$month = sprintf("%01d", $month);
$day   = sprintf("%01d", $day);
 
$next_week = getNthDay($year, $month, $day, '+1 week');
$pre_week  = getNthDay($year, $month, $day, '-1 week');
 
$table = NULL;
//週間の日付出力
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

$timeTable = NULL;

?>