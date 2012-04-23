<?php
abstract class Entity {
	protected $id;
	abstract public function id();
	abstract public function setId();
}
?>