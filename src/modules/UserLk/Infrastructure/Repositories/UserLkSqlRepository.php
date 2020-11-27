<?php


namespace UserLk\Infrastructure\Repositories;

use Rosseti\Common\MySqlAdapter;

class UserLkSqlRepository implements IUserLkSqlRepository
{
    private $dbCon;

    /**
     * UserLkSqlRepository constructor.
     * @param $dbCon
     */
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



    public function getUserInfo($id): array
    {
        $sql =  "SELECT
                    u.name,
                    u.surname,
                    u.patronymic,
                    p.name_position,
                    su.full_name as structural_units,
                    ed.name as education,
                    e.date_of_employment
                FROM hakaton.employees e
                JOIN hakaton.users u ON u.id=e.user_id
                JOIN hakaton.positions p ON e.position_id=p.id
                JOIN hakaton.structural_units su ON su.id=e.structural_unit_id
                JOIN hakaton.education ed ON ed.id=e.education_id
                WHERE u.id = '$id'
                LIMIT 1";
        return $this->getDbCon()->select($sql);
    }

    public function getUserRole($id): array
    {
        $sql =  "SELECT
                    u.name,
                    u.surname,
                    u.patronymic,
                    r.id,
                    r.name_role
                FROM hakaton.users u
                JOIN hakaton.user_to_role utr ON utr.id_user = u.id
                JOIN hakaton.role r ON r.id = utr.id_role
                WHERE u.id = '$id'";
        return $this->getDbCon()->select($sql);
    }

    public function getUsersList(): array
    {
        $sql =  "SELECT
                    u.name,
                    u.surname,
                    u.patronymic,
                    p.name_position as position,
                    su.full_name as structuralUnits,
                    ed.name as education,
                    e.date_of_employment as employment,
                    r.name_role as roleName,
                    r.id as roleNumber
                FROM hakaton.employees e
                JOIN hakaton.users u ON u.id=e.user_id
                JOIN hakaton.positions p ON e.position_id=p.id
                JOIN hakaton.structural_units su ON su.id=e.structural_unit_id
                JOIN hakaton.education ed ON ed.id=e.education_id
                JOIN hakaton.user_to_role utr ON utr.id_user=u.id
                JOIN hakaton.role r ON r.id=utr.id_role";
        return $this->getDbCon()->select($sql);
    }
}