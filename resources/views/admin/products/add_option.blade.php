@extends('admin.layouts.layout')
@section('content')

@if (session()->has('message'))
<div class="alert alert-danger">
    {{ session()->get('message') }}
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<!-- partial -->
<div class="main-panel">
   <div class="content-wrapper">
      <div class="row">
         <div class="col-lg-12 grid-margin stretch-card">




            <!-- row -->
        <div class="card">
            <div class="card-body">
                <h4>Add Product`s Option</h4><br>
                <div class="col-lg-12 margin-tb">

                <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
                    action="{{route('addOption')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $id }}">
                    <div class="row mg-b-20">
                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" >
                            <label for="option_id">option :</label>
                            <select class="custom-select mr-sm-2" name="option_id">
                                <option selected disabled>choose..</option>
                                @foreach($options as $option)
                                    <option  style="color: black" value="{{ $option->id }}">{{ $option->name }}</option>
                                @endforeach
                            </select>
                            </div>

                        <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" >
                            <label for="Classroom_id">option_value : <span class="text-danger">*</span></label>
                            <select class="custom-select mr-sm-2" name="option_value_id">

                            </select>
                        </div>

                    </div>

                    <br>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-left">
                        <button class="btn btn-primary pd-x-20 " type="submit">save</button>
                    </div>
                </form>
            </div>


        </div>
            <!-- row closed -->
         </div>
      </div>
   </div>
   <!-- content-wrapper ends -->
   <!-- partial:../../partials/_footer.html -->
   <footer class="footer">
      <div class="d-sm-flex justify-content-center justify-content-sm-between">
         <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.  Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
         <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
      </div>
   </footer>
   <!-- partial -->
</div>
<!-- main-panel ends -->
@endsection

