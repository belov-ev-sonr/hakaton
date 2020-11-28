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
        return $this->dbCon->select($sql);
    }
}