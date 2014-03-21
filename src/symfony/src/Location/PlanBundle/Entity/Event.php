<?php
namespace Location\PlanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Event
 *
 * @ORM\Table("events")
 * @ORM\Entity(repositoryClass="Location\PlanBundle\Entity\EventRepository")
 */
class Event {
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    /**
     * @var datetime
     *
     * @ORM\Column(name="from", type="datetime")
     */
    private $from;
    /**
     * @var datetime
     *
     * @ORM\Column(name="until", type="datetime")
     */
    private $until;
    /**
     * @var string
     *
     */
    private $date;
    /**
     * @var string
     *
     */
    private $time;
    /**
     * @var string
     *
     * @ORM\Column(name="leader", type="string", length=255)
     */
    private $leader;
    /**
     * @var string
     *
     * @ORM\Column(name="coleader", type="string", length=255)
     */
    private $coleader;
    /**
     * @ORM\ManyToOne(targetEntity="Room", inversedBy="events")
     */
    private $room;
    /**
     * @ORM\ManyToMany(targetEntity="Asset", mappedBy="events")
     */
    private $assets;
    /**
     * Constructor
     */
    public function __construct() {
        $this->assets = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }
    /**
     * Set name
     *
     * @param string $name
     * @return Event
     */
    public function setName($name) {
        $this->name = $name;
        
        return $this;
    }
    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }
    /**
     * Set description
     *
     * @param string $description
     * @return Event
     */
    public function setDescription($description) {
        $this->description = $description;
        
        return $this;
    }
    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }
    /**
     * Set from
     *
     * @param \DateTime $from
     * @return Event
     */
    public function setFrom($from) {
        $this->from = $from;
        
        return $this;
    }
    /**
     * Get from
     *
     * @return \DateTime
     */
    public function getFrom() {
        return $this->from;
    }
    /**
     * Set until
     *
     * @param \DateTime $until
     * @return Event
     */
    public function setUntil($until) {
        $this->until = $until;
        
        return $this;
    }
    /**
     * Get until
     *
     * @return \DateTime
     */
    public function getUntil() {
        return $this->until;
    }
    /**
     * Get date
     *
     * @return \String
     */
    public function getDate() {
        return $this->from->format('d.m.Y');
    }
    /**
     * Get time
     *
     * @return \String
     */
    public function getTime() {
        return $this->from->format('G:i') . " - " . $this->until->format('G:i') . " Uhr";
    }
    /**
     * Set leader
     *
     * @param string $leader
     * @return Event
     */
    public function setLeader($leader) {
        $this->leader = $leader;
        
        return $this;
    }
    /**
     * Get leader
     *
     * @return string
     */
    public function getLeader() {
        return $this->leader;
    }
    /**
     * Set coleader
     *
     * @param string $coleader
     * @return Event
     */
    public function setColeader($coleader) {
        $this->coleader = $coleader;
        
        return $this;
    }
    /**
     * Get coleader
     *
     * @return string
     */
    public function getColeader() {
        return $this->coleader;
    }
    /**
     * Set room
     *
     * @param \Location\PlanBundle\Entity\Room $room
     * @return Event
     */
    public function setRoom(\Location\PlanBundle\Entity\Room $room = null) {
        $this->room = $room;
        
        return $this;
    }
    /**
     * Get room
     *
     * @return \Location\PlanBundle\Entity\Room
     */
    public function getRoom() {
        return $this->room;
    }
    /**
     * Add assets
     *
     * @param \Location\PlanBundle\Entity\Asset $assets
     * @return Event
     */
    public function addAsset(\Location\PlanBundle\Entity\Asset $assets) {
        $this->assets[] = $assets;
        
        return $this;
    }
    /**
     * Remove assets
     *
     * @param \Location\PlanBundle\Entity\Asset $assets
     */
    public function removeAsset(\Location\PlanBundle\Entity\Asset $assets) {
        $this->assets->removeElement($assets);
    }
    /**
     * Get assets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAssets() {
        return $this->assets;
    }



    public function jsonSerialize()
    {
        return array(
            'name' => $this->name,
            'description' => $this->description,
            'from' => $this->from->format("d.m.Y H:i:s"),
            'until' => $this->until->format("d.m.Y H:i:s"),
            'leader' => $this->leader,
            'coleader' => $this->coleader,
            'room' => $this->room->getName(),
        );
    }
}
