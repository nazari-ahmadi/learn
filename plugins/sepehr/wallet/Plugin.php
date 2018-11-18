<?php namespace Sepehr\wallet;

use Backend;

use Sepehr\Wallet\Components\Wallet;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            Wallet::class => 'walletComponent'
        ];
    }

    public function registerSettings()
    {
    }

    public function registerFormWidgets()
    {

    }

    public function registerPermissions()
    {
        return [
            "sepehr.wallet.access_wallet" => [
                "tab" => 'کیف پول',
                "label" => 'مدیریت کیف پول',
                "order" => 1
            ],
        ];
    }
    public function registerNavigation()
    {
        return [
            'main' => [
                'label' => 'کیف پول',
                'url' => Backend::url('sepehr/wallet/wallets'),
//                'iconSvg' => 'plugins/sepehr/service/assets/images/service.svg',
                'permissions' => ['sepehr.wallet.*'],
                'order' => 300,
                'sideMenu' => [
                    'wallet' => [
                        'label' => 'کیف پول',
                        'url' => Backend::url('sepehr/wallet/wallets'),
                        'icon' => 'icon-envelope',
                        'permissions' => ['sepehr.wallet.access_wallet'],
                        'order' => 300,
                    ],

                ]
            ]
        ];
    }

}
