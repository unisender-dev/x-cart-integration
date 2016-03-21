<?php
namespace XLite\Module\UnisenderInc\Integration\View\Menu\Admin;

/**
 * Top menu widget
 */
class LeftMenu extends \XLite\View\Menu\Admin\LeftMenu implements \XLite\Base\IDecorator
{
    protected function defineItems()
    {
        $list = parent::defineItems();
        if (!isset($list['promotions'])) {
            $list['promotions'] = array(
                self::ITEM_TITLE => 'Unisender Manager',
                self::ITEM_TARGET => 'unisender',
                self::ITEM_WEIGHT => 1000,
                self::ITEM_CHILDREN => array(),
            );
        }

        $list['promotions'][static::ITEM_CHILDREN]['unisender'] = array(
            static::ITEM_TITLE => 'Unisender Manager',
            static::ITEM_TARGET => 'unisender',
            self::ITEM_WEIGHT => 1000,
        );

        return $list;
    }
}
