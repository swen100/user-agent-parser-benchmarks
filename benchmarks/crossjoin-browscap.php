<?php

ini_set('memory_limit', -1);

require __DIR__ . '/../vendor/autoload.php';

$cacheDir = __DIR__ . '/../cache';
$resultsFile = $cacheDir . '/output-crossjoin-browscap-php.txt';
$agentListFile = __DIR__ . '/../data/ua-list.txt';

$agents = file($agentListFile);

$bench = new Ubench;
$bench->start();

$browscap = new \Crossjoin\Browscap\Browscap();
$results = '';

foreach ($agents as $agentString) {
    $r = $browscap->getBrowser($agentString)->getData();
    $results .= json_encode(array($r->platform, $r->browser, $r->version)) . "\n";
    break;  // remove if you want to check all the list
}

$bench->end();

file_put_contents($resultsFile, $results);

echo $bench->getTime(true), ' secs ', PHP_EOL;
echo $bench->getMemoryPeak(true), ' bytes', PHP_EOL;