<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;
use App\MayarNotif;
use App\MayarMessage;
use Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
 
    public function ChangeNotif(Request $request)
    {

        //validate Input
        $validate = Validator::make(request()->all(), [
            'Type'=>'required',
        ]);

    
        if ($validate->fails()) {
            return response()->json(['err',['err'=>'0','message'=>$validate->messages()]]); 
        }



        //Check Type Of The Target Who Open The DropDown
        if($request->input('Type') === "Provider"){

            //Get Target Data
            $ServiceProviderTarget=Auth::guard('ServiceProvider')->user();
            $targetId=$ServiceProviderTarget['id'];

            
            //get Notifications Where Status Is 0 Not Fetched Yet
            $getNotif=MayarNotif::where([['NotifTargetType',1],['NotifTargetId',$targetId],['NotifStatus',0]])->get();

        }

        if($request->input('Type') === "BigBoss"){

            //get Target Data
            $BigBossTarget=$request->session()->get('Authenticated');
            
            //get Notifications Where Status Is 0 Not Fetched Yet
            $getNotif=MayarNotif::where([['NotifTargetType',0],['NotifTargetId','BigBoss'],['NotifStatus',0]])->get();

        }

        //Update Notification Status to 1 => Displayed On View
        foreach ($getNotif as $Notif ) {

            $NotifOne=mayarNotif::find($Notif['id']);
            //Update Notif
            $NotifOne->Update([
                'NotifStatus'=>1
            ]);
        }

        return response()->json(200);

    }

    public function getMessages(Request $request)
    {
        //get Messages
        $getMessages=MayarMessage::all();

        return response()->json($getMessages, 200);
    }



}
