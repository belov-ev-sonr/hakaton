<?php


namespace UserLk\Infrastructure\DTO;


class UserInfoDTO
{
    private $name;

    private $patronymic;

    private $surname;

    private $position;

    private $structuralUnits;

    private $education;

    private $id;

    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->patronymic = $data['patronymic'];
        $this->surname = $data['surname'];
        $this->position = $data['position'];
        $this->structuralUnits = $data['structuralUnits'];
        $this->education = $data['education'];
        $this->id = $data['id'];
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPatronymic()
    {
        return $this->patronymic;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return mixed
     */
    public function getStructuralUnits()
    {
        return $this->structuralUnits;
    }

    /**
     * @return mixed
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


}