<?php


namespace UserLk\Infrastructure\Repositories;

use Rosseti\Common\MySqlAdapter;
use UserLk\Infrastructure\DTO\UserInfoDTO;

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
                    p.id as positions,
                    su.id as structural_units,
                    ed.id as education,
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
                    e.id,
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

    public function getPositionsList(): array
    {
        $sql =  "SELECT
                    id,
                    name_position as position
                FROM hakaton.positions";
        return $this->getDbCon()->select($sql);
    }

    public function getStructuralUnitsList(): array
    {
        $sql =  "SELECT
                    id,
                    full_name as structuralUnit
                FROM hakaton.structural_units";
        return $this->getDbCon()->select($sql);
    }

    public function getEducationList(): array
    {
        $sql =  "SELECT
                    id,
                    name as education
                FROM hakaton.education";
        return $this->getDbCon()->select($sql);
    }

    public function updUserInfo(UserInfoDTO $data): int
    {
        $name = $data->getName();
        $surname = $data->getSurname();
        $patronymic = $data->getPatronymic();
        $position = $data->getPosition();
        $structuralUnits = $data->getStructuralUnits();
        $education = $data->getEducation();
        $id = $data->getId();
        $sql =  "UPDATE 
                    hakaton.users
                SET 
                    name = '$name',
                    surname = '$surname',
                    patronymic = '$patronymic',
                    position = '$position',
                    structuralUnits = '$structuralUnits',
                    education = '$education'
                WHERE id = '$id'";
        $this->getDbCon()->update($sql);
        return $id;
    }

    public function addUser(UserInfoDTO $data): int
    {
        $name = $data->getName();
        $surname = $data->getSurname();
        $patronymic = $data->getPatronymic();
        $position = $data->getPosition();
        $structuralUnits = $data->getStructuralUnits();
        $education = $data->getEducation();
        $sql =  "INSERT INTO 
                    hakaton.users
                SET 
                    name = '$name',
                    surname = '$surname',
                    patronymic = '$patronymic',
                    position = '$position',
                    structuralUnits = '$structuralUnits',
                    education = '$education'";
        $this->getDbCon()->insert($sql);
        return $this->getDbCon()->getLastInsertId();
    }

    public function deactiveteUser($id): int
    {
        $sql =  "UPDATE 
                    hakaton.users
                SET 
                    is_active = 0
                WHERE id = '$id'";
        $this->getDbCon()->update($sql);
        return $id;
    }
}