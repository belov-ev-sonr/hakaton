<?php


namespace OtherRoute\IInfrastructure\Repositories;


use Rosseti\Common\MySqlAdapter;

class OtherSqlRepository implements IOtherSqlRepository
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

    public function getDigitalCategory(): array
    {
        $sql = "SELECT
                *
                FROM hakaton.categories_of_digital_transformation";
        return $this->getDbCon()->select($sql);
    }

    public function getFirstExpert($id): array
    {
        $sql = "SELECT
                    u.name,
                    u.surname,
                    u.patronymic,
                    las.comment,
                    las.date_upd,
                    as1.status
                FROM hakaton.log_application_status las
                JOIN hakaton.signatures_application_status sas ON sas.first_expert_id=las.id_upd
                JOIN hakaton.users u ON u.id = sas.first_expert_id
                JOIN hakaton.application_status as1 ON as1.id = las.status_id
                WHERE las.application_id = '$id'
                ORDER BY las.date_upd DESC";
        return $this->getDbCon()->select($sql);
    }

    public function getSecondExpert($id): array
    {
        $sql = "SELECT
                    u.name,
                    u.surname,
                    u.patronymic,
                    las.comment,
                    las.date_upd,
                    as1.status
                FROM hakaton.log_application_status las
                JOIN hakaton.signatures_application_status sas ON sas.second_expert_id=las.id_upd
                JOIN hakaton.users u ON u.id = sas.second_expert_id
                JOIN hakaton.application_status as1 ON as1.id = las.status_id
                WHERE las.application_id = '$id'
                ORDER BY las.date_upd DESC";
        return $this->getDbCon()->select($sql);
    }

    public function getSuperExpert($id): array
    {
        $sql = "SELECT
                    u.name,
                    u.surname,
                    u.patronymic,
                    las.comment,
                    las.date_upd,
                    as1.status
                FROM hakaton.log_application_status las
                JOIN hakaton.signatures_application_status sas ON sas.super_expert_id=las.id_upd
                JOIN hakaton.users u ON u.id = sas.super_expert_id
                JOIN hakaton.application_status as1 ON as1.id = las.status_id
                WHERE las.application_id = '$id'
                ORDER BY las.date_upd DESC";
        return $this->getDbCon()->select($sql);
    }

    public function getImplementor($id): array
    {
        $sql = "SELECT
                    u.name,
                    u.surname,
                    u.patronymic,
                    las.comment,
                    las.date_upd,
                    as1.status
                FROM hakaton.signatures_application_status sas
                JOIN hakaton.log_application_status las ON sas.implementor_id=las.id_upd
                JOIN hakaton.users u ON u.id = sas.implementor_id
                JOIN hakaton.application_status as1 ON as1.id = las.status_id
                WHERE sas.application_id = '$id'
                ORDER BY las.date_upd DESC";
        return $this->getDbCon()->select($sql);
    }
}