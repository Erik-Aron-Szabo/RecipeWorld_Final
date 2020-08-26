@extends('layouts.app')

@section('content')

<h2>Recipes</h2>
<small>Here you can find the recipies to make.</small>
<br><hr>

{{-- Ul the recipes from DB --}}
{{-- RecipeController -> 'recipes' ==> ALL the recipes in DB --}}
@if (count($recipes) > 0)
  <div class="card">
    <ul class="list-group list-group-flush">
      @foreach ($recipes as $recipe)
        <li class="list-group-item">
          <h4><a href="/recipes/{{$recipe->id}}">{{$recipe->title}}</a></h4>
        </li>
      @endforeach
    </ul>
  </div>
@endif

@endsection
