@extends('layouts.master')

@section('content')
<!-- Content -->
<div class="content container-fluid">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/visa-services') }}">Services</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>
        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{baseUrl('visa-services')}}">
          <i class="tio mr-1"></i> Back 
        </a>
      </div>
    </div>
    <!-- End Row -->
  </div>
  <!-- End Page Header -->

  <!-- Card -->
  <div class="card">

    <div class="card-body">
      <form id="visaServices-form" class="js-validate" action="{{ baseUrl('/visa-services/save') }}" method="post">

        @csrf
         <!-- Input Group -->
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Service Under</label>
          <div class="col-sm-10">
            <select class="form-control" name="parent_id">
              <option value="0">None</option>
              @foreach($main_services as $service)
              <option value="{{ $service->id }}">{{$service->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <!-- End Input Group -->
        <!-- Input Group -->
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Name</label>
          <div class="col-sm-10">
            <input type="text" name="name" id="name" placeholder="Enter Visa Service" class="form-control">
          </div>
        </div>
        <!-- End Input Group -->
        <div class="js-form-message form-group row">
          <label class="col-sm-2 col-form-label">Documents</label>
          <div class="col-sm-10">
            <select class="form-control" multiple name="document_folders[]">
              @foreach($documents as $document)
              <option value="{{ $document->id }}">{{$document->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <button type="button" class="btn add-btn btn-primary">Add</button>
        </div>
        <!-- End Input Group -->

      </div><!-- End Card body-->
    </div>
    <!-- End Card -->
  </div>
  <!-- End Content -->
  @endsection

  @section('javascript')
  <script type="text/javascript">
    $(document).ready(function(){
      $(".add-btn").click(function(e){
        e.preventDefault(); 
        $(".add-btn").attr("disabled","disabled");
        $(".add-btn").find('.fa-spin').remove();
        $(".add-btn").prepend("<i class='fa fa-spin fa-spinner'></i>");
        
        var name = $("#name").val();
        var formData = $("#visaServices-form").serialize();
        $.ajax({
          url:"{{ baseUrl('visa-services/save') }}",
          type:"post",
          data:formData,
          dataType:"json",
          beforeSend:function(){
          },
          success:function(response){
           $(".add-btn").find(".fa-spin").remove();
           $(".add-btn").removeAttr("disabled");
           if(response.status == true){
            successMessage(response.message);
            window.location.href = response.redirect_back;
          }else{
            $.each(response.message, function (index, value) {
              $("input[name="+index+"]").parents(".js-form-message").find("#"+index+"-error").remove();
              $("input[name="+index+"]").parents(".js-form-message").find(".form-control").removeClass('is-invalid');

              var html = '<div id="'+index+'-error" class="invalid-feedback">'+value+'</div>';
              $(html).insertAfter("*[name="+index+"]");
              $("input[name="+index+"]").parents(".js-form-message").find(".form-control").addClass('is-invalid');
            });
          }
        },
        error:function(){
         $(".add-btn").find(".fa-spin").remove();
         $(".add-btn").removeAttr("disabled");
       }
     });
      });
    });
  </script>

  @endsection