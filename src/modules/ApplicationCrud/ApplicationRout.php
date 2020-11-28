<?php

namespace ApplicationCrud;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use ApplicationCrud\Application\Service\ApplicationService;

class ApplicationRout
{
    public function __construct(App $app)
    {
        $app->post('/addApplication',           [$this, 'addApplication']);
        $app->post('/updApplication/{id}',      [$this, 'updApplication']);
        $app->get('/getUserApplications/{id}',  [$this, 'getUserApplications']);
        $app->get('/getApplication/{id}',       [$this, 'getApplication']);

    }

    public function getApplication(Request $request, Response $response)
    {
        $idApplication = $request->getAttribute('id');
        $service = new ApplicationService();
        return $response->withJson($service->getApplicationData($idApplication));
    }

    public function addApplication(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $service = new ApplicationService();
        return $response->withJson($service->addApplication($data));
    }

    public function updApplication(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $data['applicationID'] = $request->getAttribute('id');
        $service = new ApplicationService();
        return $response->withJson($service->updApplication($data));
    }

    public function getUserApplications(Request $request, Response $response)
    {
        $idUser = $request->getAttribute('id');
        $service = new ApplicationService();
        return $response->withJson($service->getApplications($idUser));
    }
}
