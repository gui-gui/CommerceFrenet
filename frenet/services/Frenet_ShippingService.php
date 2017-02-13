<?php

namespace Craft;

class Frenet_ShippingService extends Frenet_BaseService
{
  protected $endpoint = '/shipping/'; 

  public function getShippingInfo()
  {
    $url      = $this->_buildFrenetUrl($this->endpoint . 'info');
    $response = $this->_makeGetRequest($url);
    return $response;
  }

  public function fetchShippingQuote($request) {
      return 'ok';
  }

}