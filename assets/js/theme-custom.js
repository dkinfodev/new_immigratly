function internalError(){
	hideLoader();
	warningMessage("Something went wrong. Try again!")
}
function showLoader(){
    $(".loader").show();
}
function hideLoader(){
    $(".loader").hide();
}
function successMessage(message){
  toastr.success(message, 'Success');
}
function errorMessage(message){  
  toastr.error(message, 'Warning');
}
function warningMessage(message){
  toastr.warning(message, 'Warning');
}
function redirect(url){
  window.location.href = url;
}
function initSelect(){
	$('select').each(function () {
      $.HSCore.components.HSSelect2.init($(this));
    });
}
function confirmAction(e){
	var url = $(e).attr("data-href");
	Swal.fire({
      title: 'Are you sure to delete?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      confirmButtonClass: 'btn btn-primary',
      cancelButtonClass: 'btn btn-danger ml-1',
      buttonsStyling: false,
    }).then(function(result) {
    	if(result.value){
    		redirect(url);
    	}
    })
}

function deleteMultiple(e){
	var url = $(e).attr("data-href");
	if($(".row-checkbox:checked").length <= 0){
		warningMessage("No records selected to delete");
		return false;
	}
	Swal.fire({
      title: 'Are you sure to delete?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      confirmButtonClass: 'btn btn-primary',
      cancelButtonClass: 'btn btn-danger ml-1',
      buttonsStyling: false,
    }).then(function(result) {
    	if(result.value){
    		if($(".row-checkbox:checked").length <= 0){
    			warningMessage("No records selected to delete");
    			return false;
    		}
    		var row_ids = [];
    		$(".row-checkbox:checked").each(function(){
    			row_ids.push($(this).val());
    		});
    		var ids = row_ids.join(",");
    		$.ajax({
		        type: "POST",
		        url: url,
		        data:{
		            _token:csrf_token,
		            ids:ids,
		        },
		        dataType:'json',
		        beforeSend:function(){
		           
		        },
		        success: function (response) {
		            if(response.status == true){
		            	location.reload();
		            }else{
		            	errorMessage(response.message);
		            }
		        },
		        error:function(){
		        	internalError();
		        }
		    });
    	}
    })
}
function validation(errors){
	$(".invalid-feedback").remove();
	$(".form-control").removeClass('is-invalid');
	$.each(errors, function (index, value) {
	  $("*[name="+index+"]").parents(".js-form-message").find(".invalid-feedback").remove();
	  $("*[name="+index+"]").parents(".js-form-message").find(".form-control").removeClass('is-invalid');
	  var html = '<div id="'+index+'-error" class="invalid-feedback">'+value+'</div>';
	  if($("[name="+index+"]").get(0).tagName == 'SELECT'){
	  	$("*[name="+index+"]").parents(".js-form-message").append(html);
	  }else{
	  	$(html).insertAfter("*[name="+index+"]");
	  }
	  $("*[name="+index+"]").parents(".js-form-message").find(".form-control").addClass('is-invalid');
	});
}
function initEditor(id,type="full"){
 	var textarea = document.getElementById(id);
	if(type  == 'basic'){
		return CKEDITOR.replace(textarea, {
		  toolbar: [
		    // { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
		    // { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
		    // { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
		    // { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
		    // '/',
		    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
		    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
		    { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
		    // { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
		    '/',
		    { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
		    { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		    { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
		    { name: 'others', items: [ '-' ] },
		    { name: 'about', items: [ 'About' ] }
		  ],
		  toolbarGroups: [
		    { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		    { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
		    { name: 'forms' },
		    '/',
		    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		    { name: 'links' },
		    { name: 'insert' },
		    '/',
		    { name: 'styles' },
		    { name: 'colors' },
		    { name: 'tools' },
		    { name: 'others' },
		    { name: 'about' }
		  ]
		});
	}else{
		return CKEDITOR.replace(textarea);
	}
}