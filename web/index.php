<?php

require('../vendor/autoload.php');

$app = new Silex\Application();
$app['debug'] = true;

// Register the monolog logging service
$app->register(new Silex\Provider\MonologServiceProvider(), array(
  'monolog.logfile' => 'php://stderr',
));

// Register view rendering
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

// Our web handlers

$app->get('/', function() use($app) {
  $app['monolog']->addDebug('logging output.');
  return $app['twig']->render('index.twig');
});

$app->post('/validarFirma', function() use($app) {

	$word= $_REQUEST['mensaje'];
	$hash= $_REQUEST['hash'];
	$transform = hash('sha256', $word);
	$value=strtoupper($transform);
	if ($value==$hash){
		$answer= true;
  	}
  	else {
  		$answer= false;
  	}
  	
  return json_encode(array('mensaje' => $word,'valido' => $answer ));
});

$app->get('/status', function() use($app) {

  return $app->json('Http 201',201);
});

$app->run();
