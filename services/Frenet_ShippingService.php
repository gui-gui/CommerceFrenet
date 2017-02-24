<?php

namespace Craft;

class Frenet_ShippingService extends Frenet_BaseService
{
  protected $endpoint = '/shipping/'; 

  public function getAllAvailableCarriers()
  {
    $url      = $this->_buildFrenetUrl($this->endpoint . 'info');
    $frenetCarriers = $this->_makeGetRequest($url);
    $response = [];

    foreach ($frenetCarriers['ShippingSeviceAvailableArray'] as $carrier) 
    {
        $carrierModel = new Frenet_CarrierModel();
        $carrierModel->name = $carrier['Carrier'];
        $carrierModel->handle = $carrier['CarrierCode'] . '-' . $carrier['ServiceCode'];
        $carrierModel->methodId = null;
        $carrierModel->serviceDescription = $carrier['ServiceDescription'];
        $carrierModel->carrierCode = $carrier['CarrierCode'];
        $carrierModel->serviceCode = $carrier['ServiceCode'];
        $carrierModel->extraShippingDays = 0;

        $response[] = $carrierModel;
    }

    return $response;
  }

  // change this to recieve order model only
  public function getQuote($itemTotal, $lineItems = [], $zipCode)
  {
    $postFields =  $this->_generateQuotePostFields($itemTotal, $lineItems, $zipCode);

    return $this->_fetchShippingQuote($postFields);
  }

  private function _fetchShippingQuote($postFields = [])
  {
    if(empty($postFields))
    {
      return false;
    }

    $url      = $this->_buildFrenetUrl($this->endpoint . 'quote');
    $response = $this->_makePostRequest($url, $postFields);

    return $response;
  }

  private function _generateQuotePostFields($itemTotal, $lineItems = [], $zipCode) 
  {
    $sellerCep = str_replace('-','', $this->originCep);
    $recipientCep = str_replace('-','', $zipCode);
    $total = number_format((float)$itemTotal, 2, '.', '');
    $itemsArray = [];

    if(craft()->plugins->getPlugin('boxpacker')->isEnabled && $this->boxPacker)
    {
      $packedBoxes = $this->_boxPackerPacking($lineItems, '1');
    }
    else 
    {
      $packedBoxes = $this->_simplePacking($lineItems);
    }

    if(!$packedBoxes)
    {
      return [];
    }

    foreach ($packedBoxes as $item)
    {
      $itemsArray[] = (object) array(
        "SKU" => $item->reference,
        "Weight" => $this->_convertWeight($item->weight),
        "Width" => $this->_convertDimension($item->width),
        "Height" => $this->_convertDimension($item->height),
        "Length" => $this->_convertDimension($item->length)
      );
    }

    return [
      "SellerCEP" => $sellerCep,
      "RecipientCEP" => $recipientCep,
      "ShipmentInvoiceValue" => $total,
      "ShippingItemArray" => $itemsArray
    ];
    
  }

  private function _boxPackerPacking($lineItems = [], $methodId)
  {

    $boxesForMethod = craft()->boxPacker_boxes->getAllBoxesByShippingMethodId('2');
    $packedBoxes = craft()->boxPacker->getPackedBoxes($lineItems, $boxesForMethod);

    return $packedBoxes;
  }


  private function _simplePacking($lineItems)
  {

    $items = [];
    foreach ($lineItems as $item)
    {
      for ($x=0; $x < $item->qty; $x++)
      {
        $items[] = (object) array(
            "reference" => $item->sku,
            "weight" => $item->weight,
            "width" => $item->width,
            "height" => $item->height,
            "length" => $item->length
        );
      }
    }
    return $items;
  }

}