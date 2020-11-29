<?php


namespace ApplicationCrud\Infrastructure\Repositories;


use ApplicationCrud\Infrastructure\DTO\ApplicationDTO;
use Rosseti\Common\MySqlAdapter;

class ApplicationSqlRepository implements IApplicationRepository
{
    private $dbCon;

    public function __construct($dbCon = null)
    {
        $this->dbCon = new MySqlAdapter();
    }

    /**
     * @return MySqlAdapter
     */
    public function getDbCon(): MySqlAdapter
    {
        return $this->dbCon;
    }



    public function getUserApplications($idUser): array
    {
        $sql =  "SELECT
                        a.short_title as shortTitle,
                        a.date,
                        a.existing_disadvantages as existingDisadvantages,
                        a.solution_description as solutionDescription,
                        a.is_economy as isEconomy,
                        a.id,
                        a.expected_positive_effect as expectedPositiveEffect
                FROM hakaton.application a
                JOIN hakaton.applications_to_user atu ON atu.id_application = a.id
                WHERE atu.id_user = '$idUser'
                ";
        return $this->getDbCon()->select($sql);
    }

    public function addApplicationData(ApplicationDTO $data): int
    {
        $shortTitle = $data->getShortTitle();
        $existingDisadvantages = $data->getExistingDisadvantages();
        $solutionDescription = $data->getSolutionDescription();
        $expectedPositiveEffect = $data->getExpectedPositiveEffect();
        $isEconomy = $data->getIsEconomy();
        $date = date("Y-m-d");
        $category = $data->getCategory();
        $suggestion = $data->getSuggestion();

        $sql =  "INSERT INTO
                    hakaton.application
                SET
                    short_title = '$shortTitle', 
                    existing_disadvantages = '$existingDisadvantages', 
                    solution_description = '$solutionDescription', 
                    expected_positive_effect = '$expectedPositiveEffect',
                    is_economy = '$isEconomy',
                    date = '$date',
                    category = '$category',
                    suggestion = '$suggestion'";

        $this->getDbCon()->insert($sql);
        $lastId = $this->getDbCon()->getLastInsertId();
        return $lastId;
    }

    public function addApplicationToUser($Users, $idApplication): int
    {
        foreach ($Users as $user) {
            $percent = $user['percent'];
            $idUser = $user['userId'];

            $sql = "INSERT INTO
                    hakaton.applications_to_user
                SET
                    id_user = '$idUser',
                    id_application = '$idApplication',
                    percent = '$percent'";

            $this->getDbCon()->insert($sql);

        }

        return $this->getDbCon()->getLastInsertId();
    }

    public function addApplicationToDigital($idApplication, $idCategories): int
    {
        foreach ($idCategories as $idCategory) {
            $sql = "INSERT INTO
                    hakaton.application_to_digital_category
                SET
                    id_application = '$idApplication', 
                    id_digital_category = '$idCategory'";

            $this->getDbCon()->insert($sql);

        }

        return $this->getDbCon()->getLastInsertId();
    }

    public function addExpenditures($expenditures, $idApplication): int
    {
        foreach ($expenditures as $expenditure) {
            $costItem = $expenditure['costItem'];
            $sum = $expenditure['sum'];
            $p_p = $expenditure['p_p'];
            $sql = "INSERT INTO
                    hakaton.expenditures
                SET
                    cost_item = '$costItem', 
                    sum = '$sum',
                    id_application = '$idApplication',
                    p_p = '$p_p'";

            $this->getDbCon()->insert($sql);

        }

        return $this->getDbCon()->getLastInsertId();
    }

    public function addTermsToImplementation($termsForImplementation, $idApplication): int
    {
        foreach ($termsForImplementation as $item) {
            $stageName = $item['stageName'];
            $days = $item['days'];
            $p_p = $item['p_p'];
            $sql = "INSERT INTO
                    hakaton.terms_for_implementation
                SET
                    stage_name = '$stageName', 
                    days = '$days',
                    id_application = '$idApplication',
                    p_p = '$p_p'";

            $this->getDbCon()->insert($sql);

        }

        return $this->getDbCon()->getLastInsertId();
    }

    public function deleteApplicationToDigital($idApplication): int
    {
        $sql = "DELETE FROM
                    hakaton.application_to_digital_category
                WHERE 
                    id_application = '$idApplication'";

        $this->getDbCon()->delete($sql);
    }

    public function deleteApplicationToUser($idApplication): int
    {
        $sql = "DELETE FROM
                    hakaton.applications_to_user
                WHERE 
                    id_application = '$idApplication'";

        $this->getDbCon()->delete($sql);
    }

    public function deleteExpenditures($idApplication): int
    {
        $sql = "DELETE FROM
                    hakaton.expenditures
                WHERE 
                    id_application = '$idApplication'";

        $this->getDbCon()->delete($sql);
    }

    public function deleteTermsToImplementation($idApplication): int
    {
        $sql = "DELETE FROM
                    hakaton.terms_for_implementation
                WHERE 
                    id_application = '$idApplication'";

        $this->getDbCon()->delete($sql);
    }

    public function updApplicationData(ApplicationDTO $data): int
    {
        $shortTitle = $data->getShortTitle();
        $existingDisadvantages = $data->getExistingDisadvantages();
        $solutionDescription = $data->getSolutionDescription();
        $expectedPositiveEffect = $data->getExpectedPositiveEffect();
        $isEconomy = $data->getIsEconomy();
        $applicationId = $data->getApplicationID();

        $sql =  "UPDATE
                    hakaton.application
                SET
                    short_title = '$shortTitle', 
                    existing_disadvantages = '$existingDisadvantages', 
                    solution_description = $solutionDescription, 
                    expected_positive_effect = $expectedPositiveEffect,
                    is_economy = '$isEconomy'
                    WHERE 
                    id = '$applicationId'";

        $this->getDbCon()->insert($sql);
    }

    public function getApplication($idApplication): array
    {
        $sql =  "SELECT
                        a.short_title as shortTitle,
                        a.date,
                        a.existing_disadvantages as existingDisadvantages,
                        a.solution_description as solutionDescription,
                        a.is_economy as isEconomy,
                        a.id,
                        a.expected_positive_effect as expectedPositiveEffect
                FROM hakaton.application a
                JOIN hakaton.applications_to_user atu ON atu.id_application = a.id
                WHERE a.id = '$idApplication'
                ";
        return $this->getDbCon()->select($sql);
    }

    public function getApplicationToUser($idApplication): array
    {
        $sql =  "SELECT
                    id_user as userId,
                    percent
                FROM hakaton.applications_to_user
                WHERE id_application = '$idApplication'";
        return $this->getDbCon()->select($sql);
    }

    public function getApplicationToDigital($idApplication): array
    {
        $sql =  "SELECT
                    GROUP_CONCAT(id_digital_category SEPARATOR ', ') as digitalCat
                FROM hakaton.application_to_digital_category
                WHERE id_application = '$idApplication'";
        return $this->getDbCon()->select($sql);
    }

    public function getExpenditures($idApplication): array
    {
        $sql =  "SELECT
                    cost_item as costItem,
                    sum,
                    p_p
                FROM hakaton.expenditures
                WHERE id_application = '$idApplication'";
        return $this->getDbCon()->select($sql);
    }

    public function getTermsToImplementation($idApplication): array
    {
        $sql =  "SELECT
                    stage_name as stageName,
                    days,
                    p_p
                FROM hakaton.terms_for_implementation
                WHERE id_application = '$idApplication'";
        return $this->getDbCon()->select($sql);
    }
}