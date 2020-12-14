@extends('layouts.master')

@section('content')

<div class="content container-fluid">

 <form id="form" method="post" action="{{baseUrl('dashboard-setting')}}" class="js-validate">
	  @csrf

    <div class="row justify-content-md-between">

      <div class="col-md-4">
        <!-- Logo -->
        <label class="custom-file-boxed custom-file-boxed-sm" for="logoUploader">
        	@if(!empty($record->logo))
        	{{$record->logo}}
            <img id="logoImg" class="avatar avatar-xl avatar-4by3 avatar-centered h-100 mb-2" src="{{ DashboardSettingDir().$record->logo }}" alt="Profile Image">
          @else
            <img id="logoImg" class="avatar avatar-xl avatar-4by3 avatar-centered h-100 mb-2" src="./assets/svg/illustrations/browse.svg" alt="Profile Image">
          @endif

          <span class="d-block">Upload your Image here</span>

          <input type="file" class="js-file-attach custom-file-boxed-input" name="logo" id="logoUploader"
          data-hs-file-attach-options='{
          "textTarget": "#logoImg",
          "mode": "image",
          "targetAttr": "src"
        }'>
      	</label>
      	<!-- End Logo -->    
      		<button type="submit" class="btn btn-primary">Submit</button>
      </div> <!-- End colmd4 -->
      

  	</div><!--row edn -->
</form>
</div>
@endsection


@section('javascript')
<script type="text/javascript">

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