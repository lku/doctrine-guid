<?php

namespace LKu\DoctrineGuid;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber as DoctrineEventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Id\AbstractIdGenerator;

final class EventSubscriber implements DoctrineEventSubscriber
{
    /** @var AbstractIdGenerator */
    protected $guidGenerator;

    /**
     * @param AbstractIdGenerator $guidGenerator
     */
    public function __construct(AbstractIdGenerator $guidGenerator)
    {
        $this->guidGenerator = $guidGenerator;
    }

    /**
     * @inheritdoc
     */
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
        ];
    }

    /**
     * @param LifecycleEventArgs $args
     * @return void
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entityManager = $args->getEntityManager();
        $object = $args->getObject();
        $metadata = $entityManager->getClassMetadata(get_class($object));

        foreach ($metadata->getFieldNames() as $field) {
            $type = $metadata->getTypeOfField($field);
            if ($type === Type::GUID) {
                $property = $metadata->getReflectionProperty($field);
                $value = $property->getValue($object);

                if (empty($value)) {
                    $guid = $this->guidGenerator->generate($entityManager, $object);
                    $property->setValue($object, $guid);
                }
            }
        }
    }
}
