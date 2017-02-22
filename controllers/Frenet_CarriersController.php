<?php
namespace Craft;

class Frenet_CarriersController extends BaseController
{
    protected $allowAnonymous = false;

     /**
     * @param array $variables
     * @throws HttpException
     */
    public function actionIndex(array $variables = [])
    {
        $variables['carriers'] = craft()->frenet_carriers->getAllCarriers();

        $this->renderTemplate('frenet/carriers/index', $variables);
    }


    public function actionEdit(array $variables = [])
    {
        $carriers = craft()->frenet_carriers->getAllCarriers();
        $frenetCarriers = craft()->frenet_shipping->getAllAvailableCarriers();
        
        $carriersHandles = array_column($carriers, 'handle');

        foreach ($frenetCarriers as $carrier)
        {
            if(!in_array($carrier->handle, $carriersHandles))
            {
                $carriers[] = $carrier;                
            }
            
        }

        $variables['carriers'] = $carriers;
        $variables['shippingMethods'] = craft()->commerce_shippingMethods->getAllShippingMethods();

        $this->renderTemplate('frenet/carriers/_edit', $variables);
    }

    public function actionSaveMultiple()
    {
        $this->requirePostRequest();

        $carriers = craft()->request->getPost('carriers');
        $errors = [];

        foreach ($carriers as $carrier) 
        {
            $carrierModel = craft()->frenet_carriers->getCarrierById($carrier['id']);
            
            if (!$carrierModel)
            {
                $carrierModel = new Frenet_CarrierModel();
            }

            $carrierModel->name = $carrier['name'];
            $carrierModel->handle = $carrier['carrierCode'] . '-' . $carrier['serviceCode'];
            $carrierModel->methodId = $carrier['methodId'];
            $carrierModel->serviceDescription = $carrier['serviceDescription'];
            $carrierModel->carrierCode = $carrier['carrierCode'];
            $carrierModel->serviceCode = $carrier['serviceCode'];
            $carrierModel->extraShippingDays = $carrier['extraShippingDays'];

            // Save it
            if (!craft()->frenet_carriers->saveCarrier($carrierModel)) {
                $errors[] = $carrierModel->name . ' ' . $carrierModel->serviceDescription;
            }
        }

        if(empty($errors))
        {
            craft()->userSession->setNotice(Craft::t('Carriers saved.'));
            $this->redirectToPostedUrl($carriers);
        } else {
            craft::dd($errors);
            craft()->userSession->setError('Couldn’t save these carriers: ' . implode(', ', $errors));
            craft()->urlManager->setRouteVariables(compact('availableCarriers'));
        }

    }


    /**
    * @throws HttpException
    */
    public function actionDelete()
    {
        $this->requireAjaxRequest();

        $carrierId = craft()->request->getRequiredPost('id');

        if (craft()->frenet_carriers->deleteCarrierById($carrierId)) {
            $this->returnJson(['success' => true]);
        };
    }

}
