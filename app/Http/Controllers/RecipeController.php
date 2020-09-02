<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use App\Recipe;
use App\Rate;
use App\User;
use DB;

class RecipeController extends Controller
{


  public function __construct()
  {
    $this->middleware('auth', ['except' => ['index', 'show']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function index()
  {
    //$recipes = Recipe::all();
    $recipes = Recipe::orderBy('title', 'asc')->get();

    // $ratings_array = array("user_id" => 0, 'recipe_id' => 0);
    // $new_ratings_array = array();
    // foreach ($ratings as $rating) {
    //   $ratings_array[$rating->user_id]
    // }

    //$recipes3 = DB::select('SELECT * FROM recipes ORDER BY title DESC');
    return view('recipes.index')->with('recipes', $recipes);
  }
  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('/recipes.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $this->validate($request, [
      'title' => 'required',
      'instructions' => 'required',
      'cover_image' => 'image|nullable|max:1999'
    ]);

    // handle file upload
    if ($request->hasFile('cover_image')) {
      // get file with extensions
      $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();

      // get filename
      $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);

      // GET JUST EXTENSION
      $extension = $request->file('cover_image')->getClientOriginalExtension();

      // filename to store
      $fileNameToStore = $filename . '_' . time() . '.' . $extension; //like blah_2020-08-26.png

      // upload image
      $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
    } else {
      $fileNameToStore = 'noimage.jpeg';
    }


    $recipe = new Recipe();
    $recipe->title = $request->input('title');
    $recipe->instructions = $request->input('instructions');
    $recipe->user_id = auth()->user()->id;
    $recipe->cover_image = $fileNameToStore;
    $recipe->rating = 0;
    $recipe->save();


    return redirect('/recipes')->with('success', 'Recipe created.');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $recipe = Recipe::find($id);
    return view('recipes/show')->with('recipe', $recipe);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {

    $recipe = Recipe::find($id);


    return view('recipes/show')->with('recipe', $recipe);

    if (Auth::id() !== $recipe->user_id) {
      return redirect('/recipessgit')->with('error', 'Unauthorized page.');
    }

    return view('recipes.edit')->with('recipe', $recipe);
  }


  public function vote(Request $request)
  {
    if (Auth::id() == null) {
      return redirect('/recipessgit')->with('error', 'Login in order to Like this recipe.');
    }

    $id = $request->input('id');
    $recipe = Recipe::find($id);

    $rate_user_id = Rate::where('recipe_id', $id)->pluck('user_id')->toArray();

    if (in_array(Auth::id(), $rate_user_id)) {
      return redirect('/recipes')->with('recipe', $recipe)->with('error', 'You already liked this recipe.');
    }

    $rate = new Rate();
    $rate->user_id = Auth::id();
    $rate->recipe_id = $id;
    $rate->save();

    $recipe = Recipe::find($id);
    Recipe::where('id', $rate->recipe_id)->increment('rating', 1);
    $recipe->save();

    return redirect()->route('recipes.show', [$recipe])->with('recipe', $recipe);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $this->validate($request, [
      'title' => 'required',
      'instructions' => 'required',
      'cover_image' => 'image|nullable|max:1999'
    ]);

    if ($request->hasFile('cover_image')) {

      $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
      $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
      $path = $request->file('cover_image')->storeAs('public/cover_images', $filename);
    }


    $recipe = Recipe::find($id);
    $recipe->title = $request->input('title');
    $recipe->instructions = $request->input('instructions');
    if ($request->hasFile('cover_image')) {
      $recipe->cover_image = $filename;
    }
    $recipe->save();

    return redirect()->route('recipes.index', [$recipe])->with('success', 'Recipe edited.');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $recipe = Recipe::find($id);
    $image_path = storage_path('app/public/cover_images/' . $recipe->cover_image);
    unlink($image_path);
    $recipe->delete();

    return redirect('/recipes')->with('success', 'Recipe deleted.');
  }
}
