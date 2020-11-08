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
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/super-admin') }}">Super Admin</a></li>
            <li class="breadcrumb-item active" aria-current="page">Quick Leads</li>
          </ol>
        </nav>

        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modelQuickLead">
          <i class="tio-add mr-1"></i>Add
        </button>
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
              <input id="datatableSearch" onchange="search(this.value)" type="search" class="form-control" placeholder="Search visa services" aria-label="Search visa service">
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
                <a class="btn btn-sm btn-outline-danger" href="javascript:;">
                  <i class="tio-delete-outlined"></i> Delete
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Row -->
    </div>
    <!-- End Header -->

    <!-- Table -->
    <div class="table-responsive datatable-custom">
      <table id="tableList" class="table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
        <thead class="thead-light">
          <tr>
            <th class="table-column-pr-0">
              <div class="custom-control custom-checkbox">
                <input id="datatableCheckAll" type="checkbox" class="custom-control-input">
                <label class="custom-control-label" for="datatableCheckAll"></label>
              </div>
            </th>
            <th class="table-column-pl-0">Name</th>
            <th>Email</th>
            <th>Phone no.</th>
            <th>Visa Service</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    <!-- End Table -->

    <!-- Footer -->
    <div class="card-footer">
      <!-- Pagination -->
      <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
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
<!-- End Footer -->
</div>
<!-- End Card -->


<!-- Modal -->
<div id="modelQuickLead" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenteredScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenteredScrollableTitle">Quick Lead</h5>
        <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
          <i class="tio-clear tio-lg"></i>
        </button>
      </div>
      <div class="modal-body">

        <form method="post" id="quickLead-form" class="js-validate" action="{{ baseUrl('/quick-lead/save') }}">  
          @csrf
          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Full name <i class="tio-help-outlined text-body ml-1" data-toggle="tooltip" data-placement="top" title="Name for quick lead"></i></label>

            <div class="col-sm-9">
              <div class="input-group input-group-sm-down-break">
                <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" id="first_name" placeholder="Your first name" aria-label="Your first name" >
                @error('first_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" id="last_name" placeholder="Your last name" aria-label="Your last name">
                @error('last_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Email</label>
            <div class="col-sm-9">
              <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Your email" aria-label="Email" value="mark@example.com">
              @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Phone </label>
            <div class="col-sm-3">
              <select name="country_code" class="form-control">
                @foreach($countries as $key=>$c)
                <option id="{{$c->phonecode}}" value="+{{$c->phonecode}}">+{{$c->phonecode}}</option>
                @endforeach
              </select>
            </div>

            <div class="col-sm-6">
              <input type="text" name="phone_no" id="phone_no" class="form-control @error('phone_no') is-invalid @enderror">
              @error('phone_no')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>      
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="row form-group js-form-message">
            <label class="col-sm-3 col-form-label input-label">Visa Service </label>
            <div class="col-sm-9">

              <select name="visa_service" id="visa_service" class="form-control @error('visa_service') is-invalid @enderror">
                @foreach($visaService as $key=>$v)
                <option id="{{$v->id}}" value="{{$v->id}}">{{$v->name}}</option>
                @endforeach
              </select>
              @error('visa_service')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
          </div>      
          <!-- End Form Group -->

          <!-- Form Group -->
          <div class="d-flex justify-content-end">
            <div class="form-group">
              <button type="button" class="btn add-btn btn-primary">Add</button>
            </div>
          </div>
        </form>
        <!-- End Form -->
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->

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
  })
  loadData();
  function loadData(page=1){
    $.ajax({
      type: "POST",
      url: BASEURL + '/quick-lead/ajax-list?page='+page,
      data:{
        _token:csrf_token
      },
      dataType:'json',
      beforeSend:function(){
        var cols = $("#tableList thead tr > th").length;
        $("#tableList tbody").html('<tr><td colspan="'+cols+'"><center><i class="fa fa-spin fa-spinner fa-3x"></i></center></td></tr>');
            // $("#paginate").html('');
          },
          success: function (data) {
            $("#tableList tbody").html(data.contents);
            
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


  function search(keyword){
    $.ajax({
      type: "POST",
      url: BASEURL + '/quick-lead/search/'+keyword,
      data:{
        _token:csrf_token
      },
      dataType:'json',
      beforeSend:function(){
        var cols = $("#tableList thead tr > th").length;
        $("#tableList tbody").html('<tr><td colspan="'+cols+'"><center><i class="fa fa-spin fa-spinner fa-3x"></i></center></td></tr>');
            // $("#paginate").html('');
          },
          success: function (data) {
            $("#tableList tbody").html(data.contents);
            
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
          url: BASEURL + '/program-types/delete',
          data:{
            _token:csrf_token,
            record_id:id,
          },
          dataType:'json',
          success: function (result) {
            if(result.status == true){
              Swal.fire({
                type: "success",
                title: 'Deleted!',
                text: 'Record Body has been deleted.',
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
</script>


<script type="text/javascript">
  $(document).ready(function(){
    $(".add-btn").click(function(e){
      e.preventDefault(); 
      $(".add-btn").attr("disabled","disabled");
      $(".add-btn").find('.fa-spin').remove();
      $(".add-btn").prepend("<i class='fa fa-spin fa-spinner'></i>");

      var first_name = $("#first_name").val();
      var last_name = $("#last_name").val();
      var email = $("#email").val();
      var phone_no = $("#phone_no").val();
      var visa_service = $("#visa_service").val();

      var formData = $("#quickLead-form").serialize();
      $.ajax({
        url:"{{ baseUrl('quick-lead/save') }}",
        type:"post",
        data:formData,
        dataType:"json",
        beforeSend:function(){
        },
        success:function(response){
         $(".add-btn").find(".fa-spin").remove();
         $(".add-btn").removeAttr("disabled");
         if(response.status == true){
          successMessage(response.message);
          window.location.href = response.redirect_back;
        }else{
          $.each(response.message, function (index, value) {
            $("input[name="+index+"]").parents(".js-form-message").find("#"+index+"-error").remove();
            $("input[name="+index+"]").parents(".js-form-message").find(".form-control").removeClass('is-invalid');

            var html = '<div id="'+index+'-error" class="invalid-feedback">'+value+'</div>';
            $("input[name="+index+"]").parents(".js-form-message").append(html);
            $("input[name="+index+"]").parents(".js-form-message").find(".form-control").addClass('is-invalid');
          });
        }
      },
      error:function(){
       $(".add-btn").find(".fa-spin").remove();
       $(".add-btn").removeAttr("disabled");
     }
      });
    });

  });
  </script>
    @endsection