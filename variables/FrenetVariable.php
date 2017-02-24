<?php
namespace Craft;

class FrenetVariable
{

	public function getAvailableShippingMethods()
    {
        $cart = craft()->commerce_cart->getCart();
        $methods = craft()->commerce_shippingMethods->getOrderedAvailableShippingMethods($cart);
		
		$methods['sedex']['amount'] = "10.0000" ;

		return $methods;

	}	


}