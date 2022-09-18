@extends('layouts.master')

@section('title')
    Top 3 Industry Partners
@endsection


@section('content')
    @if ($top3Partners)
        <h1>Top 3 Industry Partners</h1>
        <hr>
        <?php $int = 1;?>
        @foreach($top3Partners as $partner)
            <div class="partnerDetails">
                <h3>Number {{$int}}</h3>
                <p>{{$partner->PARTNER}}</p>
                <p>Current Projects: {{$partner->projects}}</p>
            <?php $int ++;?>
            </div>
        @endforeach
        
    @else
        No partners currently <a href="{{ url("add_project") }}">ADVERTISE YOUR PROJECT</a> to get started
    @endif

@endsection
