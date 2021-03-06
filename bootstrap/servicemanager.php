<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Admin;

use Ixocreate\Admin\Config\AdminConfig;
use Ixocreate\Admin\Config\Client\ClientConfigGenerator;
use Ixocreate\Admin\Config\Client\ClientConfigProviderSubManager;
use Ixocreate\Admin\Config\Factory\AdminConfigFactory;
use Ixocreate\Admin\Helper\Factory\ServerUrlHelperFactory;
use Ixocreate\Admin\Helper\Factory\UrlHelperFactory;
use Ixocreate\Admin\Helper\ServerUrlHelper;
use Ixocreate\Admin\Helper\UrlHelper;
use Ixocreate\Admin\Permission\Voter\VoterSubManager;
use Ixocreate\Admin\Role\RoleSubManager;
use Ixocreate\Admin\Router\AdminRouter;
use Ixocreate\Admin\Router\Factory\AdminRouterFactory;
use Ixocreate\Admin\Widget\DashboardWidgetProviderSubManager;
use Ixocreate\Application\ServiceManager\ServiceManagerConfigurator;
use Ixocreate\Schema\SchemaSubManager;

/** @var ServiceManagerConfigurator $serviceManager */
$serviceManager->addFactory(AdminConfig::class, AdminConfigFactory::class);
$serviceManager->addFactory(AdminRouter::class, AdminRouterFactory::class);
$serviceManager->addFactory(ServerUrlHelper::class, ServerUrlHelperFactory::class);
$serviceManager->addFactory(UrlHelper::class, UrlHelperFactory::class);
$serviceManager->addFactory(ClientConfigGenerator::class);

$serviceManager->addSubManager(RoleSubManager::class);
$serviceManager->addSubManager(ClientConfigProviderSubManager::class);
$serviceManager->addSubManager(DashboardWidgetProviderSubManager::class);
$serviceManager->addSubManager(VoterSubManager::class);
$serviceManager->addSubManager(SchemaSubManager::class);
