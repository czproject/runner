
# CzProject\Runner

<a href="https://www.patreon.com/bePatron?u=9680759"><img src="https://c5.patreon.com/external/logo/become_a_patron_button.png" alt="Become a Patron!" height="35"></a>
<a href="https://www.paypal.me/janpecha/1eur"><img src="https://buymecoffee.intm.org/img/button-paypal-white.png" alt="Buy me a coffee" height="35"></a>

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
