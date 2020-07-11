<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

use App\Mail\CustActivateMail;
use App\Mail\CustRestPassMail;
use App\MayarCustomer;
use App\MayarOrder;
use App\MayarService;
use App\ServiceUpgrades;
use App\MayarNotif;
use App\MayarMessage;
use App\MayarFile;

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
        ]);

        if ($validate->fails()) {
            return response()->json(['err',['err'=>'0','message'=>'ValidationErr']],400);
 
        }
        
        //Check If Email Used Before
        $getCustMail=MayarCustomer::where('Custmail',$request->input('CustMailI'))->count();
        if($getCustMail >0){
            return response()->json(['err',['err'=>'0','message'=>'MailUsedErr']],400);
        }


        //Check If UserName Used Befor
        $getCustUserName=MayarCustomer::where('CustUserName',$request->input('CustUserNameI'))->count();
        if($getCustUserName >0){
            return response()->json(['err',['err'=>'0','message'=>'UserNameUsedErr']],400);
        }

        //Check If Passowrds Match
        if($request->input('CustPassI') != $request->input('CustPass2I')){
            return response()->json(['err',['err'=>'0','message'=>'PasswordNotMatchErr']],400);
        }

        //generate Activation Token 
        $AcivationToken= md5(rand(1, 10) . microtime());
        $PassRestToken=md5(rand(1, 12) . microtime());

        //Save Customer
        $SaveCustomer=new MayarCustomer([
            'CustFirstName'=>$request->input('CustFirstNameI'),
            'CustLastName'=>$request->input('CustLastNameI'),
            'CustUserName'=>$request->input('CustUserNameI'),
            'CustPass'=>bcrypt($request->input('CustPassI')),
            'CustMail'=>$request->input('CustMailI'),
            'CustStatus'=>0, // Not Activated Need Activation
            'CustCountry'=>$request->input('CustCountryI'),
            'CustAddress'=>$request->input('CustAddressI'),
            'CustActivationToken'=>$AcivationToken,
            'CustPassRestToken'=>$PassRestToken,
            'CustPassRestExpire'=>1
        ]);

        $SaveCustomer->save();

        //Send Activation link to Customer mail
        $ActivationUrl=config('getEnv.ActivateUrl');
        Mail::to($SaveCustomer['CustMail'])->send(new CustActivateMail($AcivationToken,$ActivationUrl));


        //Send Success Response
        return response()->json(['err',['err'=>'1','message'=>'CustRegisterSuccessErr']], 201);
    }



    public function CustLogIn(Request $request)
    {

        //validate Inputs
        $validate = Validator::make(request()->all(), [
            'CustUserNameI'=>"required",
            'CustPassI'=>'required'
        ]);
        if ($validate->fails()) {
            return response()->json(['err',['err'=>'0','message'=>'ValidationErr']],400);
        }

        //Chcek UserName Input Value
        //LogIn With Email
         if(filter_var($request->input('CustUserNameI'), FILTER_VALIDATE_EMAIL)){
            if (!$token = Auth::guard('api')->attempt(
                array(
                'CustMail'=>$request->input('CustUserNameI'),
                'password'=>$request->input('CustPassI')
                ))) {
    
            return response()->json(['err'=>['err'=>'1','message' => 'UnauthorizedErr']], 401);
    
            }    

            //get Customer
            $getCust=Auth::guard('api')->user();
            
            return response()->json([ 'err'=>'0','Customer'=>$getCust,'token' => $token,'expires' => auth('api')->factory()->getTTL() * 60,]);
         }
         //LogIn With UserName
         else{
            if (!$token = Auth::guard('api')->attempt(
                array(
                'CustUserName'=>$request->input('CustUserNameI'),
                'password'=>$request->input('CustPassI')
                ))) {


            return response()->json(['err' =>['err'=>'1','message'=>'UnauthorizedErr']], 401);
    
            }    

            //get Customer
            $getCust=Auth::guard('api')->user();

            return response()->json([ 'err'=>'0','Customer'=>$getCust,'token' => $token,'expires' => auth('api')->factory()->getTTL() * 60,]);

         }
        

        //CheckCustomer

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

        return response()->json(['err',['err'=>'1','message'=>'CustUpdatedSuccesErr']], 200);
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
            return response()->json(['err',['err'=>'0','message'=>'ValidationErr']],400);
        }

        //Check Customer
        $CheckCustomer=MayarCustomer::where([['id','=',$request->input('CustomerIdI')],['CustStatus','=','1']])->count();
        if($CheckCustomer ===0){
            return response()->json(['err',['err'=>'0','message'=>'SWErr']], 500);
        }

        //Check Service
        $CheckService=MayarService::where([['id','=',$request->input('ServiceIdI')],['ServiceStatus','=','1']])->get();
        $CheckService->load('ServiceProvider');
        $CountService=$CheckService->count();
        if($CountService ===0){
            return response()->json(['err',['err'=>'0','message'=>'SWErr']], 500);
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
            'OrderPrice'=>$TotalPrice,
            'OrderTargetId'=>$CheckService[0]['ServiceProvider']['id']
        ]);
       $SaveOrder->save();

       //Create New Folder For The Order
       Storage::cloud()->makeDirectory($SaveOrder['id']);

       //get Folder BaseName
       $dir = '/';
       $recursive = false; // Get subdirectories also?
       $contents = collect(Storage::cloud()->listContents($dir, $recursive));
   
       $OrderDir = $contents->where('type', '=', 'dir')
           ->where('filename', '=',$SaveOrder['id'])
           ->first(); // There could be duplicate directory names!
   
       // Update Folder Column
       $SaveOrder->update([
           'OrderFolder'=>$OrderDir['basename']
       ]);

       //Check If Have Files  
       if(!empty($request->input('FilesArr'))){


        $FileArr = explode(",", $request->input('FilesArr'));
        foreach ($FileArr as $File) {

            //Update OrderID On DB
            $getFile=MayarFile::find($File);
            $getFile->Update([
                'OrderId'=>$SaveOrder['id']
            ]);

            //Move Files To Folder
            $contents2 = collect(Storage::cloud()->listContents($dir, $recursive));
   
            $StorageFile = $contents2->where('type', '=', 'file')
                ->where('basename', '=',$getFile['BaseName'])
                ->first(); // There could be duplicate directory names!
        
            $FileMove=Storage::cloud('google')->move($StorageFile['basename'],$OrderDir['basename'].'/'.$StorageFile['name']);
            //$FileMove=Storage::cloud()->move($StorageFile,$OrderDir['filename'].'/'.$StorageFile);   
        }
       }

        //Add New Messages 



        //Add Notification To Provider
        $saveNotif=new MayarNotif([
            'NotifTargetType'=>1,
            'NotifTargetId'=>$CheckService[0]['ServiceProvider']['id'],
            'NotifValue'=>'You Got New Order From ',
            'NotifStatus'=>0
        ]);
        $saveNotif->save();

        return response()->json(['err',['err'=>'0','message'=>'SaveOrderSuccesErr']], 201);
    }







    public function UploadFile(Request $request)
    {
        set_time_limit(300);
        $dir='1_8XuOgF9HIeYjunKlI38y3e2IxDHA-Ry';

       //Check Input
       if($request->hasFile("FileI")){

        //get Orgenal FIle Name 
        $OFilename=$request->file('FileI')->getClientOriginalName();
       
       //Upload File To Cache Folder 
        $filename=Storage::cloud()->put($dir,$request->file("FileI"),file_get_contents($request->file('FileI')));
    
        //get Uploaded File BaseName 
        $recursive = false; // Get subdirectories also?
        $contents = collect(Storage::cloud()->listContents($dir, $recursive));
        $file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
            ->first(); // there can be duplicate file names! 
  
      
        // Save File Info On DB
        $SaveFile=new MayarFile([
            'BaseName'=>$file['basename'],
            'FileName'=>pathinfo($OFilename, PATHINFO_FILENAME),
            'StorageName'=>$file['filename'],
            'Ext'=>$file['extension'],
            'FileSource'=>0,
        ]);
        $SaveFile->save();

        return response()->json(['err',['err'=>'0','message'=>'FileUploadSucessErr','File'=>$SaveFile]], 201);

       }
       else{
        return response()->json(['err',['err'=>'0','message'=>'ValidationErr']], 400);
       }

    }


    public function SaveMessage(Request $request)
    {
        //Validate Inputs
        $validate = Validator::make(request()->all(), [
            'MessageTargetI'=>'required',
            'MessageTargetTypeI'=>'required',
            'MessageSourceI'=>'required',
            'MessageSourceTypeI'=>'required',
            'MessageValueI'=>"required",
            'MessageOrderIdI'=>'required'
        ]);
        

        if ($validate->fails()) {
            return response()->json(['err',['err'=>'0','message'=>'ValidationErr']],400);
        }

        //CheckOrder
        $getOrder=MayarOrder::find($request->input('MessageOrderIdI'));
   
        if(empty($getOrder)){
            
            return response()->json(['err',['err'=>'1','message'=>'SWErr']], 500);
        }

        //Save Message 
        $saveMessage=new MayarMessage([
            'MessageTarget'=>$request->input('MessageTargetI'),
            'MessageTargetType'=>$request->input('MessageTargetTypeI'),
            'MessageSource'=>$request->input('MessageSourceI'),
            'MessageSourceType'=>$request->input('MessageSourceTypeI'),
            'MessageValue'=>$request->input('MessageValueI'),
            'MessageStatus'=>0, //Not Fetched Yet
            'MessageOrderId'=>$request->input('MessageOrderIdI')
        ]);
        $saveMessage->save();
        return response()->json(['err',['err'=>'0','message'=>'MessageSendSuccsErr']], 201);

    }

    public function CustActivate(Request $request)
    {
        
                //Validate Inputs
                $validate = Validator::make(request()->all(), [
                    'ActivateCodeI'=>'required',
                ]);
                
        
                if ($validate->fails()) {
                    return response()->json(['err',['err'=>'0','message'=>'ValidationErr']],400);
                }

                //get Customer who have Token 
                $getCust=MayarCustomer::where('CustActivationToken','=',$request->input('ActivateCodeI'))->first();

                //Check Customer And Change Status To 1 => Activated
                if(!empty($getCust)){
                    $getCust->update(['CustStatus'=>1]);

                    return response()->json(['err',['err'=>'1','message'=>'ActivatedCustSuccesErr']],200);
                }
                else{
                    return response()->json(['err',['err'=>'0','message'=>'SWErr']],500);
                }
    }

    public function CustPassRestReq(Request $request)
    {

        //Validate Inputs
        $validate = Validator::make(request()->all(), [
            'CustMailI'=>'required',
        ]);
        

        if ($validate->fails()) {
            return response()->json(['err',['err'=>'0','message'=>'ValidationErr']],400);
        }
        
        //get Customer By Mail 
        $getCustomer=MayarCustomer::where([['CustMail',$request->input('CustMailI')],['CustStatus','1']])->first();

        //Check Mail And Send Rest Mail Message To it
        if(!empty($getCustomer)){

            $RestUrl=config('getEnv.RestPassUrl');
            $RestToken=$getCustomer['CustPassRestToken'];
            Mail::to($getCustomer['CustMail'])->send(new CustRestPassMail($RestToken,$RestUrl));

            return response()->json(['err',['err'=>'1','message'=>'RestMsgSendSuccesErr']],200);
        }
        else{
            return response()->json(['err',['err'=>'0','message'=>'SWErr']],500);
        }
        
    }

    public function CustRestPassExec(Request $request)
    {
    
    //validate inputs 
    $validate = Validator::make(request()->all(), [
        'RestPassTokenI'=>'required',
        'RestPass1I'=>'required',
        'RestPass2I'=>'required'
    ]);
    
    if ($validate->fails()) {
        return response()->json(['err',['err'=>'0','message'=>'ValidationErr']],400);
    }
    
    //get Customer By Rest Password
    $getCustomer=MayarCustomer::where([['CustPassRestToken',$request->input('RestPassTokenI')],['CustStatus','1']])->first();

 

        //Check if Passowrds matche
        if($request->input('RestPass1I') === $request->input('RestPass2I')){

                //Check Customer And Update Password
                if(!empty($getCustomer)){

                    $getCustomer->update(['CustPass'=>bcrypt($request->input('RestPass1I'))]);
                    return response()->json(['err',['err'=>'1','message'=>'UpdatPassSuccesErr']],200);

                }
                else{
                    return response()->json(['err',['err'=>'0','message'=>'SWErr']],500);
                }
        
        }
        else{
            return response()->json(['err',['err'=>'0','message'=>'RestPassNotMatchErr']],403);
        }
    }


}
