<?php namespace Sepehr\Service\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use RainLab\User\Models\User;
use Sepehr\Details\Models\Sex;
use Sepehr\Details\Models\Status;
use Sepehr\Service\Models\Service;

/**
 * Reports Back-end Controller
 */
class Reports extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Sepehr.Service', 'services', 'reports');
    }

    public function index()
    {
        $this->addCss('/plugins/sepehr/service/assets/css/jquery.tagit.css');
        $this->addCss('/plugins/sepehr/service/assets/css/tagit.ui-zendesk.css');
        $this->addJs('/plugins/sepehr/service/assets/js/jquery.autocomplete.js');
        $this->addJs('/plugins/sepehr/service/assets/js/tag-it.js');

        $this->vars['sex'] = Sex::orderBy('name')->get();
        $this->vars['users'] = User::orderBy('first_name')->orderBy('last_name')->get();
        $this->vars['statuses'] = Status::orderBy('name')->get();

        return $this->asExtension('ListController')->index();
    }

    public function onReports()
    {
        $senderPostalCode = post("sender_postal_code");
        $senderAddress = post("sender_address");
        if (!$sex = post('sex_id')) {
            $sex = Sex::select('id')->get();
            $sex[] = 0;
        }

        if (!$user = post('user_id')) {
            $user = User::select('id')->get();
            $user[] = 0;
        }

        if (!$status = post('status_id')) {
            $status = Status::select('id')->get();
            $status[] = 0;
        }

        $services = Service::
        where('sender_postal_code', 'LIKE', "%$senderPostalCode%")
            ->where('sender_address', 'LIKE', "%$senderAddress%")
            ->whereIn('user_id', $user)
            ->whereIn('status_id', $status)
            ->get();
        $this->vars['services'] = $services;

//        $this->vars['packages'] = $services->packages;
        $this->vars['service'] = new Services();

    }
}
