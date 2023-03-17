
# CzProject\Runner

<a href="https://www.janpecha.cz/donate/"><img src="https://buymecoffee.intm.org/img/donate-banner.v1.svg" alt="Donate" height="100"></a>

## Installation

[Download a latest package](https://github.com/czproject/runner/releases) or use [Composer](http://getcomposer.org/):

```
composer require czproject/runner
```

`CzProject\Runner` requires PHP 5.3.0 or later.


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
