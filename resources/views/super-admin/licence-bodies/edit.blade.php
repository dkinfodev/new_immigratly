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
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/licence-bodies') }}">Licence Bodies</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Edit</a></li>
            <li class="breadcrumb-item active" aria-current="page">Licence Bodies</li>
          </ol>
        </nav>

        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{baseUrl('licence-bodies/')}}">
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
      <form id="licenceBodies-form" class="js-validate" action="{{ baseUrl('/licence-bodies/save') }}" method="post">

        @csrf
        <!-- Input Group -->
        <div class="js-form-message form-group">
          <label class="input-label">Licence Body</label>

          <textarea class="form-control form-control-flush" rows=3 name="name" id="name" placeholder="Enter name of licence body..." required data-msg="Please enter a licence body name." >
            {{ $record->name }}
          </textarea>
          <input type="hidden" value="{{base64_encode($record->id)}}" name="rid" id="rid">
        </div>
        <!-- End Input Group -->

        <!-- Input Group -->
        <div class="js-form-message form-group">
          <label class="input-label">Country</label>
          <select name="country_id" id="country_id" class="custom-select custom-select-flush">
            @foreach($countries as $key=>$c)
            <option <?php if(($record->country_id)==($c->id)) {echo "selected";} else {echo ""; }  ?> value="{{$c->id}}" name="{{$c->name}}">{{$c->name}}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group">
          <button type="button" class="btn update-btn btn-primary">Update</button>
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
      $(".update-btn").click(function(e){
        e.preventDefault(); 
        $(".update-btn").attr("disabled","disabled");
        $(".update-btn").find('.fa-spin').remove();
        $(".update-btn").prepend("<i class='fa fa-spin fa-spinner'></i>");
        
        var id = $("#rid").val();
        var name = $("#name").val();
        var country_id = $("#country_id").val();
        var formData = $("#licenceBodies-form").serialize();
        $.ajax({
          url:"{{ baseUrl('licence-bodies/update') }}",
          type:"post",
          data:formData,
          dataType:"json",
          beforeSend:function(){

          },
          success:function(response){
           $(".update-btn").find(".fa-spin").remove();
           $(".update-btn").removeAttr("disabled");
           if(response.status == true){
            successMessage(response.message);
            window.location.href = response.redirect_back;
          }else{
            $.each(response.message, function (index, value) {
              $("input[name="+index+"]").parents(".js-form-message").find("#"+index+"-error").remove();
              $("input[name="+index+"]").parents(".js-form-message").find(".form-control").removeClass('is-invalid');

              var html = '<div id="'+index+'-error" class="invalid-feedback">'+value+'</div>';
              $("input[name="+index+"]").parents(".js-form-message").append(html);
              $("input[name="+index+"]").parents(".js-form-message").find(".form-control").addClass('is-invalid');
            });
          }
        },
        error:function(){
         $(".signup-btn").find(".fa-spin").remove();
         $(".signup-btn").removeAttr("disabled");
       }
     });
      });
    });
  </script>


  @endsection