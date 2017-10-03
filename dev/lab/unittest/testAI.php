<?php
require_once $_SERVER['DOCUMENT_ROOT']."/setting/api/PHPAI/vendor/autoload.php";
use Phpml\Classification\KNearestNeighbors;

$samples = [[1, 3], [1, 4], [2, 4], [3, 1], [4, 1], [4, 2]];
$labels = ['a', 'a', 'a', 'b', 'b', 'b'];

$classifier = new KNearestNeighbors();
$classifier->train($samples, $labels);

$a = $classifier->predict([3, 2]);

echo $a;