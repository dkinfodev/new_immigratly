@extends('layouts.master')

@section('style')
<style>
.event_paid_details{
  display: none;
}
.hidden{
  display: none;
}
</style>
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
          <label>Event Name</label>
          <input type="text" class="form-control" name="event_name" id="event_name">
        </div>

        <div class="row">

          <div class="col-md-6">

            <div class="form-group">
              <label>Event Category</label>
              <select name="category" class="form-control" id="category">
                <option>Select</option>
              </select>
            </div>
          </div>  

          <div class="col-md-6">
            <div class="form-group">
              <label>Event Language</label>
              <select name="language" class="form-control" id="language">
                <option>Select</option>
                @foreach($languages as $key=>$l)
                <option value="{{$l->id}}">{{$l->name}}</option>
                @endforeach
              </select>
            </div>
          </div>

        </div>  
        
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Event Level</label>
              <select name="event_level" class="form-control" id="event_level">
                <option>Select</option>
                <option>Beginner</option>
                <option>Intermediate</option>
                <option>Advance</option>
              </select>
            </div>
          </div>  

          <div class="col-md-6">
            <div class="form-group">
              <label>Tags</label>
              <select name="tags" class="form-control" id="tags">
                <option>Select</option>
              </select>
            </div>
          </div>  

        </div>    

        
        <div class="form-group">
          <label>No. of seats</label>
          <input type="number" name="seats" class="form-control" id="seats">
        </div>

        <div class="row">

          <div class="col-md-6 order-2">
            <div class="form-group">
              <label>Event Cover Image</label>
              <!-- Dropzone -->
              <div class="dz-message custom-file-boxed-label">
                <img class="avatar avatar-xl avatar-4by3 mb-3" src="./assets/svg/illustrations/browse.svg" alt="Image Description">
                <h5 class="mb-1">Drag and drop your file here</h5>
                <p class="mb-2">or</p>
                <span class="btn btn-sm btn-white">Browse files</span>
              </div>
            </div>
          </div>

          <div class="col-md-6 order-1">
            <div class="form-group">
              <label>Is Event Paid?</label> &nbsp;
              <input type="checkbox" name="event_paid" id="event_paid" >
            </div>

            <div class="row event_paid_details"  id="event_paid_details">
              <div class="col-md-6">
                <div class="form-group">
                  <lable>Event Cost</lable>
                  <input type="number" name="event_cost" id="event_cost" class="form-control">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <lable>Price Per Group</lable>
                  <select name="price_per_group" id="price_per_group" class="form-group">
                    <option>Per Person</option>
                    <option>Per Group</option>
                  </select>
                </div>
              </div>

            </div>


          </div>

        </div>  


        <div class="row">
          <div class="col-md-9 online-event" id="online_event">
            <div class="form-group">
              <label>Online Event Link</label>
              <input type="text" class="form-control" name="online_event_link" id="online_event_link">
            </div>
          </div>

          <div class="col-md-9 offline_event_details hidden">
            <div class="form-group">
              <label>Address</label>
              <textarea name="event_address" rows="4" id="event_address" class="form-control"></textarea>
            </div>
          </div>

          <div class="col-md-3" style="margin-top:20px;">
            <div class="form-group">
              <label>Is this offline event?</label> &nbsp;
              <input type="checkbox" name="offline_event" id="offline_event">
            </div>
          </div>



          <div class="col-md-4 offline_event_details hidden">
            <div class="form-group">
              <label>City</label>
              <select class="form-control" name="city" id="city">
                <option>Select</option>
              </select>
            </div>
          </div>

          <div class="col-md-4 offline_event_details hidden">
            <div class="form-group">
              <label>State</label>
              <select class="form-control" name="state" id="state">
                <option>Select</option>
              </select>
            </div>
          </div>

          <div class="col-md-4 offline_event_details hidden">
            <div class="form-group">
              <label>Country</label>
              <select class="form-control" name="country" id="country">
                <option>Select</option>
              </select>
            </div>
          </div>

        </div>


        <div class="form-group">
          <label>Short Description</label>
          <input type="text" class="form-control" name="short_description" id="short_description">
        </div>


        <div class="form-group">
          <label>Event Description</label>
          <textarea name="event_content" id="event_content" class="form-control"></textarea>
        </div>

          <hr class="my-5">

    <div class="js-add-field" data-hs-add-field-options='{
        "template": "#addTopicItemTemplate",
        "container": "#addTopicItemContainer",
        "defaultCreated": 0
      }'>
      <!-- Title -->
      <div class="bg-light border-bottom p-2 mb-3">
        <div class="row">
          <div class="col-sm-6">
            <h6 class="card-title text-cap">Topic</h6>
          </div>
        </div>
      </div>

      <!-- Container For Input Field -->
      <div id="addTopicItemContainer"></div>

      <a href="javascript:;" class="js-create-field form-link btn btn-sm btn-no-focus btn-ghost-primary" style="margin-bottom: 20px;">
        <i class="tio-add"></i> Add Topic
      </a>

      <!-- Add Phone Input Field -->
      <div id="addTopicItemTemplate" class="item-row"  style="display: none;">
        <!-- Content -->
        <div class="input-group-add-field">
          <div class="row">
            <div class="col-md-6 js-form-message">
              <input type="text" class="form-control mb-3 particular_name" placeholder="Topic name" aria-label="Item name">
            </div>

          </div>
          <!-- End Row -->

          <a class="js-delete-field input-group-add-field-delete" href="javascript:;" data-toggle="tooltip" data-placement="top" title="Remove item">
            <i class="tio-clear"></i>
          </a>
        </div>
        <!-- End Content -->
      </div>


        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label>Event Author</label>
              <select name="author" class="form-control" id="author">
                <option>Select</option>
              </select>
            </div>

            <div class="form-group">
              <label>Is Event Popular</label>
              <input type="checkbox" name="popular_event" id="popular_event">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Event Date and Time</label>
              <input required type="text" name="event_date" id="event_date" class="flatpickr-custom-form-control form-control" id="invoice_date" placeholder="Select Event Date" data-input value="">
            </div>
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label>Start Time</label>
                  <input type="time" name="event_start_time" id="event_start_time" class="form-control">
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label>End Time</label>
                  <input type="time" name="event_end_time" id="event_end_time" class="form-control">
                </div>
              </div>
            </div>
          </div>  
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
<script src="assets/vendor/hs-unfold/dist/hs-unfold.min.js"></script>
<script src="assets/vendor/hs-form-search/dist/hs-form-search.min.js"></script>
<script src="assets/vendor/hs-file-attach/dist/hs-file-attach.min.js"></script>
<script src="assets/vendor/select2/dist/js/select2.full.min.js"></script>
<script src="assets/vendor/flatpickr/dist/flatpickr.min.js"></script>
<script src="assets/vendor/hs-quantity-counter/dist/hs-quantity-counter.min.js"></script>
<script src="assets/vendor/hs-add-field/dist/hs-add-field.min.js"></script>
<script src="assets/vendor/hs-sticky-block/dist/hs-sticky-block.min.js"></script>
<script src="assets/vendor/hs-step-form/dist/hs-step-form.min.js"></script>
<script src="assets/vendor/jquery-validation/dist/jquery.validate.min.js"></script> 

