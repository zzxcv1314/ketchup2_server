<?php

$subscriptionKey = "7e5660b766684dcebe662b790edac7a4";


getFacelist();

function getFacelist(){
  
    require_once 'HTTP/Request2.php';

    $request = new Http_Request2('https://eastus.api.cognitive.microsoft.com/face/v1.0/facelists/test');
    $url = $request->getUrl();

    $headers = array(
        // Request headers
        'Ocp-Apim-Subscription-Key' => '{subscription key}',
    );

    $request->setHeader($headers);

    $parameters = array(
        // Request parameters
    );

    $url->setQueryVariables($parameters);

    $request->setMethod(HTTP_Request2::METHOD_GET);

    // Request body
    $request->setBody("{body}");

    try
    {
        $response = $request->send();
        echo $response->getBody();
    }
    catch (HttpException $ex)
    {
        echo $ex;
    }
}
?>