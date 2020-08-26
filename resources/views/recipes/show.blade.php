@extends('layouts.app')

@section('content')
<a href="/recipes" class="btn btn-primary">Back</a>
<hr>
<h2>{{$recipe->title}}</h2>
<p>{{$recipe->instructions}}</p>
<hr>
<small>Written on {{$recipe->created_at}}</small>
<hr>
@if (!Auth::guest())
  @if (Auth::id() == $recipe->user_id)
    <a class="btn btn-default" href="/recipes/{{$recipe->id}}/edit">Edit</a>
    {!! Form::open(['action' => ['RecipeController@destroy', $recipe->id], 'method' => 'DELETE', 'class' => 'pull-right']) !!}
    {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
    {!! Form::close() !!}
  @endif
@endif
@endsection
