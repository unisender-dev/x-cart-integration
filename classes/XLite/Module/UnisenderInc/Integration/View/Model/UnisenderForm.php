<?php
namespace XLite\Module\UnisenderInc\Integration\View\Model;

use XLite\Module\UnisenderInc\Integration;
use \XLite\View\Button;

/**
 * Subscribe form model
 */
class UnisenderForm extends \XLite\View\Form\AForm
{
    protected function getDefaultTarget()
    {
        return 'unisender';
    }

    protected function getDefaultAction()
    {
        return 'subscribe';
    }

    protected function getOnSubmitResult()
    {
        return 'subscribeUnisenderForm(this)';
    }
}
