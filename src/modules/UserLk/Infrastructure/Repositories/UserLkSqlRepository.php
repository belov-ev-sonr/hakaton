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
                r.id,
                r.name_role
                FROM hakaton.users u
                JOIN hakaton.user_to_role utr ON utr.id_user = u.id
                JOIN hakaton.role r ON r.id = utr.id_role
                WHERE u.id = '$id'";
        return $this->getDbCon()->select($sql);
    }
}