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
                    
                    <form class="forms-sample" @if(empty($product['id'])) action="{{ url('admin/products/add-edit-product') }}" @else action="{{ url('admin/products/add-edit-product/'.$product['id']) }}" @endif method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="category_id">Select Category</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="">Select</option>
                                @foreach($categoriesSection as $section)
                                    <optgroup label="{{ $section['name'] }}"></optgroup>
                                    @foreach($section['categories'] as $category)
                                        <optgroup label="{{ $category['category_name'] }}">$categroy['category_name']</optgroup>
                                        @if(!empty($category['subcategories']))
                                            @foreach($category['subcategories'] as $subcategory)
                                                <option value="{{ $subcategory['id'] }}">{{ $subcategory['category_name'] }}</option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="brand_id">Select Brand</label>
                            <select name="brand_id" id="brand_id" class="form-control" style="color: #000;">
                                <option value="">Select</option>
                                @foreach($brands as $brand)
                                   <option value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" id="product_name" placeholder="Enter product Name" name="product_name" @if(!empty($product['product_name'])) value="{{ $product['product_name'] }}" @else value="{{ old('product_name') }}" @endif>
                        </div>
                        <div class="form-group">
                            <label for="product_price">Product Price</label>
                            <input type="text" class="form-control" id="product_price" placeholder="Enter product price" name="product_price" @if(!empty($product['product_price'])) value="{{ $product['product_price'] }}" @else value="{{ old('product_price') }}" @endif>
                        </div>
                        <div class="form-group">
                            <label for="product_discount">Product Discount (%)</label>
                            <input type="text" class="form-control" id="product_discount" placeholder="Enter product discount" name="product_discount" @if(!empty($product['product_discount'])) value="{{ $product['product_discount'] }}" @else value="{{ old('product_discount') }}" @endif>
                        </div>
                        <div class="form-group">
                            <label for="option_id">Product Image</label>
                            <input type="file" name="product_image" id="product_image" class="form-control"></input>
                            @if(!empty($product['product_image']))
                                <a target="_blank" href="{{ url('front/images/product_image/'.$product['product_image']) }}">View Image</a>&nbsp;|&nbsp;
                                <a href="javascript:void(0)" class="confirmDelete" module="product-image" moduleid="{{ $product['id'] }}">Delete Image</a>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="description">Product Description</label>
                            <textarea class="form-control" id="description" placeholder="Enter description" name="description" @if(!empty($product['description'])) value="{{ $product['description'] }}" @else value="{{ old('description') }}" @endif></textarea>
                        </div>
                        <div class="form-group">
                            <label for="is_featured">Featured Items</label>
                            <input type="checkbox" class="form-control" style="width: 15px; height:15px; display: inline-block" id="is_featured" name="is_featured" value="Yes" @if(!empty($product['is_featured']) && $product['is_featured'] == "Yes") checked="" @endif/>
                        </div>
                        <div class="form-group">
                            <label for="status">product Status</label>
                            <select name="status" id="status">
                                <option value="0">Inactive</option>
                                <option value="1">Active</option>
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
