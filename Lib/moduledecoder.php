<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php');

	class ModuleDecoder {
		public $code;
		public $moduleStart = '{!';
		public $moduleEnd = '!}';
		public $final;

		private $startPos;
		private $endPos;
		private $module;
		private $class;
		private $title;

		public function __construct($code) {
			$this->code = $code;

			if ($this->findModule()) {
				echo $this->final;
			} else {
				echo $this->code;
			};


		}

		private function findModule() {
			$this->startPos = strpos($this->code, $this->moduleStart);

			if ($this->startPos === false) {
				return false;
			} else {
				return $this->replaceModule();
			}
		}

		//Find end
		private function replaceModule() {
			$this->endPos = strpos($this->code, $this->moduleEnd); //Find End Position

			$this->module = substr($this->code, $this->startPos, $this->endPos-$this->startPos); //Make Substring

			$this->module = str_replace('{!', '', $this->module); //Replace front
			$this->module = strip_tags(trim($this->module));


			list($this->class, $this->title) = explode(":", $this->module);

			//echo '<pre>'.$this->title.'</pre>';
			//echo '<pre>'.$this->class.'</pre>';

			if ($this->class != false) {
				return $this->runModule();
			} else {
				return false;
			}
		}

		private function runModule() {
			$class = new $this->class();

			$this->final = substr($this->code, 0, $this->startPos);
			$this->final .= $class->displayModule($this->title);
			$this->final .= substr($this->code, $this->endPos+2);

			return $this->final;
		}







	} //end class


?>