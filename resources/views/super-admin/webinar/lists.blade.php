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
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>

        <h1 class="page-title">{{$pageTitle}}</h1>
   
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{(baseUrl('webinar/add'))}}">
          <i class="tio-user-add mr-1"></i> Add
        </a>
      </div>
    </div>
    <!-- End Row -->
  </div>
  <!-- End Page Header -->
  <!-- Card -->
  <div class="card">
    <!-- Header -->
    <div class="card-header">
      <div class="row justify-content-between align-items-center flex-grow-1">
        <div class="col-sm-6 col-md-4 mb-3 mb-sm-0">
          <form>
            <!-- Search -->
            <div class="input-group input-group-merge input-group-flush">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="tio-search"></i>
                </div>
              </div>
              <input id="datatableSearch" type="search" class="form-control" placeholder="Search " aria-label="Search">
            </div>
            <!-- End Search -->
          </form>
        </div>

        <div class="col-sm-6">
          <div class="d-sm-flex justify-content-sm-end align-items-sm-center">
            <!-- Datatable Info -->
            <div id="datatableCounterInfo" class="mr-2 mb-2 mb-sm-0" style="display: none;">
              <div class="d-flex align-items-center">
                <span class="font-size-sm mr-3">
                  <span id="datatableCounter">0</span>
                  Selected
                </span>
                <a class="btn btn-sm btn-outline-danger" data-href="{{ baseUrl('webinar/delete-multiple') }}" onclick="deleteMultiple(this)" href="javascript:;">
                  <i class="tio-delete-outlined"></i> Delete
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Row -->
    </div>
  </div>

  <!-- End Card -->
  <div class="row" id="articles-list"></div>
  <!-- Pagination -->
  <div class="row justify-content-center justify-content-sm-between align-items-sm-center mt-3">
    <div class="col-md-3 mb-2 mb-sm-0">
      <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
        <span class="mr-2">Page:</span>
        <span id="pageinfo"></span>
      </div>
    </div>

    <div class="col-md-3 pull-right">
      <div class="justify-content-center justify-content-sm-end">
        <nav id="datatablePagination" aria-label="Activity pagination">
           <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
              <ul id="datatable_pagination" class="pagination datatable-custom-pagination">
                 <li class="paginate_item page-item previous disabled">
                    <a class="paginate_button page-link btn btn-primary" aria-controls="datatable" data-dt-idx="0" tabindex="0" id="datatable_previous"><span aria-hidden="true">Prev</span></a>
                 </li>
                 <li class="paginate_item page-item">
                    <input onblur="changePage('goto')" min="1" type="number" id="pageno" class="form-control text-center" />
                 </li>
                 <li class="paginate_item page-item next disabled">
                    <a class="paginate_button page-link btn btn-primary" aria-controls="datatable" data-dt-idx="3" tabindex="0"><span aria-hidden="true">Next</span></a>
                 </li>
              </ul>
           </div>
        </nav>
      </div>
    </div>
  </div>
  <!-- End Pagination -->
</div>
<!-- End Content -->
@endsection

@section('javascript')
<script src="assets/vendor/hs-toggle-switch/dist/hs-toggle-switch.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('.js-toggle-switch').each(function () {
    var toggleSwitch = new HSToggleSwitch($(this)).init();
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
  $("#datatableSearch").keyup(function(){
    var value = $(this).val();
    if(value == ''){
      loadData();
    }
    if(value.length > 3){
      loadData();
    }
  });
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

})
loadData();
function loadData(page=1){
  var search = $("#datatableSearch").val();
    $.ajax({
        type: "POST",
        url: BASEURL + '/webinar/ajax-list?page='+page,
        data:{
            _token:csrf_token,
            search:search,
        },
        dataType:'json',
        beforeSend:function(){
            showLoader();
        },
        success: function (data) {
            hideLoader();
            $("#articles-list").html(data.contents);
            
            if(data.total_records > 0){
              var pageinfo = data.current_page+" of "+data.last_page+" <small class='text-danger'>("+data.total_records+" records)</small>";
              $("#pageinfo").html(pageinfo);
              $("#pageno").val(data.current_page);
              if(data.current_page < data.last_page){
                $(".next").removeClass("disabled");
              }else{
                $(".next").addClass("disabled","disabled");
              }
              if(data.current_page > 1){
                $(".previous").removeClass("disabled");
              }else{
                $(".previous").addClass("disabled","disabled");
              }
              $("#pageno").attr("max",data.last_page);
            }else{
              $(".datatable-custom").find(".norecord").remove();
              var html = '<div class="text-center text-danger norecord">No records available</div>';
              $(".datatable-custom").append(html);
            }
        },
    });
}
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
function confirmDelete(id){
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      confirmButtonClass: 'btn btn-primary',
      cancelButtonClass: 'btn btn-danger ml-1',
      buttonsStyling: false,
    }).then(function(result) {
      if (result.value) {
        $.ajax({
            type: "POST",
            url: BASEURL + '/staff/delete-user',
            data:{
                _token:csrf_token,
                user_id:id,
            },
            dataType:'json',
            success: function (result) {
                if(result.status == true){
                    Swal.fire({
                        type: "success",
                        title: 'Deleted!',
                        text: 'User has been deleted.',
                        confirmButtonClass: 'btn btn-success',
                    }).then(function () {

                        window.location.href= result.redirect;
                    });
                }else{
                    Swal.fire({
                        title: "Error!",
                        text: "Error while deleting",
                        type: "error",
                        confirmButtonClass: 'btn btn-primary',
                        buttonsStyling: false,
                    });
                }
            },
        });
      }
    })
}

function changeStatus(e){
  var id = $(e).attr("data-id");
  if($(e).is(":checked")){
    $.ajax({
        type: "POST",
        url: BASEURL + '/staff/status/active',
        data:{
            _token:csrf_token,
            id:id,
        },
        dataType:'json',
        success: function (result) {
            if(result.status == true){
                successMessage(result.message);
                loadData();
            }else{
                errorMessage(result.message);
            }
        },
    });
  }else{
    $.ajax({
        type: "POST",
        url: BASEURL + '/staff/status/inactive',
        data:{
            _token:csrf_token,
            id:id,
        },
        dataType:'json',
        success: function (result) {
            if(result.status == true){
                successMessage(result.message);
                loadData();
            }else{
                errorMessage(result.message);
            }
        },
        error: function(){
          internalError();
        }
    });
  }
}

function profileStatus(e){
  var id = $(e).attr("data-id");
  if($(e).is(":checked")){
    $.ajax({
        type: "POST",
        url: BASEURL + '/staff/profile-status/active',
        data:{
            _token:csrf_token,
            id:id,
        },
        dataType:'json',
        success: function (result) {
            if(result.status == true){
                successMessage(result.message);
            }else{
                errorMessage(result.message);
            }
        },
    });
  }else{
    $.ajax({
        type: "POST",
        url: BASEURL + '/staff/profile-status/inactive',
        data:{
            _token:csrf_token,
            id:id,
        },
        dataType:'json',
        success: function (result) {
            if(result.status == true){
                successMessage(result.message);
                loadData();
            }else{
                errorMessage(result.message);
            }
        },
        error: function(){
          internalError();
        }
    });
  }
}
</script>
@endsection