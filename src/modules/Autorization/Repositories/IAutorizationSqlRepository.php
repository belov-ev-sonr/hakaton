<?php


namespace Autorization\Repositories;


interface IAutorizationSqlRepository
{
    public function getUserHash($email, $pass);
}