<?php
namespace Craft;

class Frenet_CarrierModel extends BaseModel
{
    public function getCpEditUrl()
    {
        return UrlHelper::getCpUrl('frenet/carriers/' . $this->id);
    }

    public function __toString()
    {
        return (string) $this->getAttribute('name');
    }

    public function getMethod()
    {
        return craft()->commerce_shippingMethods->getShippingMethodById($this->methodId);
    }

    /**
     * @return array
     */
    protected function defineAttributes()
    {
        return [
            'id' => AttributeType::Number,
            'name' => [AttributeType::String, 'required' => true],
            'handle' => [AttributeType::String, 'required' => true],
            'methodId' => [AttributeType::String, 'required' => true],
            'carrierCode' => [AttributeType::String, 'required' => true],
            'serviceCode' => [AttributeType::String, 'required' => true],
            'serviceDescription' => [AttributeType::String. 'required' => true],
            'extraShippingDays' => [AttributeType::Number, 'required' => true, 'default' => 0]
        ];
    }
}
