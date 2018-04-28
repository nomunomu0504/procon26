<?php
header('Access-Control-Allow-Origin:*');
$app = new \Phalcon\Mvc\Micro();

$app->get('/', function() {

    $req = array();
    parse_str($_SERVER['QUERY_STRING'], $req);
//	echo "get\n";
//    var_dump($req);
    echo json_encode($req);
});

$app->post('/', function() {

    $req = array();
    parse_str($_SERVER['QUERY_STRING'], $req);
//	echo "post\n";
//    var_dump($req);
    echo json_encode($req);
});

$app->delete('/', function() {

    $req = array();
    parse_str($_SERVER['QUERY_STRING'], $req);
//	echo "delete\n";
//    var_dump($req);
    echo json_encode($req);
});

$app->put('/', function() {

    $req = array();
    parse_str($_SERVER['QUERY_STRING'], $req);
//    echo "put\n";
//    var_dump($req);
    echo json_encode($req);
});

$app->handle();