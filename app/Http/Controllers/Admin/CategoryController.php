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

    // All category showing metho
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
     $data=array();
     $data['category_name']=$request->category_name;
    //  $data['category_slug']=Str::slug('Laravel 5 Framework', '-');
    $data['category_slug']=Str::slug($request->category_name, '-');
     DB :: table('categories')->insert($data);
        
         
        $notification=array('messege' => 'Category inserted!', 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }

    //delete category method
    //  public function destroy($id)
    //  {
    //     DB::table('categories')->where('id',$id)->delete(); 

    //      $notification=array('messege' => 'Category deleted!', 'alert-type' => 'success');
    //     return redirect()->back()->with($notification);
    //  }
}
