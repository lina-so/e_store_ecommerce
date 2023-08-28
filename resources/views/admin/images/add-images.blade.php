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
                <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Product Images</h4>
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
                        <form class="forms-sample" action="{{ url('admin/add-images/'. $product['id']) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="product_name">Product Name: &nbsp; {{ $product->product_name }}</label>
                            </div>
                            <div class="form-group">
                                <label for="product_price">Product Price: &nbsp; {{ $product->product_price }}</label>
                            </div>
                            <div class="form-group">
                                @if(!empty($product->product_image))
                                    <img style="width:120px;" src="{{ url('front/images/product_images/'. $product['product_image']) }}" alt="">
                                @endif                            
                            </div>
                            <div class="form-group">
                                <input type="file" name="images[]" multiple="" id="images">
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <button class="btn btn-light">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ url('admin/edit-attributes/'. $product['id']) }}">
                @csrf
                    <table id="products" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    ID
                                </th>
                                <th>
                                    Image
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($product['images'] as $image)
                            <tr>
                                <td>
                                    {{ $image['id'] }}
                                </td>
                                <td>
                                    <img src="{{ url('front/images/product_images/small/'.$image['image']) }}" alt="">
                                </td>
                                
                                <td>
                                    @if($image['status'] == 1)
                                        <a href="javascript:void(0)" class="update-image-status" id="image-{{ $image['id'] }}" image_id="{{ $image['id'] }}"><i style="font-size: 25px;" class="mdi mdi-bookmark-check" status="Active"></i></a>
                                    @else
                                        <a href="javascript:void(0)" class="update-image-status" id="image-{{ $image['id'] }}" image_id="{{ $image['id'] }}"><i style="font-size: 25px;" class="mdi mdi-bookmark-outline" status="Inactive"></i>
                                    @endif
                                </td>
                                <td>
                                    <a title="Delete Image" href="{{ url('admin/delete-image/'.$image['id']) }}" class="confirmDelete" module="image" moduleid="{{ $image['id'] }}"><i style="font-size: 25px;" class="mdi mdi-file-excel-box"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
</div>
@include('admin.layouts.footer')
<!-- partial -->
@endsection
