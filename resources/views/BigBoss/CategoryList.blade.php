@extends('layout.master')


@section('Content')
@include('includes.Navbar')
@include('includes.error')
@include('includes.BigBossSideNav')
<div id='Content'>
    <table class="table table-responsive ">
        <thead>
            <tr>
             <th>Category Name</th>
             <th>Category Service Count</th>
             <th>Options</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($Categories as $Category)
            <tr>
                <td>{{ $Category['CategoryName'] }}</td>
                <td>{{$Category['CategoryServiceNum']}}</td>
                <td>
                    <button class='btn btn-warning UpdateCatBut'  data-toggle="modal" data-target="#UpdateCategory" data-catid='{{$Category['id']}}'><span class="glyphicon glyphicom-plus"></span>Update</button>
                    <button data-catid='{{$Category['id']}}' data-toggle="modal"  data-target='#DelCategory' class='btn btn-danger CatDelBut'><span class="glyphicon glyphicom-plus"></span>Del</button>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>

@endsection