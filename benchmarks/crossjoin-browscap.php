<?php

ini_set('memory_limit', -1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config.php';

$cacheDir = $config['cacheDir'];
$resultsFile = $cacheDir . '/output-crossjoin-browscap.txt';
$agentListFile = $config['userAgentListFile'];

$agents = file($agentListFile);

$bench = new Ubench;
$bench->start();

$results = '';

foreach ($agents as $agentString) {
    \Crossjoin\Browscap\Cache\File::setCacheDirectory($cacheDir);
    $updater = new \Crossjoin\Browscap\Updater\None();
    \Crossjoin\Browscap\Browscap::setUpdater($updater);
    $browscap = new \Crossjoin\Browscap\Browscap();
    $r = $browscap->getBrowser($agentString)->getData();
    $results .= json_encode(array($r->platform, $r->browser, $r->version)) . "\n";
}

$bench->end();

file_put_contents($resultsFile, $results);

echo $bench->getTime(true), ' secs ', PHP_EOL;
echo $bench->getMemoryPeak(true), ' bytes', PHP_EOL;
