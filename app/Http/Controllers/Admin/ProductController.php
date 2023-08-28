<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\ProdcutAttribute;
use App\Models\ProductImage;
use App\Models\Value;
use App\Models\Option;
use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use App\Models\ProductValue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

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

    
    public function deleteImage($id){
        // Delete image
        $productImage = ProductImage::select('image')->where('id', $id)->first();
        
        // Get product images path
        $small_image_path = 'front/images/product_images/small/';
        $medium_image_path = 'front/images/product_images/medium/';
        $large_image_path = 'front/images/product_images/large/';

        // Delete product small image if exists in small folder
        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }
        
        // Delete product medium image if exists in medium folder
        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }
        
        // Delete product large image if exists in large folder
        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }

        // Delete product image from products table
        ProductImage::where('id', $id)->delete();

        $message = "Image has been deleted successfully!";

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
            $product->product_discount = $data['product_discount'];// Upload category photo
            if($request->hasFile('product_image')){
               $image_tmp = $request->file('product_image');
               if($image_tmp->isValid()){

                   // Get image extension
                   $extention = $image_tmp->getClientOriginalExtension();

                   // Generate new image name
                   $imageName = rand(111,99999).'.'.$extention;
                   $largeImagePath = 'front/images/product_images/large/'.$imageName;
                   $mediumImagePath = 'front/images/product_images/medium/'.$imageName;
                   $smallImagePath = 'front/images/product_images/small/'.$imageName;

                   // Upload the image
                   Image::make($image_tmp)->resize(1000, 1000)->save($largeImagePath);
                   Image::make($image_tmp)->resize(500, 500)->save($mediumImagePath);
                   Image::make($image_tmp)->resize(250, 250)->save($smallImagePath);

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

            return redirect()->back()->with('success_message', 'Product has beend added successfully!');
        }
        // Get section with categories and subcategories
        $categoriesSection = Section::with('categories')->get();
        $categories = Category::all();

        // Get all brands
        $brands = Brand::where('status', 1)->get();

        return view('admin.products.add-edit-product',compact('title', 'categoriesSection', 'brands','categories'))->with('success_message', $message);
    }

    // Add Attributes
    public function addEditAttributes(Request $request, $id){
        Session::put('page', 'products');
        $product = Product::select('id', 'product_name', 'product_price', 'product_image')->with('attributes')->find($id);

        if($request->isMethod('post')){
            $data = $request->all();
            foreach($data['sku'] as $key => $value){
                // SKU duplicate check
                $skuCount = ProdcutAttribute::where('sku', $value)->count();
                if($skuCount > 0){
                    return redirect()->back()->with('error_message', 'SKU already exists Please add another sku!');
                }
                if(!empty($value)){
                    $attribute = new ProdcutAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->value_id = $data['value_id'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                
                    $attribute->save();
                }
            }
            
            return redirect()->back()->with('success_message', 'Attributes has been added successfully!');
        }

        return view('admin.attributes.add-edit-attributes')->with(compact('product'));      
    }

    public function updateAttributeStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == "Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProdcutAttribute::query()->where('id', $data['attribute_id'])->update(['status' => $status]);

            return response()->json(['status' => $status, 'attribute_id' =>  $data['attribute_id']]);
        }
    }

    // Edit attributes
    public function editAttributes(Request $request, $id){
        if($request->isMethod('post')){
            $data = $request->all();
            foreach($data['attributeId'] as $key => $attribute){
                if(!empty($attribute)){
                    ProdcutAttribute::where(['id'=>$data['attributeId'][$key]])->update(['price'=> $data['price'][$key]], ['stock' => $data['stock'][$key]]);
                }
            }

            return redirect()->back()->with('success_message', 'Attributes have been updated successfully!');
        }

    }

    // Add Images
    public function addImages(Request $request, $id){
        Session::put('page', 'products');
        $product = Product::select('id', 'product_name', 'product_price', 'product_image')->with('images')->find($id);
        if($request->isMethod('post')){
            if($request->hasFile('images')){
                $images = $request->file('images');
                foreach($images as $key => $image){
                    // Get image temp image
                    $image_tmp = Image::make($image);
                    // Get image name
                    $image_name = $image->getClientOriginalName();
                    // Get image extension
                    $extention = $image->getClientOriginalExtension();

                    // Generate new image name
                    $imageName = $image_name.rand(111,99999).'.'.$extention;
                    $largeImagePath = 'front/images/product_images/large/'.$imageName;
                    $mediumImagePath = 'front/images/product_images/medium/'.$imageName;
                    $smallImagePath = 'front/images/product_images/small/'.$imageName;

                    // Upload the image
                    Image::make($image_tmp)->resize(1000, 1000)->save($largeImagePath);
                    Image::make($image_tmp)->resize(500, 500)->save($mediumImagePath);
                    Image::make($image_tmp)->resize(250, 250)->save($smallImagePath);

                    $image = new ProductImage;
                    $image->image = $imageName;
                    $image->product_id = $id;
                    $image->status = 1;

                    $image->save();
                }

                return redirect()->back()->with('success_message', 'Product Images has been added successfully!');
            }
        }
        return view('admin.images.add-images')->with(compact('product'));
    }

    // Update image status
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
    /*************************************************************************************************/

    public function getOption($id)
    {
        $product = Product::findOrFail($id);
        $category = $product->category;
        $options = $category->options;

        // dd($product);


        return view('admin.products.add_option', compact('options', 'id'));

    }

    /*************************************************************************************************/


    public function getOptionValue($id)
    {
        $option = Option::with('values')->findOrFail($id);

        $option_values = $option->values;

        return $option_values;
    }


    /*************************************************************************************************/

    public function addOption(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $product_value = ProductValue::where('product_id',$request->product_id)->where('value_id',$request->option_value_id)->first();

        if(isset($product_value))
        {
            Session::flash('message','product`s option value already exists ');
            return back();
        }
        else
        {
            $product->values()->attach($request->option_value_id);
            return redirect()->back()->with('success','option value add successfully');
        }

    }


}
