<?php
/**
 * Created by PhpStorm.
 * User: Ehsan
 * Date: 11/17/2018
 * Time: 10:25 AM
 */

use Sepehr\Details\Models\Sex;
use October\Rain\Database\Updates\Seeder;
use Sepehr\Details\Models\SpecialService;
use Sepehr\Details\Models\Weight;
use Sepehr\Details\Models\Acceptance;
use Sepehr\Details\Models\DistributionTime;
use Sepehr\Details\Models\InsuranceType;
use Sepehr\Details\Models\PackageType;
use Sepehr\Details\Models\PostType;
use Sepehr\Details\Models\Status;
use Sepehr\Details\Models\CountryCode;

class Seed extends Seeder
{
    /**
     *
     */
    public function run()
    {
        Sex::create(['name'=>'زن']);
        Sex::create(['name'=>'مرد']);

        Weight::create(['name'=>'کمتر از 250 گرم']);
        Weight::create(['name'=>'بین 250 گرم تا 500 گرم']);
        Weight::create(['name'=>'بین 1 کیلوگرم تا 2 کیلوگرم']);


        SpecialService::create(['name'=>'پیامک']);
        SpecialService::create(['name'=>'بازه زمانی']);


         CountryCode::create([
             'name'=>'ایران',
             'code'=>'+98',
             'placeholder'=>'',
             ]);

         Acceptance::create(['name'=>'نامشخص']);
         Acceptance::create(['name'=>'قبول']);
         Acceptance::create(['name'=>'رد']);


        PostType::create(['name'=>'عادی']);
        PostType::create(['name'=>'پیشتاز']);
        PostType::create(['name'=>'ویژه']);


        DistributionTime::create(['name'=>'بین 8 صبح تا 12 صبح']);
        DistributionTime::create(['name'=>'بین 14 تا 17']);



        PackageType::create(['name'=>'پاکت']);
        PackageType::create(['name'=>'جعبه']);


        Status::create(['name'=>'ثبت شده']);
        Status::create(['name'=>'ارجاع شده']);
        Status::create(['name'=>'قبول توسط مامور پست']);
        Status::create(['name'=>'در حال تحویل ']);



        InsuranceType::create(['name'=>'بیمه ایران']);
        InsuranceType::create(['name'=>'بیمه آسیا']);



    }
}