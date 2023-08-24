<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Value;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ValueController extends Controller
{
    public function values(){
        Session::put('page', 'values');
        $values = Value::with(['option'])->get();

        return view('admin.values.values')->with(compact('values'));
    }

    public function deleteValue($id){
        // Delete value
        value::where('id', $id)->delete();
        $message = "Value has been deleted successfully!";

        return redirect()->back()->with('success_message', $message);
    }

    public function addEditValue(Request $request, $id = null){
        Session::put('page', 'values');
        if($id == ""){
            $title = "Add value";
            $value = new Value;
            $message = "Value added successfully";
        }else{
            $title = "Edit value";
            $value = Value::find($id);
            $message = "value updated successfully";
        }
        if($request->isMethod('post')){
            $data = $request->all();
            $customMessages = [
                'name.required' => 'Value name is required'
            ];

            $this->validate(request(), [
                'name' => 'required',
            ], $customMessages);

            $value->name = $data['name'];
            $value->option_id = $data['option_id'];
            $value->save();

            return redirect('admin/values')->with('success_message', $message);
        }
        // Get all options
        $options = Option::with('values')->get();

        return view('admin.values.add-edit-value')->with(compact('title', 'value', 'options'));
    }
}
