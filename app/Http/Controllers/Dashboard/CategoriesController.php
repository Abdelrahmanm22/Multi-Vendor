<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
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
        $request = request();
        $categories = Category::leftJoin('categories as parents','parents.id','=','categories.parent_id')
            ->select(
                'categories.*',
                'parents.name as parent_name'
            )
            ->filter($request->query())
            ->paginate(5);
        return view('dashboard.categories.index',compact('categories'));
    }
//    public function index()
//    {
////        $categories = Category::all(); ///Return Collection Object , we can get $categories[0] or $categories->first();
//        ///to use search
//        $request = request();
//        $query = Category::query();
//        if ($name=$request->query('name')){
//            $query->where('name','LIKE',"%{$name}%");
//        }
//        if ($status= $request->query('status')){
//            $query->where('status','=',$status);
//        }
//
////        $categories = Category::paginate(2);//default is 15 row
////        $categories = $query->paginate(2);
//        $categories = Category::active()->paginate(2); //for local scope
//        return view('dashboard.categories.index',compact('categories'));
//    }

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
    public function store(CategoryRequest $request)
    {
//        return 0;
        // If the request reaches here, it means it has passed validation


        ///Request Validation
//        $request->validate([
//           'name'=>'required|string|min:3|max:255', //255 number of characters
//            'parent_id'=>[
//                'nullable',
//                'int',
//                'exists:categories,id',
//            ],
//            'image'=>[
//                'image',
//                'max:1048576', //1048576 bytes
//                'dimensions:min_width=100,min_height=100',
//            ],
//            'status'=>'in:active,archived',
//        ]);


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

        return $data['image'];

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
    public function update(CategoryRequest $request, $id)
    {
        ///Request Validation
//        $request->validate([
//            'name'=>'required|string|min:3|max:255', //255 number of characters
//            'parent_id'=>[
//                'nullable',
//                'int',
//                'exists:categories,id',
//            ],
//            'image'=>[
//                'image',
//                'max:1048576', //1048576 bytes
//                'dimensions:min_width=100,min_height=100',
//            ],
//            'status'=>'in:active,archived',
//        ]);

        $category = Category::find($id);
//        $category = Category::update([
//            '',
//            '',
//        ]);
        $old_image = $category->image;
        $data = $request->except('image');
        $new_image = $this->uploadFile($request);
        if ($new_image) {
            $data['image'] = $new_image;
        }

        $category->update($data);

        if ($old_image and $new_image){ //isset ==> mwgod w msh null
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
        ///when use soft delete we want not delete image so comment this if
//        if ($category->image){
//            Storage::disk('public')->delete($category->image);
//        }
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

    public function trash()
    {

        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash',compact('categories'));
    }
    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        //عايز ارجع من الناس المعمولها سوفت ديليت
        $category->restore();
        return redirect()->route('dashboard.categories.trash')->with('success','Category Restored..');
    }
    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);

        $category->forceDelete(); //بتشيله نهائيا
        if ($category->image){
            Storage::disk('public')->delete($category->image);
        }
        return redirect()->route('dashboard.categories.trash')->with('success','Category Deleted Forever..');

    }
}
