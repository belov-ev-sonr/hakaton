<?php


namespace OtherRoute\IInfrastructure\Repositories;


interface IOtherSqlRepository
{
    public function getDigitalCategory(): array;
    public function getFirstExpert($id): array;
}