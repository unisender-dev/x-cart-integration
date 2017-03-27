<?php
namespace XLite\Module\UnisenderInc\Integration;

abstract class Main extends \XLite\Module\AModule
{
    /**
     * Author name
     *
     * @return string
     */
    public static function getAuthorName()
    {
        return 'Unisender Inc';
    }

    /**
     * Get module major version
     *
     * @return string
     */
    public static function getMajorVersion()
    {
        return '5.3';
    }

    /**
     * Module version
     *
     * @return string
     */
    public static function getMinorVersion()
    {
        return '1';
    }

    /**
     * Module name
     *
     * @return string
     */
    public static function getModuleName()
    {
        return 'Unisender Integration';
    }

    /**
     * Module description
     *
     * @return string
     */
    public static function getDescription()
    {
        return 'Create and send professional newsletters! The module integrates your store with UniSender, a popular service for mailing and bulk SMS messaging.';
    }

    /**
     * Determines if we need to show settings form link
     *
     * @return boolean
     */
    public static function showSettingsForm()
    {
        return true;
    }

    /**
     * Return link to settings form
     *
     * @return string
     */
    public static function getSettingsForm()
    {
        return \XLite\Core\Converter::buildURL('unisender');
    }

    public static function runBuildCacheHandler()
    {
        parent::runBuildCacheHandler();

        $weight = ((int)\XLite\Core\Config::getInstance()->UnisenderInc->Integration->formWeight * 100);

        \XLite\Core\Layout::getInstance()->addClassToList(
            'XLite\Module\UnisenderInc\Integration\View\UnisenderForm',
            'sidebar.first',
            array(
                'zone' => \XLite\Model\ViewList::INTERFACE_CUSTOMER,
                'weight' => $weight,
            )
        );
    }
}
