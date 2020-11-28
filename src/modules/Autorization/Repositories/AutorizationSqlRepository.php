<?php


namespace Autorization\Repositories;

use Rosseti\Common\MySqlAdapter;

class AutorizationSqlRepository implements IAutorizationSqlRepository
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



    public function getUserHash($email, $pass)
    {
        $sql =  "SELECT
                    u.id,
                    u.userHash,
                    u.name `firstName`,
                    u.surname `secondName`,
                    u.patronymic
                FROM hakaton.autorization a
                JOIN hakaton.users u ON a.user_id = u.id
                WHERE a.email = '$email'
                AND a.password = '$pass'";
        return $this->getDbCon()->select($sql)[0];
    }
}