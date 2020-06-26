<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MayarProvider;
use App\MayarCategory;

class BigBossController extends Controller
{
    //

    public function BigBossLoginGet(Request $request)
    {
        if(!empty($request->session()->get('authenticated'))){
            return redirect()->route('DashboardGet');
        }
        return view('BigBoss.LogIn');
    }


    public function BigBossLoginPost (Request $request)
    {

        if(!empty($request->session()->get('authenticated'))){
            return redirect()->route('DashboardGet');
        }
        //validate inputs
        $validate=$request->validate([
            'BigUserI'=>"required",
            'BigPassI'=>"required"
        ]);

        //Chek BigBoss Creds
        if ($validate['BigUserI'] === env('BIGBOSSU') && $validate['BigPassI'] === env('BIGBOSSP')) {
            $request->session()->put('authenticated', time());
            return redirect()->route("DashboardGet");
        }
        return "Somthing Worng";
    }



    public function DashboardGet()
    {
        return view('BigBoss.Dashboard');
    }

    public function LogOut(Request $request){ 
         $request->session()->forget('authenticated');
          return redirect('/');
    }


    public function ProviderListGet()
    {
        //get Providers
        $getProviders=MayarProvider::all();
        return view('BigBoss.ProviderList',['Providers'=>$getProviders]);
    }

    public function SaveProvider(Request $request)
    {
       //Validate Inputs
        $validate=$request->validate([
            'ProviderNameI'=>'required',
            'ProviderUserNameI'=>'required',
            'ProviderPasswordI'=>'required',
            'ProviderIconSrcI'=>'required',
            'ProviderDescI'=>'required'
        ]);

        //Check If Provider UserName Is Available 
        $CheckProvier=MayarProvider::where('ProviderName',$validate['ProviderNameI'])->count();
        if($CheckProvier > 1){
            return  redirect()->route('DashboardGet')->with('err',['err'=>'0','message'=>'Provider UserName Is Already In Use']);
        }

        //Save Provider
        $SaveProvider=new MayarProvider([
            "ProviderName"=>$validate['ProviderNameI'],
            "ProviderUserName"=>$validate['ProviderUserNameI'],
            "ProviderPass"=>bcrypt($validate['ProviderPasswordI']),
            "ProviderIconSrc"=>$validate['ProviderIconSrcI'],
            "ProviderDesc"=>$validate['ProviderDescI'],
            "ProviderServiceNum"=>0
        ]);
        $SaveProvider->Save();

        return redirect()->route('DashboardGet')->with('err',['err'=>'1','message'=>'Provider Succesfully Saved']);
    }

    public function UpdateProvider(Request $request)
    {
       //validate inputs
       $validate=$request->validate([
        'ProviderNameUI'=>'required',
        'ProviderUserNameUI'=>'required',
        'ProviderIconSrcUI'=>'required',
        'ProviderDescUI'=>'required',
        'UpdateProviderId'=>'required'
       ]);
       
       //Check Provider And Update
       $getProvider=MayarProvider::find($validate['UpdateProviderId']);
       if(!empty($getProvider)){

       //Update Provider
       $getProvider->update([
           'ProviderName'=>$validate['ProviderNameUI'],
           'ProviderUserName'=>$validate['ProviderUserNameUI'],
           'ProviderIconSrc'=>$validate['ProviderIconSrcUI'],
           'ProviderDesc'=>$validate['ProviderDescUI']
       ]);

       return redirect()->route('DashboardGet')->with('err',['err'=>'1','message'=>'Provider Succesfully Updated']);

       }
       else{
        return redirect()->route('DashboardGet')->with('err',['err'=>'0','message'=>'Somthing Wrong']);
       }

    }

    public function ProviderOne(Request $request)
    {
        //validate inputs
        $validate=$request->validate([
            'ProviderId'=>'required'
        ]);

        //Check And get Provider
        $getProvider=MayarProvider::find($validate['ProviderId']);
        if(!empty($getProvider)){
        return response()->json($getProvider, 200);
        }
        else{
            return response()->json('Somthing Wrong',404);
        }
    
    }

