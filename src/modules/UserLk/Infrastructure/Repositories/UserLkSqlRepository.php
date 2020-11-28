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
                    u.id,
                    u.name,
                    u.surname,
                    u.patronymic,
                    p.id as positions,
                    p.name_position as position_name,
                    su.id as structural_units,
                    su.full_name as structural_units_name,
                    ed.id as education,
                    ed.name as education_name,
                    e.date_of_employment,
                    utr.id_role,
                    (SELECT r.name_role FROM hakaton.role r WHERE r.id = utr.id_role LIMIT 1) role_name
                FROM hakaton.employees e
                JOIN hakaton.users u ON u.id=e.user_id
                JOIN hakaton.user_to_role utr ON u.id=utr.id_user
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
                    r.id as roleNumber,
                    u.is_active active
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
                    name_position as name
                FROM hakaton.positions";
        return $this->getDbCon()->select($sql);
    }

    public function getStructuralUnitsList(): array
    {
        $sql =  "SELECT
                    id,
                    full_name as name
                FROM hakaton.structural_units";
        return $this->getDbCon()->select($sql);
    }

    public function getEducationList(): array
    {
        $sql =  "SELECT
                    id,
                    name
                FROM hakaton.education";
        return $this->getDbCon()->select($sql);
    }

    public function updUserInfo(UserInfoDTO $data): int
    {
        $name = $data->getName();
        $surname = $data->getSurname();
        $patronymic = $data->getPatronymic();
        $id = $data->getId();
        $idRole = $data->getRoleId();
        $sql =  "UPDATE 
                    hakaton.users
                SET 
                    name = '$name',
                    surname = '$surname',
                    patronymic = '$patronymic'
                WHERE id = '$id'";
        $this->getDbCon()->update($sql);
        $this->updateEmployee($data);
        $this->updRoleUser($idRole, $id);
        return $id;
    }

    private function updateEmployee(UserInfoDTO $data): int
    {
        $sql = "
            UPDATE hakaton.employees
            SET position_id = '{$data->getPosition()}',
                structural_unit_id = '{$data->getStructuralUnits()}',
                education_id = '{$data->getEducation()}'
            WHERE `user_id` = '{$data->getId()}'";
        $this->getDbCon()->update($sql);
        return (int)$data->getId();
    }

    public function addUser(UserInfoDTO $data): int
    {
        $name = $data->getName();
        $surname = $data->getSurname();
        $patronymic = $data->getPatronymic();
        $position = $data->getPosition();
        $structuralUnits = $data->getStructuralUnits();
        $education = $data->getEducation();
        $roleId = $data->getRoleId();
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
        $lastId = $this->getDbCon()->getLastInsertId();
        $this->addRoleUser($roleId, $lastId);
        return $lastId;
    }

    public function changeUserStatus($id, $isActive): int
    {
        $sql =  "UPDATE 
                    hakaton.users
                SET 
                    is_active = '$isActive'
                WHERE id = '$id'";
        $this->getDbCon()->update($sql);
        return $id;
    }

    public function getRoleList(): array
    {
        $sql =  "SELECT
                    id,
                    name_role as name
                FROM hakaton.role";
        return $this->getDbCon()->select($sql);
    }

    public function addRoleUser($idRole, $idUser): int
    {
        $sql =  "INSERT INTO 
                    hakaton.user_to_role
                SET 
                    id_user = '$idUser',
                    id_role = '$idRole'";
        $this->getDbCon()->insert($sql);
        return $this->getDbCon()->getLastInsertId();
    }

    public function updRoleUser($idRole, $idUser): int
    {
        $sql =  "UPDATE 
                    hakaton.user_to_role
                SET 
                    id_role = '{$idRole}'
                WHERE id_user = '{$idUser}'";
        $this->getDbCon()->update($sql);
        return $idUser;
    }
}