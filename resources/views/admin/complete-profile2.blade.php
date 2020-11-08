@extends('layouts.master')

@section('style')
<link rel="stylesheet" href="assets/vendor/quill/dist/quill.snow.css">
@endsection

@section('content')

<!-- Content -->
<div class="bg-dark">
  <div class="content container-fluid" style="height: 25rem;">
    <!-- Page Header -->
    <div class="page-header page-header-light">
      <div class="row align-items-center">
        <div class="col">
          <h1 class="page-header-title">{{$pageTitle}}</h1>
        </div>
      </div>
      <!-- End Row -->

      <!-- Nav Scroller -->
      <div class="js-nav-scroller hs-nav-scroller-horizontal">
        <span class="hs-nav-scroller-arrow-prev hs-nav-scroller-arrow-dark-prev" style="display: none;">
          <a class="hs-nav-scroller-arrow-link" href="javascript:;">
            <i class="tio-chevron-left"></i>
          </a>
        </span>

        <span class="hs-nav-scroller-arrow-next hs-nav-scroller-arrow-dark-next" style="display: none;">
          <a class="hs-nav-scroller-arrow-link" href="javascript:;">
            <i class="tio-chevron-right"></i>
          </a>
        </span>

        <!-- Nav -->
        <ul class="nav nav-tabs nav-tabs-light page-header-tabs" id="pageHeaderTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" href="javascript:;">Complete Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="javascript:;">
              Varification Status
              @if($profile_status == 0)
              <span class="badge badge-warning badge-pill ml-1">
                <i class="tio-warning mr-1"></i> Verification Pending
              </span>
              @else
              <span class="badge badge-success badge-pill ml-1">
                <i class="tio-success mr-1"></i> Verification required
              </span>
              @endif
            </a>
          </li>
        </ul>
        <!-- End Nav -->
      </div>
      <!-- End Nav Scroller -->
    </div>
    <!-- End Page Header -->
  </div>
</div>
<!-- End Content -->


<!-- Content -->
<div class="content container-fluid" style="margin-top: -17rem;">
  <!-- Card -->
  <div class="card mb-3 mb-lg-5" style="padding:30px;">
    <!-- Header -->

    <!-- Step Form -->
    <form id="profile_form" class="js-step-form js-validate"
    data-hs-step-form-options='{
    "progressSelector": "#validationFormProgress",
    "stepsSelector": "#validationFormContent",
    "endSelector": "#validationFormFinishBtn",
    "isValidate": true
  }'>
  <!-- Step -->
  <ul id="validationFormProgress" class="js-step-progress step step-sm step-icon-sm step-inline step-item-between mb-7">
    <li class="step-item">
      <a class="step-content-wrapper" href="javascript:;"
      data-hs-step-form-next-options='{
      "targetSelector": "#validationPersonalInfo"
    }'>
    <span class="step-icon step-icon-soft-dark">1</span>
    <div class="step-content">
      <span class="step-title">Personal Info</span>
    </div>
  </a>
</li>

<li class="step-item">
  <a class="step-content-wrapper" href="javascript:;"
  data-hs-step-form-next-options='{
  "targetSelector": "#validationFormAboutMe"
}'>
<span class="step-icon step-icon-soft-dark">2</span>
<div class="step-content">
  <span class="step-title">About</span>
</div>
</a>
</li>

<li class="step-item">
  <a class="step-content-wrapper" href="javascript:;"
  data-hs-step-form-next-options='{
  "targetSelector": "#validationFormCompanyInfo"
}'>
<span class="step-icon step-icon-soft-dark">3</span>
<div class="step-content">
  <span class="step-title">Company Info</span>
</div>
</a>
</li>
</ul>
<!-- End Step -->

