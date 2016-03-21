<?php
namespace XLite\Module\UnisenderInc\Integration\View;

use XLite\Module\UnisenderInc\Integration;
use \XLite\View\Button;

/**
 * Subscribe form viewer
 *
 * @ListChild (list="sidebar.single")
 * @ListChild (list="sidebar.first")
 */
class UnisenderForm extends \XLite\View\SideBarBox
{
	/**
	 * Register the CSS class
	 *
	 * @return string
	 */
	protected function getBlockClasses()
	{
		return parent::getBlockClasses() . ' unisenderSubscribe';
	}

	/**
	 * Get widget title
	 *
	 * @return string
	 */
    protected function getHead()
    {
        $title = \XLite\Core\Config::getInstance()->UnisenderInc->Integration->formTitle;
        if (empty($title)) {
            $title = static::t('subscribe');
        }
        return $title;
    }

    protected function getDir()
    {
        return 'modules/UnisenderInc/Integration';
    }

	public function getCSSFiles()
	{
		$list = parent::getCSSFiles();
		$list[] = 'modules/UnisenderInc/Integration/css/unisender_form.css';

		return $list;
	}

    public function getJSFiles()
    {
        $list = parent::getJSFiles();
        $list[] = 'modules/UnisenderInc/Integration/js/subscribeForm.js';

        return $list;
    }
}
