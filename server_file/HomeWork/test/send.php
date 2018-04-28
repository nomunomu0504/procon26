<?php

// This sample uses the HTTP_Request2 package. (for more information: http://pear.php.net/package/HTTP_Request2)
require_once '../vendor/pear-pear.php.net/HTTP_Request2/HTTP/Request2.php';
$headers = array(
    'Content-Type' => '',
);

$query_params = array(
    // Specify your subscription key
    'subscription-key' => '*****************',
    // Specify values for optional parameters, as needed
    'param1' => 'aaaaaa',
    'param2' => '111111'
);

$request = new Http_Request2('https://*********.******.***/teacher/');
$request->setMethod(HTTP_Request2::METHOD_PUT);
// Basic Authorization Sample
// $request-setAuth('{username}', '{password}');
$request->setHeader($headers);

$url = $request->getUrl();
$url->setQueryVariables($query_params);
$request->setBody("");

try
{
    $response = $request->send();

    echo $response->getBody();
}
catch (HttpException $ex)
{
    echo $ex;
}