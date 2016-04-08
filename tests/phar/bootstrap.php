<?php

require __DIR__ . '/PharTestCase.php';

echo "Building PHAR... \n";

chdir(__DIR__ . '/../..');
@exec('ant phar', $output ,$returnCode);
if ($returnCode !== 0) {
    throw new RuntimeException('Could not build PHAR');
}

foreach (glob(__DIR__ . '/../../build/phar/*.phar') as $pharFile) {
    define ('PHAR_FILENAME',  $pharFile);
    echo sprintf("Using PHAR %s for the test run. \n\n", $pharFile);
    break;
}
