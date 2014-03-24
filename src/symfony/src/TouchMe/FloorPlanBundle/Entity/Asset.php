<?php

namespace TouchMe\FloorPlanBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
* Asset
*/
class Asset
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
     * @var string
     */
    private $src;

    /**
     * @var string
     */
    private $file;

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
     * Set title
     *
     * @param string $title
     * @return Asset
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
     * Set src
     *
     * @param string $src
     * @return Asset
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Get src
     *
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Set file
     *
     * @param UploadedFile $file
     * @return Asset
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Add events
     *
     * @param \TouchMe\FloorPlanBundle\Entity\Event $events
     * @return Asset
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
     * Asset toArray
     * @return array
     */
    public function toArray()
    {
        $array = get_object_vars($this);
        unset($array['events']);

        return array_filter($array);
    }

    /**
     * Get absolute path
     * @return string
     */
    public function getAbsolutePath()
    {
        return null === $this->src ? null : $this->getUploadRootDir() . '/' . $this->src;
    }

    /**
     * Get relative path from web root
     * @return string
     */
    public function getWebPath()
    {
        return null === $this->src ? null : $this->getUploadDir() . '/' . $this->src;
    }

    /**
     * Get the absolute directory path where uploaded documents should be saved
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    /**
     * Get rid of the __DIR__ so it doesn't screw up when displaying uploaded doc/image in the view.
     * @return string
     */
    protected function getUploadDir()
    {
        return 'uploads';
    }

    /**
     * Moves the file into the proper directory
     *
     */
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->src = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }
}
