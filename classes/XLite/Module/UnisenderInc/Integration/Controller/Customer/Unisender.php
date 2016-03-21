<?php
namespace XLite\Module\UnisenderInc\Integration\Controller\Customer;

use XLite\Module\UnisenderInc\Integration;

/**
 * Subscribe form
 */
class Unisender extends \XLite\Controller\Customer\ACustomer
{
    /**
     * Send subscribe form to Unisender
     *
     * @return void
     */
    protected function doActionSubscribe()
    {
        if ($this->isAJAX() == false) {
            $this->redirect($this->buildUrl());
        }

        $data = \XLite\Core\Request::getInstance()->getPostData();
        $listIds = Integration\Core\Settings::getDefaultListId();
        $response = Integration\Core\UnisenderApi::getInstance()->subscribeForm($data, $listIds);
        if ($response['error']) {
            $result = json_encode(array(
                'status' => 'error',
                'message' => $response['error']
            ));
        } else {
            $formSuccessMessage =
                \XLite\Core\Config::getInstance()->UnisenderInc->Integration->formSuccessMessage;
            if (!empty($formSuccessMessage)) {
                $message = $formSuccessMessage;
            } else {
                $message = static::t('subscriptionSuccess');
            }
            $result = json_encode(array(
                'status' => 'success',
                'message' => $message
            ));
        }

        die($result);
    }
}
