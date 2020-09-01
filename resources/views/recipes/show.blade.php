@extends('layouts.app')
@section('head')
<style>
  /* Erik */

  .recipe-block {
    position: relative;
  }

  .rating {
    position: absolute;
    bottom: 0;
    right: 20px;
  }

  .vote {
    position: absolute;
    bottom: 0;
    left: 20px;
  }
</style>
@section('head')
@section('content')
<a href="/recipes" class="btn btn-primary">Back</a>
<hr>
<div class="recipe-block">
  <h2>{{$recipe->title}}</h2>
  {!! Form::open(['action' => 'RecipeController@vote', 'method' => 'post']) !!}
  {{Form::hidden('id', $recipe->id)}}
  {{Form::submit('Vote')}}
  {!! Form::close() !!}
  <p class="rating">Rating: {{$recipe->rating}}</p>
</div>
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

@section('script')
<script>

</script>

@endsection