# CzProject\Runner

[![Build Status](https://github.com/czproject/runner/workflows/Build/badge.svg)](https://github.com/czproject/runner/actions)
[![Downloads this Month](https://img.shields.io/packagist/dm/czproject/runner.svg)](https://packagist.org/packages/czproject/runner)
[![Latest Stable Version](https://poser.pugx.org/czproject/runner/v/stable)](https://github.com/czproject/runner/releases)
[![License](https://img.shields.io/badge/license-New%20BSD-blue.svg)](https://github.com/czproject/runner/blob/master/license.md)

<a href="https://www.janpecha.cz/donate/"><img src="https://buymecoffee.intm.org/img/donate-banner.v1.svg" alt="Donate" height="100"></a>

## Installation

[Download a latest package](https://github.com/czproject/runner/releases) or use [Composer](http://getcomposer.org/):

```
composer require czproject/runner
```

`CzProject\Runner` requires PHP 5.6.0 or later.


## Usage

``` php
use CzProject\Runner\Runner;

$runner = new Runner('/path/to/working/directory');

$result = $runner->run('ls');
$result = $runner->run(array('git', 'remote', 'add', $remoteName, $remoteUrl));
$result = $runner->run(array(
	'git',
	'clone',
	$cloneUrl,
	'--bare' => TRUE,
	'--branch' => 'master',
));

$result->isOk();
$result->getCommand();
$result->getCode();
$result->getOutput();
```

------------------------------

License: [New BSD License](license.md)
<br>Author: Jan Pecha, https://www.janpecha.cz/
