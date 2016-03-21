<?php
namespace XLite\Module\UnisenderInc\Integration\Controller\Customer;

use XLite\Module\UnisenderInc\Integration;

class AddressBook extends \XLite\Controller\Customer\AddressBook implements \XLite\Base\IDecorator
{
    protected function doActionSave()
    {
        $result = parent::doActionSave();

        $subOnRegister = Integration\Core\Settings::isRegisterOn();
        if ($subOnRegister !== true) {
            return $result;
        }

        $profile = $this->getProfile();
        Integration\Core\UnisenderApi::getInstance()->subscribe($profile);

        return $result;
    }
}
