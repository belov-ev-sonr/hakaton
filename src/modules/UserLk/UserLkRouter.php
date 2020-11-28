<?php

namespace UserLk;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use UserLk\Infrastructure\Repositories\UserLkSqlRepository;
use UserLk\Application\Service\UserInfoService;

class UserLkRouter
{
    public function __construct(App $app)
    {
        $app->get('/getUserRole/{id}',          [$this, 'getUserRole']);
        $app->get('/getUserInfo/{id}',          [$this, 'getUserInfo']);
        $app->get('/getUsersList',              [$this, 'getUsersList']);
        $app->get('/getPositionsList',          [$this, 'getPositionsList']);
        $app->get('/getStructuralUnitsList',    [$this, 'getStructuralUnitsList']);
        $app->get('/getEducationList',          [$this, 'getEducationList']);
    }

    public function getPositionsList(Request $request, Response $response)
    {
        $repository = new UserLkSqlRepository();
        return $response->withJson($repository->getPositionsList());
    }

    public function getStructuralUnitsList(Request $request, Response $response)
    {
        $repository = new UserLkSqlRepository();
        return $response->withJson($repository->getStructuralUnitsList());
    }

    public function getEducationList(Request $request, Response $response)
    {
        $repository = new UserLkSqlRepository();
        return $response->withJson($repository->getEducationList());
    }

    public function getUserInfo(Request $request, Response $response)
    {
        $idUser = $request->getAttribute('id');
        $repository = new UserLkSqlRepository();
        $service = new UserInfoService();
        $data = $service->getInfo($repository->getUserInfo($idUser)[0]);
        return $response->withJson($data);
    }

    public function getUserRole(Request $request, Response $response)
    {
        $idUser = $request->getAttribute('id');
        $repository = new UserLkSqlRepository();
        $data = $repository->getUserRole($idUser);
        return $response->withJson($data[0]);
    }

    public function getUsersList(Request $request, Response $response)
    {
        $repository = new UserLkSqlRepository();
        return $response->withJson($repository->getUsersList());
    }

    public function getHello(Request $request, Response $response)
    {
        return $response->withJson('hello');
    }
}