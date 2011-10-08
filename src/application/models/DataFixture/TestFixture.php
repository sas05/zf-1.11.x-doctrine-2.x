<?php

namespace Application\Models\DataFixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\DataFixtures\FixtureInterface,
    Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;

class TestFixture extends AbstractFixture implements OrderedFixtureInterface
{
    const ORDER = 2;

    public function getOrder()
    {
        return self::ORDER;
    }
    
    public function load($em)
    {
        $em->flush();
    }
}