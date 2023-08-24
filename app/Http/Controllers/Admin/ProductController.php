<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
use App\Models\Section;
use App\Models\Value;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function products(){
        Session::put('page', 'products');
        $products = Product::with('section')->with('category')->get();

        return view('admin.products.products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == "Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Product::query()->where('id', $data['product_id'])->update(['status' => $status]);

            return response()->json(['status' => $status, 'product_id' =>  $data['product_id']]);
        }
    }

    public function deleteProduct($id){
        // Delete product
        Product::where('id', $id)->delete();
        $message = "Product has been deleted successfully!";

        return redirect()->back()->with('success_message', $message);
    }

    public function addEditProduct(Request $request, $id = null){
        Session::put('page', 'products');
        if($id == ""){
            $title = "Add Product";
            $product = new Product;
            $message = "Product added successfully";
        }else{
            $title = "Edit Product";
            $product = Product::find($id);
            $message = "Product updated successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'category_id' => 'required',
                'product_name' => 'required',
                'product_price' => 'required',
            ];

            $customMessages = [
                'category_id' => 'Category is required',
                'product_name.required' => 'Product name is required',
                'product_price.required' => 'Product price is required',
            ];

            $this->validate($request, $rules, $customMessages);

            if($data['product_discount']==""){
                $data['product_discount'] = 0;
            }
            // Save product details
            $product->category_id = $data['category_id'];

            $product->brand_id = $data['brand_id'];
            $adminType = Auth::guard('admin')->user()->type;
            $vendorId = Auth::guard('admin')->user()->vendor_id;
            $adminId = Auth::guard('admin')->user()->id;
            $product->admin_type = $adminType;
            $product->vendor_id = $vendorId;
            if($adminType == "vendor"){
                $product->vendor_id = $vendorId;
            }else{
                $product->vendor_id = 0;
            }
            $product->product_name = $data['product_name'];
            $product->product_discount = $data['product_discount'];// Upload category photo
            if($request->hasFile('product_image')){
               $image_tmp = $request->file('product_image');
               if($image_tmp->isValid()){

                   // Get image extension
                   $extention = $image_tmp->getClientOriginalExtension();

                   // Generate new image name
                   $imageName = rand(111,99999).'.'.$extention;
                   $imagePath = 'front/images/product_images/'.$imageName;
                   
                   // Upload the image
                   Image::make($image_tmp)->save($imagePath);

                   $product->product_image = $imageName;
               }
           }else{
               $product->product_image = "";
           }
            $product->description = $data['description'];
            if(!empty($data['is_featured'])){
                $product->is_featured = $data['is_featured'];
            }else{
                $product->is_featured = "No";
            }

            $product->status = 1;
            $product->save();

        }
        // Get section with categories and subcategories
        $categoriesSection = Section::with('categories')->get();
        $categories = Category::all();

        // Get all brands
        $brands = Brand::where('status', 1)->get();

        return view('admin.products.add-edit-product',compact('title', 'categoriesSection', 'brands','categories'))->with('success_message', $message);
    }
}
