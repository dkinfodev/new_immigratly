$(document).ready(function(){
  // Pagination Script
  $("#datatableCheckAll").change(function(){
    if($(this).is(":checked")){
      $(".row-checkbox").prop("checked",true);
    }else{
      $(".row-checkbox").prop("checked",false);
    }
    if($(".row-checkbox:checked").length > 0){
      $("#datatableCounterInfo").show();
    }else{
      $("#datatableCounterInfo").hide();
    }
    $("#datatableCounter").html($(".row-checkbox:checked").length);
  });

  $(".next").click(function(){
    if(!$(this).hasClass('disabled')){
      changePage('next');
    }
  });
  $(".previous").click(function(){
    if(!$(this).hasClass('disabled')){
      changePage('prev');
    }
  });
});
function changePage(action){
  var page = parseInt($("#pageno").val());
  if(action == 'prev'){
    page--;
  }
  if(action == 'next'){
    page++;
  }
  if(!isNaN(page)){
    loadData(page);
  }else{
    errorMessage("Invalid Page Number");
  }
  
}
// Pagination Script
function initPagination(data,parent_class= ''){
	$(".row-checkbox").change(function(){
	    if($(".row-checkbox:checked").length > 0){
	      $("#datatableCounterInfo").show();
	    }else{
	      $("#datatableCounterInfo").show();
	    }
	    $("#datatableCounter").html($(".row-checkbox:checked").length);
  	});
	if(parent_class != ''){
		parent_class = parent_class+" ";
	}
  $(parent_class+".datatable-custom").find(".norecord").remove();
	if(data.total_records > 0){
      var pageinfo = data.current_page+" of "+data.last_page+" <small class='text-danger'>("+data.total_records+" records)</small>";
      $(parent_class+"#pageinfo").html(pageinfo);
      $(parent_class+"#pageno").val(data.current_page);
      if(data.current_page < data.last_page){
        $(parent_class+".next").removeClass("disabled");
      }else{
        $(parent_class+".next").addClass("disabled","disabled");
      }
      if(data.current_page > 1){
        $(parent_class+".previous").removeClass("disabled");
      }else{
        $(parent_class+".previous").addClass("disabled","disabled");
      }
      $(parent_class+"#pageno").attr("max",data.last_page);
    }else{
      
      var html = '<div class="text-center text-danger norecord">No records available</div>';
      $(parent_class+".datatable-custom").append(html);
    }
}
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
function bottomMessage(message,type){
  toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-bottom-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }
  if(type == 'success'){
    toastr.success(message, 'Success');
  }else{
    toastr.error(message, 'Success');
  }
  
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
  $(".custom-select").removeClass('is-invalid');
	$.each(errors, function (index, value) {
	  $("*[name="+index+"]").parents(".js-form-message").find(".invalid-feedback").remove();
	  $("*[name="+index+"]").parents(".js-form-message").find(".form-control").removeClass('is-invalid');
	  var html = '<div id="'+index+'-error" class="invalid-feedback required-error">'+value+'</div>';
	  if($("[name="+index+"]").get(0).tagName == 'SELECT'){
	  	$("*[name="+index+"]").parents(".js-form-message").append(html);
      $("*[name="+index+"]").parents(".js-form-message").find(".custom-select").addClass('is-invalid');
	  }else{
	  	$(html).insertAfter("*[name="+index+"]");
	  }
	  $("*[name="+index+"]").parents(".js-form-message").find(".form-control").addClass('is-invalid');
	});
}
function initEditor(id,type="full"){
 	var textarea = document.getElementById(id);
 	var editor;
	if(type  == 'basic'){
		editor = CKEDITOR.replace(textarea, {
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
		editor = CKEDITOR.replace(textarea);
	}
	editor.on( 'change', function( evt ) {
	    $("#"+id).val( evt.editor.getData());
	});
	return editor;
}

function randomNumber(){
  var minm = 10000; 
  var maxm = 99999; 
  var number = Math.floor(Math.random() * (maxm - minm + 1)) + minm; 
  return number;
}