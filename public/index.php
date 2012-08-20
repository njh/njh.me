<?php

require '../vendor/autoload.php';

# FIXME: work out how to autoload EasyRdf
set_include_path(get_include_path() . PATH_SEPARATOR . '../vendor/njh/easyrdf/lib/');
require 'EasyRdf.php';

// Prepare app
$app = new Slim(array(
    'negotiation.enabled' => true
));

// Setup routes
$app->get('/', function () use ($app) {
    $format = $app->respondTo('rdf', 'ttl', 'json');
    switch($format) {
        case 'html':
            return $app->redirect('http://www.aelius.com/njh/', 303);
        default:
            # FIXME: return absolute URL
            return $app->redirect("foaf.$format", 303);
    }
});

$app->get('/foaf:format', function () use ($app) {
    $format = $app->respondTo('rdf', 'ttl', 'json');
    $foaf = new EasyRdf_Graph();
    $foaf->parseFile('../data/foaf.ttl', 'turtle');

    # FIXME: serialise by file extension automatically
    switch($format) {
        case 'rdf':
            return $app->response()->body( $foaf->serialise('rdfxml') );
        case 'ttl':
            return $app->response()->body( $foaf->serialise('turtle') );
        case 'json':
            return $app->response()->body( $foaf->serialise('json') );
    }
});

// Run app
$app->run();
