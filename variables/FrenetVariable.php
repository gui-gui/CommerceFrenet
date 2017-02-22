<?php
namespace Craft;

class FrenetVariable
{
	public function __call($name, $arguments)
	{
		$className = 'Craft\Frenet_' . ucfirst($name) . 'Variable';
		return (class_exists($className)) ? new $className() : 'null';
	}
}