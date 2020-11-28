<?php


namespace ApplicationExpert;


use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

class ApplicationExpertRout
{
    public function __construct(App $app)
    {
        $app->post('/getListApplication/{id}',   [$this, 'getListApplication']);
    }

    public function getListApplication(Request $request, Response $response)
    {
        $idExpert = $request->getAttribute('id');

    }
}