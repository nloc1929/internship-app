@extends('layouts.master')

@section('title')
    Project Details
@endsection


@section('content')
    <div class="projectDetails">
        <h1>{{$project->TITLE}}</h1>
        <hr>
        <p><strong>Industry Partner: </strong>{{$project->PARTNER}}</p>
        <p><strong>Location: </strong>{{$project->LOCATION}}</p>
        <p><strong>Field: </strong>{{$project->FIELD}}</p>
        <p><strong>Description: </strong>{{$project->DESCRIPTION}}</p>
        <p><strong>Number of Students Needed: </strong>{{$project->STUDENT_NUM}}</p>
        <hr>
    </div>
    
    <div class="studentDetails">
        @if ($students)
            <p class="heading">Applicants:</p>
            @foreach($students as $student)
            <div class="studentDetails">
                <p>
                    <a  data-bs-toggle="collapse" data-bs-target="#student{{$student->ID}}" aria-expanded="false" aria-controls="student{{$student->ID}}">
                    {{$student->FIRST_NAME}} {{$student->LAST_NAME}}
                    </a>
                </p>
                <div class="collapse" id="student{{$student->ID}}">
                    <div class="card card-body">
                        <p id="justText"> 
                            @if($student->PROJECT_A == $project->ID)
                                "{{$student->JUST_TEXT_A}}"<br>
                                - {{$student->FIRST_NAME}} {{$student->LAST_NAME}}
                            @endif
                            @if($student->PROJECT_B == $project->ID)
                                "{{$student->JUST_TEXT_B}}"<br>
                                - {{$student->FIRST_NAME}} {{$student->LAST_NAME}}
                            @endif
                            @if($student->PROJECT_C == $project->ID)
                                "{{$student->JUST_TEXT_C}}"<br>
                                - {{$student->FIRST_NAME}} {{$student->LAST_NAME}}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>

    

    <div class="projectButtons">
        <p><a href="{{ url("apply_project/$project->ID") }}"><button class="btn btn-success">Apply For Project</button></a></p>
        <p><a href="{{ url("update_project/$project->ID") }}"><button class="btn btn-primary">Update Project</button></a></p>
        <p><a href="{{ url("delete_project/$project->ID") }}"><button class="btn btn-danger">Delete Project</button></a></p>
        <p><a href="{{ url("/") }}">Home</a></p>
    </div> 
@endsection