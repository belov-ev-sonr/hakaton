<?php

namespace OtherRoute;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use OtherRoute\IInfrastructure\Repositories\OtherSqlRepository;

class OtherRout
{
    public function __construct(App $app)
    {
        $app->get('/getDigitalCategory',    [$this, 'getDigitalCategory']);

    }

    public function getDigitalCategory(Request $request, Response $response)
    {
        $repository = new OtherSqlRepository();
        return $response->withJson($repository->getDigitalCategory());
    }
}