<!-- Content Step Form -->
<div id="validationFormContent">
  <div id="validationPersonalInfo" class="active">

    <div class="row justify-content-md-between">
      <div class="col-md-4">
        <!-- Logo -->
        <label class="custom-file-boxed custom-file-boxed-sm" for="logoUploader">
          <img id="logoImg" class="avatar avatar-xl avatar-4by3 avatar-centered h-100 mb-2" src="./assets/svg/illustrations/browse.svg" alt="Image Description">

          <span class="d-block">Upload your Image here</span>

          <input type="file" class="js-file-attach custom-file-boxed-input" id="logoUploader"
          data-hs-file-attach-options='{
          "textTarget": "#logoImg",
          "mode": "image",
          "targetAttr": "src"
        }'>
      </label>
      <!-- End Logo -->
    </div>

    <div class="col-md-7 justify-content-md-end">

      <div class="row form-group">
        <label for="validationFormUsernameLabel" class="col-form-label input-label">First name</label>

        <div class="col-12">
          <div class="js-form-message">
            <input type="text" class="form-control" name="first_name" id="validationFormFirstnameLabel" placeholder="Firstname" aria-label="Firstname" required data-msg="Please enter your first name." value="{{ $user->first_name }}">
          </div>
        </div>
      </div>
      <!-- End Form Group -->

      <div class="row form-group">
        <label for="validationFormUsernameLabel" class="col-form-label input-label">Last name</label>

        <div class="col-12">
          <div class="js-form-message">
            <input type="text" class="form-control" name="last_name" id="validationFormLastnameLabel" placeholder="Lastname" aria-label="Lastname" required data-msg="Please enter your last name." value="{{ $user->last_name }}">
          </div>
        </div>
      </div>
      <!-- End Form Group -->

    </div>
  </div>
  <!-- End Row -->

  <hr class="my-5">

  <div class="row justify-content-md-between">
    <div class="col-md-6">
      <!-- Form Group -->
      <div class="row form-group">
        <label for="validationFormUsernameLabel" class="col-sm-5 col-form-label input-label">Email</label>

        <div class="col-sm-7">
          <div class="js-form-message">
            <input type="email" class="form-control" name="email" id="validationFormEmailLabel" placeholder="Email" aria-label="Email" required data-msg="Please enter your email." value="{{ $user->email }}">
          </div>
        </div>
      </div>
      <!-- End Form Group -->

      <!-- Form Group -->
      <div class="row form-group">
        <label class="col-sm-5 col-form-label input-label">Phone Number</label>

        <div class="col-sm-3">
          <div class="js-form-message">
            <select name="country_code" id="country_code" class="form-control">
              <option>Select</option>
              @foreach($countries as $country)
              <option {{$user->country_code == $country->phonecode?"selected":""}} value="+{{$country->phonecode}}">+{{$country->phonecode}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="js-form-message">
            <input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Phone number" aria-label="Email" required data-msg="Please enter your phone number." value="{{$user->phone_no}}">
          </div>
        </div>
      </div>
      <!-- End Form Group -->
      <!-- Form Group -->
      <div class="row form-group">
        <label class="col-sm-5 col-form-label input-label">Gender</label>

        <div class="col-sm-7">
          <div class="js-form-message">
            <select name="gender" class="form-control">
              <option>Select</option>
              <option {{($user->gender == 'male')?'selected':''}} value="male">Male</option>
              <option {{($user->gender == 'female')?'selected':''}} value="female">Female</option>
            </select>
          </div>
        </div>
      </div>
      <!-- End Form Group -->
      <!-- Form Group -->
      <div class="row form-group">
        <label class="col-sm-5 col-form-label input-label">Date of Birth</label>
        <div class="col-sm-7">
          <div class="input-group">
              <input type="text" name="date_of_birth" id="date_of_birth" value="{{ $user->date_of_birth }}" class="form-control" placeholder="Date of Birth" aria-label="Date of birth" required data-msg="Enter date of birth">
              <div class="input-group-addon p-2">
                  <i class="tio-date-range"></i>
              </div>
          </div>
        </div>
      </div>
      <!-- End Form Group -->
      <!-- Form Group -->
      <div class="row form-group">
        <label class="col-sm-5 col-form-label input-label">Languages Known</label>

        <div class="col-sm-7">
          <div class="js-form-message">
            <select name="languages_known[]" multiple id="languages_known" class="form-control">
              <option>Select</option>
              <?php
                $language_known = explode(",",$user->language_known);
              ?>
              @foreach($languages as $language)
              <option {{in_array($language->name,$language_known)?"selected":""}} value="{{$language->name}}">{{$language->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <!-- End Form Group -->
      

    </div> <!-- div end -->
 

    <div class="col-md-6">
      
      <!-- Form Group -->
      <div class="row form-group">
        <label class="col-sm-5 col-form-label input-label">Country</label>
        <div class="col-sm-7">
          <div class="js-form-message">
            <select name="country_id" id="country_id" onchange="stateList(this.value,'state_id')" class="form-control">
              <option>Select</option>
              @foreach($countries as $country)
              <option {{$user->country_id == $country->id?"selected":""}} value="{{$country->id}}">{{$country->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <!-- End Form Group -->
      <!-- Form Group -->
      <div class="row form-group">
        <label class="col-sm-5 col-form-label input-label">State</label>
        <div class="col-sm-7">
          <div class="js-form-message">
            <select name="state_id" id="state_id" onchange="cityList(this.value,'city_id')" class="form-control">
              <option>Select</option>
              @foreach($states as $state)
              <option {{$user->state_id == $state->id?"selected":""}} value="{{$state->id}}">{{$state->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <!-- End Form Group -->

      <!-- Form Group -->
      <div class="row form-group">
        <label class="col-sm-5 col-form-label input-label">City</label>
        <div class="col-sm-7">
          <div class="js-form-message">
            <select name="city_id" id="city_id" class="form-control">
              <option>Select</option>
              @foreach($cities as $city)
              <option {{$user->city_id == $city->id?"selected":""}} value="{{$city->id}}">{{$city->name}}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
      <!-- End Form Group -->
      
      <!-- Form Group -->
      <div class="row form-group">
        <label class="col-sm-5 col-form-label input-label">Address</label>
        <div class="col-sm-7">
          <div class="js-form-message">
            <input type="text" class="form-control" name="address" id="validationAddressLabel" placeholder="Address" aria-label="Address" required data-msg="Please enter your address" value="{{ $user->address }}">
          </div>
        </div>
      </div>
      <!-- End Form Group -->

      <!-- Form Group -->
      <div class="row form-group">
        <label class="col-sm-5 col-form-label input-label">Zip Code</label>
        <div class="col-sm-7">
          <div class="js-form-message">
            <input type="text" class="form-control" name="zip_code" id="zip_code" placeholder="Zipcode" aria-label="Zipcode" required data-msg="Please enter your zip code" value="{{ $user->zip_code }}">
          </div>
        </div>
      </div>
    </div>
    <!-- End Form Group -->
  </div>

  <!-- Footer -->
  <div class="d-flex align-items-center">
    <div class="ml-auto">
      <button type="button" class="btn btn-primary"
      data-hs-step-form-next-options='{
      "targetSelector": "#validationFormAboutMe"
    }'>
    Next <i class="tio-chevron-right"></i>
  </button>
</div>
</div>
<!-- End Footer -->
</div>

<div id="validationFormAboutMe" style="display: none;">

  <!-- Form Group -->
  <div class="row form-group">
    <label class="col-sm-5 col-form-label input-label">License Body</label>

    <div class="col-sm-7">
      <div class="js-form-message">
        <select name="license_body[]" multiple id="license_body" class="form-control">
          <option>Select</option>
          <?php
            $license_body = explode(",",$user->license_body);
          ?>
          @foreach($licence_bodies as $bodies)
          <option {{in_array($bodies->id,$license_body)?"selected":""}} value="{{$bodies->id}}">{{$bodies->name}}</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>
  <!-- End Form Group -->

  <div class="row form-group">
    <div class="col-md-12">
      <label class="col-form-label input-label">About Professional</label>
      <textarea class="form-control" id="about_professional" name="about_professional"></textarea>
    </div>
  </div>

<!-- End Quill -->


<!-- Footer -->
<div class="d-flex align-items-center">
  <button type="button" class="btn btn-ghost-secondary mr-2"
  data-hs-step-form-prev-options='{
  "targetSelector": "#validationPersonalInfo"
}'>
<i class="tio-chevron-left"></i> Previous step
</button>

<div class="ml-auto">
  <button type="button" class="btn btn-primary"
  data-hs-step-form-next-options='{
  "targetSelector": "#validationFormCompanyInfo"
}'>
Next <i class="tio-chevron-right"></i>
</button>
</div>
</div>
<!-- End Footer -->
</div>

<div id="validationFormCompanyInfo" style="display: none;">
 <div class="row justify-content-md-between">
  <div class="col-md-6">
    <!-- Form Group -->
    <div class="row form-group">
      <label for="validationFormCompanyNameLabel" class="col-sm-5 col-form-label input-label">Company Name</label>

      <div class="col-sm-7">
        <div class="js-form-message">
          <input type="text" class="form-control" name="company_name" id="validationFormCompanyCompanyNameLabel" placeholder="Company" aria-label="Company Name" required data-msg="Please enter your company name." value="{{$company_details->company_name}}">
        </div>
      </div>
    </div>
    <!-- End Form Group -->

    <!-- Form Group -->
    <div class="row form-group">
      <label for="validationFormWebsiteLabel" class="col-sm-5 col-form-label input-label">Website URL</label>

      <div class="col-sm-7">
        <div class="js-form-message">
          <input type="text" class="form-control" name="website_url" id="validationFormWebsiteLabel" placeholder="Website URL" aria-label="Email" required data-msg="Please enter your website." value="{{$company_details->website_url}}">
        </div>
      </div>
    </div>
    <!-- End Form Group -->

    <!-- Form Group -->
    <div class="row form-group">
      <label for="validationFormUsernameLabel" class="col-sm-5 col-form-label input-label">Email</label>

      <div class="col-sm-7">
        <div class="js-form-message">
          <input type="email" class="form-control" name="email" id="validationFormEmailLabel" placeholder="Email" aria-label="Email" required data-msg="Please enter your email." value="{{$company_details->email}}">
        </div>
      </div>
    </div>
    <!-- End Form Group -->

    <!-- Form Group -->
    <div class="row form-group">
      <label class="col-sm-5 col-form-label input-label">Phone Number</label>
      <div class="col-sm-3">
        <div class="js-form-message">
          <select name="cp_country_code" id="cp_country_code" class="form-control">
            <option>Select</option>
            @foreach($countries as $country)
            <option {{$user->country_code == $country->phonecode?"selected":""}} value="+{{$country->phonecode}}">+{{$country->phonecode}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="js-form-message">
          <input type="text" class="form-control" name="phone_no" id="validationFormPhonenumberLabel" placeholder="Phone number" aria-label="Email" required data-msg="Please enter your phone number." value="{{$company_details->phone_no}}">
        </div>
      </div>
    </div>
    <!-- End Form Group -->

    <!-- Form Group -->
    <div class="row form-group">
      <label for="validationFormNewPasswordLabel" class="col-sm-5 col-form-label input-label">Owner ID Proof</label>

      <div class="col-sm-7">
        <div class="js-form-message">
          <div class="custom-file">
            <input type="file" class="js-file-attach custom-file-input" id="customFile"
            data-hs-file-attach-options='{
            "textTarget": "[for=\"customFile\"]"
          }'>
          <label class="custom-file-label" for="customFile">Choose file</label>
        </div>
      </div>
    </div>
  </div>
  <!-- End Form Group -->

 <!-- Form Group -->
    <div class="row form-group">
      <label for="validationFormNewPasswordLabel" class="col-sm-5 col-form-label input-label">Company Address Proof</label>

      <div class="col-sm-7">
        <div class="js-form-message">
          <div class="custom-file">
            <input type="file" class="js-file-attach custom-file-input" id="customFile"
            data-hs-file-attach-options='{
            "textTarget": "[for=\"customFile\"]"
          }'>
          <label class="custom-file-label" for="customFile">Choose file</label>
        </div>
      </div>
    </div>
  </div>
  <!-- End Form Group -->

</div> <!-- div end -->


<div class="col-md-6">
  <!-- Form Group -->
  <div class="row form-group">
    <label class="col-sm-5 col-form-label input-label">Register Date</label>

    <div class="col-sm-7">
      <div class="input-group">
          <input type="text" name="date_of_register" id="date_of_register" value="" class="form-control" placeholder="Date of Register" aria-label="Date of Register" required data-msg="Enter date of register">
          <div class="input-group-addon p-2">
              <i class="tio-date-range"></i>
          </div>
      </div>
    </div>
  </div>
  <!-- End Form Group -->

  <!-- Form Group -->
  <div class="row form-group">
    <label class="col-sm-5 col-form-label input-label">Country</label>
    <div class="col-sm-7">
      <div class="js-form-message">
        <select name="cp_country_id" id="cp_country_id" class="form-control">
          <option>Select</option>
          <option value="A">A</option>
          <option value="B">B</option>
        </select>
      </div>
    </div>
  </div>
  <!-- End Form Group -->

  <!-- Form Group -->
  <div class="row form-group">
    <label for="validationFormNewPasswordLabel" class="col-sm-5 col-form-label input-label">State</label>
    <div class="col-sm-7">
      <div class="js-form-message">
        <select name="state" class="form-control">
          <option>Select</option>
          <option value="A">A</option>
          <option value="B">B</option>
        </select>
      </div>
    </div>
  </div>
  <!-- End Form Group -->

  <!-- Form Group -->
  <div class="row form-group">
    <label for="validationFormNewPasswordLabel" class="col-sm-5 col-form-label input-label">City</label>
    <div class="col-sm-7">
      <div class="js-form-message">
        <select name="city" class="form-control">
          <option>Select</option>
          <option value="A">A</option>
          <option value="B">B</option>
        </select>
      </div>
    </div>
  </div>
  <!-- End Form Group -->

  <!-- Form Group -->
  <div class="row form-group">
    <label for="validationFormAddressLabel" class="col-sm-5 col-form-label input-label">Address</label>
    <div class="col-sm-7">
      <div class="js-form-message">
        <input type="text" class="form-control" name="address" id="validationAddressLabel" placeholder="Address" aria-label="Address" required data-msg="Please enter your address">
      </div>
    </div>
  </div>
  <!-- End Form Group -->

  <!-- Form Group -->
  <div class="row form-group">
    <label for="validationFormZipLabel" class="col-sm-5 col-form-label input-label">Zip Code</label>
    <div class="col-sm-7">
      <div class="js-form-message">
        <input type="text" class="form-control" name="zipcode" id="validationZipLabel" placeholder="Zipcode" aria-label="Zipcode" required data-msg="Please enter your zip code">
      </div>
    </div>
  </div>
</div>
</div>

  <!-- Form Group -->
  <div class="row form-group">
    <label for="validationFormServicesLabel" class="col-sm-3 col-md-3 col-form-label input-label">Type of Services</label>
    <div class="col-sm-9 col-md-9">
      <div class="js-form-message">
        <input type="text" class="form-control" name="services" id="validationServicesLabel" placeholder="Enter type services you provide" aria-label="Address" required data-msg="Please enter your services">
      </div>
    </div>
  </div>
  <!-- End Form Group -->



<!-- Footer -->
<div class="d-sm-flex align-items-center">
  <button type="button" class="btn btn-ghost-secondary mb-3 mb-sm-0 mr-2"
  data-hs-step-form-prev-options='{
  "targetSelector": "#validationFormAboutMe"
}'>
<i class="tio-chevron-left"></i> Previous step
</button>

<div class="d-flex justify-content-end ml-auto">
  <button type="button" class="btn btn-white mr-2" data-dismiss="modal" aria-label="Close">Cancel</button>
  <button id="validationFormFinishBtn" type="button" class="btn btn-primary">Save Changes</button>
</div>
</div>
<!-- End Footer -->
</div>
</div>
<!-- End Content Step Form -->

<!-- Message Body -->
<div id="validationFormSuccessMessage" style="display:none;">
  <div class="text-center">
    <img class="img-fluid mb-3" src="assets/svg/illustrations/create.svg" alt="Image Description" style="max-width: 15rem;">

    <div class="mb-4">
      <h2>Successful!</h2>
      <p>Your changes have been successfully saved.</p>
    </div>

    <div class="d-flex justify-content-center">
      <a class="btn btn-white mr-3" href="#">
        <i class="tio-chevron-left ml-1"></i> Back to projects
      </a>
      <a class="btn btn-primary" href="#">
        <i class="tio-city mr-1"></i> Add new project
      </a>
    </div>
  </div>
</div>
<!-- End Message Body -->
</form>
<!-- End Step Form -->

</div>
</div>


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
<!-- JS Front -->

<script src="assets/vendor/quill/dist/quill.min.js"></script>

<script>
  $(document).on('ready', function () {
    $('#date_of_birth,#date_of_register').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        maxDate:(new Date()).getDate(),
        todayHighlight: true,
        orientation: "bottom auto"
    });
    $('.js-validate').each(function() {
      $.HSCore.components.HSValidation.init($(this));
    });

    // initialization of step form
    $('.js-step-form').each(function () {
      var stepForm = new HSStepForm($(this), {
        finish: function() {
          $("#validationFormProgress").hide();
          $("#validationFormContent").hide();
          $("#validationFormSuccessMessage").show();
          $.ajax({
              url:"{{ baseUrl('save-profile') }}",
              data:{
                country_id:country_id
              },
              dataType:"json",
              beforeSend:function(){
                 $("#state_id").html('');
              },
              success:function(response){
                if(response.status == true){
                  $("#state_id").html(response.options);
                } 
              },
              error:function(){
                 
              }
          });
        }
      }).init();
    });

    // initialization of quilljs editor
    $('.js-flatpickr').each(function () {
      $.HSCore.components.HSFlatpickr.init($(this));
    });
    initEditor("about_professional");
  });

  function stateList(country_id){
      $.ajax({
          url:"{{ url('states') }}",
          data:{
            country_id:country_id
          },
          dataType:"json",
          beforeSend:function(){
             $("#state_id").html('');
          },
          success:function(response){
            if(response.status == true){
              $("#state_id").html(response.options);
            } 
          },
          error:function(){
             
          }
      });
  }
  function cityList(state_id){
      $.ajax({
          url:"{{ url('cities') }}",
          data:{
            state_id:state_id
          },
          dataType:"json",
          beforeSend:function(){
             $("#city_id").html('');
          },
          success:function(response){
            if(response.status == true){
              $("#city_id").html(response.options);
            } 
          },
          error:function(){
             
          }
      });
  }
</script>



@endsection

