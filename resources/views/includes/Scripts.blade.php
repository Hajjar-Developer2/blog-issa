
<Script>
    
//Toast Start
var lang = "{{str_replace('_','-',app()->getLocale()) }}";

 if(lang ==="en"){
    toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "8000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
 }
 else{
  toastr.options = {
  "closeButton": true,
  "debug": false,
  "newestOnTop": true,
  "progressBar": false,
  "positionClass": "toast-top-left",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "8000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}
 }



var Timer=4000;

setTimeout(() => {

  // toastr["info"]("Message", "Hello")

$.ajax({
  method:"post",
  data:{  _token:"{{csrf_token()}}"  },
  url:"{{ route('getMessages') }}",
  success:function(data){
        data.forEach(Message => {
          toastr["info"](Message['MessageValue'], "Hello")
        });
    console.log(data)
  }
})
  

}, Timer);



//Toast End


//Change All Notificateion Status  When Click On Dropdown 

$(document).on('click','.NotifDrop',function(){

  //get Target Type
  var Type=$(this).data('type');

  $.ajax({
  method:'post',
  url:"{{ route('ChangeNotifPost') }}",
  data:{Type:Type,_token:"{{ csrf_token() }}"}})

})

//End Change All Notificateion Status  When Click On Dropdown 



 //get Categories And Providers for AddService Form

$(document).on('click',".AddService",function(){

function list(list,type) {
    let list1="";

    if(type == "Category"){
        list.map((item)=>{
      list1 += '<option value="'+item.id+'" >'+item.CategoryName+'</option>';
    });
    return list1;
    }
}

$.ajax({
  method:'post',
  url:"{{ route('getCatProAjax') }}",
  data:{_token:"{{ csrf_token() }}"},
  success:function(data){     
    

            var Categories=list(data['Categories'],'Category');
            $(".CategoryInput").html(Categories)
  }
})
})

//End get Categories And Providers for AddService Form


//get Category Id for Delete CategoryModal

$(document).on('click','.CatDelBut',function(){
  var CatId=$(this).data('catid');

  $('input[name="CatId"]').val(CatId);
})

// end get Category Id for Delete CategoryModal



//get Category Data for Update CategoryModal


$(document).on('click','.UpdateCatBut',function(){
  var UpdateCatId=$(this).data('catid');

  $('.UpdateCategorySpinner').show();
  $('.UpdateCategoryForm').hide();

  $.ajax({
  method:'post',
  url:"{{ route('CategoryOne') }}",
  data:{CatId:UpdateCatId,_token:"{{ csrf_token() }}"},
  success:function(data){   

     $('.UpdateCategoryForm').show();
     $('.UpdateCategorySpinner').hide();  
  
    $('input[name="UpdateCatId"]').val(UpdateCatId);
    $('input[name="CategoryNameUpdateI"]').val(data.CategoryName);
  }
})
})


//End get Category Id for Update CategoryModal


//get Provider Data For Update Provider Modal
$(document).on('click','.UpdateProviderBut',function(){
     $('.UpdateProviderSpinner').show();
     $('.UpdateProviderForm').hide(); 
  var UpdateProviderId=$(this).data('providerid');
  $.ajax({
  method:'post',
  url:"{{ route('ProviderOne') }}",
  data:{ProviderId:UpdateProviderId,_token:"{{ csrf_token() }}"},
  success:function(data){     
   $('input[name="ProviderNameUI"]').val(data.ProviderName);
   $('input[name="ProviderUserNameUI"]').val(data.ProviderUserName);
   $('input[name="ProviderIconSrcUI"]').val(data.ProviderIconSrc);
   $('textarea[name="ProviderDescUI"]').val(data.ProviderDesc);
   $('input[name="UpdateProviderId"]').val(UpdateProviderId);

   $('.UpdateProviderSpinner').hide(); 
   $('.UpdateProviderForm').show();

  }
})
})
// End get Provider Data For Update Provider Modal


//get Provider Id for Delete Provider modal

$(document).on('click','.DelProviderBut',function(){
  var ProviderId=$(this).data('providerid');

  $('input[name="ProviderId"]').val(ProviderId);
})

// end get Provider Id for Delete Provider modal






//get Service For Update Service Form Start 


$('.UpdateSerBtn').on('click',function(){


 $('.UpdateServiceSpinner').show();
 $('.UpdateServiceForm').hide();

 var ServiceId=$(this).data('serviceid');

//  console.log(ServiceId)

 var route='{{ route("ServiceOne","ServiceId") }}';
 var url=route.replace('ServiceId',ServiceId);
 $.ajax({
  method:'get',
  url:url,
  success:function(data){

 //get Categories
  function list(list,type) {
      let list1="";

      if(type == "Category"){
          list.map((item)=>{
        list1 += '<option value="'+item.id+'" >'+item.CategoryName+'</option>';
      });
      return list1;
      }
  }
  $.ajax({
    method:'post',
    url:"{{ route('getCatProAjax') }}",
    data:{_token:"{{ csrf_token() }}"},
    success:function(data){     
      var Categories=list(data['Categories'],'Category');
      $(".CategoryInputSerUp").html(Categories)
    }
  })
  //end Get Categories


   //fill input Fields
   $('input[name="ServiceNameUI"]').val(data.Service.ServiceName);
   $('input[name="ServiceThumbnailUI"]').val(data.Service.ServiceThumb);
   $('input[name="ServicePriceUI"]').val(data.Service.ServicePrice);
   $('textarea[name="ServiceDescUI"]').val(data.Service.ServiceDesc);
   $('input[name="ServiceIdUI"]').val(data.Service.id);

   //Set add UpgradeBtn Serviceid data
   $('.SaveUpgradeBtn').data('serviceid',ServiceId);
   $('.UpgradesListAj').html('<div class="sk-chase "> <div class="sk-chase-dot"></div><div class="sk-chase-dot"></div><div class="sk-chase-dot"></div><div class="sk-chase-dot"></div><div class="sk-chase-dot"></div><div class="sk-chase-dot"></div></div>')
   //get Service Upgrades
    $.ajax({
        method:'post',
        url:"{{ route('GetUpgrades') }}",
        data:{
          ServiceIdI:ServiceId,
          _token:"{{ csrf_token() }}"
          },
        success:function(data){ 

          // get Upgrades List

          function Uplist(list) {
              let list1="";
                  list.map((item)=>{
                list1 += '<div class="UpgradeOne" ><h4>'+item.UpgradeTitle+'</h4> <button  type="button" class="DelUpgradeBtn" data-UpgId="'+item.id+'" data-serviceid="'+item.ServiceId+'" >X</button> </div>';
              });
              return list1;
          }
          var UpgradesList=Uplist(data[1].Upgrades)
          $('.UpgradesListAj').html(UpgradesList)
        }
      }) 

   $('.UpdateServiceSpinner').hide();
   $('.UpdateServiceForm').show();  
  
  }
})

})

//get Service For Update Service Form End 


//Add Service Upgrades Form Collpase Start

  $(".UpdateSerAddBtn").click(function(){
    $(".UpgradeFormCollapse").collapse('toggle');
  });

//Add Service Upgrades Form Collpase End





//Add Service Upgrades Send Request Start

$('.SaveUpgradeBtn').click(function(){

 
//get Add Upgrade Form Values
 var SerUpTitle=$('input[name="ServiceUpTitleI"]');
 var SerUpPrice=$('input[name="ServiceUpPriceI"]');
 var SerUpDesc=$('textarea[name="ServiceUpDescI"]');
 var ServiceIdUp=$(this).data('serviceid');


 //Save Upgrade And Refresh Upgrades List
 $.ajax({
    method:'post',
    url:"{{ route('SaveUpgrade') }}",
    data:{
      SerUpTitleI:SerUpTitle.val(),
      SerUpPriceI:SerUpPrice.val(),
      SerUpDescI:SerUpDesc.val(),
      ServiceIdI:ServiceIdUp,
      _token:"{{ csrf_token() }}"
      },
      statusCode: {
      400: function() {
        toastr["danger"]("Validation Error")
      }
    },
    success:function(data){ 

      //Fetch Toaster
      toastr["success"]("Service upgrade Created")

      //Collpas Form 
      $(".UpgradeFormCollapse").collapse('toggle');

      //Empty inputs
      SerUpTitle.val(null),
      SerUpPrice.val(null),
      SerUpDesc.val(null),

      //Loading Spinner
      $('.UpgradesListAj').html('<div class="sk-chase "> <div class="sk-chase-dot"></div><div class="sk-chase-dot"></div><div class="sk-chase-dot"></div><div class="sk-chase-dot"></div><div class="sk-chase-dot"></div><div class="sk-chase-dot"></div></div>')


      //Refresh Upgrades List
      $.ajax({
        method:'post',
        url:"{{ route('GetUpgrades') }}",
        data:{
          ServiceIdI:ServiceIdUp,
          _token:"{{ csrf_token() }}"
          },
        success:function(data){ 

          // get Upgrades List

          function Uplist(list) {
              let list1="";
                  list.map((item)=>{
                list1 += '<div class="UpgradeOne" ><h4>'+item.UpgradeTitle+'</h4> <button  type="button" class="DelUpgradeBtn" data-UpgId="'+item.id+'" data-serviceid="'+item.ServiceId+'" >X</button> </div>';
              });
              return list1;
          }
          var UpgradesList=Uplist(data[1].Upgrades)
          $('.UpgradesListAj').html(UpgradesList)
        }
      }) 
    }
  })  
})

//Add Service Upgrades Send Request End




//Start Delete Service Upgrades Request 

$(document).on('click','.DelUpgradeBtn',function(){

  //Get Upgrade Id
  var UpgradeId=$(this).data('upgid');
  var ServiceIdUp=$(this).data('serviceid');
  console.log(UpgradeId)

  $.ajax({
    url:"{{route('DelUpgrade')}}",
    method:'post',
    data:{
      UpgradeIdI:UpgradeId,
      _token:"{{ csrf_token() }}"
    },
    statusCode: {
          400:function() {
           
            //Fetch Danger  Toastr 
            toastr["danger"]("Somthing Wrong")
          },
          200:function(){

            //Fetch Succsess Toastr 
            toastr["success"]("Service upgrade Deleted")

            //Loading Spinner
            $('.UpgradesListAj').html('<div class="sk-chase "> <div class="sk-chase-dot"></div><div class="sk-chase-dot"></div><div class="sk-chase-dot"></div><div class="sk-chase-dot"></div><div class="sk-chase-dot"></div><div class="sk-chase-dot"></div></div>')


            //Refresh Upgrades List
            $.ajax({
                method:'post',
                url:"{{ route('GetUpgrades') }}",
                data:{
                  ServiceIdI:ServiceIdUp,
                  _token:"{{ csrf_token() }}"
                  },
                success:function(data){ 

                  // get Upgrades List

                  function Uplist(list) {
                      let list1="";
                          list.map((item)=>{
                        list1 += '<div class="UpgradeOne" ><h4>'+item.UpgradeTitle+'</h4> <button  type="button" class="DelUpgradeBtn" data-UpgId="'+item.id+'" data-serviceid="'+item.ServiceId+'" >X</button> </div>';
                      });
                      return list1;
                  }
                  var UpgradesList=Uplist(data[1].Upgrades)
                  $('.UpgradesListAj').html(UpgradesList)
                }
              }) 
            }
    },
  })


})
//End Delete Service Upgrades Request 


//Start Delete Service 


$(document).on('click','.DelSerBtn',function(){



var ServiceId=$(this).data('serviceid');

$('input[name="DelSerIdI"]').val(ServiceId);



})


//end Delete Service 





//Change Service Statis Start

$(document).on('click','.StatusBtn',function(){


  var SerStatus=$(this).data('status');
  var SerId=$(this).data('serviceid');
  var StatusBtn=$(this);

  if(SerStatus == 0){
    //Change Status To 1 (Publish)
    $.ajax({
      url:"{{route('ChangeStatusSer')}}",
      method:'post',
      data:{
        ServiecIdI:SerId,
        SerStausI:SerStatus,
        _token:"{{csrf_token()}}"
      },
      success:function(data){

        //Fetch Success Toaster 
        toastr["success"]("Service Successfully Published")

        //remove success class And Put Primary Class
        $(StatusBtn).removeClass('btn-success')
        $(StatusBtn).addClass('btn-primary')

        //Change Text inside Button
        $(StatusBtn).html("Suspend");

        //Update Data Status
        $(StatusBtn).data('status','1')
      }
    })
  }

  if(SerStatus === 1){

    //Change Status To 0 (Suspend)
    $.ajax({
      url:"{{route('ChangeStatusSer')}}",
      method:'post',
      data:{
        ServiecIdI:SerId,
        SerStausI:SerStatus,
        _token:"{{csrf_token()}}"
      },
      success:function(data){


        //Fetch Success Toaster 
        toastr["success"]("Service Successfully Suspended")

        //remove success class And Put Primary Class
        $(StatusBtn).removeClass('btn-primary')
        $(StatusBtn).addClass('btn-success')

        //Change Text inside Button
        $(StatusBtn).html('Publish')

        //Update Data Status
        $(StatusBtn).data('status','0')
      }
    })
    
  }


  


})

//Change Service Statis End







</Script>

