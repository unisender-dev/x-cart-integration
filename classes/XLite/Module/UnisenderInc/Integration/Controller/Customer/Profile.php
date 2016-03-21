<?php
namespace XLite\Module\UnisenderInc\Integration\Controller\Customer;

use XLite\Module\UnisenderInc\Integration;

class Profile extends \XLite\Controller\Customer\Profile implements \XLite\Base\IDecorator
{
    protected function doActionRegister()
    {
        $result = parent::doActionRegister();

        $subOnRegister = Integration\Core\Settings::isRegisterOn();
        if ($subOnRegister !== true) {
            return $result;
        }

        $listId = Integration\Core\Settings::getRegisterListId();
        $profile = $this->getModelForm()->getModelObject();

        Integration\Core\UnisenderApi::getInstance()->subscribe($profile, $listId);

        return $result;
    }

    protected function doActionUpdate()
    {
        parent::doActionUpdate();

        $subOnRegister = Integration\Core\Settings::isRegisterOn();
        if ($subOnRegister !== true) {
            return false;
        }

        $profile = $this->getModelForm()->getModelObject();

        Integration\Core\UnisenderApi::getInstance()->subscribe($profile);

        return true;
    }
}
