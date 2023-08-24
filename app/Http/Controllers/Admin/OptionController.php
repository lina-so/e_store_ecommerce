<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OptionController extends Controller
{
    public function options(){
        Session::put('page', 'options');
        $options = Option::get()->toArray();

        return view('admin.options.options')->with(compact('options'));
    }

    public function deleteOption($id){
        // Delete option
        Option::where('id', $id)->delete();
        $message = "Option has been deleted successfully!";

        return redirect()->back()->with('success_message', $message);
    }

    public function addEditOption(Request $request, $id = null){
        Session::put('page', 'options');
        if($id == ""){
            $title = "Add Option";
            $option = new Option;
            $message = "Option added successfully";
        }else{
            $title = "Edit Option";
            $option = Option::find($id);
            $message = "Option updated successfully";
        }
        if($request->isMethod('post')){
            $data = $request->all();
            $customMessages = [
                'name.required' => 'Option name is required'
            ];

            $this->validate(request(), [
                'name' => 'required',
            ], $customMessages);

            $option->name = $data['name'];
            $option->save();

            return redirect('admin/options')->with('success_message', $message);
        }
        $getOptions = Option::get()->toArray();

        return view('admin.options.add-edit-option')->with(compact('title', 'option'));
    }
}
