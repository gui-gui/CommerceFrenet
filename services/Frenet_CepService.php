<?php

namespace Craft;

class Frenet_CepService extends Frenet_BaseService
{
  protected $endpoint = '/CEP/'; 

  public function getAddress($cep)
  {
    $url      = $this->_buildFrenetUrl($this->endpoint . 'Address/' . $cep);
    $response = $this->_makeGetRequest($url);
    return $response;
  }

}