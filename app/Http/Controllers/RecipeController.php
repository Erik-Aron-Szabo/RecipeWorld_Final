<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use App\Recipe;
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
    $order = array('asc', 'desc');
    $orderDesc = 'desc';
    //$recipes = Recipe::all();
    $recipes = Recipe::orderBy('title', 'asc')->get();
    //$recipes3 = DB::select('SELECT * FROM recipes ORDER BY title DESC');
    return view('recipes.index')->with('recipes', $recipes);
  }

  public function desc()
  {
    $recipes = Recipe::orderBy('title', 'desc')->get();
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
    return view('recipes.show')->with('recipe', $recipe);
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

    if (Auth::id() !== $recipe->user_id) {
      return redirect('/recipessgit')->with('error', 'Unauthorized page.');
    }
    return view('recipes.edit')->with('recipe', $recipe);
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
      $path = $request->file('cover_image')->storeAs('public/cover_images');
    }


    $recipe = Recipe::find($id);
    $recipe->title = $request->input('title');
    $recipe->instructions = $request->input('instructions');
    if ($request->hasFile('cover_image')) {
      $recipe->cover_image = $fileNameToStore;
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
