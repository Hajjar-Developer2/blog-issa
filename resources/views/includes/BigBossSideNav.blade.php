<div class="wrapper">


  <nav id="sidebar">
    <div class="sidebar-header">
        <h3>BigBoss Sidebar</h3>
    </div>

    <ul class="list-unstyled components">
        <li class="active">
        <a href="#CategorySub" data-toggle="collapse" aria-expanded="false">Categories</a>
            <ul class="collapse list-unstyled" id="CategorySub">
             <li><a href="{{ route('CategoryList') }}">Category List</a></li>
             <li><a href="#"  data-toggle="modal" data-target="#AddCategory">Add Category</a></li> 
            </ul>
        </li>
        <li>  
        <a href="#ProviderList" data-toggle="collapse" aria-expanded="false">Providers</a>
        <ul class="collapse list-unstyled" id="ProviderList">
            <li><a href="{{ route('ProviderList') }}">Providers List</a></li>
            <li><a href="#" data-toggle="modal" data-target="#AddProvider">Add Provider</a></li> 
           </ul>
        </li>
        <li>  
         <a href="#Ads" >Advertisment</a>
        </li>
    </ul>
  </nav>

  @include('includes.BigBossModals')
