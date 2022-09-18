@extends('layouts.master')

@section('title')
    Apply for Project Form
@endsection


@section('content')
<div class="formSection">
    <span id="errorMessage" name="errorMessage">{{$errorMessage}}</span>
    <form method="post" action="{{ url("apply_project_action") }}">
    {{ csrf_field() }}
        <input type="hidden" name="PID" value="{{ $project->ID }}">
        <input type="hidden" name="TITLE" value="{{ $project->TITLE }}">
        <input type="hidden" name="PARTNER" value="{{ $project->PARTNER }}">
        <div class="mb-3">
            <label for="FIRST_NAME" class="form-label">First Name:</label>
            <input type="text" class="form-control" id="FIRST_NAME" name="FIRST_NAME" placeholder="First">
        </div>
        <div class="mb-3">
            <label for="LAST_NAME" class="form-label">Last Name:</label>
            <input type="text" class="form-control" id="LAST_NAME" name="LAST_NAME" placeholder="Last">
        </div>
        <div class="mb-3">
            <label for="JUST_TEXT" class="form-label">Why would you like to join this project?</label>
            <textarea class="form-control" id="JUST_TEXT" name="JUST_TEXT" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="PROJECT_NUM" class="form-label">Project Preference (1-3):</label>
            <input type="range" class="form-control" id="PROJECT_NUM" name="PROJECT_NUM" min="1" max="3" step="1">
        </div>    
        <button type="submit" class="btn btn-primary">Apply For Project</button>
    </form>
</div>
@endsection