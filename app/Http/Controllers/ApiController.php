<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\MayarCustomer;
use App\MayarOrder;
use App\MayarService;
use App\ServiceUpgrades;
use App\MayarNotif;

class ApiController extends Controller
{
    //

    public function CustRegister(Request $request)
    {
        //validate Inputs
        $validate = Validator::make(request()->all(), [
            'CustFirstNameI'=>'required',
            'CustLastNameI'=>'required',
            'CustUserNameI'=>"required",
            'CustPassI'=>'required',
            'CustPass2I'=>'required',
            'CustMailI'=>'required',
            'CustCountryI'=>'required',
            'CustAddressI'=>'required'
        ]);

        if ($validate->fails()) {
            return response()->json(['err',['err'=>'0','message'=>$validate->messages()]]);
           
        }
        
        //Check If Email Used Before
        $getCustMail=MayarCustomer::where('Custmail',$request->input('CustMailI'))->count();
        if($getCustMail >0){
            return response()->json(['err',['err'=>'0','message'=>'mail is Already In Use']],403);
        }


        //Check If UserName Used Befor
        $getCustUserName=MayarCustomer::where('CustUserName',$request->input('CustUserNameI'))->count();
        if($getCustUserName >0){
            return response()->json(['err',['err'=>'0','message'=>'UserName is Already In Use']],403);
        }

        //Check If Passowrds Match
        if($request->input('CustPassI') != $request->input('CustPass2I')){
            return response()->json(['err',['err'=>'0','message'=>'Passwords Is Not Match']],403);
        }

        //generate Activation Token 
        $AcivationToken= md5(rand(1, 10) . microtime());

        //Save Customer
        $SaveCustomer=new MayarCustomer([
            'CustFirstName'=>$request->input('CustFirstNameI'),
            'CustLastName'=>$request->input('CustLastNameI'),
            'CustUserName'=>$request->input('CustUserNameI'),
            'CustPass'=>bcrypt($request->input('CustPassI')),
            'CustMail'=>$request->input('CustMailI'),
            'CustStatus'=>1, // Activated Can Log To It
            'CustCountry'=>$request->input('CustCountryI'),
            'CustAddress'=>$request->input('CustAddressI'),
            'CustActivationToken'=>$AcivationToken
        ]);
        $SaveCustomer->save();

        //Send Activation link to Customer mail



        //Send Success Response
        return response()->json(['err',['err'=>'1','message'=>'Customer Succsesfully Created ,Activate Your Account']], 200);
    }

    public function CustLogIn(Request $request)
    {

        //validate Inputs
        $validate = Validator::make(request()->all(), [
            'CustUserNameI'=>"required",
            'CustPassI'=>'required'
        ]);
        if ($validate->fails()) {
            return response()->json(['err',['err'=>'0','message'=>$validate->messages()]]);
        }

        //CheckCustomer
        if (!$token = Auth::guard('api')->attempt(
            array(
            'CustUserName'=>$request->input('CustUserNameI'),
            'password'=>$request->input('CustPassI')
            ))) {

        return response()->json(['error' => 'Unauthorized'], 401);

        }    
        return response()->json(['token' => $token,'expires' => auth('api')->factory()->getTTL() * 60,]);
    }



    public function CustInfo()
    {
        $Customer=Auth::guard('api')->user();
        
        return response()->json(['Customer'=>$Customer], 200,);
    }

    public function CustEdit(Request $request)
    {
        //get Customer Id
        $Cust=Auth::guard('api')->user();
        $CustId=$Cust['id'];

        //get Customer  
        $getCust=MayarCustomer::find($CustId);

        //Check IF Pass Is Match
        if($request->input('CustPassI') != $request->input('CustPass2I')){
            return response()->json(['err',['err'=>'0','message'=>'Passsword Not Match']], 200);
        }


        //Update Customer
        $UpdateCust=$getCust->update([
            'CustFirstName'=>$request->input('CustFirstNameI'),
            'CustLastName'=>$request->input('CustLastNameI'),
            'CustUserName'=>$request->input('CustUserNameI'),
            'CustPass'=>bcrypt($request->input('CustPassI')),
            'CustCountry'=>$request->input('CustCountryI'),
            'CustAddress'=>$request->input('CustAddressI'),
        ]);

        return response()->json(['err',['err'=>'1','message'=>'Customer Succesfully Updated']], 200);
    }




    public function CustLogOut()
    {
        Auth::guard('api')->logout();

        return response(200);
    }


    public function SaveOrder(Request $request)
    {
        //Validate Inputs
        $validate = Validator::make(request()->all(), [
            'ServiceIdI'=>'required',
            'ServiceUpgradesI'=>'required',
            'CustomerIdI'=>"required"
        ]);
        

        if ($validate->fails()) {
            return response()->json(['err',['err'=>'0','message'=>$validate->messages()]]);
        }

        //Check Customer
        $CheckCustomer=MayarCustomer::where([['id','=',$request->input('CustomerIdI')],['CustStatus','=','1']])->count();
        if($CheckCustomer ===0){
            return response()->json(['err',['err'=>'0','message'=>'Somthing Wrong']], 403);
        }

        //Check Service
        $CheckService=MayarService::where([['id','=',$request->input('ServiceIdI')],['ServiceStatus','=','1']])->get();
        $CheckService->load('ServiceProvider');
        $CountService=$CheckService->count();
        if($CountService ===0){
            return response()->json(['err',['err'=>'0','message'=>'Somthing Wrong']], 403);
        }
         

        // Check Service Upgrades
        $ServiceUpgradesArr=array();
        $ServiceUpgradesPriceArr=array();
        if($request->input('ServiceUpgradesI') !='null'){
            foreach (['1','2'] as $ServiceUpgrade) {
                $getUpgrade=ServiceUpgrades::where([['id','=',$ServiceUpgrade],['ServiceId','=',$request->input('ServiceIdI')]])->get();
                array_push($ServiceUpgradesArr,$getUpgrade[0]);
                array_push($ServiceUpgradesPriceArr,$getUpgrade[0]['UpgradePrice']);
               
            }
        }else{
            $ServiceUpgradesArr=[];
        }

        //Serialize Upgrades
        $SerializedUp=serialize($ServiceUpgradesArr);


        //Set TotalPrice
        $UpgradesArr=array_sum($ServiceUpgradesPriceArr);
        $ServicePrice=$CheckService[0]['ServicePrice'];
        $TotalPrice=$UpgradesArr+$ServicePrice;

        //Save Order
        $SaveOrder=new MayarOrder([
            'OrderServiceId'=>$request->input('ServiceIdI'),
            'OrderCustomerId'=>$request->input('CustomerIdI'),
            'OrderStatus'=>0, //Isnt Completed Status
            'OrderUpgradesId'=>$SerializedUp,
            'OrderPrice'=>$TotalPrice
        ]);
       $SaveOrder->save();


        //Add New Messages 



        //Add Notification To Provider
        $saveNotif=new MayarNotif([
            'NotifTargetType'=>1,
            'NotifTargetId'=>$CheckService[0]['ServiceProvider']['id'],
            'NotifValue'=>'You Got New Order From ',
            'NotifStatus'=>0
        ]);
        $saveNotif->save();

        return response()->json(['err',['err'=>'0','message'=>'Order Succesfully Created']], 200);
    }










}
