<?php


namespace UserLk\Application\Service;

use DateTime;

class UserInfoService
{
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