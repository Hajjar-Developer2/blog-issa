@extends('layout.master')


@section('Content')
@include('includes.ProviderNavbar')
@include('includes.error')
@include('includes.ProvidersSideNav')
<div id='Content'>
    <div class="panel-group" id="accordion">
        @foreach ($Orders as $Order)
         <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$Order['id']}}">Order : {{$Order['id']}}</a>
              </h4>
            </div>
            <div id="collapse{{$Order['id']}}" class="panel-collapse collapse ">
              <div class="panel-body">
                  <div class="row">
                      <div class="col-sm-12">
                            <h3>Orderd Service: <span><a href="#">{{ $Order['Service']['ServiceName'] }} </a></span></h3>
                            <h3>Customer: <span><a href='#'> {{ $Order['Customer']['CustUserName'] }} </a></span></h3>
                            <h3>Desception:</h3>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae eius non, nam nemo nulla magnam repellat sequi quod odio ipsa tenetur necessitatibus dolorem voluptates aliquid, natus blanditiis expedita ipsum iste.</p>
                            <h3>Order Files:</h3>
                            <ul class='OrderFileList'>
                                @foreach ($Order['Files'] as $File)
                                 <li><a href="https://drive.google.com/file/d/{{$File['BaseName']}}"><img src="http://127.0.0.1/images/avatar.png" ><h4>{{ $File['FileName'] }}<span>{{ $File['Ext']}}</span></h4></a></li>
                                @endforeach
                               
                            </ul>
                            <br><br><br>
                            <h3>Biling:</h3>
                            <table class="table table-light">
                                <thead>
                                    <tr>
                                        <th>item</th>
                                        <th>type</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $Order['Service']['ServiceName'] }}</td>
                                        <td>Service</td>
                                        <td>{{ $Order['Service']['ServicePrice']}}</td>
                                    </tr>
                                    @foreach ($Order['OrderUpgradesId'] as $Upgrades)
                                    <tr>
                                        <td>{{ $Upgrades['UpgradeTitle']}}</td>
                                        <td>Service Upgrade</td>
                                        <td>{{ $Upgrades['UpgradePrice']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>{{ $totalPrice}}</th>
                                    </tr>
                                  </tfoot>
                            </table>
  
  
                      </div>
                  </div>
              </div>
              <div class="panel-footer">Order Footer<div class="pull-right"><button class="btn btn-primary">Deliver</button></div></div>
            </div>
          </div>
        @endforeach

</div>

@endsection