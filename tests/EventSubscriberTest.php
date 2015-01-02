<?php

namespace LKu\DoctrineGuidTest;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Id\AbstractIdGenerator;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use LKu\DoctrineGuid\EventSubscriber;
use LKu\DoctrineGuidTest\Asset\Entity;
use PHPUnit_Framework_Assert;
use PHPUnit_Framework_MockObject_MockObject;
use PHPUnit_Framework_TestCase;
use ReflectionProperty;
use Zend\ServiceManager\ServiceManager;

/**
 * Test case for {@see \LKu\DoctrineGuid\EventSubscriber}
 */
class EventSubscriberTest extends PHPUnit_Framework_TestCase
{
    /** @var AbstractIdGenerator|PHPUnit_Framework_MockObject_MockObject */
    protected $guidGenerator;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        $this->guidGenerator = $this->getMockBuilder(AbstractIdGenerator::class)->getMockForAbstractClass();
    }

    /**
     * @covers \LKu\DoctrineGuid\EventSubscriber::__construct
     */
    public function testConstructor()
    {
        $subscriber = new EventSubscriber($this->guidGenerator);

        $this->assertSame($this->guidGenerator, PHPUnit_Framework_Assert::readAttribute($subscriber, 'guidGenerator'));
    }

    /**
     * @covers \LKu\DoctrineGuid\EventSubscriber::getSubscribedEvents
     */
    public function testSubscribedEvents()
    {
        $subscriber = new EventSubscriber($this->guidGenerator);

        $this->assertTrue(in_array(Events::prePersist, $subscriber->getSubscribedEvents()));
    }

    /**
     * @covers \LKu\DoctrineGuid\EventSubscriber::prePersist
     */
    public function testPrePersist()
    {
        $testGuid = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx';
        $this->guidGenerator->expects($this->once())
            ->method('generate')
            ->will($this->returnValue($testGuid));

        $subscriber = new EventSubscriber($this->guidGenerator);

        $entity = new Entity();

        $propertyReflection = new ReflectionProperty(Entity::class, 'guid');
        $propertyReflection->setAccessible(true);

        $metadata = $this->getMockBuilder(ClassMetadataInfo::class)->disableOriginalConstructor()->getMock();
        $metadata->expects($this->any())
            ->method('getFieldNames')
            ->will($this->returnValue(['guid']));
        $metadata->expects($this->any())
            ->method('getTypeOfField')
            ->will($this->returnValue(Type::GUID));
        $metadata->expects($this->any())
            ->method('getReflectionProperty')
            ->will($this->returnValue($propertyReflection));

        $em = $this->getMockBuilder(EntityManager::class)->disableOriginalConstructor()->getMock();
        $em->expects($this->any())
            ->method('getClassMetadata')
            ->will($this->returnValue($metadata));

        $args = new LifecycleEventArgs($entity, $em);
        $subscriber->prePersist($args);

        $this->assertEquals($testGuid, $entity->getGuid());
    }
}
