@foreach($records as $key => $record)
<tr>
  <td class="table-column-pr-0">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($record->id) }}" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td class="table-column-pl-0">
    <a class="d-flex align-items-center" href="javascript:;">
      @if(!empty($record->Client($record->client_id)))
      <?php
      $client = $record->Client($record->client_id);
      ?>
      <div class="avatar avatar-soft-primary mt-4 avatar-circle">
        <span class="avatar-initials">{{userInitial($client)}}</span>
      </div>
      @else
      <div class="avatar avatar-soft-primary mt-4 avatar-circle">
        <span class="avatar-initials">UN</span>
      </div>
      @endif
      <!-- <img class="avatar" src="assets/svg/brands/capsule.svg" alt="Image Description"> -->
      <div class="ml-3">
        <span class="d-block h5 text-hover-primary mb-0">{{ $record->case_title }}</span>
        <span class="d-block font-size-sm text-body">Created on {{ dateFormat($record->created_at) }}</span>
      </div>
    </a>
  </td>
  <td>
    @if(!empty($record->Client($record->client_id)))
    <?php
    $client = $record->Client($record->client_id);
    ?>
    <span class="badge badge-soft-primary p-2">{{$client->first_name." ".$client->last_name}}</span>
    @else
    <span class="badge badge-soft-danger p-2">Client not found</span>
    @endif
  </td>
  <td>
    @if(!empty($record->Service($record->VisaService->service_id)))
    <span class="badge badge-soft-info p-2">{{$record->Service($record->VisaService->service_id)->name}}</span>
    @else
    <span class="badge badge-soft-info p-2">Service Removed</span>
    @endif
  </td>
  <!-- <td>
    <span class="text-body">
      <i class="tio-calendar-month"></i> {{$record->start_date}}
    </span>
  </td> -->
  
   <td>
    <!-- Avatar Group -->
    <div class="avatar-group avatar-group-xs avatar-circle">
      <span class="avatar avatar-light js-nav-tooltip-link avatar-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ count($record->AssingedMember) }} assigned">
        <span class="avatar-initials">{{ count($record->AssingedMember) }} member(s)</span>
      </span>
      <!-- <a class="avatar" href="user-profile.html" data-toggle="tooltip" data-placement="top" title="Costa Quinn">
        <img class="avatar-img" src="./assets/img/160x160/img6.jpg" alt="Image Description">
      </a>
      <a class="avatar" href="user-profile.html" data-toggle="tooltip" data-placement="top" title="Clarice Boone">
        <img class="avatar-img" src="./assets/img/160x160/img7.jpg" alt="Image Description">
      </a>
      <a class="avatar avatar-soft-danger" href="user-profile.html" data-toggle="tooltip" data-placement="top" title="Adam Keep">
        <span class="avatar-initials">A</span>
      </a> -->
    </div>
    <!-- End Avatar Group -->
  </td>
  
  <td>
      <div class="hs-unfold">
      <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
         data-hs-unfold-options='{
           "target": "#action-{{$key}}",
           "type": "css-animation"
         }'>
              More <i class="tio-chevron-down ml-1"></i>
      </a>
      <div id="action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
        <a class="dropdown-item" href="{{baseUrl('cases/edit/'.base64_encode($record->id))}}">Edit</a>
        <a class="dropdown-item" href="{{baseUrl('cases/case-documents/'.base64_encode($record->id))}}">Case Documents</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('cases/delete/'.base64_encode($record->id))}}">Delete</a> 
      </div>
    </div>
   </td>
</tr>
@endforeach
<script type="text/javascript">
$(document).ready(function(){

  $('.js-nav-tooltip-link').tooltip({ boundary: 'window' })
  $('.js-hs-action').each(function () {
    var unfold = new HSUnfold($(this)).init();
  });
  $(".row-checkbox").change(function(){
    if($(".row-checkbox:checked").length > 0){
      $("#datatableCounterInfo").show();
    }else{
      $("#datatableCounterInfo").show();
    }
    $("#datatableCounter").html($(".row-checkbox:checked").length);
  });
})
</script>