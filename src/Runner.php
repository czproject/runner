<?php

	namespace CzProject\Runner;

	use CzProject\PathHelper;


	class Runner
	{
		/** @var string */
		private $directory;

		/** @var bool */
		private $mergeOutputs;


		/**
		 * @param string $directory
		 * @param bool $mergeOutputs
		 */
		public function __construct($directory, $mergeOutputs = TRUE)
		{
			$this->directory = PathHelper::absolutizePath($directory);
			$this->mergeOutputs = $mergeOutputs;
		}


		/**
		 * @param  string|string[]
		 * @param  string|NULL
		 * @return RunnerResult
		 */
		public function run($command, $subdirectory = NULL)
		{
			$directory = $this->getDirectory($subdirectory);

			if (!is_dir($directory)) {
				throw new RunnerException("Directory '$directory' not found");
			}

			$cwd = getcwd();
			chdir($directory);

			$cmd = NULL;

			if (is_string($command)) {
				$cmd = $command;

			} else {
				$cmd = $this->processCommand((array) $command);
			}

			exec($cmd . ($this->mergeOutputs ? ' 2>&1' : ''), $output, $returnCode);
			chdir($cwd);
			return new RunnerResult($cmd, $returnCode, $output);
		}


		/**
		 * @param  string|NULL
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
		 * @param  string
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
		 * @param  array
		 * @return string
		 */
		protected function processCommand(array $args)
		{
			$cmd = array();

			$programName = $this->escapeArgument(array_shift($args));

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
	}
