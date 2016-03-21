<?php
namespace XLite\Module\UnisenderInc\Integration\Core;

use XLite\Module\UnisenderInc\Integration;

/**
 * Integration tabs and settings
 *
 */
class Settings extends \XLite\Base\Singleton
{
    /**
     * Tabs/sections
     */
    const SECTION_CONNECTION = 'connection';
    const SECTION_SUBSCRIBE = 'subscribe';
    const SECTION_FORM = 'form';

    /**
     * List of configuration fields separated by sections
     */
    public $sectionFields = array(
        self::SECTION_CONNECTION => array(
            'apiKey',
            'defaultListId'
        ),
        self::SECTION_SUBSCRIBE => array(
            'subOnRegister',
            'registerListId',
            'subOnCheckout',
            'checkoutListId',
        ),
        self::SECTION_FORM => array(
            'enableForm',
            'formTitle',
            'formWeight',
            'formSuccessMessage'
        ),
    );

    static public $apiKey;
    static public $defaultListId;

    /**
     * Required fields
     *
     * @var array
     */
    protected $requiredFields = array(
        'apiKey',
    );

    /**
     * Get default section
     *
     * @return string
     */
    public function getDefaultSection()
    {
        return static::SECTION_CONNECTION;
    }

    /**
     * Get list of fields for section
     *
     * @param string $section Section name
     *
     * @return array
     */
    public function getFieldsForSection($section = '')
    {
        $fields = isset($this->sectionFields[$section])
            ? $this->sectionFields[$section]
            : array();

        $apiKey = Integration\Core\Settings::getApiKey();
        if (empty($apiKey) && (empty($section) || $section === self::SECTION_CONNECTION)) {
            $fields = array('apiKey');
        }
        return $fields;
    }

    public function saveSettings($newSettings)
    {
        $newNames = array_keys($newSettings);
        foreach ($this->sectionFields as $fields) {
            foreach ($fields as $name) {
                if (!in_array($name, $newNames)) {
                    continue;
                }

                $trueName = \XLite\Core\Database::getRepo('XLite\Model\Config')
                    ->findOneBy(array('name' => $name, 'category' => 'UnisenderInc\Integration'));
                if (!$trueName) {
                    continue;
                }

                \XLite\Core\Database::getRepo('XLite\Model\Config')->update(
                    $trueName,
                    array('value' => $newSettings[$name])
                );
            }
        }
    }

    /**
     * @return Integration\Core\Settings
     */
    public static function getInstance()
    {
        return parent::getInstance();
    }

    /**
     * Get all sections
     *
     * @return array
     */
    public static function getAllSections()
    {
        return array(
            static::SECTION_CONNECTION,
            static::SECTION_SUBSCRIBE,
            static::SECTION_FORM,
        );
    }


    public static function getApiKey()
    {
        if (empty(self::$apiKey)) {
            self::$apiKey = \XLite\Core\Config::getInstance()->UnisenderInc->Integration->apiKey;
        }

        return self::$apiKey;
    }

    public static function isRegisterOn()
    {
        return (bool)\XLite\Core\Config::getInstance()->UnisenderInc->Integration->subOnRegister;
    }

    public static function isCheckoutOn()
    {
        return (bool)\XLite\Core\Config::getInstance()->UnisenderInc->Integration->subOnCheckout;
    }

    public static function getDefaultListId()
    {
        if (empty(self::$defaultListId)) {
            self::$defaultListId = \XLite\Core\Config::getInstance()->UnisenderInc->Integration->defaultListId;
        }

        return self::$defaultListId;
    }

    public static function getRegisterListId()
    {
        $listId = \XLite\Core\Config::getInstance()->UnisenderInc->Integration->registerListId;
        if (empty($listId)) {
            $listId = \XLite\Core\Config::getInstance()->UnisenderInc->Integration->defaultListId;
        }

        return $listId;
    }

    public static function getCheckoutListId()
    {
        $listId = \XLite\Core\Config::getInstance()->UnisenderInc->Integration->checkoutListId;
        if (empty($listId)) {
            $listId = \XLite\Core\Config::getInstance()->UnisenderInc->Integration->defaultListId;
        }

        return $listId;
    }
}
