@extends('layouts.master')

@section('title')
    Delete Project
@endsection


@section('content')
    <div class="formSection">
        <h1>Delete Project</h1>
        <h2>{{$project->TITLE}}</h2>
        <p>{{$project->PARTNER}}</p>
        <form method="post" action="{{ url("delete_project_action") }}">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $project->ID }}">
            <input class="btn btn-danger" type="submit" value="Delete Project">
        </form>
    </div>
@endsection