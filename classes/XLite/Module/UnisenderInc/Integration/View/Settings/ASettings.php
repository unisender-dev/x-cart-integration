<?php
namespace XLite\Module\UnisenderInc\Integration\View\Settings;

use XLite\Module\UnisenderInc\Integration;

/**
 * Settings parent
 */
abstract class ASettings extends \XLite\View\AView
{

    /**
     * List of tabs/sections where this setting should be displayed
     *
     * @return array
     */
    abstract public function getSections();

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return $this->getDir() . '/form.twig';
    }

    /**
     * Return list of allowed targets
     *
     * @return array
     */
    public static function getAllowedTargets()
    {
        $list = parent::getAllowedTargets();
        $list[] = 'unisender';
        return $list;
    }

    public function getCSSFiles()
    {
        $list = parent::getCSSFiles();
        $list[] = 'modules/UnisenderInc/Integration/style.css';
        return $list;
    }

    /**
     * Return templates directory name
     *
     * @return string
     */
    protected function getDir()
    {
        return 'modules/UnisenderInc/Integration';
    }

    /**
     * Check if widget is visible
     *
     * @return boolean
     */
    protected function isVisible()
    {
        return parent::isVisible()
        && in_array(
            \XLite\Core\Request::getInstance()->section,
            $this->getSections()
        );
    }

    public function isConnected()
    {
        return Integration\Core\Settings::getApiKey();
    }

    public function getRegisterUrl()
    {
        $lang = $this->getCurrentLanguage()->getCode();
        $lang = $lang == 'ru' ? 'ru' : 'en';
        return 'http://www.unisender.com/' . $lang . '/registration/';
    }

    public function getApiConfigUrl()
    {
        $lang = $this->getCurrentLanguage()->getCode();
        $lang = $lang == 'ru' ? 'ru' : 'en';
        return 'http://cp.unisender.com/' . $lang . '/v5/user/info/api';
    }

    public function getNewAffiliateAccountUrl()
    {
        return 'http://www.unisender.com/?a=xcart';
    }

    public function getHelpUrl()
    {
        $lang = $this->getCurrentLanguage()->getCode();
        //TODO Create page in English
        return $url = 'http://www.unisender.com/ru/blog/2014/09/novaya_integraciya_unisender_xcart/';
        if ($lang == 'ru') {
            $url = 'http://www.unisender.com/ru/blog/2014/09/novaya_integraciya_unisender_xcart/';
        } else {
            $url = 'http://www.unisender.com/ru/blog/2014/09/novaya_integraciya_unisender_xcart/';
        }
        return $url;
    }
}
