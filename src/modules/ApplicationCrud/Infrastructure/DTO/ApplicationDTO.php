<?php


namespace ApplicationCrud\Infrastructure\DTO;


class ApplicationDTO
{
    private $users;

    private $shortTitle;

    private $existingDisadvantages;

    private $solutionDescription;

    private $expectedPositiveEffect;

    private $isEconomy;

    private $idDigitalCategory;

    private $expenditures;

    private $termsForImplementation;

    private $applicationID;


    public function __construct($data)
    {
        $this->users = $data['users'];
        $this->shortTitle = $data['shortTitle'];
        $this->existingDisadvantages = $data['existingDisadvantages'];
        $this->solutionDescription = $data['solutionDescription'];
        $this->expectedPositiveEffect = $data['expectedPositiveEffect'];
        $this->isEconomy = $data['isEconomy'];
        $this->idDigitalCategory = $data['idDigitalCategory'];
        $this->expenditures = $data['expenditures'];
        $this->termsForImplementation = $data['termsForImplementation'];
        $this->applicationID = $data['applicationID'];
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @return mixed
     */
    public function getShortTitle()
    {
        return $this->shortTitle;
    }

    /**
     * @return mixed
     */
    public function getExistingDisadvantages()
    {
        return $this->existingDisadvantages;
    }

    /**
     * @return mixed
     */
    public function getSolutionDescription()
    {
        return $this->solutionDescription;
    }

    /**
     * @return mixed
     */
    public function getExpectedPositiveEffect()
    {
        return $this->expectedPositiveEffect;
    }

    /**
     * @return mixed
     */
    public function getIsEconomy()
    {
        return $this->isEconomy;
    }

    /**
     * @return mixed
     */
    public function getIdDigitalCategory()
    {
        return $this->idDigitalCategory;
    }

    /**
     * @return mixed
     */
    public function getExpenditures()
    {
        return $this->expenditures;
    }

    /**
     * @return mixed
     */
    public function getTermsForImplementation()
    {
        return $this->termsForImplementation;
    }

    /**
     * @return mixed
     */
    public function getApplicationID()
    {
        return $this->applicationID;
    }


}