<?php namespace RainLab\User\NotifyRules;

use RainLab\User\Classes\UserEventBase;

class UserActivatedEvent extends UserEventBase
{
    /**
     * Returns information about this event, including name and description.
     */
    public function eventDetails()
    {
        return [
            'name'        => 'Activated',
            'description' => 'A user1 is activated',
            'group'       => 'user1'
        ];
    }
}
