@extends('layouts.master')


@section('title')
    Add New Project Form
@endsection



@section('content')
<div class="formSection">
  <h1>Advertise Your Project Here</h1>
  <hr>
  <span id="errorMessage" name="errorMessage">{{$errorMessage}}</span>
  <form method="post" action="{{ url("add_project_action") }}">
  {{ csrf_field() }}
    <div class="mb-3">
      <label for="TITLE" class="form-label">Project Title:</label>
      <input type="text" class="form-control" id="TITLE" name="TITLE" placeholder="Project Alpha">
    </div>
    <div class="mb-3">
      <label for="PARTNER" class="form-label">Industry Partner:</label>
      <input type="text" class="form-control" id="PARTNER" name="PARTNER" placeholder="Vandalay Industries" value="">
    </div>
    <div class="mb-3">
      <label for="LOCATION" class="form-label">Location:</label>
      <textarea class="form-control" id="LOCATION" name="LOCATION" rows="3"></textarea>
    </div>
    <div class="mb-3">
      <label for="FIELD" class="form-label">Field of Project:</label>
      <input type="text" class="form-control" id="FIELD" name="FIELD" placeholder="Software Development">
    </div>
    <div class="mb-3">
      <label for="DESCRIPTION" class="form-label">Project Description:</label>
      <textarea class="form-control" id="DESCRIPTION" name="DESCRIPTION" rows="3"></textarea>
    </div>
    <div class="mb-3">
      <label for="STUDENT_NUM" class="form-label">No. of Students Required (3-8):</label>
      <br>
      <span id="numScale">3</span><span id="numScale">4</span><span id="numScale">5</span><span id="numScale">6</span><span id="numScale">7</span><span id="numScale">8</span>
      <input type="range" class="form-control" id="STUDENT_NUM" name="STUDENT_NUM" min="3" max="8" step="1">
    </div>
    <button type="submit" class="btn btn-primary">Advertise Project</button>
  </form>
</div>
@endsection
