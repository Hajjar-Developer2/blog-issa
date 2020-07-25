@extends('layout.master')


@section('Content')
@include('includes.ProviderNavbar')
@include('includes.error')
@include('includes.ProvidersSideNav')
<div id='ContentBlank'>

        <div class="row">
            
            @foreach ($Services as $Service)
                <div class="col-sm-6">
                    <div class=" ServiceBox">
                        <div class="ServiceOptions btn-group">
                            @if ($Service['ServiceStatus'] === 1)
                             <button class='btn btn-success StatusBtn' data-status="{{$Service['ServiceStatus']}}" data-serviceid='{{$Service['id']}}'>Publish</button>
                             @else
                             <button class='btn btn-primary StatusBtn' data-status="{{$Service['ServiceStatus']}}" data-serviceid='{{$Service['id']}}'>Suspend</button>
                            @endif
                            
                            <button class='btn btn-warning UpdateSerBtn' data-toggle="modal" data-target="#UpdateService" data-ServiceId='{{$Service['id']}}' >Update</button>
                            <button class='btn btn-danger DelSerBtn' data-toggle="modal" data-target="#DelService" data-Serviceid="{{$Service['id']}}" >Delete</button>
                            <button class="btn btn-info">More</button>
                        </div>
                        <img src="http://127.0.0.1/images/1.jpg" class="img-responsive">
                        <h4>{{$Service['ServiceName']}}</h4>
                    </div>
                </div>
            @endforeach

         </div>

</div>

@endsection