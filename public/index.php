<?php

set_include_path(get_include_path() . PATH_SEPARATOR . '../lib/');

require '../vendor/autoload.php';

// Prepare app
$app = new Slim(array(
    'negotiation.enabled' => true
));

// Setup routes
$app->get('/', function () use ($app) {
    $format = $app->respondTo('html', 'rdf');
    switch($format) {
        case 'html':
            return $app->redirect('http://www.aelius.com/njh/', 303);
        default:
            return $app->redirect("http://www.aelius.com/njh/foaf.$format", 303);
    }        
});

// Run app
$app->run();
