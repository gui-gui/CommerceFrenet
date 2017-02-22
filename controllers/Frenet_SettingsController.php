<?php
namespace Craft;

class Frenet_SettingsController extends BaseController
{
    protected $allowAnonymous = false;

    public function init()
    {
        // All system setting actions require an admin
        craft()->userSession->requireAdmin();
    }
    /**
     * Commerce Settings Index
     */
    public function actionIndex()
    {
        $settings = craft()->frenet_settings->getSettings();

        $this->renderTemplate('frenet/settings/index',
            ['settings' => $settings]);
    }

    /**
     * Commerce Settings Form
     */
    public function actionEdit()
    {
        $settings = craft()->frenet_settings->getSettings();

        $this->renderTemplate('frenet/settings',
            ['settings' => $settings]);
    }


    /**
     * @throws HttpException
     */
    public function actionSaveSettings()
    {
        $this->requirePostRequest();
        $postData = craft()->request->getPost('settings');
        $settings = Frenet_SettingsModel::populateModel($postData);

        if (!craft()->frenet_settings->saveSettings($settings)) {
            craft()->userSession->setError(Craft::t('Couldn’t save settings.'));
            $this->renderTemplate('frenet/settings', ['settings' => $settings]);
        } else {
            craft()->userSession->setNotice(Craft::t('Settings saved.'));
            $this->redirectToPostedUrl();
        }
    }

}