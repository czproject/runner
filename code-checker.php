<?php

return function (JP\CodeChecker\CheckerConfig $config) {
	$config->setPhpVersion(new JP\CodeChecker\Version('5.6.0'));
	$config->addPath('./src');
	JP\CodeChecker\Sets\CzProjectMinimum::configure($config);
};
