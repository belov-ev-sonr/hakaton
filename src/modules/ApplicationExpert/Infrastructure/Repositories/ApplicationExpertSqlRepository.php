<?php


namespace ApplicationExpert\Infrastructure\Repositories;

use Rosseti\Common\MySqlAdapter;

class ApplicationExpertSqlRepository
{
    private $dbCon;

    public function __construct()
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

    public function getApplicationToExpert($id)
    {
        $sql =  "SELECT
                 id
                FROM hakaton.signatures_application_status
                WHERE first_expert_id = '$id'
                    OR second_expert_id = '$id'
                    OR super_expert_id = '$id'
                    OR implementor_id = '$id'
                    AND second_expert_status = 0
                    AND first_expert_status = 0
                    AND super_expert_status = 0
                    AND implementor_status = 0
                ";
        return $this->getDbCon()->select($sql);
    }

    public function getStatusExpert($id)
    {
        $sql =  "SELECT
                    as1.id,
                    as1.status
                FROM hakaton.user_to_role utr
                JOIN hakaton.role_to_status rts ON rts.id_role = utr.id_role
                JOIN hakaton.application_status as1 ON as1.id = rts.Id_application_status
                WHERE utr.id_user = '$id'
                ";
        return $this->getDbCon()->select($sql);
    }

    public function addLogStatus($data)
    {
        $statusId = $data['idStatus'];
        $dataUpd = date('Y-m-d');
    }
}