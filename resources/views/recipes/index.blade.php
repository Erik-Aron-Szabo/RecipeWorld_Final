@extends('layouts.app')
@section('head')

<style>
  .switch {
    position: relative;
    display: inline-block;
    width: 40px;
    height: 21px;
  }

  .switch input {
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .5s;
    transition: .5s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 16.5px;
    width: 17px;
    left: 4px;
    bottom: 3px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
  }

  input:checked+.slider {
    background-color: #2196F3;
  }

  input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked+.slider:before {
    -webkit-transform: translateX(14px);
    -ms-transform: translateX(14px);
    transform: translateX(14px);
  }

  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
  }

  .slider.round:before {
    border-radius: 50%;
  }

  /* Erik */

  .recipe-block {
    position: relative;
  }

  .rating {
    position: absolute;
    bottom: 0;
    right: 20px;
  }
</style>
@endsection

<!-- 888 -->

@section('content')
<h2>Recipes</h2>
<small>Here you can find the recipies to make.</small>
<hr>
<h5>Order By:</h5>
{!! Form::open(['action' => 'OrderController@descending', 'method' => 'post', 'id' => 'order_form' ]) !!}
<div id="b">
  <p>Title</p>
  <label class="switch">
    {{Form::checkbox('sort_order', 'desc', true)}}
    <span class="slider round"></span>
  </label>
  {!! Form::close() !!}
</div>
<br>
<hr style="margin-top: 0;">

{{-- Ul the recipes from DB --}}
{{-- RecipeController -> 'recipes' ==> ALL the recipes in DB --}}
@if (count($recipes) > 0)
<div class="card">

  <ul class="list-group list-group-flush">
    @foreach ($recipes as $recipe)

    <div class="row">
      <div class="col-md-4">
        <img style="width: 100%" src="/storage/cover_images/{{$recipe->cover_image}}" alt="">
      </div>
      <div class="col-md-8 recipe-block">
        <h4><a href="/recipes/{{$recipe->id}}">{{$recipe->title}}</a>
          <details class="col-md-7">
            <summary>Instructions</summary><small>
              {{$recipe->instructions}}
            </small>
          </details>
        </h4>
        <p class="rating"> Rating: {{$recipe->rating)}</p>
      </div>
    </div>

    @endforeach
  </ul>

</div>
@endif

@endsection

@section('script')
<script>
  $(document).ready(function() {
    $("#order_form").on("change", "input:checkbox", function() {
      $("#order_form").submit();
    });
  });
</script>
@endsection