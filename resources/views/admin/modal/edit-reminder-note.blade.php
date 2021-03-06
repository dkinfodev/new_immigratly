<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="staticBackdropLabel">{{$pageTitle}}</h5>
      <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
        <i class="tio-clear tio-lg"></i>
      </button>
    </div>
    <div class="modal-body">
      <form method="post" id="popup-form" class="js-validate" action="{{ baseUrl('/edit-reminder-note/'.$record->unique_id) }}">  
          @csrf
          <!-- Form Group -->
           <div class="form-group js-form-message">
              <label class="input-label">Reminder date</label>
              <div class="js-flatpickr flatpickr-custom input-group input-group-merge">
                 <div class="input-group-prepend" data-toggle>
                    <div class="input-group-text">
                       <i class="tio-date-range"></i>
                    </div>
                 </div>
                 <input data-msg="Please select reminder date" type="text" name="reminder_date" class="flatpickr-custom-form-control form-control" id="reminder_date" placeholder="Select reminder date" data-input value="{{ dateFormat($record->reminder_date,'d/m/Y') }}">
              </div>
           </div>
           <!-- End Form Group -->

          <!-- Form Group -->
          <div class="form-group js-form-message">
              <label class="input-label">Notes</label>
              <div class="input-group input-group-sm-down-break">
                <textarea type="text" class="form-control" name="notes" id="notes" placeholder="Please enter the notes" aria-label="Select Reminder Date"><?php echo $record->notes ?></textarea>
                @error('notes')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $notes }}</strong>
                </span>
                @enderror
              </div>
          </div>
          <!-- End Form Group -->
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
    // initSelect();
    $('#reminder_date').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        maxDate:(new Date()).getDate(),
        todayHighlight: true,
        orientation: "bottom auto"
    });
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
                fetchReminderNotes();
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