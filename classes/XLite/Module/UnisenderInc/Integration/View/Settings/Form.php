<?php
namespace XLite\Module\UnisenderInc\Integration\View\Settings;

use XLite\Module\UnisenderInc\Integration;

/**
 * Subscribe form tab
 *
 * @ListChild (list="admin.center", zone="admin", weight="200")
 */
class Form extends Integration\View\Settings\ASettings
{
    /**
     * List of tabs/sections where this setting should be displayed
     *
     * @return boolean
     */
    public function getSections()
    {
        return array(Integration\Core\Settings::SECTION_FORM);
    }
}
