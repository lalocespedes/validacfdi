<?php

use lalocespedes\CfdiMx\Parser;

$app->put('/parse', function() use($app) {

	$file = $app->request()->getBody();

	$parse = new Parser($file);

	echo json_encode($parse->jsonSerialize());  //parsear el xml

})->name('parse-put');