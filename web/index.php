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
	if (strcmp($transform, $hash) == 0){
		$answer= $word . ' true';
  	}
  	else {
  		$answer= $word . ' false';
  	}

  return $answer;
});

$app->get('/status', function() use($app) {
  var_dump(http_response_code(201));
	$value= 'Http 201';

  return $value;
});

$app->run();
