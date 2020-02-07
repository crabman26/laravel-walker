<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ads;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $ads = Ads::all()->toArray();
        return view('ads.index',compact('ads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('ads.create');
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
        $this->validate($request, [
            'Name' => 'required',
            'Surname' => 'required'
        ]);
        $ad = new Ads([
            'Name' => $request->get('Name'),
            'Surname' => $request->get('Surname'),
            'Town' => $request->get('Town'),
            'Region' => $request->get('Region'),
            'Email' => $request->get('E-mail'),
            'Description' => $request->get('Description'),
            'State' => $request->get('State')
        ]);

        $ad->save();
        return redirect()->route('ads.index')->with('success', 'Ad was added succesfully.');

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
        $ads = Ads::find($id);
        return view('ads.edit',compact('ads','id'));
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
        $this->validate($request, [
            'Name' => 'required',
            'Surname' => 'required'
        ]);

        $ads = Ads::find($id);
        $ads->Name = $request->get('Name');
        $ads->Surname = $request->get('Surname');
        $ads->Town = $request->get('Town');
        $ads->Region = $request->get('Region');
        $ads->Email = $request->get('E-mail');
        $ads->Description = $request->get('Description');
        $ads->State = $request->get('State');
        $ads->save();
        return redirect()->route('ads.index')->with('success','Ad was updated succesfully!');
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
        $ads = Ads::find($id);
        $ads->delete();
        return redirect()->route('ads.index')->with('success','Ad was deleted succesfully');
    }
}
