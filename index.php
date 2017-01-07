<?php
/**
 *
 */

include_once __DIR__ . '/GenerateDescription.php';

$generate = new GenerateDescription(1213, 1);
$description = $generate->newDescription();
var_dump($description);
