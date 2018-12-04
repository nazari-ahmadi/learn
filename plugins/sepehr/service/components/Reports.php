<?php namespace Sepehr\Service\Components;

use Auth;
use Cms\Classes\ComponentBase;
use DB;
use Sepehr\Details\Models\DistributionTime;
use Sepehr\Details\Models\InsuranceType;
use Sepehr\Details\Models\PackageType;
use Sepehr\Details\Models\PostType;
use Sepehr\Details\Models\SpecialService;
use Sepehr\Details\Models\Weight;
use Sepehr\Service\Models\Service;

class Reports extends ComponentBase
{
  public function componentDetails()
  {
    return [
      'name' => 'Reports Component',
      'description' => 'No description provided yet...'
    ];
  }


  public function defineProperties()
  {
    return [];
  }

  public function preVars()
  {
    $this->page['weight'] = Weight::orderBy('name')->get();
    $this->page['postTypes'] = PostType::orderBy('name')->get();
    $this->page['packageTypes'] = PackageType::orderBy('name')->get();
    $this->page['insurancesTypes'] = InsuranceType::orderBy('name')->get();
    $this->page['distributionTimes'] = DistributionTime::orderBy('name')->get();
    $this->page['specialServices'] = SpecialService::orderBy('name')->get();
  }

  public function onReports()
  {
    $sender_postal_code = post('sender_postal_code');
    $sender_address = post('sender_address');
    $transaction_code = post('transaction_code');
    $weight_id = post('weight_id');
    $receiver_postal_code = post('receiver_postal_code');
    $receiver_address = post('receiver_address');
    $post_type_id = post('post_type_id');
    $distribution_time_id = post('distribution_time_id');
    $special_services_id = post('special_services_id');
    $package_type_id = post('package_type_id');
    $insurance_type_id = post('insurance_type_id');

//    "weight_id":"5455"
//    "receiver_address": "تهران"
//      "weight_id":"$weight_id"

    if ($weight_id != "0") {
      $weight = "$weight_id";
    } else {
      $weight = null;
    }

    if ($receiver_postal_code != null) {
      $receiverPostalCode = $receiver_postal_code;
    } else {
      $receiverPostalCode = null;
    }

    if ($receiver_address != null) {
      $receiverAddress = "$receiver_address";
    } else {
      $receiverAddress = null;

    }

    if ($post_type_id != "0") {
      $postType = "$post_type_id";
    } else {
      $postType = null;
    }

    if ($distribution_time_id != "0") {
      $distributionTime = "$distribution_time_id";
    } else {
      $distributionTime = null;
    }
    if ($special_services_id != "0") {
      $specialServices = "$special_services_id";
    } else {
      $specialServices = null;
    }
    if ($package_type_id != "0") {
      $packageType = "$package_type_id";
    } else {
      $packageType = null;
    }
    if ($insurance_type_id != "0") {
      $insuranceType = "$insurance_type_id";
    } else {
      $insuranceType = null;
    }


    $user = Auth::getUser()->id;
    $services = Service::
    where('user_id', $user)
      ->where('sender_postal_code', 'like', "%$sender_postal_code%")
      ->where('sender_address', 'like', "%$sender_address%")
      ->where('transaction_code','like', "%$transaction_code%")
      ->where('packages', 'like', "\"weight_id\":$weight%")
        /*->where('packages', 'like', "%\"receiver_postal_code\":$receiverPostalCode%")
        ->where('packages', 'like', "%\"receiver_address\":$receiverAddress%")
        ->where('packages', 'like', "%\"post_type_id\":$postType%")
        ->where('packages', 'like', "%\"distribution_time_id\":$distributionTime%")
        ->where('packages', 'like', "%\"special_services_id\":$specialServices%")
        ->where('packages', 'like', "%\"package_type_id\":$packageType%")
        ->where('packages', 'like', "\"insurance_type_id\":$insuranceType%") */
      ->get();
    throw new \ApplicationException(json_encode($services));
    $this->page['result'] = $services;
  }


  public function onRun()
  {
    $this->preVars();
  }
}
