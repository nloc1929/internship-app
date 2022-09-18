@extends('layouts.master')

@section('title')
    Update Project Form
@endsection

@section('content')
    <div class="formSection">
        <h1>Update Project</h1>
        <span id="errorMessage" name="errorMessage">{{$errorMessage}}</span>
        <form method="post" action="{{ url("update_project_action") }}">
            {{ csrf_field() }}
            <input type="hidden" name="ID" value="{{ $project->ID }}">
            <div class="mb-3">
                <label for="title">Title:</label>
                <br>
                <input type="text" name="TITLE" value="{{$project->TITLE}}"></input>
            </div>
            <div class="mb-3">
                <label for="field">Field:</label>
                <br>
                <input type="text" name="FIELD" value="{{$project->FIELD}}"></input>
            </div>
            <div class="mb-3">
                <label for="description">Description:</label>
                <br>
                <textarea type="text" name="DESCRIPTION">{{$project->DESCRIPTION}}</textarea>
            </div>
            <div class="mb-3">
                <label for="STUDENT_NUM" class="form-label">No. of Students Required (3-8):</label>
                <input type="range" class="form-control" id="STUDENT_NUM" name="STUDENT_NUM" min="3" max="8" value="{{$project->STUDENT_NUM}}">
            </div>
            <input class="btn btn-primary" type="submit" value="Update Project">
        </form>
    </div>
@endsection