@extends('layouts.master')

@section('style')
<link rel="stylesheet" href="assets/vendor/quill/dist/quill.snow.css">
@endsection


@section('content')
<!-- Content -->
<div class="content container-fluid">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Account</a></li>
            <li class="breadcrumb-item active" aria-current="page">Settings</li>
          </ol>
        </nav>

        <h1 class="page-header-title">Settings</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="user-profile-my-profile.html">
          <i class="tio-user mr-1"></i> My profile
        </a>
      </div>
    </div>
    <!-- End Row -->
  </div>
  <!-- End Page Header -->

  <div class="row">
    
    <div class="col-lg-12">
      <form method="post" id="form" class="js-validate" action="{{baseUrl('/submit-profile') }}">  
      @csrf
      <!-- Card -->
      <div class="card mb-3 mb-lg-5">
        <!-- Profile Cover -->
        <div class="profile-cover">
          <div class="profile-cover-img-wrapper">
            <img id="profileCoverImg" class="profile-cover-img" src="./assets/img/1920x400/img2.jpg" alt="Image Description">

            <!-- Custom File Cover -->
            <div class="profile-cover-content profile-cover-btn">
              <div class="custom-file-btn">
                <input type="file" class="js-file-attach custom-file-btn-input" name="profile_image" id="profileCoverUplaoder"
                data-hs-file-attach-options='{
                "textTarget": "#profileCoverImg",
                "mode": "image",
                "targetAttr": "src"
              }'>
              <label class="custom-file-btn-label btn btn-sm btn-white" for="profileCoverUplaoder">
                <i class="tio-add-photo mr-sm-1"></i>
                <span class="d-none d-sm-inline-block">Update your header</span>
              </label>
            </div>
          </div>
          <!-- End Custom File Cover -->
        </div>
      </div>
      <!-- End Profile Cover -->

      <!-- Avatar -->
      <label class="avatar avatar-xxl avatar-circle avatar-border-lg avatar-uploader profile-cover-avatar" for="avatarUploader">
        <img id="avatarImg" class="avatar-img" src="./assets/img/160x160/img6.jpg" alt="Image Description">

        <input type="file" class="js-file-attach avatar-uploader-input" id="avatarUploader"
        data-hs-file-attach-options='{
        "textTarget": "#avatarImg",
        "mode": "image",
        "targetAttr": "src"
      }'>

      <span class="avatar-uploader-trigger">
        <i class="tio-edit avatar-uploader-icon shadow-soft"></i>
      </span>
    </label>
    <!-- End Avatar -->

    <!-- Body -->
    <div class="card-body">
      <div class="row">
        <div class="col-sm-5">
          <span class="d-block font-size-sm mb-2">Who can see your profile photo? <i class="tio-help-outlined" data-toggle="tooltip" data-placement="top" title="Your visibility setting only applies to your profile photo. Your header image is always visible to anyone."></i></span>

          <!-- Select -->
          <div class="select2-custom">
            <select class="js-select2-custom"
            data-hs-select2-options='{
            "minimumResultsForSearch": "Infinity"
          }'>
          <option value="privacy1" data-option-template='<span class="media"><i class="tio-earth-east tio-lg text-body mr-2" style="margin-top: .125rem;"></i><span class="media-body"><span class="d-block">Anyone</span><small class="select2-custom-hide">Visible to anyone who can view your content. Accessible by installed apps.</small></span></span>'>Anyone</option>
          <option value="privacy2" data-option-template='<span class="media"><i class="tio-lock-outlined tio-lg text-body mr-2" style="margin-top: .125rem;"></i><span class="media-body"><span class="d-block">Only you</span><small class="select2-custom-hide">Only visible to you.</small></span></span>'>Only you</option>
        </select>
      </div>
      <!-- End Select -->
    </div>
  </div>
  <!-- End Row -->
</div>
<!-- End Body -->
</div>
<!-- End Card -->

<!-- Card -->
<div class="card mb-3 mb-lg-5">
  <div class="card-header">
    <h2 class="card-title h4">Personal information</h2>
  </div>

  <!-- Body -->
  <div class="card-body">
    <!-- Form -->
    
      <!-- Form Group -->
      <div class="row form-group js-form-message">
        <label class="col-sm-3 col-form-label input-label">Full name <i class="tio-help-outlined text-body ml-1" data-toggle="tooltip" data-placement="top" title="Displayed on public forums, such as Front."></i></label>

        <div class="col-sm-9">
          <div class="input-group input-group-sm-down-break">
            <input type="text" class="form-control" name="first_name" id="first_name" value="{{$user->first_name}}" placeholder="Your first name" aria-label="Your first name" >
            
            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Your last name" value="{{$user->last_name}}" aria-label="Your last name">
            

          </div>
        </div>
      </div>
      <!-- End Form Group -->

      <!-- Form Group -->
      <div class="row form-group js-form-message">
        <label class="col-sm-3 col-form-label input-label">Email</label>

        <div class="col-sm-9">
          <input type="email" class="form-control" name="email" id="email" placeholder="Your email" value="{{$user->email}}" aria-label="Email" value="mark@example.com">
          
        </div>
      </div>
      <!-- End Form Group -->

      <!-- Form Group -->
      <div class="row form-group js-form-message">
        <label class="col-sm-3 col-form-label input-label">Phone </label>

        <div class="col-sm-2">
          <select name="country_code" class="form-control">

            @foreach($countries as $key=>$c)

            @if($c->phonecode == $user->country_code)
            <option id="{{$c->phonecode}}" value="+{{$c->phonecode}}" selected="true">+{{$c->phonecode}}</option>
            @else
            <option id="{{$c->phonecode}}" value="+{{$c->phonecode}}">+{{$c->phonecode}}</option>
            @endif

            @endforeach
            
          </select>
        </div>

        <div class="col-sm-7">
          <input type="text" name="phone_no" value="{{$user->phone_no}}" id="phone_no" class="form-control">

        </div>
      </div>      
      <!-- End Form Group -->
      <!-- Form Group -->
      <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    
    <!-- End Form -->
  </div>
  <!-- End Body -->
</div>
<!-- End Card -->

<!-- Sticky Block End Point -->
<div id="stickyBlockEndPoint"></div>
</form>
</div>
</div>
<!-- End Row -->
</div>
<!-- End Content -->

@endsection


@section('javascript')

<!-- JS Implementing Plugins -->
<script src="assets/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside.min.js"></script>
<script src="assets/vendor/hs-unfold/dist/hs-unfold.min.js"></script>
<script src="assets/vendor/hs-form-search/dist/hs-form-search.min.js"></script>
<script src="assets/vendor/hs-file-attach/dist/hs-file-attach.min.js"></script>
<script src="assets/vendor/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
<script src="assets/vendor/select2/dist/js/select2.full.min.js"></script>
<script src="assets/vendor/hs-sticky-block/dist/hs-sticky-block.min.js"></script>
<script src="assets/vendor/hs-scrollspy/dist/hs-scrollspy.min.js"></script>
<script src="assets/vendor/pwstrength-bootstrap/dist/pwstrength-bootstrap.min.js"></script>

<script src="assets/vendor/quill/dist/quill.min.js"></script>


<!-- JS Front -->
<!-- <script src="assets/js/theme.min.js"></script> -->

<!-- JS Plugins Init. -->
<script>
  $(document).on('ready', function () {

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
</script>
 @endsection
