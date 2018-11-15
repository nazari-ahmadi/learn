<?php namespace RainLab\User;

use App;
use Auth;
use Event;
use Backend;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;
use Illuminate\Foundation\AliasLoader;
use RainLab\User\Classes\UserRedirector;
use RainLab\User\Models\MailBlocker;
use RainLab\Notify\Classes\Notifier;

class Plugin extends PluginBase
{
    /**
     * @var boolean Determine if this plugin should have elevated privileges.
     */
    public $elevated = true;

    public function pluginDetails()
    {
        return [
            'name'        => 'rainlab.user1::lang.plugin.name',
            'description' => 'rainlab.user1::lang.plugin.description',
            'author'      => 'Alexey Bobkov, Samuel Georges',
            'icon'        => 'icon-user1',
            'homepage'    => 'https://github.com/rainlab/user1-plugin'
        ];
    }

    public function register()
    {
        $alias = AliasLoader::getInstance();
        $alias->alias('Auth', 'RainLab\User\Facades\Auth');

        App::singleton('user1.auth', function() {
            return \RainLab\User\Classes\AuthManager::instance();
        });

        App::singleton('redirect', function ($app) {
            // overrides with our own extended version of Redirector to support 
            // seperate url.intended session variable for frontend
            $redirector = new UserRedirector($app['url']);

            // If the session is set on the application instance, we'll inject it into
            // the redirector instance. This allows the redirect responses to allow
            // for the quite convenient "with" methods that flash to the session.
            if (isset($app['session.store'])) {
                $redirector->setSession($app['session.store']);
            }

            return $redirector;
        });

        /*
         * Apply user1-based mail blocking
         */
        Event::listen('mailer.prepareSend', function($mailer, $view, $message) {
            return MailBlocker::filterMessage($view, $message);
        });

        /*
         * Compatability with RainLab.Notify
         */
        $this->bindNotificationEvents();
    }

    public function registerComponents()
    {
        return [
            \RainLab\User\Components\Session::class       => 'session',
            \RainLab\User\Components\Account::class       => 'account',
            \RainLab\User\Components\Login::class         => 'login',
            \RainLab\User\Components\Register::class      => 'register',
            \RainLab\User\Components\ResetPassword::class => 'resetPassword',
            \RainLab\User\Components\Activation::class    => 'activation'
        ];
    }

    public function registerPermissions()
    {
        return [
            'rainlab.users.main.access_users' => [
                'tab'   => 'rainlab.user1::lang.plugin.tab',
                'label' => 'rainlab.user1::lang.plugin.access_users'
            ],
            'rainlab.users.main.access_groups' => [
                'tab'   => 'rainlab.user1::lang.plugin.tab',
                'label' => 'rainlab.user1::lang.plugin.access_groups'
            ],
            'rainlab.users.access_settings' => [
                'tab'   => 'rainlab.user1::lang.plugin.tab',
                'label' => 'rainlab.user1::lang.plugin.access_settings'
            ],
            'rainlab.users.main.impersonate_user' => [
                'tab'   => 'rainlab.user1::lang.plugin.tab',
                'label' => 'rainlab.user1::lang.plugin.impersonate_user'
            ],
        ];
    }

    public function registerNavigation()
    {
        return [
            'main' => [
                'label'       => 'rainlab.user1::lang.users.menu_label',
                'url'         => Backend::url('rainlab/user1/users'),
                'icon'        => 'icon-user1',
                'iconSvg'     => 'plugins/rainlab/user1/assets/images/user1-icon.svg',
                'permissions' => ['rainlab.users.main.*'],
                'order'       => 100,
                'sideMenu'    => [
                    'users' => [
                        'label'       => 'کاربران',
                        'url'         => Backend::url('rainlab/user1/users'),
                        'icon'        => 'icon-user1',
                        'permissions' => ['rainlab.users.main.access_users'],
                    ],
                    'usergroups' => [
                        'label'       => 'گروه های کاربری',
                        'url'         => Backend::url('rainlab/user1/usergroups'),
                        'icon'        => 'icon-users',
                        'permissions' => ['rainlab.users.main.access_groups'],
                    ]                    
                ]
            ]
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'rainlab.user1::lang.settings.menu_label',
                'description' => 'rainlab.user1::lang.settings.menu_description',
                'category'    => SettingsManager::CATEGORY_USERS,
                'icon'        => 'icon-cog',
                'class'       => 'RainLab\User\Models\Settings',
                'order'       => 500,
                'permissions' => ['rainlab.users.access_settings']
            ]
        ];
    }

    public function registerMailTemplates()
    {
        return [
            'rainlab.user1::mail.activate',
            'rainlab.user1::mail.welcome',
            'rainlab.user1::mail.restore',
            'rainlab.user1::mail.new_user',
            'rainlab.user1::mail.reactivate',
            'rainlab.user1::mail.invite',
        ];
    }

    public function registerNotificationRules()
    {
        return [
            'groups' => [
                'user1' => [
                    'label' => 'User',
                    'icon' => 'icon-user1'
                ],
            ],
            'events' => [
                \RainLab\User\NotifyRules\UserActivatedEvent::class,
                \RainLab\User\NotifyRules\UserRegisteredEvent::class,
            ],
            'actions' => [],
            'conditions' => [
                \RainLab\User\NotifyRules\UserAttributeCondition::class
            ],
        ];
    }

    protected function bindNotificationEvents()
    {
        if (!class_exists(Notifier::class)) {
            return;
        }

        Notifier::bindEvents([
            'rainlab.user1.activate' => \RainLab\User\NotifyRules\UserActivatedEvent::class,
            'rainlab.user1.register' => \RainLab\User\NotifyRules\UserRegisteredEvent::class
        ]);

        Notifier::instance()->registerCallback(function($manager) {
            $manager->registerGlobalParams([
                'user1' => Auth::getUser()
            ]);
        });
    }
}
