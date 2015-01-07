<?php

namespace LKu\DoctrineGuidTest\Asset;

class Entity
{
    /**
     * @var string
     * @ORM\Column(type="guid")
     **/
    protected $guid;

    /**
     * @param string $guid
     */
    public function __construct($guid)
    {
        $this->guid = $guid;
    }

    /**
     * @return string
     */
    public function getGuid()
    {
        return $this->guid;
    }
}
