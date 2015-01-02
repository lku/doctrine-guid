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
     * @return string
     */
    public function getGuid()
    {
        return $this->guid;
    }
}
