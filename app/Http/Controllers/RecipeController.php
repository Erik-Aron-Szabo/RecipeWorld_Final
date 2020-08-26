<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
      $recipes = Recipe::all();
      $recipes2 = Recipe::orderBy('title', 'desc')->get();
      $recipes3 = DB::select('SELECT * FROM recipes ORDER BY title DESC');
        return view('recipes.index')->with('recipes', $recipes3);
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
          'instructions' => 'required'
        ]);

        $recipe = new Recipe();
        $recipe->title = $request->input('title');
        $recipe->instructions = $request->input('instructions');
        $recipe->user_id = auth()->user()->id;
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
          return redirect('/recipes')->with('error', 'Unauthorized page.');
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
          'instructions' => 'required'
        ]);

        $recipe = Recipe::find($id);
        $recipe->title = $request->input('title');
        $recipe->instructions = $request->input('instructions');
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
        $recipe->delete();
        return redirect()->route('recipes.index')->with('success', 'Recipe deleted.');
    }
}
