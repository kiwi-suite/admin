<?php
/**
 * kiwi-suite/admin (https://github.com/kiwi-suite/admin)
 *
 * @package kiwi-suite/admin
 * @see https://github.com/kiwi-suite/admin
 * @copyright Copyright (c) 2010 - 2018 kiwi suite GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace KiwiSuite\Admin\Type;

use Doctrine\DBAL\Types\StringType;
use KiwiSuite\Admin\Role\RoleInterface;
use KiwiSuite\Admin\Role\RoleMapping;
use KiwiSuite\Admin\Role\RoleSubManager;
use KiwiSuite\Contract\Type\DatabaseTypeInterface;
use KiwiSuite\Entity\Type\AbstractType;

final class RoleType extends AbstractType implements DatabaseTypeInterface
{
    /**
     * @var RoleSubManager
     */
    private $roleSubManager;
    /**
     * @var RoleMapping
     */
    private $roleMapping;

    public function __construct(RoleSubManager $roleSubManager, RoleMapping $roleMapping)
    {
        $this->roleSubManager = $roleSubManager;
        $this->roleMapping = $roleMapping;
    }

    public function transform($value)
    {
        if (empty($this->roleMapping->getMapping()[$value])) {
            throw new \Exception("invalid role");
        }
        $roleClass = $this->roleMapping->getMapping()[$value];

        return $this->roleSubManager->get($roleClass);
    }

    public function getRole(): RoleInterface
    {
        return $this->value();
    }

    public function __toString()
    {
        return $this->value()::getName();
    }

    public function convertToDatabaseValue()
    {
        return (string) $this;
    }

    public static function baseDatabaseType(): string
    {
        return StringType::class;
    }

    public static function serviceName(): string
    {
        return 'role';
    }
}
