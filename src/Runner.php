<?php

	declare(strict_types=1);

	namespace CzProject\Runner;

	use CzProject\PathHelper;


	class Runner
	{
		const MERGE_OUTPUTS = 0;
		const ERR_DEV_NULL = 1;

		/** @var string */
		private $directory;

		/** @var int */
		private $outputHandling;


		/**
		 * @param string $directory
		 * @param int $outputHandling
		 */
		public function __construct($directory, $outputHandling = self::MERGE_OUTPUTS)
		{
			$this->directory = PathHelper::absolutizePath($directory);
			$this->outputHandling = $outputHandling;
		}


		/**
		 * @param  string|string[] $command
		 * @param  string|NULL $subdirectory
		 * @return RunnerResult
		 */
		public function run($command, $subdirectory = NULL)
		{
			$directory = $this->getDirectory($subdirectory);

			if (!is_dir($directory)) {
				throw new RunnerException("Directory '$directory' not found");
			}

			$cwd = getcwd();

			if ($cwd === FALSE) {
				throw new \CzProject\Runner\Exception('Getting of current working directory failed.');
			}

			chdir($directory);

			$cmd = NULL;

			if (is_string($command)) {
				$cmd = $command;

			} else {
				$cmd = $this->processCommand((array) $command);
			}

			exec($cmd . ' ' . $this->generateOutputHandler(), $output, $returnCode);
			chdir($cwd);
			return new RunnerResult($cmd, $returnCode, $output);
		}


		/**
		 * @param  string|NULL $subdirectory
		 * @return string
		 */
		public function getDirectory($subdirectory = NULL)
		{
			$directory = $this->directory;

			if ($subdirectory !== NULL) {
				$directory = rtrim($directory . '/' . PathHelper::absolutizePath($subdirectory, NULL), '/');
			}

			return $directory;
		}


		/**
		 * @param  string $argument
		 * @return string
		 */
		public function escapeArgument($argument)
		{
			return escapeshellarg($argument);
		}


		/**
		 * Example: [
		 *   'program',
		 *   '--directory' => 'test',
		 *   '--bare',
		 *   'value'
		 * ]
		 * @param  array<int|string, string|bool> $args
		 * @return string
		 */
		protected function processCommand(array $args)
		{
			if (count($args) === 0) {
				throw new \CzProject\Runner\Exception('Missing arguments.');
			}

			$cmd = [];

			$programName = $this->escapeArgument((string) array_shift($args));

			foreach ($args as $opt => $arg) {
				if (is_string($opt)) {
					if ($arg !== FALSE && $arg !== NULL) {
						$cmd[] = $opt;
					}
				}

				if (!is_bool($arg)) {
					$cmd[] = $this->escapeArgument($arg);
				}
			}

			return "$programName " . implode(' ', $cmd);
		}


		/**
		 * @return string
		 */
		private function generateOutputHandler()
		{
			if ($this->outputHandling === self::MERGE_OUTPUTS) {
				return '2>&1';

			} elseif ($this->outputHandling === self::ERR_DEV_NULL) {
				return '2>/dev/null';
			}

			throw new Exception('Invalid output handling mode ' . $this->outputHandling);
		}
	}
