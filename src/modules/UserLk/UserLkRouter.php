<?php

namespace UserLk;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use UserLk\Infrastructure\Repositories\UserLkSqlRepository;
use UserLk\Infrastructure\TransferData\UserRoleTransferData;

class UserLkRouter
{
    public function __construct(App $app)
    {
        $app->get('/getUserInfo/{id}', [$this, 'getUserInfo']);
        $app->get('/hello', [$this, 'getHello']);
    }

    public function getUserInfo(Request $request, Response $response)
    {
        $idUser = $request->getAttribute('id');
        $repository = new UserLkSqlRepository();
        $data = $repository->getUserInfo($idUser);
        return $response->withJson($data[0]);
    }

    public function getHello(Request $request, Response $response)
    {
        return $response->withJson('hello');
    }
}