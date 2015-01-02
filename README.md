# Doctrine GUID Event Subscriber

This library provides [event subscriber](http://docs.doctrine-project.org/en/latest/reference/events.html) 
for [Doctrine ORM](http://www.doctrine-project.org/projects/orm.html), which generates GUID in `prePersist` event automatically for every
entity field with [guid](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/basic-mapping.html#doctrine-mapping-types) type.

## Installation

```sh
composer require lku/doctrine-guid:~1.0
```

## Requirements

 * PHP 5.4+
 * Doctrine ORM 2.4+

## Usage

```php
$guidGenerator = new Doctrine\ORM\Id\UuidGenerator();
$subscriber = new LKu\DoctrineGuid\EventSubscriber($guidGenerator);

$entityManager->getEventManager()->addEventSubscriber($subscriber);
```

## License

 This library is released under the MIT License.
