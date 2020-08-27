@extends('layouts.app')




@section('content')
<a href="/recipes" class="btn btn-primary">Back</a>
<hr>
<h2>{{$recipe->title}}</h2>
<small>Written on {{$recipe->created_at}}</small>
<hr>
<div class="row">
  <div class="col-md-12">
    <img style="width: 100%" src="/storage/cover_images/{{$recipe->cover_image}}" alt="">
  </div>
</div>
<p>{{$recipe->instructions}}</p>
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
