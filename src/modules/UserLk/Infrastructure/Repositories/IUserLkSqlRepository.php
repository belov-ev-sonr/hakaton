<?php


namespace UserLk\Infrastructure\Repositories;

use UserLk\Infrastructure\DTO\UserInfoDTO;

interface IUserLkSqlRepository
{
    public function getUserRole($id): array;
    public function getUserInfo($id): array;
    public function getUsersList(): array;
    public function getPositionsList(): array;
    public function getStructuralUnitsList(): array;
    public function getEducationList(): array;
    public function updUserInfo(UserInfoDTO $data): int;
    public function addUser(UserInfoDTO $data): int;
    public function changeUserStatus($id, $isActive): int;
    public function getRoleList(): array ;
    public function addRoleUser($idRole, $idUser): int;
    public function updRoleUser($idRole, $idUser): int;

}