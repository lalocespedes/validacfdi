<?php

libxml_use_internal_errors(true);

$fileValidate = function($file) use($app) {

		$dom = new DOMDocument();
		//$dom = new DOMDocument('1.0', 'utf-8');
		$dom->load($file);
		$errors = libxml_get_errors();

		if($errors){

			echo "XML no valido";
	   		$app->stop();
		}

		return true;

};

$schemaValidate = function($file) use($app) {

	$file = preg_replace('{<Addenda.*/Addenda>}is', '<Addenda/>', $file);
	$file = preg_replace('{<cfdi:Addenda.*/cfdi:Addenda>}is', '<cfdi:Addenda/>', $file);

	$xml = new DOMDocument();
	$xml->loadXML($file);

	$ok = $xml->schemaValidate("/home/validacfdi/resources/xsd/cfdv32.xsd");

	if ($ok) {
    
		return true;

	} else {

	    $errors = libxml_get_errors();

	    foreach ($errors as $error) {

	    	$response[] =  $error->message;	

		}

	    libxml_clear_errors();
	}

	echo json_encode($response);
};

$app->post('/valid', function() use($app, $fileValidate, $schemaValidate) {

	$file = file_get_contents($_FILES['xml']["tmp_name"]);

	$fileValidate($file);
	$schemaValidate($file);


});

$app->put('/valid', function() use($app, $fileValidate, $schemaValidate) {

	$file = $app->request()->getBody();

	$fileValidate($file);
	$schemaValidate($file);

});