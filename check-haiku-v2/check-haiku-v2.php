<?php

declare(strict_types=1);
require 'vendor/autoload.php';

$igo = new Igo\Tagger();
$result = $igo->parse('小田原でみんなで一句詠みたいな');
print_r($result);
