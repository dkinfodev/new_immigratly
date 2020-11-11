@extends('layouts.signup-master')
@section('style')
<style type="text/css">
.custom-select {
    height: 56px;
}
</style>
@endsection
@section('content')
<!-- ========== HEADER ========== -->
    <header class="position-absolute top-0 left-0 right-0 mt-3 mx-3">
      <div class="d-flex d-lg-none justify-content-between">
        <a href="index.html">
          <img class="w-100" src="assets/svg/logos/logo.svg" alt="Image Description" style="min-width: 7rem; max-width: 7rem;">
        </a>
        <!-- End Select -->
      </div>
    </header>
    <!-- ========== END HEADER ========== -->

    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main" class="main pt-0">
      <!-- Content -->
      <div class="container-fluid px-3">
        <div class="row">
          <!-- Cover -->
          <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center min-vh-lg-100 position-relative bg-light px-0">
            <!-- Logo & Language -->
            <div class="position-absolute top-0 left-0 right-0 mt-3 mx-3">
              <div class="d-none d-lg-flex justify-content-between">
                <a href="index.html">
                  <img class="w-100" src="assets/svg/logos/logo.svg" alt="Image Description" style="min-width: 7rem; max-width: 7rem;">
                </a>
              </div>
            </div>
            <!-- End Logo & Language -->

            <div style="max-width: 23rem;">
              <div class="text-center mb-5">
                <img class="img-fluid" src="assets/svg/illustrations/chat.svg" alt="Image Description" style="width: 12rem;">
              </div>

              <div class="mb-5">
                <h2 class="display-4">Build digital products with:</h2>
              </div>

              <!-- List Checked -->
              <ul class="list-checked list-checked-lg list-checked-primary list-unstyled-py-4">
                <li class="list-checked-item">
                  <span class="d-block font-weight-bold mb-1">All-in-one tool</span>
                  Build, run, and scale your apps - end to end
                </li>

                <li class="list-checked-item">
                  <span class="d-block font-weight-bold mb-1">Easily add &amp; manage your services</span>
                  It brings together your tasks, projects, timelines, files and more
                </li>
              </ul>
              <!-- End List Checked -->

              <div class="row justify-content-between mt-5 gx-2">
                <div class="col">
                  <img class="img-fluid" src="assets/svg/brands/gitlab-gray.svg" alt="Image Description">
                </div>
                <div class="col">
                  <img class="img-fluid" src="assets/svg/brands/fitbit-gray.svg" alt="Image Description">
                </div>
                <div class="col">
                  <img class="img-fluid" src="assets/svg/brands/flow-xo-gray.svg" alt="Image Description">
                </div>
                <div class="col">
                  <img class="img-fluid" src="assets/svg/brands/layar-gray.svg" alt="Image Description">
                </div>
              </div>
              <!-- End Row -->
            </div>
          </div>
          <!-- End Cover -->

          <div class="col-lg-6 d-flex justify-content-center align-items-center min-vh-lg-100">
            <div class="w-100 pt-10 pt-lg-7 pb-7" style="max-width: 25rem;">
              <!-- Form -->
              <form id="signup-form" class="js-validate" action="{{ url('signup/professional') }}" method="post">
                @csrf
                <div id="personal-info">
                <div class="text-center mb-5">
                  <h1 class="display-4">Create your account</h1>
                  <p>Already have an account? <a href="authentication-signin-cover.html">Sign in here</a></p>
                </div>
                <label class="input-label" for="fullNameSrEmail">Full name</label>

                <!-- Form Group -->
                <div class="form-row">
                  <div class="col-sm-6">
                    <div class="js-form-message form-group">
                      <input type="text" class="form-control form-control-lg" name="first_name" id="first_name" placeholder="Mark" aria-label="Mark" required data-msg="Please enter your first name.">
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="js-form-message form-group">
                      <input type="text" class="form-control form-control-lg" name="last_name" id="last_name" placeholder="Williams" aria-label="Williams" required data-msg="Please enter your last name.">
                    </div>
                  </div>
                </div>
                <!-- End Form Group -->

                <!-- Form Group -->
                <div class="js-form-message form-group">
                  <label class="input-label" for="signupSrEmail">Your email</label>

                  <input type="email" class="form-control form-control-lg" name="email" id="signupSrEmail" placeholder="Markwilliams@example.com" aria-label="Markwilliams@example.com" required data-msg="Please enter a valid email address.">
                </div>
                <!-- End Form Group -->

                <label class="input-label" for="phoneNo">Mobile Number</label>

                <!-- Form Group -->
                <div class="form-row">
                  <div class="col-sm-5">
                    <div class="js-form-message form-group">
                      <div class="select2-custom select2-custom-right">
                        <select class="js-select2-custom form-control-lg" id="country_code" name="country_code">
                            @foreach($countries as $code)
                                <option {{ old("country_code") =='+'.$code->phonecode?"selected":"" }} value="+{{ $code->phonecode }}">+{{ $code->phonecode }}({{$code->name}})</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-7">
                    <div class="js-form-message form-group">
                      <input type="text" class="form-control form-control-lg" name="phone_no" id="phone_no" placeholder="Mobile Number" aria-label="Mark" required data-msg="Please enter mobile number">
                    </div>
                  </div>
                </div>
                <!-- End Form Group -->
                <div class="js-form-message form-group">
                  <label class="input-label">Company Name</label>
                  <input type="text" class="form-control form-control-lg" name="company_name" id="company_name" placeholder="Company Name" aria-label="company_name" required data-msg="Please enter a valid company name.">
                </div>
                <div class="js-form-message form-group">
                  <label class="input-label">Choose your subdomain name</label>
                    
                    <input type="text" name="subdomain" class="form-control" id="subdomain" name="form-control-rangelength" placeholder="Subdomain between 4 - 10 chars" minlength="4" maxlength="10" required>
                </div>
                <!-- End Form Group -->
                <!-- Form Group -->
                <div class="js-form-message form-group">
                  <label class="input-label" for="password">Password</label>

                  <div class="input-group input-group-merge">
                    <input type="password" class="js-toggle-password form-control form-control-lg" name="password" id="password" placeholder="8+ characters required" aria-label="8+ characters required" required
                           data-msg="Your password is invalid. Please try again."
                           data-hs-toggle-password-options='{
                             "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                             "defaultClass": "tio-hidden-outlined",
                             "showClass": "tio-visible-outlined",
                             "classChangeTarget": ".js-toggle-passowrd-show-icon-1"
                           }'>
                    <div class="js-toggle-password-target-1 input-group-append">
                      <a class="input-group-text" href="javascript:;">
                        <i class="js-toggle-passowrd-show-icon-1 tio-visible-outlined"></i>
                      </a>
                    </div>
                  </div>
                </div>
                <!-- End Form Group -->

                <!-- Form Group -->
                <div class="js-form-message form-group">
                  <label class="input-label" for="password_confirmation">Confirm password</label>

                  <div class="input-group input-group-merge">
                    <input type="password" class="js-toggle-password form-control form-control-lg" name="password_confirmation" id="password_confirmation" placeholder="8+ characters required" aria-label="8+ characters required" required
                           data-msg="Password does not match the confirm password."
                           data-hs-toggle-password-options='{
                             "target": [".js-toggle-password-target-1", ".js-toggle-password-target-2"],
                             "defaultClass": "tio-hidden-outlined",
                             "showClass": "tio-visible-outlined",
                             "classChangeTarget": ".js-toggle-passowrd-show-icon-2"
                           }'>
                    <div class="js-toggle-password-target-2 input-group-append">
                      <a class="input-group-text" href="javascript:;">
                        <i class="js-toggle-passowrd-show-icon-2 tio-visible-outlined"></i>
                      </a>
                    </div>
                  </div>
                </div>
                <!-- End Form Group -->

                <!-- Checkbox -->
                <div class="js-form-message form-group">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="termsCheckbox" name="termsCheckbox" required data-msg="Please accept our Terms and Conditions.">
                    <label class="custom-control-label font-size-sm text-muted" for="termsCheckbox"> I accept the <a href="#">Terms and Conditions</a></label>
                  </div>
                </div>
                <!-- End Checkbox -->

                <button type="button" class="btn btn-lg btn-block btn-primary mb-2 signup-btn">Create an account</button>
              </div>
                <div id="verify-screen"></div>
              </form>
              <!-- End Form -->
            </div>
          </div>
        </div>
        <!-- End Row -->
      </div>
      <!-- End Content -->
    </main>
    <!-- ========== END MAIN CONTENT ========== -->
@endsection

@section("javascript")
<script type="text/javascript">
$(document).ready(function(){
  $(".signup-btn").click(function(e){
      e.preventDefault(); 
      $(".signup-btn").attr("disabled","disabled");
      $(".signup-btn").find('.fa-spin').remove();
      $(".signup-btn").prepend("<i class='fa fa-spin fa-spinner'></i>");
      var verify_by = 'sms';
      var phone_no = $("#phone_no").val();
      var country_code = $("#country_code").val();
      var value = country_code+phone_no;
      var formData = $("#signup-form").serialize();
      formData += "&verify_by="+verify_by;
      formData += "&value="+value;
      $.ajax({
          url:"{{ url('signup/professional') }}",
          type:"post",
          data:formData,
          dataType:"json",
          beforeSend:function(){
             
          },
          success:function(response){
             $(".signup-btn").find(".fa-spin").remove();
             $(".signup-btn").removeAttr("disabled");
             if(response.status == true){
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
             $(".signup-btn").find(".fa-spin").remove();
             $(".signup-btn").removeAttr("disabled");
          }
      });
  });
});
</script>
@endsection