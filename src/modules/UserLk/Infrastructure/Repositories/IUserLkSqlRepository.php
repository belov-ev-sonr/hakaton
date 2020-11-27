<?php


namespace UserLk\Infrastructure\Repositories;


interface IUserLkSqlRepository
{
    public function getUserInfo($id): array;

}