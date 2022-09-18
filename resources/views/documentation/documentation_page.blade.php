@extends('layouts.master')

@section('title')
    Site Documentation
@endsection


@section('content')
<div class="documentationPage">
    <h1>DOCUMENTATION</h1>
    <hr>
    <p class="question">1. An ER diagram for the database. Note: many-to-many relationships must be broken down into
        one-to-many.</p>
    <img src="{{asset('images/er-diagram.jpg')}}" alt="ER Diagram of Databse Relationship" id="erDiagram">
    <hr>
    <p class="question">2. Describe what you were able to complete, what you were not able to complete.</p>
    <p class="answer">I was able to complete requirements 1 to 13 as described in the assignment details. 
        Due to poor time management I didn't leave myself enough time to learn about the session feature of Laravel and complete the project assignment page. 
        This is something I will ask my workshop tutor about and spend some extra time on in the following week to ensure I understand how I can solve these tasks in the future.</p>
    <hr>
    <p class="question">3. Reflect on the process you have applied to develop your solution (e.g. how did you get started,
        did you do any planning, how often do you test your code, how did you solve the problems you
        come across). What changes would you make for assignment 2 to improve your process?</p>
    <p class="answer">I began all my preperation on paper, first with looking over all the requirements and organising the database tables, and secondly, which table headers are needed for each.
        Sketching out the required forms helped to isolate which fields translate to each table heading and the relationship between tables. 
        Once I had a good theoretical understanding of how the information would be transferred between databases, 
        I started with adding a project and testing to see if the 'projects' database would connect with the 'partners' database, then added the update feature, delete feature and so on.
        <br>
        I tested database and input data using the dump and display function almost constantly when adding a new route, function, and variable. This tool was crucial for me to solve these problems.
        I tested each form for input errors, tested each new function, and each database query with all combinations I could think of after I constructed them, however this did not prevent future bugs as I added more features.
        Testing demands time and patience, I simply did not leave myself enough time for proper testing, this is something I will consider when planning for future assignments.
        <br>
        For assignment two, I will start planning (on paper) much earlier before the due date, planning on paper helped me immenseley and spending more time on planning could have saved me a lot of future errors.
        I would like to learn a lot more about SQL queries and database relationships so I can use them more effectively, I feel that this assignment could have been done with a lot less PHP code if I could utilise SQL queries to do the work.
    </p>
    <hr>
    <p class="question">4. If you have completed Task 15, you need to explain your method and justify how your
        assignment implementation satisfies the most number of students.</p>
    <p class="answer">I did not complete Task 15.</p>
</div>


@endsection