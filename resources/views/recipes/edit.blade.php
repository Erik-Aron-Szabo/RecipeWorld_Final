@extends('layouts.app')

@section('content')
<h2>Edit: {{$recipe->title}}</h2>
{!! Form::open(['action' => ['RecipeController@update', $recipe->id], 'method' => 'PUT']) !!}
<div class="form-group">
  {{Form::label('title', 'Title')}}
  {{Form::text('title', $recipe->title, ['class' => 'form-control', 'placeholder' => 'Title'])}}
</div>
<div class="form-group">
  {{Form::label('instructions', 'Instructions')}}
  {{Form::textarea('instructions', $recipe->instructions, ['class' => 'form-control', 'placeholder' => 'Instructions'])}}
</div>
{{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
{!! Form::close() !!}
@endsection
