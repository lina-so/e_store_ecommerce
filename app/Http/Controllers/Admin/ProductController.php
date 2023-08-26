<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductImages;
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

    public function updateAttributeStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == "Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Product::query()->where('id', $data['attribute_id'])->update(['status' => $status]);

            return response()->json(['status' => $status, 'attribute_id' =>  $data['attribute_id']]);
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
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            // Upload Product photo
            if($request->hasFile('product_image')){
               $image_tmp = $request->file('product_image');
               if($image_tmp->isValid()){

                   // Get image extension
                   $extention = $image_tmp->getClientOriginalExtension();

                   // Generate new image name
                   $imageName = rand(111,99999).'.'.$extention;
                   $largeImagePath = 'front/images/product_images/large/'.$imageName;
                   $meduimImagePath = 'front/images/product_images/medium/'.$imageName;
                   $smallImagePath = 'front/images/product_images/small/'.$imageName;
                   
                   // Upload the image
                   Image::make($image_tmp)->resize(1000, 1000)->save($largeImagePath);
                   Image::make($image_tmp)->resize(500, 500)->save($meduimImagePath);
                   Image::make($image_tmp)->resize(250, 250)->save($smallImagePath);

                   $product->product_image = $imageName;
               }
           }

            $product->description = $data['description'];
            if(!empty($data['is_featured'])){
                $product->is_featured = $data['is_featured'];
            }else{
                $product->is_featured = "No";
            }

            $product->status = 1;
            $product->save();

            return redirect('/admin/products')->with('success_message', $message);
        }
        // Get section with categories and subcategories
        $categoriesSection = Section::with('categories')->get();
        $categories = Category::all();

        // Get all brands
        $brands = Brand::where('status', 1)->get();

        // Get all values
        $values = Value::get();

        return view('admin.products.add-edit-product',compact('title', 'categoriesSection', 'brands','categories', 'values'));
    }

    public function addAttributes(Request $request, $id){
        Session::put('page', 'products');
        $title = "Add Attributes";
        $product = Product::select('id', 'product_name', 'product_price', 'product_image')->with('attributes')->find($id);
        if($request->isMethod('post')){
            $data = $request->all();
            
            foreach($data['sku'] as $key => $value){
                if(!empty($value)){
                    $attribute = new ProductAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->value_id = $data['value_id'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();
                }
            }

            return redirect()->back()->with('success_message', 'Product Attribute has been added successfully!');
        }

        return view('admin.attributes.add-edit-attributes')->with(compact('title', 'product'));
    }
    
    // Edit attributes
    public function editAtributes(Request $request, $id){
        Session::put('page', 'attributes');
        if($request->isMethod('post')){
            $data = $request->all();
            dd($data);
            foreach($data['attributeId'] as $key => $value){
                if(!empty($attribute)){
                    ProductAttribute::where(['id' => $data['attribute'][$key]])->update(['price' => $data['price'][$key], 'stock'=>$data['stock'][$key]]);
                }
            }
            return redirect()->back()->with('success_message', 'Product Attributes has been updated successfully!');
        }
    }

    // Delete attribute
    public function deleteAttribute($id){
        // Delete 
        ProductAttribute::where('id', $id)->delete();
        $message = "Product attribute has been deleted successfully!";

        return redirect()->back()->with('success_message', $message);
    }

    // Add images
    public function addImages(Request $request, $id){
        Session::put('page', 'product');
        $product = Product::select('id', 'product_name', 'product_price', 'product_image')->with('images')->find($id);
       if($request->isMethod('post')){
            $data = $request->all();
            // Upload product photo
            if($request->hasFile('images')){
                $images = $request->file('images');
                foreach($images as $key => $image){
                    // Generate temp image
                    $image_tmp = Image::make($image);

                    // Get image name
                    $image_name = $image->getClientOriginalExtension();

                    // Get image extension
                    $extention = $image->getClientOriginalExtension();

                    // Generate new image name
                    $imageName = $image_name.rand(111,99999).'.'.$extention;
                    $largeImagePath = 'front/images/product_images/large/'.$imageName;
                    $meduimImagePath = 'front/images/product_images/medium/'.$imageName;
                    $smallImagePath = 'front/images/product_images/small/'.$imageName;
        
                    // Upload the image
                    Image::make($image_tmp)->resize(1000, 1000)->save($largeImagePath);
                    Image::make($image_tmp)->resize(500, 500)->save($meduimImagePath);
                    Image::make($image_tmp)->resize(250, 250)->save($smallImagePath);
                    
                    $image = new ProductImages;
                    $image->image = $imageName;
                    $image->product_id = $id;
                    $image->status = 1;
                    
                    $image->save();
                }
                
            return redirect()->back()->with('success_message', 'Product images have been added successfully!');
            }
        }

        return view('admin.images.add-images')->with(compact('product'));
    }

    public function updateImageStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == "Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Product::query()->where('id', $data['image_id'])->update(['status' => $status]);

            return response()->json(['status' => $status, 'image_id' =>  $data['image_id']]);
        }
    }

    // Delete image
    public function deleteImage($id){
        // Delete image
        ProductImages::where('id', $id)->delete();
        $message = "Product image has been deleted successfully!";

        return redirect()->back()->with('success_message', $message);
    }
}
