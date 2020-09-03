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

  .comment {
    align-content: center;
    background-color: grey;
    color: white;
    text-align: center;
  }

  #outer {
    width: 100%;
    text-align: center;
  }

  .inner {
    display: inline-block;
    height: 25px;
  }

  .delete {
    position: absolute;
    right: 0;
    height: 8%;
    width: 8%;
    font-size: 12px;
    text-align: center;
    padding-bottom: 9px;
    padding-top: 0px;
  }

  .edit {
    position: absolute;
    margin-left: 10px;
    background-color: lightblue;
    right: 10%;
    height: 8%;
    width: 8%;
    font-size: 12px;
    text-align: center;
    padding-bottom: 9px;
    padding-top: 0px;
  }

  .edit2 {
    position: absolute;
    margin-left: 10px;
    background-color: lightblue;
    right: 5%;
    height: 8%;
    width: 18%;
    font-size: 12px;
    text-align: center;
    padding-bottom: 9px;
    padding-top: 0px;
  }
</style>
@section('head')
@section('content')
<?php
$user_id = Auth::id();
$recipe_id = $recipe->id;
?>
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
<hr>
<br>
<h4>Instructions:</h4>
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

<!-- Comments -->
<div class="row">
  <div class="col-md-10">
    <h4>Comments:</h4>
    <br>
    <!-- New Comment -->
    @if ($user_id > 0)
    <button id="newcomment" onclick="unhide()" class="btn btn-primary"> New Comment </button>
    <div id="hidden" hidden>
      {!! Form::open(['action' => 'CommentController@create', 'method' => 'post']) !!}
      {{Form::textarea('message', '', ['class' => 'form-control', 'placeholder' => 'What did you think about the recipe?'])}}
      {{Form::hidden('recipe_id', $recipe_id)}}
      {{Form::hidden('user_id', $user_id)}}
      {{Form::submit('Comment')}}
      {!! Form::close() !!}
    </div>
    <br><br>
    @foreach ($comments as $comment)
    @if ($comment->recipe_id == $recipe->id)
    @foreach ($users as $user)
    @if ($comment->user_id == $user->id)
    <p class="comment">"{{$comment->message}}" || <small>{{$user->name}}</small></p>
    @if ($user->id == $user_id)
    <!-- delete -->
    {!! Form::open(['action' => 'CommentController@destroy', 'method' => 'DELETE']) !!}
    <div id="outer">
      {{Form::hidden('recipe_id', $recipe_id)}}
      {{Form::hidden('comment_id', $comment->id)}}
      <button type="submit" class="inner delete btn-danger">Delete</button>
    </div>
    {!! Form::close() !!}


    <button onclick="unhide_edit()" class="inner edit btn-light">Edit</button>

    <div id="hidden_edit" hidden>
      {!! Form::open(['action' => 'CommentController@update', 'method' => 'put']) !!}
      {{Form::textarea('message', '', ['class' => 'form-control', 'placeholder' => 'What did you think about the recipe?'])}}
      {{Form::hidden('recipe_id', $recipe_id)}}
      {{Form::hidden('user_id', $user_id)}}
      {{Form::hidden('recipe_id', $recipe_id)}}
      {{Form::hidden('comment_id', $comment->id)}}
      <button class="edit2 btn-primary btn">Edit</button>
      {!! Form::close() !!}

    </div>

    @endif
    @endif
    @endforeach
    @endif
    <br>
    @endforeach
    @endif
    </>
  </div>


  @endsection

  @section('script')
  <script>
    function unhide_edit() {
      var hidden_edit_div = document.getElementById("hidden_edit");
      hidden_edit_div.removeAttribute('hidden');
    }


    function unhide() {
      var hidden_div = document.getElementById("hidden");
      hidden_div.removeAttribute('hidden');
    }
  </script>

  @endsection