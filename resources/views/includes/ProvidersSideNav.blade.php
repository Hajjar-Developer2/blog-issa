<div class="wrapper">


    <nav id="sidebar">
      <div class="sidebar-header">
          <h3>Providers Sidebar</h3>
      </div>
  
      <ul class="list-unstyled components">
          <li class="active">
          <a href="#ServiceSub" data-toggle="collapse" aria-expanded="false">{{ trans('lang.Services') }}</a>
              <ul class="collapse list-unstyled" id="ServiceSub">
               <li><a href="{{ route('ServiceListGet') }}">{{ trans('lang.ServiceList') }}</a></li>
               <li><a href="#" class="AddService" data-toggle="modal" data-target="#AddService">{{ trans('lang.AddService') }}</a></li> 
              </ul>
          </li>
          <li >
            <a href="#OrdersSub" data-toggle="collapse" aria-expanded="false">{{ trans('lang.Orders') }}</a>
                <ul class="collapse list-unstyled" id="OrdersSub">
                 <li><a href="{{route('OrderListGet')}}">{{ trans('lang.OrderList') }}</a></li>
                </ul>
            </li>
      </ul>
    </nav>
  
  
@include('includes.ProvidresModals')