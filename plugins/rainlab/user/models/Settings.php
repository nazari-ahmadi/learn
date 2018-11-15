<?php namespace RainLab\User\Models;

use Lang;
use Model;
use RainLab\User\Models\User as UserModel;

class Settings extends Model
{
    /**
     * @var array Behaviors implemented by this model.
     */
    public $implement = [
        \System\Behaviors\SettingsModel::class
    ];

    public $settingsCode = 'user_settings';
    public $settingsFields = 'fields.yaml';

    const ACTIVATE_AUTO = 'auto';
    const ACTIVATE_USER_EMAIL = 'user_email';
    const ACTIVATE_USER_SMS = 'user_sms';
    const ACTIVATE_ADMIN = 'admin';

    const LOGIN_EMAIL = 'email';
    const LOGIN_USERNAME = 'username';

    public function initSettingsData()
    {
        $this->require_activation = true;
        $this->activate_mode = self::ACTIVATE_AUTO;
        $this->use_throttle = true;
        $this->block_persistence = false;
        $this->allow_registration = true;
        $this->login_attribute = self::LOGIN_EMAIL;
    }

    public function getActivateModeOptions()
    {
        return [
            self::ACTIVATE_AUTO => [
                'rainlab.user1::lang.settings.activate_mode_auto',
                'rainlab.user1::lang.settings.activate_mode_auto_comment'
            ],
            self::ACTIVATE_USER_EMAIL => [
                'rainlab.user1::lang.settings.activate_mode_user',
                'rainlab.user1::lang.settings.activate_mode_user_comment'
            ],
            self::ACTIVATE_USER_SMS => [
                'rainlab.user1::lang.settings.activate_mode_user_sms',
                'rainlab.user1::lang.settings.activate_mode_user_comment_sms'
            ],            
            self::ACTIVATE_ADMIN => [
                'rainlab.user1::lang.settings.activate_mode_admin',
                'rainlab.user1::lang.settings.activate_mode_admin_comment'
            ]
        ];
    }

    public function getLoginAttributeOptions()
    {
        return [
            self::LOGIN_EMAIL => ['rainlab.user1::lang.login.attribute_email'],
            self::LOGIN_USERNAME => ['rainlab.user1::lang.login.attribute_username']
        ];
    }

    public function getActivateModeAttribute($value)
    {
        if (!$value) {
            return self::ACTIVATE_AUTO;
        }

        return $value;
    }
}
