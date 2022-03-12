<?php

declare(strict_types=1);

namespace App;

use Nette\Bootstrap\Configurator;

class Bootstrap
{
	public static function boot(): Configurator
	{
		$configurator = new Configurator;
		$appDir = dirname(__DIR__);

		$configurator->enableTracy($appDir . '/log');
		$configurator->setDebugMode(true);

		$configurator->setTimeZone('Europe/Prague');
		$configurator->setTempDirectory($appDir . '/temp');

		$configurator->createRobotLoader()
			->addDirectory(__DIR__)
			->register();

			$configurator->addConfig($appDir . '/config/local.neon');
		$configurator->addConfig($appDir . '/config/common.neon');

		return $configurator;
	}
}
