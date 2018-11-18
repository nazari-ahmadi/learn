<?php namespace Sepehr\Wallet\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Index extends Controller
{
	public $pageTitle = 'کیف پول';

    public $requiredPermissions=['sepehr.wallet.*'];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Sepehr.Wallet', 'main', '');
    }

    public function index()
    {
    }
}