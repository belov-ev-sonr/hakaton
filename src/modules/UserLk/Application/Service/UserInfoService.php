<?php


namespace UserLk\Application\Service;

use DateTime;

class UserInfoService
{
    public function getUserList($data)
    {
        $res = [];
        foreach ($data as $row)
        {
            $res['roleNumber']      = $row['id'];
            $res['name']            = $row['name'];
            $res['surname']         = $row['surname'];
            $res['patronymic']      = $row['patronymic'];
            $res['patronymic']      = $row['patronymic'];
            $res['position']        = $row['name_position'];
            $res['structuralUnits'] = $row['structural_units'];
            $res['education']       = $row['education'];
            $res['roleName']        = $row['name_role'];
        }

        return $res;
    }

    public function getInfoForAdmin($data)
    {
        $res['name']                = $data['name'];
        $res['patronymic']          = $data['patronymic'];
        $res['surname']             = $data['surname'];
        $res['position']            = $data['positions'];
        $res['positionName']        = $data['position_name'];
        $res['structuralUnits']     = $data['structural_units'];
        $res['structuralUnitsName'] = $data['structural_units_name'];
        $res['education']           = $data['education'];
        $res['educationName']       = $data['education_name'];
        $res['roleId']              = $data['id_role'];
        $res['roleName']            = $data['role_name'];

        return $res;
    }

    public function getInfo($data): array
    {
        $date = new DateTime($data['date_of_employment']);
        $interval = $date->diff(date_create('now'));
        $res['fio']                 = $this->getFio($data);
        $res['position']            = $data['name_position'];
        $res['structuralUnits']     = $data['structural_units'];
        $res['workExperience']      = $interval->y;
        $res['education']           = $data['education'];

        return $res;
    }

    public function getFio(array $data):string
    {
        return mb_substr($data['name'],0,1).'. '.mb_substr($data['patronymic'],0,1).'. '.$data['surname'];
    }
}