<?php
namespace XLite\Module\UnisenderInc\Integration\Controller\Customer;

use XLite\Module\UnisenderInc\Integration;

/**
 * Checkout
 */
class Checkout extends \XLite\Controller\Customer\Checkout implements \XLite\Base\IDecorator
{
    public function processSucceed($doCloneProfile = true)
    {
        $subOnCheckout = Integration\Core\Settings::isCheckoutOn();

        if ($subOnCheckout === true) {
            $listIds = array(
                Integration\Core\Settings::getRegisterListId(),
                Integration\Core\Settings::getCheckoutListId()
            );
            $listIds = array_unique($listIds);
            $profile = $this->getCart()->getProfile();
            Integration\Core\UnisenderApi::getInstance()->subscribe($profile, implode(',', $listIds));
        }

        parent::processSucceed($doCloneProfile);
    }
}
