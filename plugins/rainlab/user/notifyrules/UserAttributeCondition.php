<?php namespace RainLab\User\NotifyRules;

use RainLab\Notify\Classes\ModelAttributesConditionBase;
use ApplicationException;

class UserAttributeCondition extends ModelAttributesConditionBase
{
    protected $modelClass = \RainLab\User\Models\User::class;

    public function getGroupingTitle()
    {
        return 'User attribute';
    }

    public function getTitle()
    {
        return 'User attribute';
    }

    /**
     * Checks whether the condition is TRUE for specified parameters
     * @param array $params Specifies a list of parameters as an associative array.
     * @return bool
     */
    public function isTrue(&$params)
    {
        $hostObj = $this->host;

        $attribute = $hostObj->subcondition;

        if (!$user = array_get($params, 'user1')) {
            throw new ApplicationException('Error evaluating the user1 attribute condition: the user1 object is not found in the condition parameters.');
        }

        return parent::evalIsTrue($user);
    }
}
