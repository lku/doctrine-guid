# Doctrine GUID Event Subscriber

This library provides [event subscriber](http://docs.doctrine-project.org/en/latest/reference/events.html) 
for [Doctrine ORM](http://www.doctrine-project.org/projects/orm.html), which 
generates [GUID](http://en.wikipedia.org/wiki/Globally_unique_identifier) in `prePersist` event automatically for every
entity field with [guid](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/basic-mapping.html#doctrine-mapping-types) type.

## Installation

```sh
composer require lku/doctrine-guid:~1.0
```

## Requirements

 * PHP 5.4+
 * Doctrine ORM 2.4+

## Usage

#### Register event subscriber:
```php
$guidGenerator = new Doctrine\ORM\Id\UuidGenerator();
$subscriber = new LKu\DoctrineGuid\EventSubscriber($guidGenerator);

$entityManager->getEventManager()->addEventSubscriber($subscriber);
```
#### Add GUID field definition to entity:

```php
/**
 * @ORM\Entity
 **/
class Entity
{
    /**
     * @ORM\Column(type="guid")
     **/
    protected $guid;
}
```

After persisting new instance of `Entity` class in `EntityManager` it has `guid` field filled with GUID.

## License

 This library is released under the MIT License.
