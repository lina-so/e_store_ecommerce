@extends('admin.layouts.layout')
@section('content')   
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Settings</h3>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="justify-content-end d-flex">
                        <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                        <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                            <a class="dropdown-item" href="#">January - March</a>
                            <a class="dropdown-item" href="#">March - June</a>
                            <a class="dropdown-item" href="#">June - August</a>
                            <a class="dropdown-item" href="#">August - November</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-panel">        
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ $title }}</h4>
                    @if(Session::has('error_message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> {{ Session::get('error_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    
                    @if(Session::has('success_message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> {{ Session::get('success_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    <form class="forms-sample" @if(empty($value['id'])) action="{{ url('admin/values/add-edit-value') }}" @else action="{{ url('admin/values/add-edit-value/'.$value['id']) }}" @endif method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Value Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter value Name" name="name" @if(empty($value['name'])) value="{{ $value['name'] }}" @else value="{{ old('name') }}" @endif>
                        </div>
                        <div class="form-group">
                            <label for="option_id">Select Value</label>
                            <select name="option_id" id="option_id" class="form-control">
                                <option value="">Select</option>
                                @foreach($options as $option)
                                    <option label="{{ $option['name'] }}">{{ $option['id'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>  
@include('admin.layouts.footer')
<!-- partial -->
@endsection
