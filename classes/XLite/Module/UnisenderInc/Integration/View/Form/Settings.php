<?php
namespace XLite\Module\UnisenderInc\Integration\View\Form;

use XLite\Module\UnisenderInc\Integration;

/**
 * Settings
 */
class Settings extends \XLite\View\Form\Settings
{
    /**
     * Get form parameters. Add hidden field for section
     *
     * @return array
     */
    protected function getFormParams()
    {
        $params = parent::getFormParams();

        $apiKey = Integration\Core\Settings::getInstance()->getApiKey();
        if (empty($apiKey)) {
            unset($params['defaultListId']);
        }
        $params += array(
            'section' => \XLite\Core\Request::getInstance()->section,
        );

        return $params;
    }

    protected function getDefaultAction()
    {
        $section = \XLite\Core\Request::getInstance()->section;
        return $section;
    }
}
