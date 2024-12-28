<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductionRepository")
 */
class ProductionOrm
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numOf;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $horoDebut;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $horoFin;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $typeProd;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $operateur;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cptFlacon;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cptBouchon;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cptPriseRobot;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
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
     * @return ProductionOrm
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
     * @return ProductionOrm
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
     * @return ProductionOrm
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
     * @return ProductionOrm
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
     * @return ProductionOrm
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
     * @return ProductionOrm
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
     * @return ProductionOrm
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
     * @return ProductionOrm
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
     * @return ProductionOrm
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
     * @return ProductionOrm
     */
    public function setCptDeposeRobot($cptDeposeRobot)
    {
        $this->cptDeposeRobot = $cptDeposeRobot;
        return $this;
    }

}
