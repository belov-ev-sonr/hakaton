<?php

namespace ApplicationCrud\Infrastructure\Repositories;

use ApplicationCrud\Infrastructure\DTO\ApplicationDTO;
interface IApplicationRepository
{
    public function getUserApplications($idUser): array;

    public function getApplication($idApplication): array;
    public function getApplicationToUser($idApplication): array;
    public function getApplicationToDigital($idApplication): array;
    public function getExpenditures($idApplication): array;
    public function getTermsToImplementation($idApplication): array;

    public function addApplicationData(ApplicationDTO $data): int;
    public function addApplicationToUser($idUser, $idApplication): int;
    public function addApplicationToDigital($idApplication, $idCategory): int;
    public function addExpenditures($expenditures, $idApplication): int;
    public function addTermsToImplementation($termsForImplementation, $idApplication): int;

    public function deleteApplicationToDigital($idApplication): int;
    public function deleteApplicationToUser($idApplication): int;
    public function deleteExpenditures($idApplication): int;
    public function deleteTermsToImplementation($idApplication): int;
    public function updApplicationData(ApplicationDTO $data): int;
}