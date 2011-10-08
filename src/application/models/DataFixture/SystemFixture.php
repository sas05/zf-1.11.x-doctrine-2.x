<?php

namespace Application\Models\DataFixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
Doctrine\Common\DataFixtures\FixtureInterface,
Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;

class SystemFixture extends AbstractFixture implements OrderedFixtureInterface
{
    const ORDER = 1;

    public function getOrder()
    {
        return self::ORDER;
    }

    public function load($em)
    {
        $em->flush();
    }
}