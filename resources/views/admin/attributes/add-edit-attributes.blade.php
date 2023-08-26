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
                    
                    <form class="forms-sample" action="{{ url('admin/attributes/add-edit-attributes/'. $product['id']) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="product_name">Product Name: &nbsp; {{ $product['product_name'] }}</label>
                                
                        </div>
                        <div class="form-group">
                            <label for="product_price">Product Price: &nbsp; {{ $product['product_price'] }}</label>
                        </div>
                        <div class="form-group">
                            @if(!empty($product->product_image))
                                <img target="_blank" style="width:120px;" src="{{ url('front/images/product_images/'.$product['product_image']) }}" alt="">
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="field_wrapper">
                                <div>
                                    <input type="number" name="value_id[]" placeholder="Value" style="width:120px;" required="" />
                                    <input type="text" name="sku[]" placeholder="SKU" style="width:120px;" required="" />
                                    <input type="number" name="price[]" placeholder="Price" style="width:120px;" required="" />
                                    <input type="number" name="stock[]" placeholder="Stock" style="width:120px;" required="" />
                                    <a href="javascript:void(0);" class="add_button" title="Add Attributes">Add</a>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="table-responsive pt-3">
                <form method="post" action="{{ url('admin/attributes/add-edit-attributes/'.$product['id']) }}">
                    @csrf
                    <table id="products" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>
                                    ID
                                </th>
                                <th>
                                    Value
                                </th>
                                <th>
                                    SKU
                                </th>
                                <th>
                                    Price
                                </th>
                                <th>
                                    Stock
                                </th>
                                <th>
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($product->attributes as $attribute)
                            <input style="display:none;" type="hidden" name="attributeId" value="{{ $attribute->id }}" >
                            <tr>
                                <td>
                                    {{ $attribute->id }}
                                </td>
                                <td>
                                    {{ $attribute->value_id }}
                                </td>
                                <td>
                                    {{ $attribute->sku}}
                                </td>
                                <td>
                                    <input type="number" name="price" value="{{ $attribute->price }}" requried="" style="width:70px;">
                                </td>
                                <td>
                                    <input type="number" name="stock" value="{{ $attribute->stock }}" requried="" style="width:70px;">
                                </td>
                                <td>
                                    @if($attribute['status'] == 1)
                                        <a href="javascript:void(0)" class="update-attribute-status" id="attribute-{{ $attribute['id'] }}" attribute_id="{{ $attribute['id'] }}"><i style="font-size: 25px;" class="mdi mdi-bookmark-check" status="Active"></i></a>
                                    @else
                                        <a href="javascript:void(0)" class="update-attribute-status" id="attribute-{{ $attribute['id'] }}" attribute_id="{{ $attribute['id'] }}"><i style="font-size: 25px;" class="mdi mdi-bookmark-outline" status="Inactive"></i>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Update Attributes</button>
                </form>
            </div>
        </div>
    </div> 
</div>
@include('admin.layouts.footer')
<!-- partial -->
@endsection
