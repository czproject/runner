<?php

	namespace CzProject\Runner;


	class RunnerResult
	{
		/** @var string */
		private $command;

		/** @var int */
		private $code;

		/** @var string[] */
		private $output;


		/**
		 * @param  string $command
		 * @param  int $code
		 * @param  string[] $output
		 */
		public function __construct($command, $code, array $output)
		{
			$this->command = (string) $command;
			$this->code = (int) $code;
			$this->output = $output;
		}


		/**
		 * @return bool
		 */
		public function isOk()
		{
			return $this->code === 0;
		}


		/**
		 * @return string
		 */
		public function getCommand()
		{
			return $this->command;
		}


		/**
		 * @return int
		 */
		public function getCode()
		{
			return $this->code;
		}


		/**
		 * @return string[]
		 */
		public function getOutput()
		{
			return $this->output;
		}


		/**
		 * @return bool
		 */
		public function hasOutput()
		{
			return !empty($this->output);
		}


		/**
		 * @return string
		 */
		public function toText()
		{
			return '$ ' . $this->getCommand() . "\n\n"
				. implode("\n", $this->getOutput()) . "\n\n"
				. '=> ' . $this->getCode() . "\n\n";
		}
	}
