<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Auth;
use App\MayarNotif;
use App\MayarMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        view()->composer("includes.ProviderNavbar",function($view){

            

        //Check Target Type And TargetId
        $ServiceProviderTarget=Auth::guard('ServiceProvider')->user();

        $targetId=$ServiceProviderTarget['id'];
        $targetType=1;

        //get Notifications Where Status Is 0 Not Fetched Yet
        $getNotifProvider=MayarNotif::where([['NotifTargetType',$targetType],['NotifTargetId',$targetId],['NotifStatus',0]])->get();

        //get Messages Where Status Is 0 Not Fetched Yet
        $getMessages=MayarMessage::where([['MessageTargetType',$targetType],['MessageTarget',$targetId],['MessageStatus',0]])->get();
 
        
        $view->with(['ProviderNotifs'=>$getNotifProvider,'ProviderMessage'=>$getMessages]);
        
        });

        view()->composer("includes.BigBossNavbar",function($view){


        $targetType=0;

        //get Notifications Where Status Is 0 Not Fetched Yet
        $getNotifBigBoss=MayarNotif::where([['NotifTargetType',$targetType],['NotifStatus',0],['NotifTargetId','BigBoss']])->get();

        $view->with(["BigBossNotifs"=>$getNotifBigBoss]);

        });
    }
}
