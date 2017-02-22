<?php
namespace Craft;

class Frenet_ShippingVariable
{
	protected $_serviceName = 'frenet_shipping';

	public function quote(float $itemTotal, array $lineItems, string $zipCode)
	{
		return craft()->{$this->_serviceName}->getQuote($itemTotal, $lineItems, $zipCode);
	}
}