<!-- JS Front -->
<script type="text/javascript">
  $(document).on('ready', function () {

    $('#event_date').datepicker({
      format: 'dd/mm/yyyy',
      autoclose: true,
      maxDate:(new Date()).getDate(),
      todayHighlight: true,
      orientation: "bottom auto"
    });
    

    $('.js-add-field').each(function () {
      new HSAddField($(this), {
        addedField: function() {
          var index = randomNumber();
          $("#addTopicItemContainer > .item-row:last").find(".particular_name").attr("name","items["+index+"][particular_name]");
          $("#addTopicItemContainer > .item-row:last").find(".particular_name").attr("required","true");
       // $("#addTopicItemContainer > .item-row:last").find(".amount").attr("name","items["+index+"][amount]");
       // $("#addTopicItemContainer > .item-row:last").find(".amount").attr("required","true");
     },
     deletedField: function() {
      $('.tooltip').hide();
    }
  }).init();
    });  

    $('#event_paid').change(function(){
        //alert("ok");
        if($('#event_paid').is(':checked')){
          $('#event_paid_details').removeClass('event_paid_details');
        }
        else{
          $('#event_paid_details').addClass('event_paid_details');
        }
      })

    $('#offline_event').change(function(){
        //alert("ok");
        if($('#offline_event').is(':checked')){
          $('.offline_event_details').removeClass('hidden');
          $('.online-event').addClass('hidden')
        }
        else{
          $('.offline_event_details').addClass('hidden');
          $('.online-event').removeClass('hidden')
        }
      })


    initEditor("event_content"); 

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