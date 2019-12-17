<?php

require __DIR__ . '/vendor/autoload.php';

echo '<table>';
echo '<tr><th>Domain</th><th>Status</th></tr>';

$cachePath = 'cache/domains.json';
$string = file_get_contents($cachePath);
$cache = json_decode($string, true);

$extension = '.com';

$cores = [
    "real", "small", "long", "drunk", "ill", "right", "like", "cross", "mad", "lax", "mean", "coy", "prime", "sass", "bored", "fair", "blonde", "apt", "low", "high", "wise", "wry", "huge", "fat", "quick", "clean", "drab", "plain", "red", "blue", "green", "black", "dead", "odd", "rich", "shy", "sly", "vast", "brave", "calm", "kind", "rough", "rogue", "wide", "faint", "loud", "late", "swift", "light", "weak", "wet", "full", "cool", "dark", "dry", "apt", "few", "dumb"
];
$its = [
    'dots', 'lines', 'shapes'
];


$domains = [];

foreach ($cores as $core) {
    foreach ($its as $it) {
        $toCheck = "${core}${it}${extension}";
        $domains[] = check_domain($toCheck, $cache);
    }
}

$chunked = array_chunk(array_filter($domains), 20);

foreach ($chunked as $chunk) {
    $domainCheckResults = Transip_DomainService::batchCheckAvailability($chunk);
    foreach ($domainCheckResults as $domainCheckResult) {
        print_domain($domainCheckResult);
        $cache[] = [
            'domainName' => $domainCheckResult->domainName,
            'status' => $domainCheckResult->status
        ];
    }
}

$fp = fopen($cachePath, 'wb');
fwrite($fp, json_encode($cache));
fclose($fp);

function check_domain($toCheck, $cache)
{
    $cachedDomain = find_domain($toCheck, $cache);
    if (find_domain($toCheck, $cache)) {
        print_domain($cachedDomain);
        return null;
    }

    return $toCheck;
}

function find_domain($domain, $cache)
{
    foreach ($cache as $item) {
        $objectItem = (object)$item;
        if ($objectItem->domainName === $domain) {
            return $objectItem;
        }
    }
    return null;
}

function print_domain($object)
{
    if ($object->status === 'free') {
        echo "<tr><td>{$object->domainName}</td><td>{$object->status}</td></tr>";
    }
}

echo '</table>';