<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BrandController extends Controller
{
    public function brands(){
        Session::put('page', 'brands');
        $brands = Brand::get()->toArray();

        return view('admin.brands.brands')->with(compact('brands'));
    }
public function updateBrandStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == "Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Brand::query()->where('id', $data['brand_id'])->update(['status' => $status]);

            return response()->json(['status' => $status, 'brand_id' =>  $data['brand_id']]);
        }
    }

    public function deleteBrand($id){
        // Delete brand
        Brand::where('id', $id)->delete();
        $message = "Brand has been deleted successfully!";

        return redirect()->back()->with('success_message', $message);
    }

    public function addEditbrand(Request $request, $id = null){
        Session::put('page', 'brands');
        if($id == ""){
            $title = "Add brand";
            $brand = new Brand;
            $message = "Brand added successfully";
        }else{
            $title = "Edit brand";
            $brand = Brand::find($id);
            $message = "brand updated successfully";
        }
        if($request->isMethod('post')){
            $data = $request->all();
            $customMessages = [
                'brand_name.required' => 'Name is required'
            ];

            $this->validate(request(), [
                'brand_name' => 'required',
            ], $customMessages);

            $brand->name = $data['brand_name'];
            $brand->status = 1;
            $brand->save();

            return redirect('admin/brands')->with('success_message', $message);
        }
        
        return view('admin.brands.add-edit-brand')->with(compact('title', 'brand'));
    }
}
