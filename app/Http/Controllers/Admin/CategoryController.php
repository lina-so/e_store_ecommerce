<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Models\Option;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function categories(){
        Session::put('page', 'categories');
        $categories = Category::with(['section', 'parentCategory'])->get();

        return view('admin.categories.categories')->with(compact('categories'));
    }

    public function updateCategoryStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == "Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Category::query()->where('id', $data['category_id'])->update(['status' => $status]);

            return response()->json(['status' => $status, 'category_id' =>  $data['category_id']]);
        }
    }

    public function deleteCategory($id){
        // Delete category
        Category::where('id', $id)->delete();
        $message = "Category has been deleted successfully!";

        return redirect()->back()->with('success_message', $message);
    }

    public function deleteCategoryImage($id){
        // Get category image
        $categoryImage = Category::select('category_image')->where('id', $id)->first();

        // Get Category image path
        $categoryImagePath = 'front/images/category_images/';

        // Delete Category image form category_image folder if exists
        if(file_exists($categoryImagePath.$categoryImage->category_image)){
            unlink($categoryImagePath.$categoryImage->category_image);
        }

        // Delete category image from categories
        Category::where('id', $id)->update(['category_image' => '']);
        $message = 'Category image has been deleted successfully';

        return redirect()->back()->with('success_message', $message);
    }

    public function addEditCategory(Request $request, $id = null){
        Session::put('page', 'categories');
        if($id == ""){
            $title = "Add Category";
            $category = new Category;
            $message = "Category added successfully";
        }else{
            $title = "Edit Category";
            $category = Category::find($id);
            $getCategories = Category::with('subcategories')->where(['parent_id' => 0, 'section_id' => $category['section_id']])->get();
            $message = "Category updated successfully";
        }
        if($request->isMethod('post')){
            $data = $request->all();

            $rules = [
                'category_name' => 'required',
                'section_id' => 'required',
            ];

            $customMessages = [
                'category_name' => 'Category name is required',
                'section_id' => 'Section is required',
            ];

            $this->validate($request, $rules, $customMessages);

            if($data['category_discount'] == ""){
                $data['category_discount'] = 0;
            }

            if($data['description'] == ""){
                $data['description'] = "";
            }

            // Upload category photo
             if($request->hasFile('category_image')){
                $image_tmp = $request->file('category_image');
                if($image_tmp->isValid()){

                    // Get image extension
                    $extention = $image_tmp->getClientOriginalExtension();

                    // Generate new image name
                    $imageName = rand(111,99999).'.'.$extention;
                    $imagePath = 'front/images/category_images/'.$imageName;
                    
                    // Upload the image
                    Image::make($image_tmp)->save($imagePath);

                    $category->category_image = $imageName;
                }
            }else{
                $category->category_image = "";
            }
            $category->section_id = $data['section_id'];
            $category->parent_id = $data['parent_id'];
            $category->category_name = $data['category_name'];
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->status = $data['status'];
            $category->save();
            $category->options()->attach($data['option_id']);

            return redirect('/admin/categories')->with('success_message', $message);
        }
        // Get all sections
        $getSections = Section::get();

        // Get all categories
        $getCategories = Category::get();

        // Get all options
        $options = Option::get();

        return view('admin.categories.add-edit-category')->with(compact('title', 'category', 'getSections', 'getCategories', 'options'));
    }
}
