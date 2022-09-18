@extends('layouts.master')

@section('title')
    Project List
@endsection


@section('content')
    @if ($projects)
        <h1>Projects</h1>
        <hr>
        @foreach($projects as $project)
            <p>
                <a href="{{ url("project_detail/$project->ID") }}">{{$project->TITLE}}</a>
                ({{$project->APP_NUMBER}})
                <br>
                {{$project->PARTNER}}
            </p>
        @endforeach
    @else
        No projects currently <a href="{{ url("add_project") }}">ADVERTISE YOUR PROJECT</a> to get started
    @endif

@endsection