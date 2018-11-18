<?php namespace Sepehr\Wallet\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Wallets extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController'
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = ['sepehr.wallet.access_wallet'];
    public function __construct()
    {
        BackendMenu::setContext('Sepehr.Wallet', 'main', 'wallet');
        parent::__construct();

    }
}
