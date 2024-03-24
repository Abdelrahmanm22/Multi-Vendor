<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $category = new Category();
        return view('dashboard.categories.create',compact('category','parents'));
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

        $request->merge([
            'slug' => Str::slug($request->name),
        ]);// --->>  'Sport Clothes!!'=> 'sport-clothes',
        // 'ملابس'=>'mlabes'

        ///Handling Upload Files
        $data = $request->except('image');
        $data['image'] = $this->uploadFile($request);

        //if i want record in database
        $category = Category::create($data);



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
        $old_image = $category->image;
        $data = $request->except('image');
        $data['image'] = $this->uploadFile($request);

        $category->update($data);

        if ($old_image and $data['image']){ //isset ==> mwgod w msh null
            Storage::disk('public')->delete($old_image);
        }
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
//        Category::destroy($id);
        //el tarteb mohem
        $category = Category::findOrFail($id);
        $category->delete();
        if ($category->image){
            Storage::disk('public')->delete($category->image);
        }
        return redirect()->route('dashboard.categories.index')->with('success','Category Deleted');
    }

    protected function uploadFile(Request $request)
    {

        if (!$request->hasFile('image')){
            return;
        }
        $file = $request->file('image'); ///uploaded file obj
//            $file->getClientOriginalName(); Esmo el 2asly
//            $file->getSize();
//            $file->getClientOriginalExtension();
        $path = $file->store('uploads',[
            'disk'=>'public'
        ]);
        return $path;
    }
}
