<?php
namespace XLite\Module\UnisenderInc\Integration\View\FormField\Select;

use XLite\Module\UnisenderInc\Integration;

/**
 * Unisender Lists selector
 */
class Lists extends \XLite\View\FormField\Select\Regular
{
    /**
     * Get default options
     *
     * @return array
     */
    protected function getDefaultOptions()
    {
        $api = Integration\Core\UnisenderApi::getInstance();
        $lists = $api->getLists();
        if (!empty($result['error'])) {
            \XLite\Core\TopMessage::addError($result['error']);
            return false;
        }

        return $lists;
    }
}
