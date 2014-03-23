<?php

namespace TouchMe\FloorPlanBundle\Entity;

/**
* Event
*/
class Event
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var \DateTime
     */
    private $starttime;

    /**
     * @var \DateTime
     */
    private $endtime;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $branchofstudy;

    /**
     * @var string
     */
    private $personincharge;

    /**
     * @var \TouchMe\FloorPlanBundle\Entity\Location
     */
    private $location;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $assets;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->assets = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set starttime
     *
     * @param \DateTime $starttime
     * @return Event
     */
    public function setStarttime($starttime)
    {
        $this->starttime = $starttime;

        return $this;
    }

    /**
     * Get starttime
     *
     * @return \DateTime 
     */
    public function getStarttime()
    {
        return $this->starttime;
    }

    /**
     * Set endtime
     *
     * @param \DateTime $endtime
     * @return Event
     */
    public function setEndtime($endtime)
    {
        $this->endtime = $endtime;

        return $this;
    }

    /**
     * Get endtime
     *
     * @return \DateTime 
     */
    public function getEndtime()
    {
        return $this->endtime;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set branchofstudy
     *
     * @param string $branchofstudy
     * @return Event
     */
    public function setBranchofstudy($branchofstudy)
    {
        $this->branchofstudy = $branchofstudy;

        return $this;
    }

    /**
     * Get branchofstudy
     *
     * @return string 
     */
    public function getBranchofstudy()
    {
        return $this->branchofstudy;
    }

    /**
     * Set personincharge
     *
     * @param string $personincharge
     * @return Event
     */
    public function setPersonincharge($personincharge)
    {
        $this->personincharge = $personincharge;

        return $this;
    }

    /**
     * Get personincharge
     *
     * @return string 
     */
    public function getPersonincharge()
    {
        return $this->personincharge;
    }

    /**
     * Set location
     *
     * @param \TouchMe\FloorPlanBundle\Entity\Location $location
     * @return Event
     */
    public function setLocation(\TouchMe\FloorPlanBundle\Entity\Location $location = null)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \TouchMe\FloorPlanBundle\Entity\Location 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Add assets
     *
     * @param \TouchMe\FloorPlanBundle\Entity\Asset $assets
     * @return Event
     */
    public function addAsset(\TouchMe\FloorPlanBundle\Entity\Asset $assets)
    {
        $this->assets[] = $assets;

        return $this;
    }

    /**
     * Remove assets
     *
     * @param \TouchMe\FloorPlanBundle\Entity\Asset $assets
     */
    public function removeAsset(\TouchMe\FloorPlanBundle\Entity\Asset $assets)
    {
        $this->assets->removeElement($assets);
    }

    /**
     * Get assets
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAssets()
    {
        return $this->assets;
    }
}
