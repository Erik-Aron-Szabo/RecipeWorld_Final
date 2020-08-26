@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                  <div class="card-body">
                    <a href="recipes/create" class="btn btn-primary">Create Recipe</a>
                    <hr>
                    @if (session('status'))
                      <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                      </div>
                    @endif
                    <h2 class="card-title">My Recipes</h2>
                    @if (count($recipes) > 0)
                      <table class="table table-striped">
                        <tr>
                          <th>Title</th>
                          <th></th>
                          <th></th>
                        </tr>
                        @foreach ($recipes as $recipe)
                          <tr>
                            <th>{{$recipe->title}}</th>
                            <th><a class="btn btn-default" href="recipes/{{$recipe->id}}/edit">Edit</a></th>
                          </tr>
                        @endforeach
                      </table>
                    @else
                      <p>You don't have any recipes yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
