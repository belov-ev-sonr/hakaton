<?php


namespace UserLk\Infrastructure\TransferData;


class UserRoleTransferData
{
    private $name;

    private $surname;

    private $patronymic;

    private $roleNumber;

    private $roleName;

    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->surname = $data['surname'];
        $this->patronymic = $data['patronymic'];
        $this->roleNumber = $data['id'];
        $this->roleName = $data['name_role'];
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
    public function getSurname()
    {
        return $this->surname;
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
    public function getRoleNumber()
    {
        return $this->roleNumber;
    }

    /**
     * @return mixed
     */
    public function getRoleName()
    {
        return $this->roleName;
    }



}