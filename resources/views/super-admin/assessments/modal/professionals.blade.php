<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="staticBackdropLabel">{{$pageTitle}}</h5>
      <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
        <i class="tio-clear tio-lg"></i>
      </button>
    </div>
    <div class="modal-body">
      <form method="post" id="popup-form" class="js-validate" action="{{ baseUrl('/services/add-folder/'.$service_id) }}">  
        @csrf
        <div class="row">
          @foreach($professionals as $key=>$prof)
            <div class="col-md-4">
                <div class="card">
                  <div class="card-image">
                    <img class="img-fluid w-100 rounded-lg" src="{{professionalLogo($prof->subdomain)}}" alt="Image Description">
                  </div>
                  <div class="card-footer">
                      <h3>{{professionalDetail($prof->subdomain)->company_name}}</h3>
                  </div>
                </div>
            </div>
          @endforeach
        </div>    
      </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
      <button form="popup-form" class="btn btn-primary">Save</button>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
      $("#popup-form").submit(function(e){
          e.preventDefault();
          var formData = $("#popup-form").serialize();
          var url  = $("#popup-form").attr('action');
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
                  closeModal();
                  location.reload();
                }else{
                  $.each(response.message, function (index, value) {
                      $("*[name="+index+"]").parents(".js-form-message").find("#"+index+"-error").remove();
                      $("*[name="+index+"]").parents(".js-form-message").find(".form-control").removeClass('is-invalid');
                      
                      var html = '<div id="'+index+'-error" class="invalid-feedback">'+value+'</div>';
                      $("*[name="+index+"]").parents(".js-form-message").append(html);
                      $("*[name="+index+"]").parents(".js-form-message").find(".form-control").addClass('is-invalid');
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