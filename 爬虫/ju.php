<?php
function getSubstr($str, $leftStr, $rightStr){
    $left = strpos($str, $leftStr);
    $right = strpos($str, $rightStr,$left);
    if($left < 0 or $right < $left) return '';
    return substr($str, $left + strlen($leftStr), $right-$left-strlen($leftStr));
}
$x = $_GET["p"];
$y = 'http://www.juzimi.com/article/angel-beats';
if($x == 0){
    $l = $y;
}else{
    $l = $y.'?page='.$x;
}
$t = file_get_contents($l);
$a = getSubstr($t,'<div class="view-content">','<div class="view-footer">');
$c = preg_replace('#<br/>#','',$a);
preg_match_all('/<a href="[^"]*" title="查看本句" class="xlistju">(.*?)<\/a>/is',$c,$array);
$uploadconn=new mysqli('localhost','root','root','hitokoto');
foreach ($array[1] as $value) {
  $stmt=$uploadconn->prepare ("INSERT INTO hitokoto (id, catname, text, source) VALUES(?, ?, ?, ?)");
  $stmt->bind_param ("ssss",$id,$catname,$text,$source);
  $id = time();
  $catname = '动画';
  $text = $value;
  $source ='Angel Beats';
  $stmt->execute ();
}
$x++;
if($x < 10){
  $link = '/ju.php?p='.$x;
  header('Location: '.$link);
}
?>