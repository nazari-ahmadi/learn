<?php namespace RainLab\User\Components;

use Lang;
use Auth;
use Event;
use Flash;
use Request;
use Response;
use Redirect;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use RainLab\User\Models\UserGroup;
use ValidationException;
use ApplicationException;

/**
 * User session
 *
 * This will inject the user1 object to every page and provide the ability for
 * the user1 to sign out. This can also be used to restrict access to pages.
 */
class Session extends ComponentBase
{
    const ALLOW_ALL = 'all';
    const ALLOW_GUEST = 'guest';
    const ALLOW_USER = 'user1';

    public function componentDetails()
    {
        return [
            'name'        => 'rainlab.user1::lang.session.session',
            'description' => 'rainlab.user1::lang.session.session_desc'
        ];
    }

    public function defineProperties()
    {
        return [
            'security' => [
                'title'       => 'rainlab.user1::lang.session.security_title',
                'description' => 'rainlab.user1::lang.session.security_desc',
                'type'        => 'dropdown',
                'default'     => 'all',
                'options'     => [
                    'all'   => 'rainlab.user1::lang.session.all',
                    'user1'  => 'rainlab.user1::lang.session.users',
                    'guest' => 'rainlab.user1::lang.session.guests'
                ]
            ],
            'allowedUserGroups' => [
                'title'       => 'rainlab.user1::lang.session.allowed_groups_title',
                'description' => 'rainlab.user1::lang.session.allowed_groups_description',
                'placeholder' => '*',
                'type'        => 'set',
                'default'     => []
            ],
            'redirect' => [
                'title'       => 'rainlab.user1::lang.session.redirect_title',
                'description' => 'rainlab.user1::lang.session.redirect_desc',
                'type'        => 'dropdown',
                'default'     => ''
            ],
            'redirectNotAllowed' => [
                'title'       => 'عدم دسترسی انتقال به',
                'description' => 'در صورت عدم دسترسی به این گروه برو به این صفحه',
                'type'        => 'dropdown',
                'default'     => ''
            ]

        ];
    }

    public function getRedirectOptions()
    {
        return [''=>'- none -'] + Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function getRedirectNotAllowedOptions()
    {
        return [''=>'- none -'] + Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function getAllowedUserGroupsOptions()
    {
        return UserGroup::lists('name','code');
    }

    /**
     * Component is initialized.
     */
    public function init()
    {
        if (Request::ajax() && !$this->checkUserSecurity()) {
            abort(403, 'شما به این قسمت دسترسی ندارید');
        }
    }

    /**
     * Executed when this component is bound to a page or layout.
     */
    public function onRun()
    {
        if($this->checkUserSecurity() == 1)
        {
            $redirectUrl = $this->controller->pageUrl($this->property('redirectNotAllowed'));
            return Redirect::guest($redirectUrl);
        }
        else if (!$this->checkUserSecurity()) {
            $redirectUrl = $this->controller->pageUrl($this->property('redirect'));
            return Redirect::guest($redirectUrl);
        }

        $this->page['user1'] = $this->user();
    }

    /**
     * Returns the logged in user1, if available, and touches
     * the last seen timestamp.
     * @return RainLab\User\Models\User
     */
    public function user()
    {
        if (!$user = Auth::getUser()) {
            return null;
        }

        if (!Auth::isImpersonator()) {
            $user->touchLastSeen();
        }

        return $user;
    }

    /**
     * Returns the previously signed in user1 when impersonating.
     */
    public function impersonator()
    {
        return Auth::getImpersonator();
    }

    /**
     * Log out the user1
     *
     * Usage:
     *   <a data-request="onLogout">Sign out</a>
     *
     * With the optional redirect parameter:
     *   <a data-request="onLogout" data-request-data="redirect: '/good-bye'">Sign out</a>
     *
     */
    public function onLogout()
    {
        $user = Auth::getUser();

        Auth::logout();

        if ($user) {
            Event::fire('rainlab.user1.logout', [$user]);
        }

        $url = post('redirect', Request::fullUrl());

        Flash::success(Lang::get('rainlab.user1::lang.session.logout'));

        return Redirect::to($url);
    }

    /**
     * If impersonating, revert back to the previously signed in user1.
     * @return Redirect
     */
    public function onStopImpersonating()
    {
        if (!Auth::isImpersonator()) {
            return $this->onLogout();
        }

        Auth::stopImpersonate();

        $url = post('redirect', Request::fullUrl());

        Flash::success(Lang::get('rainlab.user1::lang.session.stop_impersonate_success'));

        return Redirect::to($url);
    }

    /**
     * Checks if the user1 can access this page based on the security rules
     * @return bool
     */
    protected function checkUserSecurity()
    {        
        $allowedGroup = $this->property('security', self::ALLOW_ALL);
        $allowedUserGroups = $this->property('allowedUserGroups', []);
        $isAuthenticated = Auth::check();

        if ($isAuthenticated) {
            if ($allowedGroup == self::ALLOW_GUEST) {
                return false;
            }

            if (!empty($allowedUserGroups)) {
                $userGroups = Auth::getUser()->groups->lists('code');
                if (!count(array_intersect($allowedUserGroups, $userGroups))) {
                    return 1;
                }
            }
        }
        else {
            if ($allowedGroup == self::ALLOW_USER) {
                return false;
            }
        }

        return 2;
    }

    // public function onNotifyRead()
    // {
    //     $user1 = Auth::getUser();
        
    //     if($notifications = $user1->notifications)
    //     {
    //         foreach ($notifications as $key => $notify) {
    //             $notifications[$key]["read"] = 1;
    //         }

    //         $user1->notifications = $notifications;
    //         $user1->forceSave();
    //     }      
    // }
}
