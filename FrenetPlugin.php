<?php
namespace Craft;

class FrenetPlugin extends BasePlugin
{

    public function getName()
    {
         return Craft::t('Frenet');
    }

    public function getDescription()
    {
        return Craft::t('Frenet helps integrate your shop with frenet.com.br');
    }

    public function getDocumentationUrl()
    {
        return '';
    }

    public function getReleaseFeedUrl()
    {
        return '';
    }

    public function getVersion()
    {
        return '0.0.1';
    }

    public function getSchemaVersion()
    {
        return '0.0.1';
    }

    public function getDeveloper()
    {
        return 'Gui Rams';
    }

    public function getDeveloperUrl()
    {
        return 'github.com/gui-gui';
    }


    public function hasCpSection()
    {
        return true;
    }

    public function registerCpRoutes()
    {
        return [
            // settings
            'frenet/settings' => ['action' => 'frenet/settings/index'],
            // carriers
            'frenet/carriers' => ['action' => 'frenet/carriers/index'],
            'frenet/carriers/new' => ['action' => 'frenet/carriers/edit'],
            'frenet/carriers/(?P<id>\d+)' => ['action' => 'frenet/carriers/edit']
        ];
    }

    public function getSettingsUrl()
    {
        return 'frenet/settings';
    }

    protected function defineSettings() 
    {
        $settingModel = new Frenet_SettingsModel;

        return $settingModel->defineAttributes();
    }


}