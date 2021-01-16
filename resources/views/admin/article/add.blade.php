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
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/article') }}">Article</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>

        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="">
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
      <form id="form" class="js-validate" action="{{ baseUrl('staff/save') }}" method="post">

        @csrf
        
      
        <div class="form-group">
          <label>Category</label>
          <select name="category" class="form-control" id="category">
            <option>Select</option>
          </select>
        </div>

        <div class="form-group">
          <label>Tags</label>
          <select name="tags" class="form-control" id="tags">
            <option>Select</option>
          </select>
        </div>

        <div class="form-group">
          <label>Title</label>
          <input type="text" class="form-control" name="title" id="title">
        </div>


        <div class="form-group">
            <div class="btn-group" role="group">
               <a class="btn btn-primary"  href="javascript:;" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="tio-upload-on-cloud mr-1"></i>Image</a>
            </div>
         </div>

        <div id="collapseOne" class="collapse" aria-labelledby="headingOne">
          <div class="card-body">
            <!-- Dropzone -->
            
               <div class="dz-message custom-file-boxed-label">
                  <img class="avatar avatar-xl avatar-4by3 mb-3" src="./assets/svg/illustrations/browse.svg" alt="Image Description">
                  <h5 class="mb-1">Drag and drop your file here</h5>
                  <p class="mb-2">or</p>
                  <span class="btn btn-sm btn-white">Browse files</span>
               </div>

          </div>
            <!-- End Dropzone -->
        </div>

        <div class="form-group">
          <label>Short Description</label>
          <input type="text" class="form-control" name="short_description" id="short_description">
        </div>
     

        <div class="form-group">
          <label>Content</label>
          <textarea name="article_content" id="article_content" class="form-control"></textarea>
        </div>

        <div class="form-group">
          <label>Share with</label>
          <select name="share_with" class="form-control" id="share_with">
            <option>Public</option>
            <option>Private</option>
          </select>
        </div>

        <div class="form-group">
          <label>Content Block</label>
          <select name="content_block" class="form-control" id="content_block">
            <option>Select</option>
          
          </select>
        </div>
        

  

        <div class="form-group">
          <button type="submit" class="btn add-btn btn-primary">Add</button>
        </div>
        <!-- End Input Group -->
      </form>
    </div><!-- End Card body-->
  </div>
<!-- End Card -->
</div>
<!-- End Content -->

@endsection


@section('javascript')
<!-- JS Implementing Plugins -->

<!-- JS Implementing Plugins -->
<script src="assets/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside.min.js"></script>
<script src="assets/vendor/hs-nav-scroller/dist/hs-nav-scroller.min.js"></script>
<script src="assets/vendor/hs-go-to/dist/hs-go-to.min.js"></script>
<script src="assets/vendor/list.js/dist/list.min.js"></script>
<script src="assets/vendor/prism/prism.js"></script>
<script src="assets/vendor/hs-step-form/dist/hs-step-form.min.js"></script>
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>

<script src="assets/vendor/hs-toggle-password/dist/js/hs-toggle-password.js"></script>
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="assets/vendor/select2/dist/js/select2.full.min.js"></script>

<script src="assets/vendor/quill/dist/quill.min.js"></script>


<script>
  $(document).on('ready', function () {

    initEditor("article_content"); 

    $('#date_of_birth').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
      maxDate:(new Date()).getDate(),
      todayHighlight: true,
      orientation: "bottom auto"
    });

    // initialization of Show Password
    $('.js-toggle-password').each(function () {
        new HSTogglePassword(this).init()
    });


    // initialization of quilljs editor
    $('.js-flatpickr').each(function () {
      $.HSCore.components.HSFlatpickr.init($(this));
    });
    // initEditor("about_professional");
    
    $("#form").submit(function(e){
      e.preventDefault();
      var formData = new FormData($(this)[0]);
      var url  = $("#form").attr('action');
      $.ajax({
        url:url,
        type:"post",
        data:formData,
        cache: false,
        contentType: false,
        processData: false,
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
            validation(response.message);
          }
        },
        error:function(){
            internalError();
        }
      });
      
    });
  });
  

  function stateList(country_id,id){
    $.ajax({
      url:"{{ url('states') }}",
      data:{
        country_id:country_id
      },
      dataType:"json",
      beforeSend:function(){
       $("#"+id).html('');
     },
     success:function(response){
      if(response.status == true){
        $("#"+id).html(response.options);
      } 
    },
    error:function(){

    }
  });
  }

  function cityList(state_id,id){
    $.ajax({
      url:"{{ url('cities') }}",
      data:{
        state_id:state_id
      },
      dataType:"json",
      beforeSend:function(){
       $("#"+id).html('');
     },
     success:function(response){
      if(response.status == true){
        $("#"+id).html(response.options);
      } 
    },
    error:function(){

    }
  });
  }
</script>

@endsection