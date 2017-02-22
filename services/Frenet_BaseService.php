<?php

namespace Craft;

class Frenet_BaseService extends BaseApplicationComponent
{
    protected $frenetToken;
	protected $apiUrl;
    protected $originCep;
    protected $commerceWeightUnit;
    protected $commerceDimensionUnit;
    protected $boxPacker;

    public function init()
	{
        $settings = craft()->plugins->getPlugin('Frenet')->getSettings();
		$this->frenetToken = $settings->token;
		$this->apiUrl = $settings->apiUrl;
		$this->originCep = $settings->originCep;
		$this->boxPacker = $settings->boxPacker;

        $commerceSettings = craft()->plugins->getPlugin('Commerce')->getSettings();
        $this->commerceWeightUnit = $commerceSettings->weightUnits;
        $this->commerceDimensionUnit =  $commerceSettings->dimensionUnits;

        $errors = array();
	}
    
    protected function _buildFrenetUrl($endpoint)
	{
		return $this->apiUrl . $endpoint;
	}

    // we need dimension in centimeters
    protected function _convertDimension($size) 
    {
        if($this->commerceDimensionUnit === 'mm')
        {
            return $size/10;
        }

        if($this->commerceDimensionUnit === 'm')
        {
            return $size*100;
        }        
        
        if($this->commerceDimensionUnit === 'ft')
        {
            return $size*30.48;
        }

        if($this->commerceDimensionUnit === 'in')
        {
            return $size*2.54;
        }

        // centimeters
        return $size;
    }

    // We need weight in kilograms
    protected function _convertWeight($weight)
    {
        if($this->commerceWeightUnit === 'g')
        {
            return $weight/1000;
        }        
        
        if($this->commerceWeightUnit === 'lb')
        {
            return $weight*0.453;
        }

        return $weight;
    }

	protected function _makeGetRequest($url) {
		try {
            $client = new \Guzzle\Http\Client();
            $request = $client->get($url);
            $request->setHeader('Content-Type', 'application/json');
            $request->setHeader('token', $this->frenetToken);
            $response = $request->send();
            $output = $response->json();
            return $output;
        }
        catch(\Exception $e) {
			throw $e;
		}
    }

	protected function _makePostRequest($url, array $postFields) {
		try {
            $client = new \Guzzle\Http\Client();
            $request = $client->post($url, array(), json_encode($postFields));
            $request->setHeader('Content-Type', 'application/json');
            $request->setHeader('token', $this->frenetToken);
            $rawResponse = $request->send();
            
            $output = $rawResponse->json();
            return $output;
        }
        catch(\Exception $e) {
			throw $e;
		}
    }

}