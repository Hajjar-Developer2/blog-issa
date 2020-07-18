<div class="wrapper">


  <nav id="sidebar">
    <div class="sidebar-header">
        <h3>BigBoss Sidebar</h3>
    </div>

    <ul class="list-unstyled components">
        <li class="active">
        <a href="#CategorySub" data-toggle="collapse" aria-expanded="false">{{ trans('lang.Categories') }}</a>
            <ul class="collapse list-unstyled" id="CategorySub">
             <li><a href="{{ route('CategoryList') }}">{{ trans('lang.CategoryList') }}</a></li>
             <li><a href="#"  data-toggle="modal" data-target="#AddCategory">{{ trans('lang.AddCategory') }}</a></li> 
            </ul>
        </li>
        <li>  
        <a href="#ProviderList" data-toggle="collapse" aria-expanded="false">{{ trans('lang.Providers') }}</a>
        <ul class="collapse list-unstyled" id="ProviderList">
            <li><a href="{{ route('ProviderList') }}">{{ trans('lang.ProviderList') }}</a></li>
            <li><a href="#" data-toggle="modal" data-target="#AddProvider">{{ trans('lang.AddProvider') }}</a></li> 
           </ul>
        </li>
        <li>  
         <a href="#Ads" >{{ trans('lang.Advertisment') }}</a>
        </li>
    </ul>
  </nav>

  @include('includes.BigBossModals')
