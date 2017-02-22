<?php
namespace Craft;

class Frenet_SettingsService extends BaseApplicationComponent
{
    /** @var BasePlugin */
    private $_plugin;

    /**
     * Setup
     */
    public function init()
    {
        $this->_plugin = craft()->plugins->getPlugin('frenet');
    }

    /**
     * @param string $option
     *
     * @return mixed
     */
    public function getOption($option)
    {
        return $this->getSettings()->$option;
    }

    /**
     * Get all settings from plugin core class
     *
     * @return BoxPacker_SettingsModel
     */
    public function getSettings()
    {
        $data = $this->_plugin->getSettings();

        return Frenet_SettingsModel::populateModel($data);
    }

    /**
     * Set all settings from plugin core class
     *
     * @param BoxPacker_SettingsModel $settings
     *
     * @return bool
     */
    public function saveSettings(Frenet_SettingsModel $settings)
    {

        if (!$settings->validate()) {
            $errors = $settings->getAllErrors();

            return false;
        }

        craft()->plugins->savePluginSettings($this->_plugin, $settings);

        return true;
    }
}
