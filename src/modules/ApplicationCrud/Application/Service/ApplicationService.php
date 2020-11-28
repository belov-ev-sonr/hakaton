<?php


namespace ApplicationCrud\Application\Service;

use ApplicationCrud\Infrastructure\Repositories\ApplicationSqlRepository;
use ApplicationCrud\Infrastructure\DTO\ApplicationDTO;

class ApplicationService
{
    private $repository;

    public function __construct()
    {
        $this->repository = new ApplicationSqlRepository();
    }

    /**
     * @return ApplicationSqlRepository
     */
    public function getRepository(): ApplicationSqlRepository
    {
        return $this->repository;
    }

    public function getApplications($idUser)
    {
        return $this->getRepository()->getUserApplications($idUser);
    }

    public function addApplication($data)
    {

        $dataDto = new ApplicationDTO($data);
        $idApplication = $this->getRepository()->addApplicationData($dataDto);

        $this->getRepository()->addApplicationToDigital($dataDto->getIdDigitalCategory(), $idApplication);
        $this->getRepository()->addApplicationToUser($dataDto->getUsers(), $idApplication);
        $this->getRepository()->addExpenditures($dataDto->getExpenditures(), $idApplication);
        $this->getRepository()->addTermsToImplementation($dataDto->getTermsForImplementation(), $idApplication);

        return $idApplication;
    }

    public function updApplication($data)
    {
        $dataDTO = new ApplicationDTO($data);

        $this->getRepository()->updApplicationData($dataDTO);


        $this->getRepository()->deleteApplicationToDigital($dataDTO->getApplicationID());
        $this->getRepository()->deleteApplicationToUser($dataDTO->getApplicationID());
        $this->getRepository()->deleteExpenditures($dataDTO->getApplicationID());
        $this->getRepository()->deleteTermsToImplementation($dataDTO->getApplicationID());

        $this->getRepository()->addApplicationToDigital($dataDTO->getIdDigitalCategory(), $dataDTO->getApplicationID());
        $this->getRepository()->addApplicationToUser($dataDTO->getUsers(), $dataDTO->getApplicationID());
        $this->getRepository()->addExpenditures($dataDTO->getExpenditures(), $dataDTO->getApplicationID());
        $this->getRepository()->addTermsToImplementation($dataDTO->getTermsForImplementation(), $dataDTO->getApplicationID());

        return $dataDTO->getApplicationID();
    }

    public function getApplicationData($id)
    {
        $ApplicationInfo = $this->getRepository()->getApplication($id)[0];
        $ApplicationInfo['users'] = $this->getRepository()->getApplicationToUser($id);
        $ApplicationInfo['idDigitalCategory'] = $this->getRepository()->getApplicationToDigital($id)[0]['digitalCat'];
        $ApplicationInfo['expenditures'] = $this->getRepository()->getExpenditures($id);
        $ApplicationInfo['termsForImplementation'] = $this->getRepository()->getTermsToImplementation($id);


        return $ApplicationInfo;
    }
}