<?php


namespace ApplicationExpert;


use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use ApplicationExpert\Infrastructure\Repositories\ApplicationExpertSqlRepository;

class ApplicationExpertRout
{
    public function __construct(App $app)
    {
        $app->get('/getListApplicationId/{id}',     [$this, 'getListApplication']);
        $app->get('/getStatusExpert/{id}',          [$this, 'getStatusExpert']);
        $app->post('/updStatusApplication/{idApp}', [$this, 'updStatusApplication']);
    }

    public function getListApplication(Request $request, Response $response)
    {
        $idExpert = $request->getAttribute('id');
        $repository = new ApplicationExpertSqlRepository();
        return $response->withJson($repository->getApplicationToExpert($idExpert));
    }

    public function getStatusExpert(Request $request, Response $response)
    {
        $idExpert = $request->getAttribute('id');
        $repository = new ApplicationExpertSqlRepository();
        return $response->withJson($repository->getStatusExpert($idExpert));
    }

    public function updStatusApplication(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $data['idApp'] = $request->getAttribute('idApp');
        $repository = new ApplicationExpertSqlRepository();
    }
}