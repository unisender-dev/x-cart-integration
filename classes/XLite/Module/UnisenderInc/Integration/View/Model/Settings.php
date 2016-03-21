<?php
namespace XLite\Module\UnisenderInc\Integration\View\Model;

use XLite\Module\UnisenderInc\Integration;
use \XLite\View\Button;

/**
 * Settings model
 */
class Settings extends \XLite\View\Model\ModuleSettings
{
    /**
     * Return fields list by the corresponding schema
     *
     * @return array
     */
    protected function getFormFieldsForSectionDefault()
    {
        $formFields = parent::getFormFieldsForSectionDefault();
        $sectionFields = Integration\Core\Settings::getInstance()
            ->getFieldsForSection(\XLite\Core\Request::getInstance()->section);

        foreach ($formFields as $field => $data) {
            // Remove fields from other sections
            if (!in_array($field, $sectionFields)) {
                unset($formFields[$field]);
            }
        }

        return $formFields;
    }

    /**
     * Get editable options
     *
     * @return array
     */
    protected function getEditableOptions()
    {
        $options = parent::getEditableOptions();

        $sectionOptions = Integration\Core\Settings::getInstance()
            ->getFieldsForSection(\XLite\Core\Request::getInstance()->section);

        foreach ($options as $key => $option) {
            // Remove options from other sections
            if (!in_array($option->name, $sectionOptions)) {
                unset($options[$key]);
            }
        }

        return $options;
    }

    /**
     * Return list of the "Button" widgets
     *
     * @return array
     */
    protected function getFormButtons()
    {
        $result = parent::getFormButtons();

        $result['addons-list'] = new Button\BackToModulesLink(
            array(
                Button\BackToModulesLink::PARAM_MODULE_ID => $this->getModuleID(),
                Button\AButton::PARAM_STYLE => 'action addons-list-back-button',
            )
        );

        if ('connection' == \XLite\Core\Request::getInstance()->section) {
            $result['submit'] = new Button\Submit(
                array(
                    Button\AButton::PARAM_LABEL => static::t('Submit'),
                    Button\AButton::PARAM_STYLE => 'action',
                )
            );

        } elseif ('payment_methods' == \XLite\Core\Request::getInstance()->section) {
            $result = array();
        }

        return $result;
    }

    /**
     * Return name of web form widget class
     *
     * @return string
     */
    protected function getFormClass()
    {
        return '\XLite\Module\UnisenderInc\Integration\View\Form\Settings';
    }
}
