<?php
session_start();
$x = $_GET["x"];
$y = $_GET["y"];
$r = $_GET["r"];
$offset = $_GET['offset'];
if(!isset($_SESSION) | !isset($_SESSION["table"])){
    $_SESSION = array();
    $_SESSION["table"] = '';
}
$time_start = microtime(true);
function validate_coords($x, $y, $r){
    return $y < 5 && $y > -5 && is_numeric($y) && ($x == 3 || $x == 2 || $x == 1 || $x == 0 || $x == -1 || $x == -2 || $x == -3 || $x == -4 || $x == -5) && $r < 5 && $r > 2 && is_numeric($r);
}
function check_coords($x, $y, $r){
    return(check_circle($x, $y, $r) || check_rectangle($x, $y, $r) || check_triangle($x, $y, $r));
}
function check_circle($x, $y, $r){
    return($x<=0 && $y>=0 && $x*$x+$y*$y<=$r*$r);
}
function check_rectangle($x, $y, $r){
    return($x>=0 && $y>=0 && $x<=($r/2) && $y<=$r);
}
function check_triangle($x, $y, $r){
    return($x>=0 && $y<=0 && $y>=($x-$r));
}
if(validate_coords($x, $y, $r)){
    $scripttime = number_format(microtime(true) - $time_start, 6, ',', '');
    $response = array('x' => $x, 'y' => $y, 'r' => $r, 'now' => date('d-m-y h:i a', time() - $offset * 60), 'scripttime' => $scripttime, 'result' => check_coords($x, $y, $r) ? "true" : "false");
    echo '<tr>';
    echo '<td>' . $response['x'] . '</td>';
    echo '<td>' . $response['y'] . '</td>';
    echo '<td>' . $response['r'] . '</td>';
    echo '<td>' . $response['result'] . '</td>';
    echo '<td>' . $response['now'] . '</td>';
    echo '<td>' . $response['scripttime'] . '</td>';
    echo '</tr>';
    $_SESSION['table'] = $_SESSION['table'] . '<tr>' . '<td>' . $response['x'] . '</td>' . '<td>' . $response['y'] . '</td>' . '<td>' . $response['r'] . '</td>' . '<td>' . $response['result'] . '</td>' . '<td>' . $response['now'] . '</td>' . '<td>' . $response['scripttime'] . '</td>' . '</tr>';
}
else{
echo "false";
}
?>