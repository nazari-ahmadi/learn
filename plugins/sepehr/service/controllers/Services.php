<?php namespace Sepehr\Service\Controllers;

use Backend\Classes\Controller;
use Backend\Models\User;
use BackendMenu;
use RainLab\User\Models\User as FrontUser;
use ApplicationException;
use Sepehr\Details\Models\Acceptance;
use Sepehr\Details\Models\DistributionTime;
use Sepehr\Details\Models\InsuranceType;
use Sepehr\Details\Models\PackageType;
use Sepehr\Details\Models\PaymentType;
use Sepehr\Details\Models\PostType;
use Sepehr\Details\Models\SpecialService;
use Sepehr\Details\Models\Status;
use Sepehr\Details\Models\Weight;
use ValidationException;

class Services extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController'
    ];

    public $requiredPermissions = ['sepehr.service.access_service'];
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Sepehr.Service', 'services', 'service');
    }


    public function formBeforeCreate($model)
    {
        $model->manage_id = $this->user->id;
        foreach ($model->packages as $package) {
            $package->is_rejected = false;
        }
    }

    public function beforeCreatePackage($package,$id)
    {
        switch ($package){
            case !$package[$id]['receiver_postal_code']:
                throw new ValidationException(['receiver_postal_code' => 'لطفا کد پستی مقصد را وارد کنید.']);
                break;
            case !$package[$id]['receiver_address']:
                throw new ValidationException(['receiver_address' => 'لطفا آدرس مقصد را وارد کنید.']);
                break;
            case !$package[$id]['weight_id']:
                throw new ValidationException(['weight_id' => 'لطفا وزن بسته را انتخاب کنید.']);
                break;
            case !$package[$id]['post_type_id']:
                throw new ValidationException(['post_type_id' => 'لطفا نوع ارسال را انتخاب کنید.']);
                break;
            case !$package[$id]['package_type_id']:
                throw new ValidationException(['package_type_id' => 'لطفا نوع بسته را انتخاب کنید.']);
                break;
            case !$package[$id]['insurance_type_id']:
                throw new ValidationException(['insurance_type_id' => 'لطفا نوع بیمه را انتخاب کنید.']);
                break;
        }
    }


  public function findPostman($id)
  {
    $user=\RainLab\User\Models\User::find($id);
    return $user;
  }
    public function beforeSaveService($service)
    {
        switch ($service){
            case !$service->sender_postal_code:
                throw new ValidationException(['sender_postal_code' => 'لطفا کد پستی خود را وارد کنید.']);
                break;
            case !$service->sender_address:
                throw new ValidationException(['sender_address' => 'لطفا آدرس خود را وارد کنید.']);
                break;
            case !$service->packages:
                throw new ValidationException(['' => 'لطفا بسته های مورد نظر خود را تعیین کنید.']);
                break;
        }
    }

    public function getType($type,$id)
    {
        switch ($type){
            case 'post_type':
                return PostType::find($id)->name;
            case 'package_type':
                return PackageType::find($id)->name;
            case 'insurance_type':
                return InsuranceType::find($id)->name;
            case 'payment_type':
                return PaymentType::find($id)->name;
            case 'special_service':
                return SpecialService::find($id)->name;
            case 'weight':
                return Weight::find($id)->name;
            case 'distribution_time':
                return DistributionTime::find($id)->name;
            case 'status':
                return Status::find($id)->name;
            case 'acceptance':
                return Acceptance::find($id)->name;
            case 'postman':
                $user = FrontUser::whereId($id)->get()->first();
                return ($user->first_name . ' ' . $user->last_name);
        }
    }
}
