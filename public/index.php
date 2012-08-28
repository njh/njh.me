<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Prepare app
$app = new Slim(array(
    'negotiation.enabled' => true
));

// Setup routes
$app->get('/', function () use ($app) {
    $format = $app->respondTo('html', 'rdf', 'ttl', 'json');
    switch($format) {
        case 'html':
            return $app->redirect('http://www.aelius.com/njh/', 303);
        default:
            $rootUrl = $app->request()->getUrl() . $app->request()->getScriptName();
            return $app->redirect("$rootUrl/foaf.$format", 303);
    }
});

$app->get('/foaf:format', function () use ($app) {
    $format = $app->respondTo('rdf', 'ttl', 'json');
    $uri = $app->request()->getUrl() . $app->request()->getPath();

    $foaf = new EasyRdf_Graph($uri);
    $foaf->parseFile(__DIR__ . '/../data/foaf.ttl', 'turtle', $uri);
    $app->response()->body( $foaf->serialise($format) );
});

// Run app
$app->run();