    public function DelProvider(Request $request)
    {

                //validate Inputs
                $validate=$request->validate([
                    'BigBossPassI'=>'required',
                    'ProviderId'=>'required'
                ]);
        
                //Check BigBoss Pass
                if($validate['BigBossPassI'] != env('BIGBOSSP')){
          
                    return redirect()->route('DashboardGet')->with('err',['err'=>'0','message'=>'BigBoss Passowrd Is Not Valid']);
        
                }
        
                //Check Provider And They have No Services
                $CheckProvider=MayarProvider::find($validate['ProviderId']);
                if(!empty($CheckProvider) && $CheckProvider['ProviderServiceNum'] ==0 ){
                    
                //Delete Provider
                $CheckProvider->delete();
         
                return redirect()->route('DashboardGet')->with('err',['err'=>'1','message'=>'Provider Succesfully Deleted']);
                }
                else{
                
                return redirect()->route('ProviderList')->with('err',['err'=>'0','message'=>'Somthing Wrong']);
                }
        return $request->all();
    }


    public function CategoryListGet()
    {

        //get Categories
        $getCategories=MayarCategory::all();

        return view('BigBoss.CategoryList',['Categories'=>$getCategories]);
    }

    public function SaveCategory(Request $request)
    {
        //validate Inputs
        $validate=$request->validate([
            'CategoryNameI'=>'required'
        ]);

        //Check If Category Is Available
        $CheckCategory=MayarCategory::where('CategoryName',$validate['CategoryNameI'])->count();

        if($CheckCategory >1){
            return redirect()->route('DashboardGet')->with('err',['err'=>'0','message'=>'Category Is Already In Use']);
        }

        //Save Category
        $SaveCategory=new MayarCategory([
            'CategoryName'=>$validate['CategoryNameI'],
            'CategoryServiceNum'=>0
        ]);
        $SaveCategory->save();

        return redirect()->route('DashboardGet')->with('err',['err'=>'1','message'=>'Category Succesfully Saved']);

    }

    public function DelCategory(Request $request)
    {

        //validate Inputs
        $validate=$request->validate([
            'BigBossPassI'=>'required',
            'CatId'=>'required'
        ]);

        //Check BigBoss Pass
        if($validate['BigBossPassI'] != env('BIGBOSSP')){
            return redirect()->route('DashboardGet')->with('err',['err'=>'0','message'=>'BigBoss Passowrd Is Not Valid']);
        }

        //Check Category And They have No Services
        $CheckCategory=MayarCategory::find($validate['CatId']);
        if(!empty($CheckCategory) && $CheckCategory['CategoryServiceNum'] ==0 ){
        //Delete Category
        $CheckCategory->delete();
 
        return redirect()->route('DashboardGet')->with('err',['err'=>'1','message'=>'Category Succesfully Deleted']);
        }
        else{
        
        return redirect()->route('CategoryList')->with('err',['err'=>'0','message'=>'Somthing Wrong']);
        }

    }

    public function CategoryOne(Request $request)
    {
        //validate Input
        $validate=$request->validate([
            'CatId'=>'required'
        ]);

        //Chcek Category
        $getCategory=MayarCategory::find($validate['CatId']);

        if(!empty($getCategory)){
            
        return response()->json($getCategory, 200);

        }else{
            return response()->json('Somthing Wrong',404);
        }

    }

    public function UpdateCategory(Request $request)
    {

        //validate Inputs
        $validate=$request->validate([
            'CategoryNameUpdateI'=>'required',
            'UpdateCatId'=>'required'
        ]);

        //Check Category And Update 
        $getCategory=MayarCategory::find($validate['UpdateCatId']);

        if(!empty($getCategory)){
        
        //Update Category
        $getCategory->update([
            "CategoryName"=>$validate['CategoryNameUpdateI']
        ]);
        return redirect()->route('DashboardGet')->with('err',['err'=>'1','message'=>'Category Succsesfully updated']);
        }
        else{
        return redirect()->route('DashboardGet')->with('err',['err'=>'0','message'=>'Somthing Wrong']);
        }
        
    }


}
