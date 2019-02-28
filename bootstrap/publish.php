<?php
declare(strict_types=1);

namespace Ixocreate\Admin;

use Ixocreate\Application\Publish\PublishConfigurator;

/** @var PublishConfigurator $publish */

$publish->add('migrations', __DIR__ . '/../resources/migrations');
