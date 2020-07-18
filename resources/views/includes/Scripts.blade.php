
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

  $.ajax({
  method:'post',
  url:"{{ route('CategoryOne') }}",
  data:{CatId:UpdateCatId,_token:"{{ csrf_token() }}"},
  success:function(data){     
  
    $('input[name="UpdateCatId"]').val(UpdateCatId);
    $('input[name="CategoryNameUpdateI"]').val(data.CategoryName);
  }
})
})
//End get Category Id for Update CategoryModal


//get Provider Data For Update Provider Modal
$(document).on('click','.UpdateProviderBut',function(){
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

</Script>

