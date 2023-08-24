<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Country;
use App\Models\Vendor;
use App\Models\VendorBankDetail;
use App\Models\VendorBusinessDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    public function dashboard(){
       Session::put('page', 'dashboard');

        return view('admin.dashboard');
    }

    public function updateAdminPassword(Request $request){
        Session::put('page', 'update-admin-password');
        if($request->isMethod('post')){
            $data = $request->all();

            // Check if current password entered by admin is correct
            if(Hash::check($data['current_password'], Auth::guard('admin')->user()->password)){

                // Check if new password is matching with confirm password
                if($data['new_password'] == $data['confirm_password']){
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_password'])]);

                    return redirect()->back()->with('success_message', 'Password has been updated successfully!');
                }else{
                    
                    return redirect()->back()->with('error_message', 'New Password and Confirm Password does not match!');
                }
            }else{

                return redirect()->back()->with('error_message', 'Your current password is Incorrect');
            }
        }
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first()->toArray();

        return view('admin.settings.update-admin-password')->with(compact('adminDetails'));
    }

    public function checkAdminPassword(Request $request){
        Session::put('page', 'dashboard');
        $data = $request->all();
        
        if(Hash::check($data['current_password'], Auth::guard('admin')->user()->password)){
            return "true";
        }else{
            return "false";
        }
    }

    public function updateAdminDetails(Request $request){
        Session::put('page', 'update-admin-details');
        if($request->isMethod('post')){
            $data = $request->all();

            $customMessage = [
                'admin_name.required' => 'Name is required',
                'admin_name.regex' => 'Valid Name is required',
                'admin_mobile.required' => 'Mobile is required',
                'admin_mobile.numeric' => 'Valid Mobile is required',
            ];

            $this->validate(request(), [
                'admin_name' => ['required', 'regex:/(^([a-zA-z]+)(\d+)?$)/u'],
                'admin_mobile' => ['required', 'numeric'],
            ], $customMessage);

            // Upload admin photo
            if($request->hasFile('admin_image')){
                $image_tmp = $request->file('admin_image');
                if($image_tmp->isValid()){

                    // Get image extension
                    $extention = $image_tmp->getClientOriginalExtension();

                    // Generate new image name
                    $imageName = rand(111,99999).'.'.$extention;
                    $imagePath = 'admin/images/photos/'.$imageName;
                    
                    // Upload the image
                    Image::make($image_tmp)->save($imagePath);
                }
            }else if(!empty($data['current_admin_image'])){
                $imageName = $data['current_admin_image'];
            }else{
                $imageName = "";
            }

            // Update admin details
            Admin::where('id', Auth::guard('admin')->user()->id)->update(['name' => $data['admin_name'], 'mobile' => $data['admin_mobile'], 'image' => $imageName]);
            
            return redirect()->back()->with('success_message', 'Admin details update successfully!');
        }

        return view('admin.settings.update-admin-details');
    }

    public function updateVendorDetails($slug, Request $request){
        if($slug == "personal"){
            Session::put('page', 'update-personal-details');
            if($request->isMethod('post')){
                $data = $request->all();

                $customMessage = [
                    'vendor_name.required' => 'Name is required',
                    'vendor_city.required' => 'City is required',
                    'vendor_country.required' => 'Country is required',
                    'vendor_mobile.required' => 'Mobile is required',
                    'vendor_mobile.numeric' => 'Valid Mobile is required',
                ];
    
                $this->validate(request(), [
                    'vendor_name' => ['required'],
                    'vendor_mobile' => ['required', 'numeric'],
                ], $customMessage);
    
                // Upload vendor photo
                if($request->hasFile('vendor_image')){
                    $image_tmp = $request->file('vendor_image');
                    if($image_tmp->isValid()){
    
                        // Get image extension
                        $extention = $image_tmp->getClientOriginalExtension();
    
                        // Generate new image name
                        $imageName = rand(111,99999).'.'.$extention;
                        $imagePath = 'admin/images/photos/'.$imageName;
                        
                        // Upload the image
                        Image::make($image_tmp)->save($imagePath);
                    }
                }else if(!empty($data['current_vendor_image'])){
                    $imageName = $data['current_vendor_image'];
                }else{
                    $imageName = "";
                }
    
                // Update admin details
                Admin::where('id', Auth::guard('admin')->user()->id)->update(['name' => $data['vendor_name'], 'mobile' => $data['vendor_mobile'], 'image' => $imageName]);    
                
                // Update vendor table
                Vendor::where('id', Auth::guard('admin')->user()->vendor_id)->update(
                    [
                        'name' => $data['vendor_name'],
                        'mobile' => $data['vendor_mobile'],
                        'address' => $data['vendor_address'],
                        'city' => $data['vendor_city'],
                        'country' => $data['vendor_country'],
                    ] 
                );

                return redirect()->back()->with('success_message', 'Admin details update successfully!');
            }
            $vendorDetails = Vendor::where('id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();

        }else if($slug == "business"){
            Session::put('page', 'update-business-details');
            if($request->isMethod('post')){
                $data = $request->all();

                $customMessage = [
                    'shop_name.required' => 'Name is required',
                    'shop_city.required' => 'City is required',
                    'shop_country.required' => 'Country is required',
                    'shop_mobile.required' => 'Mobile is required',
                    'shop_mobile.numeric' => 'Valid Mobile is required',
                ];

                $this->validate(request(), [
                    'shop_name' => ['required'],
                    'shop_mobile' => ['required', 'numeric'],
                ], $customMessage);

                // Update vendor table
                VendorBusinessDetail::where('id', Auth::guard('admin')->user()->vendor_id)->update(
                    [
                        'shop_name' => $data['shop_name'],
                        'shop_address' => $data['shop_address'],
                        'shop_city' => $data['shop_city'],
                        'shop_country' => $data['shop_country'],
                        'shop_mobile' => $data['shop_mobile'],
                    ] 
                );

                return redirect()->back()->with('success_message', 'Admin details update successfully!');
            }
            $vendorDetails = VendorBusinessDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
        }else if($slug == "bank"){
            Session::put('page', 'update-bank-details');
            if($request->isMethod('post')){
                $data = $request->all();

                $customMessage = [
                    'account_name.required' => 'Name is required',
                    'bank_name.required' => 'Name is required',
                    'account_number.required' => 'Account number is required',
                    'account_number.numeric' => 'Valid account number is required',
                ];
    
                $this->validate(request(), [
                    'account_name' => ['required'],
                    'bank_name' => ['required'],
                    'account_number' => ['required', 'numeric'],
                ], $customMessage);

                // Update bank table
                VendorBankDetail::where('id', Auth::guard('admin')->user()->vendor_id)->update(
                    [
                        'account_name' => $data['account_name'],
                        'bank_name' => $data['bank_name'],
                        'account_number' => $data['account_number'],
                    ] 
                );

                return redirect()->back()->with('success_message', 'Admin details update successfully!');
            }
            $vendorDetails = VendorBankDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
        }

        return view('admin.settings.update-vendor-details')->with(compact('slug', 'vendorDetails'));
    }

    public function login(Request $request){

        if($request->isMethod('post')){

            $data = $request->all();
            
            $request->validate([
                'email' => ['required', 'email','max:255'],
                'password' => ['required'],
            ]);

            $customMessage = [
                'email.required' => 'E-mail is required!',
                'email.email' => 'Valid email is required!',
                'password.required' => 'Password is required!'
            ];

            $this->validate($request, $customMessage);

            if(Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password'], 'status'=> 1])){

                return redirect('admin/dashboard');
            }else{

                return redirect()->back()->with('error_message','Invalid Email or Password!');
            }
        }

        return view('admin.login');
    }

    public function admins($type = null){
        $admins = Admin::query();
        if(!empty($type)){
            $admins = $admins->where('type',$type);
            $title = ucfirst($type);
            Session::put('page', 'view_'.strtolower($title));
        }else{
            $title = 'All Admins | Vendors';
            Session::put('page', '');

        }
        $admins = $admins->get()->toArray();

        return view('admin.admins.admins')->with(compact('admins', 'title'));
    }

    public function viewVendorDetails($id){
        $vendorDetails = Admin::with('vendorPersonal', 'vendorBusiness', 'vendorBank')->where('id', $id)->first();
        $vendorDetails = json_decode(json_encode($vendorDetails), true);
        
        return view('admin.admins.view-vendor-details')->with(compact('vendorDetails'));
    }

    public function updateAdminStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == "Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Admin::query()->where('id', $data['admin_id'])->update(['status' => $status]);

            return response()->json(['status' => $status, 'admin_id' =>  $data['admin_id']]);
        }
    }

    public function logout(){

        Auth::guard('admin')->logout();

        return redirect('admin/login');
    }
}
