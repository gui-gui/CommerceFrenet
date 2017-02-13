<?php
namespace Craft;

class FrenetController extends BaseController
{
    protected $allowAnonymous = true;

    public function actionCep()
    {
        $this->requirePostRequest();
        $ajax = craft()->request->isAjaxRequest();
        
        if(!$ajax)
        {
            return;
        }

        $response = craft()->frenet_cep->getAddress(urlencode($_REQUEST['cep']));
        //Return no matter what - either results or an empty array which will prompt the not found message
        $this->returnJson(["success"=>true, 'response'=>$response]);

    }

    public function actionShippingInfo()
    {
        $this->requirePostRequest();
        $ajax = craft()->request->isAjaxRequest();
        
        if(!$ajax)
        {
            return;
        }

        $response = craft()->frenet_shipping->getShippingInfo();
        //Return no matter what - either results or an empty array which will prompt the not found message
        $this->returnJson(["success"=>true, 'response'=>$response]);

    }

    public function actionShippingQuote()
    {
        $this->requirePostRequest();
        $ajax = craft()->request->isAjaxRequest();
        
        if(!$ajax)
        {
            return;
        }

        $response = craft()->frenet_shipping->fetchShippingQuote($_REQUEST);
        //Return no matter what - either results or an empty array which will prompt the not found message
        $this->returnJson(["success"=>true, 'response'=>$response]);

    }

}
