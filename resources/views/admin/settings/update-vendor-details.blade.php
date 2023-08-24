@extends('admin.layouts.layout')
@section('content')   
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Update Vendor Details</h3>
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
        @if($slug == "personal")      
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Update Personal Information</h4>
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
                    
                    <form class="forms-sample" action="{{ url('admin/update-vendor-details/personal') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Vendor Username/Email</label>
                            <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="">
                        </div>
                        <div class="form-group">
                            <label for="vendor_name">Name</label>
                            <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->name }}" id="vendor_name" placeholder="Enter vendor name" name="vendor_name">
                        </div>
                        <div class="form-group">
                            <label for="vendor_address">Address</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['address'] }}" id="vendor_address" placeholder="Enter vendor address" name="vendor_address">
                        </div>
                        <div class="form-group">
                            <label for="vendor_city">City</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['city'] }}" id="vendor_city" placeholder="Enter vendor city" name="vendor_city">
                        </div>
                        <div class="form-group">
                            <label for="vendor_country">Country</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['country'] }}" id="vendor_country" placeholder="Enter vendor country" name="vendor_country">
                        </div>
                        <div class="form-group">
                            <label for="vendor_mobile">Mobile</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['mobile'] }}" id="vendor_mobile" placeholder="Enter 10 digits number for your mobile" name="vendor_mobile" minlength="10" maxlength="10">
                        </div>
                        <div class="form-group">
                            <label for="vendor_image">Vendor Photo</label>
                            <input type="file" class="form-control" id="vendor_image" name="vendor_image">
                            @if(!empty(Auth::guard('admin')->user()->vendor_image))
                                <a target="_blank" href="{{ url('admin/images/photos/'.$vendorDetails['image']) }}">View Image</a>
                                <input type="hidden" name="current_vendor_image" value="{{ $vendorDetails['image'] }}">
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
        @elseif($slug == "business")
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Update Business Information</h4>
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
                    
                    <form class="forms-sample" action="{{ url('admin/update-vendor-details/business') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Vendor Username/Email</label>
                            <input class="form-control" value="{{ $vendorDetails['shop_email'] }}" readonly="">
                        </div>
                        <div class="form-group">
                            <label for="shop_name">Shop Name</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['shop_name'] }}" id="shop_name" placeholder="Enter shop name" name="shop_name">
                        </div>
                        <div class="form-group">
                            <label for="shop_address">Shop Address</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['shop_address'] }}" id="shop_address" placeholder="Enter shop address" name="shop_address">
                        </div>
                        <div class="form-group">
                            <label for="shop_city">Shop City</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['shop_city'] }}" id="shop_city" placeholder="Enter shop city" name="shop_city">
                        </div>
                        <div class="form-group">
                            <label for="shop_country">Shop Country</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['shop_country'] }}" id="shop_country" placeholder="Enter shop country" name="shop_country">
                        </div>
                        <div class="form-group">
                            <label for="shop_mobile">Shop Mobile</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['shop_mobile'] }}" id="shop_mobile" placeholder="Enter 10 digits number for your mobile" name="shop_mobile" minlength="10" maxlength="10">
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
        @elseif($slug == "bank")
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Update Bank Information</h4>
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
                    
                    <form class="forms-sample" action="{{ url('admin/update-vendor-details/bank') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Vendor Username/Email</label>
                            <input class="form-control" value="{{ Auth::guard('admin')->user()->email }}" readonly="">
                        </div>
                        <div class="form-group">
                            <label for="account_name">Account Name</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['account_name'] }}" id="account_name" placeholder="Enter shop name" name="account_name">
                        </div>
                        <div class="form-group">
                            <label for="account_number">Account Number</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['account_number'] }}" id="account_number" placeholder="Enter 10 digits number for your mobile" name="account_number" minlength="10" maxlength="10">
                        </div>
                        <div class="form-group">
                            <label for="bank_name">Bank Name</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['bank_name'] }}" id="bank_name" placeholder="Enter shop city" name="bank_name">
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>  
@include('admin.layouts.footer')
<!-- partial -->
@endsection
