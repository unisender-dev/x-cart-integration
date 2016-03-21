<?php
namespace XLite\Module\UnisenderInc\Integration\View\Settings;

use XLite\Module\UnisenderInc\Integration;

/**
 * Connection tab
 *
 * @ListChild (list="admin.center", zone="admin", weight="200")
 */
class Connection extends Integration\View\Settings\ASettings
{
    /**
     * Return widget default template
     *
     * @return string
     */
    protected function getDefaultTemplate()
    {
        return $this->getDir() . '/connection.tpl';
    }

    /**
     * List of tabs/sections where this setting should be displayed
     *
     * @return boolean
     */
    public function getSections()
    {
        return array(Integration\Core\Settings::SECTION_CONNECTION);
    }
}
