<nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"></a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
      @if( str_replace('_','-',app()->getLocale()) == 'ar' )
        <ul class="nav navbar-nav navbar-left">
      @else
        <ul class="nav navbar-nav navbar-right">
      @endif
          <li class="dropdown">
            <a class="dropdown-toggle NotifDrop" data-toggle="dropdown" data-type='Provider' href="#"><span class=" 	glyphicon glyphicon-bell"></span></a>
            <ul class="dropdown-menu">
              @if (!empty($ProviderNotifs))
                @foreach ($ProviderNotifs as $PNotif)
                 <li><a href="#">{{$PNotif['NotifValue']}}</a></li>
                @endforeach
              @endif
            </ul>
          </li>
          <li class="dropdown">
            <a class="dropdown-toggle ToastTest MessageDrop" data-toggle="dropdown" data-type='Provider' href="#"><span class='glyphicon glyphicon-envelope'></span></a>
            <ul class="dropdown-menu">
              @if (!empty($ProviderMessage))
                @foreach ($ProviderMessage as $PMessage)
                 <li><a href="#">{{$PMessage['MessageValue']}}</a></li>
                @endforeach
              @endif
            </ul>
          </li>
          <li><a href="{{ route('ProviderLogOut') }}"><span class="glyphicon glyphicon-off"></span></a></li>
        </ul>
      </div>
    </div>
  </nav>