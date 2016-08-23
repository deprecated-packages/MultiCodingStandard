<?php

include __DIR__.'/../vendor/autoload.php';

$tempDir = __DIR__.'/temp/';

define('TEMP_DIR', $tempDir);
@mkdir($tempDir, 0777, true);

register_shutdown_function(function () use ($tempDir) {
     Nette\Utils\FileSystem::delete($tempDir);
});
