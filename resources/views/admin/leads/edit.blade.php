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
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/leads') }}">Leads</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>
        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{baseUrl('/leads')}}">
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
      <form id="form" class="js-validate" action="{{ baseUrl('/leads/update/'.base64_encode($record->id)) }}" method="post">

        @csrf
        <!-- Input Group -->
        <div class="row justify-content-md-between">
            <div class="col-md-6">
                <div class="js-form-message form-group row">
                  <label class="col-sm-2 col-form-label">Name</label>
                  <div class="col-sm-10 font-weight-bold">
                      <div class="input-group input-group-sm-down-break">
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" id="first_name" placeholder="Your first name" aria-label="Your first name" value="{{ $record->first_name }}">
                        @error('first_name')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" id="last_name" placeholder="Your last name" aria-label="Your last name" value="{{ $record->first_name }}">
                        @error('last_name')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>
                  </div>
                </div>
            </div>
            <div class="col-md-6">
              <div class="js-form-message form-group row">
                <label class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                 <input type="email" name="email" placeholder="Your email" value="{{ $record->email }}" class="form-control">
               </div>
              </div>
            </div>
        </div>
        <div class="form-group">
          <button type="submit" class="btn add-btn btn-primary">Save</button>
        </div>
        <!-- End Input Group -->

      </div><!-- End Card body-->
    </div>
    <!-- End Card -->
  </div>
  <!-- End Content -->
  @endsection

@section('javascript')
<script src="assets/vendor/hs-quantity-counter/dist/hs-quantity-counter.min.js"></script>
<script type="text/javascript">
    
$(document).on('ready', function () {
  // initialization of quantity counter
  $('.js-quantity-counter').each(function () {
    var quantityCounter = new HSQuantityCounter($(this)).init();
  });

  $("#form").submit(function(e){
      e.preventDefault();
      var formData = $("#form").serialize();
      var url  = $("#form").attr('action');
      $.ajax({
          url:url,
          type:"post",
          data:formData,
          dataType:"json",
          beforeSend:function(){
            showLoader();
          },
          success:function(response){
            hideLoader();
            if(response.status == true){
              successMessage(response.message);
              redirect(response.redirect_back);
            }else{
              $.each(response.message, function (index, value) {
                  $("*[name="+index+"]").parents(".js-form-message").find("#"+index+"-error").remove();
                  $("[name="+index+"]").parents(".js-form-message").find(".form-control").removeClass('is-invalid');
                  
                  var html = '<div id="'+index+'-error" class="invalid-feedback">'+value+'</div>';
                  $(html).insertAfter("*[name="+index+"]");
                  $("[name="+index+"]").parents(".js-form-message").find(".form-control").addClass('is-invalid');
              });
              // errorMessage(response.message);
            }
          },
          error:function(){
            internalError();
          }
      });
  });
});

</script>

  @endsection