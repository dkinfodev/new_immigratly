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
            
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="javascript:;">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Profile</li>
          </ol>
        </nav>

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
      <!-- Card -->
      <div class="card mb-3 mb-lg-5">
        <!-- Profile Cover -->
        <div class="profile-cover">
          <div class="profile-cover-img-wrapper">
            <img id="profileCoverImg" class="profile-cover-img" src="./assets/img/1920x400/img2.jpg" alt="Image Description">

            <!-- Custom File Cover -->
            <div class="profile-cover-content profile-cover-btn">
              <div class="custom-file-btn">
                <input type="file" class="js-file-attach custom-file-btn-input" id="profileCoverUplaoder"
                data-hs-file-attach-options='{
                "textTarget": "#profileCoverImg",
                "mode": "image",
                "targetAttr": "src"
              }'>
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
    <form method="post" class="js-validate" action="{{baseUrl('/update-profile') }}">  
      {{ csrf_field() }}
      <!-- Form Group -->
      <div class="row form-group js-form-message">
        <label class="col-sm-3 col-form-label input-label">Full name <i class="tio-help-outlined text-body ml-1" data-toggle="tooltip" data-placement="top" title="Displayed on public forums, such as Front."></i></label>

        
          <div class="col-sm-5">
            <div class="js-form-message">
              <input type="text" name="first_name" id="first_name" value="{{$record->first_name}}" class="form-control" placeholder="Your first name" aria-label="Your first name" >
            </div>
          </div>

          <div class="col-sm-4">
            <div class="js-form-message">
              <input type="text" name="last_name" id="last_name" value="{{$record->last_name}}" class="form-control" placeholder="Your last name" aria-label="Your first name" >
            </div>
          </div>
        </div>
      
      <!-- End Form Group -->

      <!-- Form Group -->
      <div class="row form-group js-form-message">
        <label class="col-sm-3 col-form-label input-label">Email</label>

        <div class="col-sm-9">
          <div class="js-form-message">
            <input type="email" class="form-control" name="email" id="email" placeholder="Your email" value="{{$record->email}}" aria-label="Email" value="mark@example.com">
          </div>
        </div>
      </div>
      <!-- End Form Group -->

      <!-- Form Group -->
      <div class="row form-group js-form-message">
        <label class="col-sm-3 col-form-label input-label">Phone </label>

        <div class="col-sm-2">
          <div class="js-form-message">
            <select name="country_code" id="country_code" class="form-control">
              <option value="">Select Country</option>
              @foreach($countries as $country)
              <option {{$record->country_code == $country->phonecode?"selected":""}} value="+{{$country->phonecode}}">+{{$country->phonecode}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="col-sm-7">
          <div class="js-form-message">
            <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Phone number" aria-label="phone no" required data-msg="Please enter your phone number." value="{{$record->phone_no}}">
          </div>
        </div>
      </div>      
      <!-- End Form Group -->

      <!-- Form Group -->
      <div class="row form-group js-form-message">
        <label class="col-sm-3 col-form-label input-label">Gender </label>

        <div class="col-sm-9">
          <div class="js-form-message">
            <select name="gender" class="form-control">
              <option value="">Select Gender</option>
              <option {{ (!empty($record2) && $record2->gender == 'male')?'checked':'' }} value="male">Male</option>
              <option {{ (!empty($record2) && $record2->gender == 'female')?'checked':'' }} value="female">Female</option>
            </select>
          </div>
        </div>

      </div>      
      <!-- End Form Group -->
      

      <!-- Form Group -->
      <div class="row form-group js-form-message">
        <label class="col-sm-3 col-form-label input-label">Date of Birth </label>

        <div class="col-sm-9">
          <div class="js-form-message">
            <div class="input-group">
              <input type="text" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ (!empty($record2)? $record2->date_of_birth :'')}}" placeholder="Date of Birth" aria-label="Date of birth" required data-msg="Enter date of birth">
              <div class="input-group-addon p-2">
                <i class="tio-date-range"></i>
              </div>
            </div>
          </div>  
        </div>
      </div>      
      <!-- End Form Group -->

      <!-- Form Group -->
      <div class="row form-group js-form-message">
        <label class="col-sm-3 col-form-label input-label">Languages Known </label>

        <div class="col-sm-9">
          <div class="js-form-message">
            <select name="languages_known[]" multiple id="languages_known" class="form-control">

              <?php
              if(!empty($record2)){ 
                $language_known = json_decode($record2->languages_known,true);
              }
              else{
                $language_known = "";
              }
              ?> 

              @foreach($languages as $language)
              <option {{ (!empty($record2)?((in_array($language->id,$language_known))?'selected':''):'') }} value="{{$language->id}}">{{$language->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>      
      <!-- End Form Group -->


      <!-- Form Group -->
      <div class="row form-group js-form-message">
        <label class="col-sm-3 col-form-label input-label">Country</label>

        <div class="col-sm-9">
          <div class="js-form-message">
            <select name="country_id" id="country_id" onchange="stateList(this.value,'state_id')" class="form-control">
              <option value="">Select Country</option>
              @foreach($countries as $country)
              <option {{(!empty($record2)?($record2->country_id == $country->id?"selected":""):'')}} value="{{$country->id}}">{{$country->name}}</option>
              @endforeach
            </select>
          </div>  
        </div>
      </div>      
      <!-- End Form Group -->


      <!-- Form Group -->
      <div class="row form-group js-form-message">
        <label class="col-sm-3 col-form-label input-label">State</label>

        <div class="col-sm-9">
          <div class="js-form-message">
            <select name="state_id" id="state_id" aria-label="State" required data-msg="Please select your state" onchange="cityList(this.value,'city_id')" class="form-control">
              <option value="">Select State</option>

              @if(!empty($record2))
              @foreach($states as $state)
              <option {{(!empty($record2)?($record2->state_id == $state->id?"selected":""):'')}} value="{{$state->id}}">{{$state->name}}</option>
              @endforeach
              @endif
            </select>
          </div>  
        </div>
      </div>      
      <!-- End Form Group -->


      <!-- Form Group -->
      <div class="row form-group js-form-message">
        <label class="col-sm-3 col-form-label input-label">City</label>

        <div class="col-sm-9">
          <div class="js-form-message">
            <select name="city_id" id="city_id"  aria-label="City" required data-msg="Please select your city" class="form-control">
              <option value="">Select City</option>

              @if(!empty($record2))
              @foreach($cities as $city)
              <option {{(!empty($record2)?($record2->city_id == $city->id?"selected":""):'')}} value="{{$city->id}}">{{$city->name}}</option>
              @endforeach
              @endif

            </select>
          </div>  
        </div>
      </div>      
      <!-- End Form Group -->


      <!-- Form Group -->
      <div class="row form-group js-form-message">
        <label class="col-sm-3 col-form-label input-label">Address</label>
        <div class="col-sm-9">
          <div class="js-form-message">
            <input type="text" class="form-control" name="address" id="address" placeholder="Address" aria-label="Address" required data-msg="Please enter your address" value="{{ !empty($record2)?($record2->address):'' }}">
          </div>  
        </div>
      </div>      
      <!-- End Form Group -->


      <!-- Form Group -->
      <div class="row form-group js-form-message">
        <label class="col-sm-3 col-form-label input-label">Zip Code</label>
        <div class="col-sm-9">
          <div class="js-form-message">
            <input type="text" class="form-control" name="zip_code" id="zip_code" placeholder="Zipcode" aria-label="Zipcode" required data-msg="Please enter your zip code" value="{{ !empty($record2)?$record2->zip_code:'' }}">
          </div>  
        </div>
      </div>      
      <!-- End Form Group -->

      <!-- Form Group -->
      <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    <!-- End Form -->
  </div>
  <!-- End Body -->
</div>
<!-- End Card -->




<!-- Sticky Block End Point -->
<div id="stickyBlockEndPoint"></div>
</div>
</div>
<!-- End Row -->
</div>
<!-- End Content -->

@endsection


@section('javascript')

<!-- JS Implementing Plugins -->
<script src="assets/vendor/hs-navbar-vertical-aside/hs-navbar-vertical-aside.min.js"></script>

<script src="assets/vendor/hs-nav-scroller/dist/hs-nav-scroller.min.js"></script>

<script src="assets/vendor/hs-go-to/dist/hs-go-to.min.js"></script>
<script src="assets/vendor/list.js/dist/list.min.js"></script>
<script src="assets/vendor/prism/prism.js"></script>
<script src="assets/vendor/hs-step-form/dist/hs-step-form.min.js"></script>
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- JS Front -->
<script src="assets/vendor/hs-toggle-password/dist/js/hs-toggle-password.js"></script>
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="assets/vendor/select2/dist/js/select2.full.min.js"></script>

<script src="assets/vendor/quill/dist/quill.min.js"></script>


<!-- JS Front -->
<script src="assets/js/theme.min.js"></script>

<!-- JS Plugins Init. -->
<script>
  $(document).on('ready', function () {
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
            // $.each(response.message, function (index, value) {
            //   $("*[name="+index+"]").parents(".js-form-message").find("#"+index+"-error").remove();
            //   $("[name="+index+"]").parents(".js-form-message").find(".form-control").removeClass('is-invalid');
              
            //   var html = '<div id="'+index+'-error" class="invalid-feedback">'+value+'</div>';
            //   $("[name="+index+"]").parents(".js-form-message").append(html);
            //   $("[name="+index+"]").parents(".js-form-message").find(".form-control").addClass('is-invalid');
            // });
              // errorMessage(response.message);
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
