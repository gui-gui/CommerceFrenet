<?php

namespace Craft;

class Frenet_BaseService extends BaseApplicationComponent
{
    protected $frenetToken;
	protected $apiUrl;

    public function init()
	{
        $settings = craft()->plugins->getPlugin('Frenet')->getSettings();
		$this->frenetToken = $settings->token;
		$this->apiUrl = $settings->apiUrl;
        $errors = array();
	}
    
    protected function _buildFrenetUrl($endpoint)
	{
		return $this->apiUrl . $endpoint;
	}

	protected function _makePostRequest($url) {
		try {
            $client = new \Guzzle\Http\Client();
            $request = $client->post($url);
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


}