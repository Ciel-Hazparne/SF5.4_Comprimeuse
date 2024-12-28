<?php

namespace App\Entity;

class Production
{
    private $id;
    private $numOf;
    private $horoDebut;
    private $horoFin;
    private $typeProd;
    private $operateur;
    private $cptFlacon;
    private $cptBouchon;
    private $cptPriseRobot;
    private $cptDeposeRobot;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Production
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumOf()
    {
        return $this->numOf;
    }

    /**
     * @param mixed $numOf
     * @return Production
     */
    public function setNumOf($numOf)
    {
        $this->numOf = $numOf;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHoroDebut()
    {
        return $this->horoDebut;
    }

    /**
     * @param mixed $horoDebut
     * @return Production
     */
    public function setHoroDebut($horoDebut)
    {
        $this->horoDebut = $horoDebut;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHoroFin()
    {
        return $this->horoFin;
    }

    /**
     * @param mixed $horoFin
     * @return Production
     */
    public function setHoroFin($horoFin)
    {
        $this->horoFin = $horoFin;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTypeProd()
    {
        return $this->typeProd;
    }

    /**
     * @param mixed $typeProd
     * @return Production
     */
    public function setTypeProd($typeProd)
    {
        $this->typeProd = $typeProd;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOperateur()
    {
        return $this->operateur;
    }

    /**
     * @param mixed $operateur
     * @return Production
     */
    public function setOperateur($operateur)
    {
        $this->operateur = $operateur;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCptFlacon()
    {
        return $this->cptFlacon;
    }

    /**
     * @param mixed $cptFlacon
     * @return Production
     */
    public function setCptFlacon($cptFlacon)
    {
        $this->cptFlacon = $cptFlacon;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCptBouchon()
    {
        return $this->cptBouchon;
    }

    /**
     * @param mixed $cptBouchon
     * @return Production
     */
    public function setCptBouchon($cptBouchon)
    {
        $this->cptBouchon = $cptBouchon;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCptPriseRobot()
    {
        return $this->cptPriseRobot;
    }

    /**
     * @param mixed $cptPriseRobot
     * @return Production
     */
    public function setCptPriseRobot($cptPriseRobot)
    {
        $this->cptPriseRobot = $cptPriseRobot;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCptDeposeRobot()
    {
        return $this->cptDeposeRobot;
    }

    /**
     * @param mixed $cptDeposeRobot
     * @return Production
     */
    public function setCptDeposeRobot($cptDeposeRobot)
    {
        $this->cptDeposeRobot = $cptDeposeRobot;
        return $this;
    }


}
