<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Categories::all()->toArray();
        return view('categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('categories.create');
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
        $this->validate($request,[
            'Title' => 'required',
            'Keyword' => 'required',
            'Active' => 'required'
        ]);

        $category = new Categories([
            'Title' => $request->get('Title'),
            'Keyword' => $request->get('Keyword'),
            'Active' => $request->get('Active')
        ]);

        $category->save();
        return redirect()->route('categories.index')->with('success', 'Category was added succesfully!');
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
        $categories = Categories::find($id);
        return view('categories.edit',compact('categories','id'));
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
        //
        $this->validate($request,[
            'Title' => 'required',
            'Keyword' => 'required',
            'Active' => 'required'
        ]);

        $categories = Categories::find($id);
        $categories->Title = $request->get('Title');
        $categories->Keyword = $request->get('Keyword');
        $categories->Active = $request->get('Active');
        $categories->save();
        return redirect()->route('categories.index')->with('success','Category was updated succesfully!'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $categories = Categories::find($id);
        $categories->delete();
        return redirect()->route('categories.index')->with('success','Category was deleted succesfully!');
    }
}
