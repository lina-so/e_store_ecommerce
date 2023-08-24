@extends('admin.layouts.layout')
@section('content')   
@include('admin.layouts.footer')
@section('content')
<!-- partial -->
<div class="main-panel">
   <div class="content-wrapper">
      <div class="row">
         <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
               <div class="card-body">
                  <h4 class="card-title">Options</h4>
                  <a style="max-width: 150px; float: right; display: inline-block;" href="{{ url('admin/options/add-edit-option') }}" class="btn btn-block btn-primary">Add Option</a>
                  @if(Session::has('success_message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> {{ Session::get('success_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="table-responsive pt-3">
                     <table id="options" class="table table-bordered">
                        <thead>
                           <tr>
                              <th>
                                 Option ID
                              </th>
                              <th>
                                 Name
                              </th>
                              <th>
                                 Actions
                              </th>
                           </tr>
                        </thead>
                        <tbody>
                        @foreach($options as $option)
                           <tr>
                                <td>
                                    {{ $option['id'] }}
                                </td>
                                <td>
                                    {{ $option['name'] }}
                                </td>
                                <td>
                                    <a href="{{ url('admin/options/add-edit-option/'.$option['id']) }}"><i style="font-size: 25px;" class="mdi mdi-pencil-box"></i></a>
                                    <a href="javascript:void(0)" class="confirmDelete" module="option" moduleid="{{ $option['id'] }}"><i style="font-size: 25px;" class="mdi mdi-file-excel-box"></i></a>
                                </td>
                           </tr>
                        @endforeach
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
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
