<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use App\Recipe;
use DB;

class OrderController extends Controller
{
  //
  public function getGuzzleRequest()
  {

    $client = new \GuzzleHttp\Client();

    $request = $client->get('http://recipeworld.erik/recipes?sortOrder=title_desc');

    $response = $request->getBody();

    dd($response);
  }


  public function descending(Request $request)
  {
    $recipes = Recipe::orderBy('title', 'desc')->get();
    return view('recipes.index_desc')->with('recipes', $recipes);
  }

  public function ascending()
  {
    $recipes = Recipe::orderBy('title', 'asc')->get();
    return view('recipes.index')->with('recipes', $recipes);
  }
}
