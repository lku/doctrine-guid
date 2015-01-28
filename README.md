# Doctrine GUID Event Subscriber

[![Build Status](https://travis-ci.org/lku/doctrine-guid.svg?branch=master)](https://travis-ci.org/lku/doctrine-guid)
[![Code Coverage](https://scrutinizer-ci.com/g/lku/doctrine-guid/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/lku/doctrine-guid/?branch=master)
[![Dependency Status](https://www.versioneye.com/php/lku:doctrine-guid/badge.svg)](https://www.versioneye.com/php/lku:doctrine-guid)

This library provides [event subscriber](http://docs.doctrine-project.org/en/latest/reference/events.html) 
for [Doctrine ORM](http://www.doctrine-project.org/projects/orm.html), which 
generates [GUID](http://en.wikipedia.org/wiki/Globally_unique_identifier) in `prePersist` event automatically for every
entity field with [guid](http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/basic-mapping.html#doctrine-mapping-types) type.

## Installation

```sh
composer require lku/doctrine-guid
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
