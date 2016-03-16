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

$app->post('/validate', function() use($app) {

	$word= $_GET['mensaje'];
	$hash= $_GET['hash'];
	if (strcmp($word, $hash) == 0){
		$answer= $word . '/n true /n' . $hash;
  	}
  	else {
  		$answer=$word . '/n false' . $hash;
  	}

  return $answer;
});

$app->get('/status', function() use($app) {

	$value= 'Http 201';

  return $value;
});

$app->run();
