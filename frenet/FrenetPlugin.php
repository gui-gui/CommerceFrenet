<?php
namespace Craft;

class FrenetPlugin extends BasePlugin
{

    private $version = "0.0.1";
    private $schemaVersion = "0.0.0";

    private $name = 'Frenet';
    private $description = 'Frenet helps integrate your shop with frenet.com.br';
    private $documentationUrl = '';
    private $developer = "Gui Rams";
    private $developerUrl = "https://github.com/gui-gui";
    private $releaseFeedUrl = "";

    protected static $settings;

    /**
     * Static log functions for this plugin
     *
     * @param mixed $msg
     * @param string $level
     * @param bool $force
     *
     * @return null
     */
    public static function logError($msg){
        FrenetPlugin::log($msg, LogLevel::Error, $force = true);
    }
    public static function logWarning($msg){
        FrenetPlugin::log($msg, LogLevel::Warning, $force = true);
    }
    // If debugging is set to true in this plugin's settings, then log every message, devMode or not.
    public static function log($msg, $level = LogLevel::Profile, $force = false)
    {
        if(self::$settings['debug']) $force=true;

        if (is_string($msg))
        {
            $msg = "\n\n" . $msg . "\n";
        }
        else
        {
            $msg = "\n\n" . print_r($msg, true) . "\n";
        }

        parent::log($msg, $level, $force);
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDocumentationUrl()
    {
        return $this->documentationUrl;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getSchemaVersion()
    {
        return $this->schemaVersion;
    }

    public function getDeveloper()
    {
        return $this->developer;
    }

    public function getDeveloperUrl()
    {
        return $this->developerUrl;
    }

    function hasSettings(){
        return true;
    }

    function getReleaseFeedUrl(){
        return $this->releaseFeedUrl;
    }


    public function defineSettings()
    {
        return array(
            'debug'                          => AttributeType::Bool,
            'token'                          => AttributeType::String,
            'apiUrl'                         => AttributeType::String,
            'extraShippingDays'              => AttributeType::Number,
            'originCep'                      => AttributeType::String,
        );
    }

    public function getSettingsHtml()
    {

        $settings = self::$settings;

        $variables = array(
            'name'     => $this->getName(true),
            'version'  => $this->getVersion(),
            'settings' => $settings,
            'description' => $this->getDescription(),
        );

        return craft()->templates->render('frenet/_settings', $variables);

    }

    public function init()
    {
        self::$settings = $this->getSettings();
    }


}