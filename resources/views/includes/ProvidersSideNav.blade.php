<div class="wrapper">


    <nav id="sidebar">
      <div class="sidebar-header">
          <h3>Providers Sidebar</h3>
      </div>
  
      <ul class="list-unstyled components">
          <li class="active">
          <a href="#ServiceSub" data-toggle="collapse" aria-expanded="false">Services</a>
              <ul class="collapse list-unstyled" id="ServiceSub">
               <li><a href="#">Service List</a></li>
               <li><a href="#" class="AddService" data-toggle="modal" data-target="#AddService">Add Service</a></li> 
              </ul>
          </li>
      </ul>
    </nav>
  
@include('includes.ProvidresModals')