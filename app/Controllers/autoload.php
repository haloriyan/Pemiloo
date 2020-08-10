<?php

$scan = glob("../app/Controllers/*");
foreach ($scan as $k => $s) {
    if ($s != "../app/Controllers/autoload.php" && $s != "../app/Controllers/Controller.php") {
        include realpath($s);
    }
}