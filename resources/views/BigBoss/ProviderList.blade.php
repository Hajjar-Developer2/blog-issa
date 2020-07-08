@extends('layout.master')


@section('Content')
@include('includes.BigBossNavbar')
@include('includes.error')
@include('includes.BigBossSideNav')
<div id='Content'>
    <table class="table table-responsive ">
        <thead>
            <tr>
             <th>Provider Img</th>
             <th>ProviderName</th>
             <th>Provider Service Count</th>
             <th>More</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($Providers as $Provider)
                <tr>
                    <td>img</td>
                    <td>{{$Provider['ProviderName']}}</td>
                    <td>{{$Provider['ProviderServiceNum']}}</td>
                    <td>
                      <button class="btn btn-warning UpdateProviderBut" data-toggle="modal" data-target="#UpdateProvider" data-providerid='{{$Provider["id"]}}'><span class="glyphcion glyphicon-eye">Update</span></button>
                      <button class="btn btn-danger DelProviderBut" data-toggle="modal" data-target="#DelProvider" data-providerid='{{$Provider["id"]}}'><span class="glyphcion glyphicon-eye">Delete</span></button>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>

@endsection