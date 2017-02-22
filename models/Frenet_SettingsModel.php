<?php
namespace Craft;

class Frenet_SettingsModel extends BaseModel
{
  
    public function defineAttributes()
    {
        return [
            'debug'                          => AttributeType::Bool,
            'boxPacker'                      => AttributeType::Bool,
            'token'                          => AttributeType::String,
            'apiUrl'                         => AttributeType::String,
            'originCep'                      => AttributeType::String,
        ];
    }

}
