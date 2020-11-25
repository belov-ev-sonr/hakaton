<?php
namespace Rosatom\Common;

use mysqli_result;

class MySqlAdapter
{
    /** @var DBConnect */
    private $dbConnect;

    /**
     * MySqlAdapter constructor.
     */
    public function __construct()
    {
        $this->dbConnect = DBConnect::getInstance();
    }


    /**
     * @param $sql
     * @param int $resultFormat
     * @param null $result
     * @return array|mysqli_result|null
     * @throws \Exception
     */
    public function select($sql, $resultFormat = 1, &$result = null)
    {
        $result_query = DBConnect::getMysqli()->query($sql);
        if (!$result_query) {
            throw new \Exception("Error mysql request!\n" . DBConnect::getMysqli()->error);
        }
        $result = $result ?: array();
        if ($resultFormat == 1) {
            while ($row = $result_query->fetch_assoc()) {
                $result[] = $row;
            }
        } elseif ($resultFormat == 2) {
            $result = array('head'=>[],
                'body'=>[]);
            while ($row =$result_query->fetch_assoc()) {
                $result['head'][] = $row->name;
            }
            while ($row = $result_query->fetch_array()) {
                $result['body'][] = $row;
            }
        }
        return $result;
    }

    /**
     * @param $sql
     * @return bool
     * @throws \Exception
     */
    public function insert($sql)
    {
        $result = DBConnect::getMysqli()->query($sql);
        if (!$result) {
//            throw new Exception('Error insert!');
            throw new \Exception(DBConnect::getMysqli()->error);
        }
        return (bool)$result;
    }


    /**
     * @param $sql
     * @return bool
     * @throws \Exception
     */
    public function update($sql)
    {
        $result =  DBConnect::getMysqli()->query($sql);
        if (!$result) {
            throw new \Exception('Error update!');
        }
        return (bool)$result;
    }

    /**
     * @param $sql
     * @return bool
     * @throws \Exception
     */
    public function delete($sql)
    {
        $result = DBConnect::getMysqli()->query($sql);
        if (!$result) {
            throw new \Exception('Error delete!');
        }
        return (bool)$result;
    }

    /**
     * @return int
     */
    public function getLastInsertId()
    {
        return DBConnect::getMysqli()->insert_id;
    }
    /**
     * @return int
     */
    public function getAffectedRowsCount()
    {
        return DBConnect::getMysqli()->affected_rows;
    }

}
