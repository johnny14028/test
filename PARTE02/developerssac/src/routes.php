<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// Routes
//$app->get('/[{name}]', function ($request, $response, $args) {
$app->get('/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});
$app->get('/detalle/{id}', function ($request, $response, $args) {
    $id = $request->getAttribute('id');
    $str = file_get_contents('employees.json');
    $array_json = json_decode($str, true);
    //buscamos el id del usuario
    if (is_array($array_json) && count($array_json) > 0) {
        foreach ($array_json as $index => $arrayJson) {
            if ($arrayJson['id'] == $id) {
                $skills = $arrayJson['skills'];
                $str_skill = [];
                if (is_array($skills)) {
                    foreach ($skills as $puntero => $skill) {
                        array_push($str_skill, $skill['skill']);
                    }
                }
                $arrayJson['skills'] = implode(',', $str_skill);
                $args = $arrayJson;
                break;
            }
        }
    }
    // Render index view
    return $this->renderer->render($response, 'detail.phtml', $args);
});

$app->get('/buscar/{minimo}/{maximo}', function (Request $request, Response $response) {
    $maximo = (float)$request->getAttribute('maximo');
    $minimo = (float)$request->getAttribute('minimo');
    $str = file_get_contents('employees.json');
    $array_json = json_decode($str, true);  
    $response = $response->withHeader('Content-type', 'txt/xml');
    $xml = new SimpleXMLElement('<empleados/>');
    if (is_array($array_json) && count($array_json) > 0) {
        foreach ($array_json as $index => $arrayJson) {
            preg_match_all('/[0-9][\.\d]*/', $arrayJson['salary'], $salary);
            $salary = (float)implode('', $salary[0]);
            if($salary >= $minimo && $salary <= $maximo){
              $item = $xml->addChild('empleado');
              $item->addChild('id', $arrayJson['id']);
              $item->addChild('title', $arrayJson['name']);
              $item->addChild('email', $arrayJson['email']); 
              $item->addChild('phone', $arrayJson['phone']);                
              $item->addChild('salary', $arrayJson['salary']);                
              $item->addChild('age', $arrayJson['age']);                
              $item->addChild('gender', $arrayJson['gender']);                
              $item->addChild('address', $arrayJson['address']);                
            } 
        }   
    }
    $response->getBody()->write($xml->asXml());
    return $response;
});
