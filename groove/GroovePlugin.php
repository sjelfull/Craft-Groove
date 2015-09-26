<?php
namespace Craft;

class GroovePlugin extends BasePlugin
{
    function getName()
    {
         return Craft::t('Groove');
    }

    function getVersion()
    {
        return '0.1';
    }

    function getDeveloper()
    {
        return 'Fred Carlsen';
    }

    function getDeveloperUrl()
    {
        return 'http://sjelfull.no';
    }

    public function getSettingsHtml()
    {
       return craft()->templates->render('groove/_settings', array(
           'settings' => $this->getSettings()
       ));
    }

    protected function defineSettings()
    {
        return array(
            'enabled' => array(AttributeType::Bool, 'default' => false),
            'privateToken' => array(AttributeType::String, 'default' => '', 'required' => true),
            'defaultMailbox' => array(AttributeType::String, 'default' => ''),
        );
    }

    /* == OPTIONAL ===

    public function hasCpSection()
    {
        return false;
    }

    public function getSettingsUrl()
    {
        return UrlHelper::getUrl('striper/settings');
    }

    public function onBeforeInstall()
    {
    }

    public function onAfterInstall()
    {
    }

    public function onBeforeUninstall()
    {
    }

    */

}