<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Recipe;

class CommentController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {

    $comment = new Comment();
    $comment->recipe_id = $request->input('recipe_id');
    $comment->user_id = $request->input('user_id');
    $comment->message = $request->input('message');
    $comment->save();

    $id = $request->input('recipe_id');
    $recipe = Recipe::find($id);

    return redirect()->route('recipes.show', [$recipe])->with('recipe', $recipe);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $id = $request->input('comment_id');
    $comment = Comment::find($id);
    $comment->message = $request->input('message');
    $comment->save();


    $recipe_id = $request->input('recipe_id');
    $recipe = Recipe::find($recipe_id);

    return redirect()->route('recipes.show', [$recipe])->with('recipe', $recipe);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
    $id = $request->input('comment_id');
    $comment = Comment::find($id);
    $comment->delete();

    $recipe_id = $request->input('recipe_id');
    $recipe = Recipe::find($recipe_id);

    return redirect()->route('recipes.show', [$recipe])->with('recipe', $recipe);
  }
}
