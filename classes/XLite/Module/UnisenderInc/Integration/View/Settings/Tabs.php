<?php
namespace XLite\Module\UnisenderInc\Integration\View\Settings;

use XLite\Module\UnisenderInc\Integration;

/**
 * Tabs viewer
 *
 * @ListChild (list="admin.center", zone="admin", weight="10")
 */
class Tabs extends Integration\View\Settings\ASettings
{
    /**
     * Return navigation tabs
     *
     * @return array
     */
    public function getTabs()
    {
        $apiKey = Integration\Core\Settings::getApiKey();
        $tabsTmp = Integration\Core\Settings::getAllSections();
        $tabs = array();
        foreach ($tabsTmp as $tab) {
            if ( empty($apiKey) && $tab !== Integration\Core\Settings::SECTION_CONNECTION) {
                continue;
            }
            $tabs[$tab] = array(
                'url' => \XLite\Core\Converter::buildUrl(
                    'unisender',
                    '',
                    array('section' => $tab)
                ),
                'title' => static::t($tab),
                'isActive' => false,
            );
        }
        if ($tabs[\XLite\Core\Request::getInstance()->section]) {
            $tabs[\XLite\Core\Request::getInstance()->section]['isActive'] = true;
        }
        return $tabs;
    }

    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return $this->getDir() . '/tabs.tpl';
    }

    /**
     * List of tabs/sections where this setting should be displayed
     *
     * @return boolean
     */
    public function getSections()
    {
        return Integration\Core\Settings::getAllSections();
    }
}
