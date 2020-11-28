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
        $app->get('/getFirstExpert/{id}',   [$this, 'getFirstExpert']);
        $app->get('/getSecondExpert/{id}',  [$this, 'getSecondExpert']);
        $app->get('/getSuperExpert/{id}',   [$this, 'getSuperExpert']);
        $app->get('/getImplementor/{id}',   [$this, 'getImplementor']);

    }

    public function getDigitalCategory(Request $request, Response $response)
    {
        $repository = new OtherSqlRepository();
        return $response->withJson($repository->getDigitalCategory());
    }

    public function getFirstExpert(Request $request, Response $response)
    {
        $id = $request->getAttribute('id');
        $repository = new OtherSqlRepository();
        return $response->withJson($repository->getFirstExpert($id)[0]);
    }

    public function getSecondExpert(Request $request, Response $response)
    {
        $id = $request->getAttribute('id');
        $repository = new OtherSqlRepository();
        return $response->withJson($repository->getSecondExpert($id)[0]);
    }

    public function getSuperExpert(Request $request, Response $response)
    {
        $id = $request->getAttribute('id');
        $repository = new OtherSqlRepository();
        return $response->withJson($repository->getSuperExpert($id)[0]);
    }

    public function getImplementor(Request $request, Response $response)
    {
        $id = $request->getAttribute('id');
        $repository = new OtherSqlRepository();
        return $response->withJson($repository->getImplementor($id)[0]);
    }
}