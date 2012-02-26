<?php 

$a = array('red', 'blue', 'tangerine orange', 'green', 'yellow', 'teal');
$b = array('purple', 'blue', 'magenta', 'lime', 'yellow', 'teal');

//Change should be 
// red purple tangerine orange green lime magenta


$a = range(1, 10000);
$b = range(5000, 15000);

shuffle($a);
shuffle($b);

$ts = microtime(true);
$_me = _array_diff($a, $b);
printf("ME =%.4f\n", microtime(true) - $ts);
echo '<br />';

$ts = microtime(true);
$_you = your_array_diff($a, $b);
printf("YOU=%.4f\n", microtime(true) - $ts);
echo '<br />';

//$ts = microtime(true);
//array_diff($a, $b);
//printf("PHP=%.4f\n", microtime(true) - $ts);

/*
echo 'Me: ';
print_r($_me);
echo "<br />";

echo 'You: ';
print_r($_you);
echo "<br />";
*/




function _array_diff($a, $b) {
	$map = $out = array();
	foreach($a as $val)  {$val = trim($val); $map[$val] = 1 ; }
	foreach($b as $val)  {$val = trim($val); if(isset($map[$val])) $map[$val] = 0 ; }
	foreach($map as $val => $ok) if($ok) $out[] = $val;
	return $out;
}

function your_array_diff($a, $b) {
	 $c = array_flip($a);
     $d = array_flip($b);
	
	 foreach($d as $k=>$v) {
		if (array_key_exists($k, $c)) {
			unset($c[$k]);
		} else {
			$c[$k] = $v;
		}
	 }
	
	return array_flip($c);
}






?>