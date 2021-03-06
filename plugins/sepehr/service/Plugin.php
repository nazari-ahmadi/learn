<?php namespace Sepehr\Service;

use Backend;
use Sepehr\Service\Components\Maps as MapsComponent;
use Sepehr\Service\Components\PostmanServices;
use Sepehr\Service\Components\ReferralPostman;
use Sepehr\Service\Components\Reports;
use Sepehr\Service\Components\RequestService;
use Sepehr\Service\Components\ServiceDelivery;
use Sepehr\Service\Components\ServiceList;
use Sepehr\Service\FormWidgets\Maps;
use Sepehr\Wallet\Components\Wallet;
use Sepehr\Service\FormWidgets\Packages;
use Sepehr\Service\FormWidgets\Payments;
use Sepehr\Service\FormWidgets\Postman;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{

  public function pluginDetails()
  {
    return [
      "name" => 'sepehr.service::lang.plugin.name',
      "description" => 'sepehr.service::lang.plugin.description',
      "author" => "sepehr",
      "icon" => "oc-icon-database",
      "homepage" => ''
    ];
  }


  public function registerPermissions()
  {
    return [
      "sepehr.service.access_service" => [
        "tab" => 'سرویس',
        "label" => 'مدیریت سرویس',
        "order" => 1
      ],
      'sepehr.service.access_reports' => [
        "tab" => 'سرویس',
        "label" => 'مدیریت گزارشات',
        "order" => 2
      ]
    ];
  }

  public function registerNavigation()
  {
    return [
      'services' => [
        'label' => 'سرویس',
        'url' => Backend::url('sepehr/service/index'),
        'iconSvg' => 'plugins/sepehr/service/assets/images/service.svg',
        'permissions' => ['sepehr.service.*'],
        'order' => 300,
        'sideMenu' => [
          'service' => [
            'label' => 'سرویس',
            'url' => Backend::url('sepehr/service/services'),
            'icon' => 'icon-envelope',
            'permissions' => ['sepehr.service.access_service'],
            'order' => 300,
          ],
          'reports' => [
            'label' => 'گزارش',
            'url' => Backend::url('sepehr/service/reports'),
            'icon' => 'icon-search',
            'permissions' => ['sepehr.service.access_reports'],
            'order' => 300,
          ],

        ]
      ]
    ];
  }

  public function registerComponents()
  {
    return [
      RequestService::class => 'requestService',
      ServiceList::class => 'serviceList',
      ReferralPostman::class => 'referralPostman',
      PostmanServices::class => 'PostmanServices',
      ServiceDelivery::class => 'ServiceDelivery',
      Reports::class => 'reportComponent',
      MapsComponent::class => 'mapComponent'
    ];
  }

  public function registerSettings()
  {

  }

  public function registerFormWidgets()
  {
    return
      [
        Postman::class => [
          'label' => 'پستچی',
          'code' => 'postman'
        ],
        Payments::class => [
          'label' => 'پرداخت',
          'code' => 'payment'
        ],
        Packages::class => [
          'label' => 'بسته ها',
          'code' => 'servicePackages'
        ],
        Maps::class => [
          'label' => 'نقشه',
          'code' => 'MapsForm'
        ]
      ];
  }

}
