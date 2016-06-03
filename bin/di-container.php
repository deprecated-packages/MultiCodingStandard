<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2016 Tomas Votruba (http://tomasvotruba.cz).
 */

// 1. Create temp dir
$tempDir = sys_get_temp_dir() . '/_apigen';
if (function_exists("posix_getuid")) {
	$tempDir .= posix_getuid();
}
$fileSystem = new Nette\Utils\FileSystem();
$fileSystem->delete($tempDir);
$fileSystem->createDir($tempDir);


// 2. Create container
$configurator = new Nette\Configurator();
$configurator->setDebugMode( ! Tracy\Debugger::$productionMode);
$configurator->setTempDirectory($tempDir);
$configurator->addConfig(__DIR__ . '/../src/config/config.neon');
$configurator->addParameters(['rootDir' => __DIR__ . '/..']);

return $configurator->createContainer();
