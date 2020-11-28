<?php


namespace Autorization;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Autorization\Repositories\AutorizationSqlRepository;

class AutorizationRout
{
    public function __construct(App $app)
    {
        $app->post('/login',    [$this, 'login']);
    }

    public function login(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $repository = new AutorizationSqlRepository();
        return $response->withJson($repository->getUserHash($data['email'], $data['pass']));
    }
}