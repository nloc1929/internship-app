@extends('layouts.master')

@section('title')
    Student List
@endsection


@section('content')
    <h1>Students</h1>
    <hr>
    @if ($students)
        @foreach($students as $student)
            <div class="studentDetails">
                <p>
                    <a  data-bs-toggle="collapse" data-bs-target="#student{{$student->ID}}" aria-expanded="false" aria-controls="student{{$student->ID}}">
                    {{$student->FIRST_NAME}} {{$student->LAST_NAME}}
                    </a>
                </p>
                <div class="collapse" id="student{{$student->ID}}">
                    <div class="card card-body">
                        <div class="cardBody">
                            @if($student->PROJECT_A > 0)
                                <p class="heading">First Preference</p>
                                <p>{{$student->TITLE_A}}</p>
                                <p>{{$student->PARTNER_A}}</p>
                                <p id="justText">"{{$student->JUST_TEXT_A}}"</p>
                                <p>____________</p>
                            @endif
                            @if($student->PROJECT_B > 0)
                                <p class="heading">Second Preference</p>
                                <p>{{$student->TITLE_B}}</p>
                                <p>{{$student->PARTNER_B}}</p>
                                <p id="justText">"{{$student->JUST_TEXT_B}}"</p>
                                <p>____________</p>
                            @endif
                            @if($student->PROJECT_C > 0)
                                <p class="heading">Third Preference</p>
                                <p>{{$student->TITLE_C}}</p>
                                <p>{{$student->PARTNER_C}}</p>
                                <p id="justText">"{{$student->JUST_TEXT_C}}"</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
    @else
        No students yet
    @endif

@endsection