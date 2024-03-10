<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all(); ///Return Collection Object , we can get $categories[0] or $categories->first();

        return view('dashboard.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $parents = Category::all();
        return view('dashboard.categories.create',compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ///we can access data of request in multiple ways
//        $request->input('name');
//        $request->post('name'); //from method post parameters
//        $request->query(); //from URL
//        $request->name;
//        $request['name'];
//        $request->all();

//        $request->all(); //return array of all input data
//        $request->only(['name','parent_id']);
//        $request->except(['image','status']);

        //if i want record in database
        $request->merge([
            'slug' => Str::slug($request->name),
        ]);// --->>  'Sport Clothes!!'=> 'sport-clothes',
                  // 'ملابس'=>'mlabes'

        $category = Category::create($request->all());



        ///PRG
        return redirect()->route('dashboard.categories.index')->with('success','Category Created');
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
        $category = Category::findOrFail($id);

        $parents = Category::where('id','<>',$id)
            ->where(function ($query) use($id){
                $query->whereNull('parent_id')
                    ->where('parent_id','<>',$id);
            })
            ->get();
        return view('dashboard.categories.edit',compact('category','parents'));
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
        $category = Category::find($id);
//        $category = Category::update([
//            '',
//            '',
//        ]);
        $category->update($request->all());
        return redirect()->route('dashboard.categories.index')->with('success','Category Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('dashboard.categories.index')->with('success','Category Deleted');
    }
}
