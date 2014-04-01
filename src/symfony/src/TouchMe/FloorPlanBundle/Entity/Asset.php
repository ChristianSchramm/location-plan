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
     *
     * @var string
     */
    private $srcTmp;

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
        
        if (isset($this->src))
        {
            $this->srcTmp = $this->src;
            $this->src = null;
        }

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
        return $this->src === null ? null : $this->getUploadDir() . '/' . $this->src;
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
     * Executed on PrePersist and PreUpdate
     */
    public function preUpload()
    {
      if ($this->getFile() !== null)
      {
          $this->src = preg_replace('/[^a-z0-9\.]/', '', strtolower($this->getFile()->getClientOriginalName()))
                  . substr(md5(rand()), 0, 7)
                  . $this->getFile()->guessExtension();
      }
    }

    /**
     * Moves the file into the proper directory
     * Executed on PostPersist and PostUpdate
     */
    public function upload()
    {
        // the file property can be empty if the field is not required
        if ($this->getFile() === null)
        {
            return;
        }
  
        // Moves file to upload directory with proper filename
        $this->getFile()->move($this->getUploadRootDir(), $this->src);
  
        // Checks if there is an old file
        if (isset($this->srcTmp))
        {
            // Delete the old file
            unlink($this->getUploadRootDir().'/'.$this->srcTmp);
            // Clear the srcTmp file path
            $this->srcTmp = null;
        }
  
        // Clean up the file property
        $this->file = null;
    }
    
    /**
     * Executed on PostRemove
     */
    public function removeUpload()
    {
      // If there's a file on given path, delete it
      if ($file = $this->getAbsolutePath()) {
        unlink($file);
      }
    }
}
