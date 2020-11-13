<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="staticBackdropLabel">{{$pageTitle}}</h5>
      <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
        <i class="tio-clear tio-lg"></i>
      </button>
    </div>
    <div class="modal-body">
      <form method="post" id="popup-form" class="js-validate" action="{{ baseUrl('/leads/mark-as-client/'.base64_encode($lead_id)) }}">  
          @csrf
          <div class="text-center">
            <p>Are you sure to mark leads as clients</p>
          </div>
          <div id="response" class="text-center"></div>
      </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
      <button form="popup-form" class="btn btn-primary">Mark as Client</button>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    // initSelect();
    
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
              $("#response").addClass('');
              $("#response").html('');
              if(response.status == true){
                closeModal();
                successMessage(response.message);
                // popupModal("<?php echo baseUrl('cases/create-case') ?>/"+response.user_id);
                loadData();
              }else{
                $("#response").addClass("text-danger");
                $("#response").html(response.message);
              }
            },
            error:function(){
              internalError();
            }
        });
    });
});
</script>