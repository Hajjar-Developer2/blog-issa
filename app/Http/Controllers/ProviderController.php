<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\MayarCategory;
use App\MayarService;
use App\MayarProvider;
use App\MayarOrder;

class ProviderController extends Controller
{
    //

    public function ProviderLoginGet()
    {
        //Protect Route
        if(!empty(Auth::guard('ServiceProvider')->user())){
            return redirect()->route('ProviderDashboard');
        }

        return view('Providers.LogIn');
    }

    public function ProviderLoginPost(Request $request)
    {
        //Protect Route
        if(!empty(Auth::guard('ServiceProvider')->user())){
            return redirect()->route('ProviderDashboard');
        }

        //validate Inputs
        $validate=$request->validate([
            'ProviderUserI'=>'required',
            'ProviderPassI'=>'required'
        ]);


        //Check Provider 
        if(Auth::guard('ServiceProvider')->attempt(
            array(
            'ProviderUserName'=>$validate['ProviderUserI'],
            'password'=>$validate['ProviderPassI']
            ))){
                return redirect()->route('ProviderDashboard');        
            }
            else{
                return redirect()->route('ProviderLoginGet')->with('err',['err'=>'1','Username Or Password Is Wrong']);
            }
    }

    public function ProviderLogOut()
    {
        Auth::guard('ServiceProvider')->logOut();

        return redirect('/');
    }

    public function ProviderDashboard()
    {
        return view('Providers.Dashboard');
    }

    public function getCatProAjax(Request $request)
    {
        //get Categories
        $getCategory=MayarCategory::all();
        
        //get Providers
        $getProvider=MayarProvider::all();

        return response()->json(['Categories'=>$getCategory,'Providers'=>$getProvider], 200,);

        
    }

    public function ServiceListGet()
    {
        //get Services
        $getServices=MayarService::all();
        $getServices->load('Category');
        $getServices->load('ServiceProvider');
        $getServices->load('Upgrades');
        $getServices->load('Comments.Customer');

        return $getServices;
    }


    public function SaveService(Request $request)
    {
	 	
        //validate Inputs
        $validate=$request->validate([
            'ServiceNameI'=>'required',
            'ServiceThumbnailI'=>'required',
            'ServicePriceI'=>'required',
            'ServiceCatI'=>'required',
            'ServiceDescI'=>'required',
        ]);


        //get Provider Id From Session
        $ProviderId=Auth::guard('ServiceProvider')->user();

        //Save Service
        $SaveService=new MayarService([
            'ServiceName'=>$validate['ServiceNameI'],
            'ServiceThumb'=>$validate['ServiceThumbnailI'],
            'ServicePrice'=>$validate['ServicePriceI'],
            'ServiceProviderId'=>$ProviderId['id'],
            'ServiceCatId'=>$validate['ServiceCatI'],
            'ServiceDesc'=>$validate['ServiceDescI'],
            'ServiceOrderdNum'=>0,
            'ServiceStatus'=>0
        ]);
        $SaveService->save();

        // find Category And Increase Service Num In Category +1
        $getCategory=MayarCategory::find($validate['ServiceCatI']);
        if(!empty($getCategory)){
            $Plus1=$getCategory['CategoryServiceNum']+1;
            $UpdateCategory=$getCategory->Update([
                'CategoryServiceNum'=>$Plus1
            ]);
        }

        // find Provider And Increase Service Num In Provider +1
        $getProvider=MayarProvider::find($ProviderId['id']);
        if(!empty($getProvider)){
            $PlusProv=$getProvider['ProviderServiceNum']+1;

            $UpdateProvider=$getProvider->update([
                'ProviderServiceNum'=>$PlusProv
            ]); 
        }

        return redirect()->route('ProviderDashboard')->with('err',['err'=>'1','message'=>'Service Succesfully Saved']);
    }


    public function OrderListGet()
    {
        //get Provider 
        $getProvider=Auth::guard('ServiceProvider')->user();


        //get Orders 
        $getOrders=MayarOrder::where('OrderTargetId',$getProvider['id'])->get();
        $getOrders->load('Customer');
        $getOrders->load('Service');
        $getOrders->load('Files');

        //Transform Service Upgrades
        $transformUpgrades= $getOrders->transform(function($Upgrade){ 
            $Upgrade->OrderUpgradesId=unserialize($Upgrade->OrderUpgradesId);
            return $Upgrade;
          });


          //get Total Price
          $PriceArr=array();
          if(!empty($transformUpgrades[0]['OrderUpgradesId'])){
            foreach ($transformUpgrades[0]['OrderUpgradesId'] as $Upgrades ) {
                array_push($PriceArr,$Upgrades['UpgradePrice']); 
              }
              $UpgradesPrice=array_sum($PriceArr);
          }
          else{
              $UpgradesPrice='';
          }
          $ServicePrice=$transformUpgrades[0]['Service']['ServicePrice'];
          $totalPrice=$ServicePrice+$UpgradesPrice;


        return view('Providers.OrdersList',['Orders'=>$transformUpgrades,'totalPrice'=>$totalPrice]);

    }
}
