<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // All category showing method
    public function index(){
        // $data = DB::table('categories')->get(); //using query builder
        $data = Category::all(); // using models
        return view('admin.category.category.index', compact('data'));
    }

    //store method

    public function store(Request $request)
    {
        $validated = $request->validate([
         'category_name' => 'required|unique:categories|max:55',
        
    ]);

    //query Builder
    //  $data=array();
    //  $data['category_name']=$request->category_name;
    //  $data['category_slug']=Str::slug('Laravel 5 Framework', '-');
    // $data['category_slug']=Str::slug($request->category_name, '-');
    //  DB :: table('categories')->insert($data);

    // Eloquent ORM
    Category::insert([
        'category_name'=> $request->category_name,
        'category_slug'=> str::slug($request->category_name, '-')
    ]);
        
         
        $notification=array('messege' => 'Category inserted!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    //edit method
    public function edit($id)
    {
    	// $data=DB::table('categories')->where('id',$id)->first();
    	$data=Category::findorfail($id);
        // return view('admin.category.category.edit',compact('data'));
    	return response()->json($data);
    } 
    
    //update method
    public function update(Request $request)
    {
        //Query Builder update
        // $id=$request->id;
        // $data=array();
        // $data['category_name']=$request->category_name;
        // $data['category_slug']=str::slug($request->category_name, '-');
        // DB::table('categories')->where('id',$request->id)->update($data);

        // Eloquent ORM
        $category=Category::where('id',$request->id)->first();
        $category->update([
            'category_name'=>$request->category_name,
            'category_slug'=> str::slug($request->category_name, '-')
        ]);

        $notification=array('messege' => 'Category Updated!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }    

    //delete category method
    public function destroy($id)
    {
    	//query builder
    	   //DB::table('categories')->where('id',$id)->delete();
    	//eleqoent ORM
    	$category=Category::find($id);
    	$category->delete();

    	$notification=array('messege' => 'Category Deleted!', 'alert-type' => 'success');
    	return redirect()->back()->with($notification);
    }
}
