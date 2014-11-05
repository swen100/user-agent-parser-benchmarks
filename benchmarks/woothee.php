<?php

require __DIR__ . '/../vendor/autoload.php';

$cacheDir = __DIR__ . '/../cache';
$resultsFile = $cacheDir . '/output-woothee.txt';
$agentListFile = __DIR__ . '/../data/ua-list.txt';

$agents = file($agentListFile);

$bench = new Ubench;
$bench->start();

$parser = new \Woothee\Classifier;
$results = '';

foreach ($agents as $agentString) {
    $r = $parser->parse($agentString);
    $results .= sprintf('"%s","%s","%s"' . "\n", $r['os'], $r['name'], $r['version']);
}

$bench->end();

file_put_contents($resultsFile, $results);

echo $bench->getTime(true), ' secs ', PHP_EOL;
echo $bench->getMemoryPeak(true), ' bytes', PHP_EOL;
