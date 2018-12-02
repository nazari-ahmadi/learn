<?php namespace Sepehr\Service\Components;

use Cms\Classes\ComponentBase;
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

    $services = Service::
    where('sender_postal_code', 'like', "%$sender_postal_code%")->
    where('sender_address', 'like', "%$sender_address%")->
    where('transaction_code', 'like', "%$transaction_code%")->
    whereIn()->
    whereIn("weight_id",'like',"%$weight_id%")->

    get();
    throw new \ApplicationException(json_encode($services));
  }


  public function onRun()
  {
    $this->preVars();
  }
}
