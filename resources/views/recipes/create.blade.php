@extends('layouts.app')

@section('content')

<h2>Make New Recipe</h2>
{!! Form::open(['action' => 'RecipeController@store', 'method' => 'post', 'files' => true]) !!}
<div class="form-group">
  {{Form::label('title', 'Title')}}
  {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}}

</div>
<div class="form-group">
  {{Form::label('instructions', 'Instructions')}}
  {{Form::textarea('instructions', '', ['class' => 'form-control', 'placeholder' => 'How to make the recipe?'])}}
</div>
<div class="form-group">
  {{Form::file('cover_image')}}
</div>
{{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
{!! Form::close() !!}
@endsection
