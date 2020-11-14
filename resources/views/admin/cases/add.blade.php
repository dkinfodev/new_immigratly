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
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>
        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{baseUrl('/cases')}}">
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
     <!-- Step Form -->
      <form class="js-validate js-step-form js-validate"
         data-hs-step-form-options='{
         "progressSelector": "#createProjectStepFormProgress",
         "stepsSelector": "#createProjectStepFormContent",
         "endSelector": "#createProjectFinishBtn",
         "isValidate": false
         }'>
         <!-- Step -->
         <ul id="createProjectStepFormProgress" class="js-step-progress step step-sm step-icon-sm step-inline step-item-between mb-7">
            <li class="step-item">
               <a class="step-content-wrapper" href="javascript:;"
                  data-hs-step-form-next-options='{
                  "targetSelector": "#createProjectStepDetails"
                  }'>
                  <span class="step-icon step-icon-soft-dark">1</span>
                  <div class="step-content">
                     <span class="step-title">Case Detail</span>
                  </div>
               </a>
            </li>
            <li class="step-item">
               <a class="step-content-wrapper" href="javascript:;"
                  data-hs-step-form-next-options='{
                  "targetSelector": "#createProjectStepTerms"
                  }'>
                  <span class="step-icon step-icon-soft-dark">2</span>
                  <div class="step-content">
                     <span class="step-title">Assigned Staff</span>
                  </div>
               </a>
            </li>
            <li class="step-item">
               <a class="step-content-wrapper" href="javascript:;"
                  data-hs-step-form-next-options='{
                  "targetSelector": "#createProjectStepMembers"
                  }'>
                  <span class="step-icon step-icon-soft-dark">3</span>
                  <div class="step-content">
                     <span class="step-title">Confirmation
                     </span>
                  </div>
               </a>
            </li>
         </ul>
         <!-- End Step -->
         <!-- Content Step Form -->
         <div id="createProjectStepFormContent">
            <div id="createProjectStepDetails" class="active">
              
               <!-- Form Group -->
               <div class="form-group">
                  <label for="clientNewProjectLabel" class="input-label">Client</label>
                  <div class="form-row align-items-center">
                     <div class="col-12 col-md-7 mb-3">
                        <div class="form-group js-form-message mb-0">
                            <!-- Select -->
                            <div class="select2-custom">
                               <select class="js-select2-custom" required id="client_id">
                                  @foreach($clients as $client)
                                  <option value="{{$client->master_id}}">
                                    {{$client->first_name." ".$client->last_name}}
                                  </option>
                                  @endforeach
                               </select>
                            </div>
                            <!-- End Select -->
                         </div>
                     </div>
                     <span class="col-auto">or</span>
                     <div class="col-md mb-md-3">
                        <a class="btn btn-white" href="javascript:;">
                        <i class="tio-add mr-1"></i>New client
                        </a>
                     </div>
                  </div>
               </div>
               <!-- End Form Group -->
               <!-- Form Group -->
               <div class="form-group js-form-message">
                  <label class="input-label">Case Title <i class="tio-help-outlined text-body ml-1" data-toggle="tooltip" data-placement="top" title="Displayed on public forums, such as Front."></i></label>
                  <div class="input-group input-group-merge">
                     <div class="input-group-prepend">
                        <div class="input-group-text">
                           <i class="tio-briefcase-outlined"></i>
                        </div>
                     </div>
                     <input type="text" required data-msg="Please enter case title" class="form-control" name="case_title" id="case_title" placeholder="Enter case title here" aria-label="Enter case title here">
                  </div>
               </div>
               <!-- End Form Group -->
               <div class="row">
                  <div class="col-sm-4">
                     <!-- Form Group -->
                     <div class="form-group js-form-message">
                        <label class="input-label">Start date</label>
                        <div class="js-flatpickr flatpickr-custom input-group input-group-merge">
                           <div class="input-group-prepend" data-toggle>
                              <div class="input-group-text">
                                 <i class="tio-date-range"></i>
                              </div>
                           </div>
                           <input required data-msg="Please select start date" type="text" name="start_date" class="flatpickr-custom-form-control form-control" id="start_date" placeholder="Select Start Date" data-input value="">
                        </div>
                     </div>
                     <!-- End Form Group -->
                  </div>
                  <div class="col-sm-4">
                     <!-- Form Group -->
                     <div class="form-group js-form-message">
                        <label class="input-label">End date</label>
                        <div class="js-flatpickr flatpickr-custom input-group input-group-merge">
                           <div class="input-group-prepend" data-toggle>
                              <div class="input-group-text">
                                 <i class="tio-date-range"></i>
                              </div>
                           </div>
                           <input type="text" data-msg="Please select end date" name="end_date" class="flatpickr-custom-form-control form-control" id="end_date" placeholder="Select End Date" data-input value="">
                        </div>
                     </div>
                     <!-- End Form Group -->
                  </div>
                  <div class="col-sm-4">
                     <div class="js-form-message form-group">
                        <label class="input-label font-weight-bold">Visa Service</label>
                        <select name="visa_service_id" id="visa_service_id" class="custom-select">
                          <option value="">Select Service</option>
                          @foreach($visa_services as $service)
                            @if(!empty($service->Service($service->service_id)))
                              <option value="{{$service->id}}">{{$service->Service($service->service_id)->name}} </option>
                            @endif
                          @endforeach
                        </select>
                      </div>
                  </div>
               </div>
               <div class="form-group js-form-message">
                  <label class="input-label">Description <span class="input-label-secondary">(Optional)</span></label>
                  <textarea class="form-control" id="description" name="description"></textarea>
               </div>
               
              
               <!-- Footer -->
               <div class="d-flex align-items-center">
                  <div class="ml-auto">
                     <button type="button" class="btn btn-primary"
                        data-hs-step-form-next-options='{
                        "targetSelector": "#createProjectStepTerms"
                        }'>
                     Next <i class="tio-chevron-right"></i>
                     </button>
                  </div>
               </div>
               <!-- End Footer -->
            </div>
            <div id="createProjectStepTerms" style="display: none;">
               <!-- Form Row -->
               <div class="row">
                  <div class="col-sm-6">
                      <!-- Form Group -->
                      <div class="js-form-message form-group">
                        <label class="input-label font-weight-bold">Assign Staffs</label>
                        <select name="assign_teams[]" id="assign_teams" multiple class="custom-select">
                          <option value="" disabled>Select Team</option>
                          @foreach($staffs as $staff)
                            <option value="{{$staff->id}}">{{$staff->first_name.' '.$staff->last_name}} ({{$staff->role}})</option>
                          @endforeach
                        </select>
                      </div>
                     <!-- End Form Group -->
                  </div>
               </div>
               <!-- End Form Row -->
               <!-- Form Row -->
               
               <!-- End Form Row -->
               
               <!-- Footer -->
               <div class="d-flex align-items-center">
                  <button type="button" class="btn btn-ghost-secondary mr-2"
                     data-hs-step-form-prev-options='{
                     "targetSelector": "#createProjectStepDetails"
                     }'>
                  <i class="tio-chevron-left"></i> Previous step
                  </button>
                  <div class="ml-auto">
                     <button type="button" class="btn btn-primary"
                        data-hs-step-form-next-options='{
                        "targetSelector": "#createProjectStepMembers"
                        }'>
                     Next <i class="tio-chevron-right"></i>
                     </button>
                  </div>
               </div>
               <!-- End Footer -->
            </div>
            <div id="createProjectStepMembers" style="display: none;">
              
               <div class="row">
                  <div class="col-lg-12 text-center">
                     <h2>Confirm</h2>
                     <p>Ready to create the case</p>
                  </div>
               </div>
               <!-- End Toggle Switch -->
               <!-- Footer -->
               <div class="d-sm-flex align-items-center">
                  <button type="button" class="btn btn-ghost-secondary mb-3 mb-sm-0 mr-2"
                     data-hs-step-form-prev-options='{
                     "targetSelector": "#createProjectStepTerms"
                     }'>
                  <i class="tio-chevron-left"></i> Previous step
                  </button>
                  <div class="d-flex justify-content-end ml-auto">
                     <button type="button" class="btn btn-white mr-2" data-dismiss="modal" aria-label="Close">Cancel</button>
                     <button id="createProjectFinishBtn" type="button" class="btn btn-primary">Create Case</button>
                  </div>
               </div>
               <!-- End Footer -->
            </div>
         </div>
         <!-- End Content Step Form -->
         <!-- Message Body -->
         <div id="createProjectStepSuccessMessage" style="display:none;">
            <div class="text-center">
               <img class="img-fluid mb-3" src="./assets/svg/illustrations/create.svg" alt="Image Description" style="max-width: 15rem;">
               <div class="mb-4">
                  <h2>Successful!</h2>
                  <p>New project has been successfully created.</p>
               </div>
               <div class="row justify-content-center gy-1 gx-2">
                  <div class="col-auto">
                     <a class="btn btn-white" href="projects.html">
                     <i class="tio-chevron-left ml-1"></i> Back to projects
                     </a>
                  </div>
                  <div class="col-auto">
                     <a class="btn btn-primary" href="javascript:;" data-toggle="modal" data-target="#newProjectModal">
                     <i class="tio-city mr-1"></i> Add new project
                     </a>
                  </div>
               </div>
            </div>
         </div>
         <!-- End Message Body -->
      </form>
      <!-- End Step Form -->
    </div>
    <!-- End Card -->
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
<script type="text/javascript">
initEditor("description"); 
$(document).on('ready', function () {

  $('#start_date').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
      maxDate:(new Date()).getDate(),
      todayHighlight: true,
      orientation: "bottom auto"
  });
  $('#end_date').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
      maxDate:(new Date()).getDate(),
      todayHighlight: true,
      orientation: "bottom auto"
  });
  
  $('.js-step-form').each(function () {
     var stepForm = new HSStepForm($(this), {
       finish: function() {
         $("#createProjectStepFormProgress").hide();
         $("#createProjectStepFormContent").hide();
         $("#createProjectStepSuccessMessage").show();
       }
     }).init();
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
              validation(response.message);
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
           $("#city").html('');
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