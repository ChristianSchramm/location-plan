<?php

namespace TouchMe\FloorPlanBundle\Entity;

/**
* Location
*/
class Location
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $description;

    /**
     * @var boolean
     */
    private $visible;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $events;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set number
     *
     * @param string $number
     * @return Location
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Location
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }




    /**
     * Set visible
     *
     * @param boolean $visible
     * @return Location
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean
     */
    public function getVisible()
    {
        return $this->visible;
    }





    /**
     * Set description
     *
     * @param string $description
     * @return Location
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
     * Add events
     *
     * @param \TouchMe\FloorPlanBundle\Entity\Event $events
     * @return Location
     */
    public function addEvent(\TouchMe\FloorPlanBundle\Entity\Event $events)
    {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param \TouchMe\FloorPlanBundle\Entity\Event $events
     */
    public function removeEvent(\TouchMe\FloorPlanBundle\Entity\Event $events)
    {
        $this->events->removeElement($events);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Location toArray
     * @return array
     */
    public function toArray()
    {
        $array = get_object_vars($this);
        unset($array['events']);
        unset($array["__isInitialized__"]);

        return array_filter($array);
    }

    public function __toString()
    {
      return $this->number;
    }
}
