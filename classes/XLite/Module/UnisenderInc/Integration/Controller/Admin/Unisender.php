<?php
namespace XLite\Module\UnisenderInc\Integration\Controller\Admin;

use XLite\Module\UnisenderInc\Integration;

/**
 * Integration module settings
 *
 */
class Unisender extends \XLite\Controller\Admin\Module
{
    /**
     * handleRequest
     *
     * @return void
     */
    public function handleRequest()
    {
        parent::handleRequest();
        $sections = Integration\Core\Settings::getAllSections();

        $apiKey = Integration\Core\Settings::getInstance()->getApiKey();
        $defaultSection = Integration\Core\Settings::getInstance()->getDefaultSection();

        if ((empty($apiKey) && $defaultSection != \XLite\Core\Request::getInstance()->section)
            || !in_array(\XLite\Core\Request::getInstance()->section, $sections)) {
            $this->setHardRedirect();
            $this->setReturnURL(
                $this->buildURL(
                    'unisender',
                    '',
                    array('section' => Integration\Core\Settings::getInstance()->getDefaultSection())
                )
            );
            $this->doRedirect();
        }

    }

    /**
     * Get current module ID
     *
     * @return integer
     */
    public function getModuleID()
    {
        if (!isset($this->moduleID)) {
            $module = \XLite\Core\Database::getRepo('\XLite\Model\Module')->findOneBy(
                array(
                    'name' => 'Integration',
                    'author' => 'UnisenderInc',
                    'installed' => 1,
                    'enabled' => 1,
                )
            );

            if ($module) {
                $this->moduleID = $module->getModuleID();
                $this->module = $module;
            }
        }

        return $this->moduleID;
    }

    /**
     * Update connection settings
     *
     * @return void
     */
    protected function doActionConnection()
    {
        $apiKey = Integration\Core\Settings::getInstance()->getApiKey();
        $newApiKey = \XLite\Core\Request::getInstance()->apiKey;

        //API KEY
        if (empty($newApiKey)) {
            \XLite\Core\TopMessage::addError(static::t('wrongApiKey'));
            return;
        }

        if (!empty($newApiKey) && $apiKey !== $newApiKey) {
            $api = Integration\Core\UnisenderApi::getInstance();
            $result = $api->getLists($newApiKey);
            if (!empty($result['error'])) {
                \XLite\Core\TopMessage::addError($result['error']);
                Integration\Core\Settings::getInstance()->saveSettings(array(
                    'apiKey' => ''
                ));
                return;
            }

            Integration\Core\Settings::getInstance()->saveSettings(array(
                'apiKey' => $newApiKey
            ));
        }

        //DEFAULT LIST ID
        $defaultListId = Integration\Core\Settings::getInstance()->getDefaultListId();

        $newDefaultListId = \XLite\Core\Request::getInstance()->defaultListId;

        // For first save
        if (empty($newDefaultListId)) {
            $api = Integration\Core\UnisenderApi::getInstance();
            $lists = $api->getLists();
            $keys = array_keys($lists);
            $newDefaultListId = $keys[0];
        }
        
        if (!empty($newDefaultListId) && $defaultListId !== $newDefaultListId) {
            Integration\Core\Settings::getInstance()->saveSettings(array(
                'defaultListId' => $newDefaultListId
            ));
        }

        \XLite\Core\TopMessage::addInfo(static::t('saved'));
    }

    /**
     * Update subscribe settings
     *
     * @return void
     */
    protected function doActionSubscribe()
    {
        $apiKey = Integration\Core\Settings::getInstance()->getApiKey();

        // On Register
        $subOnRegister = (bool)\XLite\Core\Request::getInstance()->subOnRegister;
        $registerListId = \XLite\Core\Request::getInstance()->registerListId;

        Integration\Core\Settings::getInstance()->saveSettings(array(
            'subOnRegister' => $subOnRegister,
            'registerListId' => $registerListId,
        ));

        // On Checkout
        $subOnCheckout = (bool)\XLite\Core\Request::getInstance()->subOnCheckout;
        $checkoutListId = \XLite\Core\Request::getInstance()->checkoutListId;

        Integration\Core\Settings::getInstance()->saveSettings(array(
            'subOnCheckout' => $subOnCheckout,
            'checkoutListId' => $checkoutListId,
        ));

        \XLite\Core\TopMessage::addInfo(static::t('saved'));
    }

    /**
     * Update form settings
     *
     * @return void
     */
    protected function doActionForm()
    {
        $enableForm = (bool)\XLite\Core\Request::getInstance()->enableForm;
        $formTitle = \XLite\Core\Request::getInstance()->formTitle;
        $formWeight = \XLite\Core\Request::getInstance()->formWeight;
        $formSuccessMessage = \XLite\Core\Request::getInstance()->formSuccessMessage;

        Integration\Core\Settings::getInstance()->saveSettings(array(
            'enableForm' => $enableForm,
            'formTitle' => $formTitle,
            'formWeight' => $formWeight,
            'formSuccessMessage' => $formSuccessMessage
        ));

        \XLite\Core\TopMessage::addInfo(static::t('saved'));
    }

    /**
     * getModelFormClass
     *
     * @return string
     */
    protected function getModelFormClass()
    {
        return '\XLite\Module\UnisenderInc\Integration\View\Model\Settings';
    }
}
