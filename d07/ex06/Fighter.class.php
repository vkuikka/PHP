<?php
abstract class Fighter {
	public $type;
	abstract function fight($target);
	public function __construct($type) {
		$this->type = $type;
	}
}
?>
