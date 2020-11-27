<?php


namespace UserLk\Infrastructure\Repositories;


interface IUserLkSqlRepository
{
    public function getUserRole($id): array;
    public function getUserInfo($id): array;

}