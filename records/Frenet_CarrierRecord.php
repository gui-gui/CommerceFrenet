<?php
namespace Craft;

class Frenet_CarrierRecord extends BaseRecord
{
    public function getTableName()
    {
        return 'frenet_carrier';
    }

    
  /**
     * @return array
     */
    public function defineRelations()
    {
        return [
            'method' => [
                self::BELONGS_TO,
                'Commerce_ShippingMethodRecord',
                'methodId'
            ],
        ];
    }

    public function defineIndexes()
    {
        return [
            ['columns' => ['handle'], 'unique' => true],
        ];
    }



    protected function defineAttributes()
    {
        return [
            'name' => [
                AttributeType::String, 
                'required' => true
            ],
            'handle' => [
                AttributeType::String, 
                'required' => true
            ],
            'carrierCode' => [
                AttributeType::String, 
                'required' => true
            ],
            'serviceCode' => [
                AttributeType::String, 
                'required' => true
            ],
            'serviceDescription' => [
                AttributeType::String,
                'required' => true
            ],
            'extraShippingDays' => [
                AttributeType::Number, 
                'min' => 0,
                'required' => true, 
                'default' => 0
            ]
        ];
    }
}