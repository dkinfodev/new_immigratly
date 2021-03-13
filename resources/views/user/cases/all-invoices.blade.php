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

      <!-- <div class="col-sm-auto">
        <a class="btn btn-primary" href="<?php echo baseUrl('cases/add') ?>">
          <i class="tio-user-add mr-1"></i> Create Case
        </a>
      </div> -->
    </div>
    <!-- End Row -->
  </div>
  <!-- End Page Header -->

  <!-- Card -->
<div class="card">
  <div class="card-header">
    <h4 class="card-header-title">List of Invoices</h4>
  </div>

  <!-- Table -->
  <div class="table-responsive datatable-custom">
    <table id="datatable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
           data-hs-datatables-options='{
             "order": [],
             "isResponsive": false,
             "isShowPaging": false,
             "pagination": "datatablePagination",
             "columnDefs": [
                    { 
                       targets: "no-sort", 
                       orderable: false
                    }
                ]
             }'>
           <thead class="thead-light">
            <tr>
                
                <th scope="col">Invoice ID</th>
                <th scope="col">Amount</th>
                <th scope="col">Payment Status</th>
                <th scope="col">Created Date</th>
                
                <th scope="col"></th>
            </tr>
            </thead>

      <tbody>
      @foreach($records as $key => $record)
        <tr>

        <td>
            {{$record['invoice_id']}}
        </td>
        <td>
            {{currencyFormat($record['invoice']['amount'])}}
        </td>
        <td class="font-weight-bold">
            @if($record['invoice']['payment_status'] == 'paid')
            <span class="legend-indicator bg-success"></span> Paid <small class="text-danger">(on {{dateFormat($record['invoice']['paid_date'],'M d, Y H:i:s A')}})</small>
            @else
            <span class="legend-indicator bg-warning"></span> Pending
            @endif
        </td>
        <td>
            {{dateFormat($record['created_at'],"M d,Y h:i:s A")}}
        </td>
        <td>
            <div class="hs-unfold">
            <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
                data-hs-unfold-options='{
                "target": "#action-{{$key}}",
                "type": "css-animation"
                }'>More  <i class="tio-chevron-down ml-1"></i>
            </a>
            <div id="action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right">

                <a class="dropdown-item" href="{{baseUrl('cases/'.$subdomain.'/invoices/view/'.$record['unique_id'])}}">
                <i class="tio-dollar dropdown-item-icon"></i>
                View Invoice
                </a>
                <div class="dropdown-divider"></div>
                
            </div>
            </div>
        </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <!-- End Table -->

  <!-- Footer -->
  <div class="card-footer">
  </div>
  <!-- End Footer -->
</div>
<!-- End Card -->
</div>
<!-- End Content -->
@endsection

@section('javascript')
<script src="assets/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script>
  $('.js-nav-tooltip-link').tooltip({ boundary: 'window' });
  $(document).on('ready', function () {
    
    $('.js-hs-action').each(function () {
      var unfold = new HSUnfold($(this)).init();
    });
    // initialization of datatables
    var datatable = $.HSCore.components.HSDatatables.init($('#datatable'));
  });
</script>
@endsection