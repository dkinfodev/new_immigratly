@foreach($records as $key => $record)
<tr>
  <td class="table-column-pr-0">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($record->id) }}" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td class="table-column-pl-0">
    {{$record->case_name}}
  </td>
  <td class="table-column-pl-0">
    {{$record->VisaService->name}}
  </td>
  <td class="table-column-pl-0">{{$record->amount_paid}}</td>
  <td class="table-column-pl-0">
    @if($record->Invoice->payment_status == 'paid')
        <span class="badge badge-success">{{$record->Invoice->payment_status}}</span>
    @else
        <span class="badge badge-danger">{{$record->Invoice->payment_status}}</span>
    @endif
  </td>
  
  <td class="table-column-pl-0">
    @if($record->professional_assigned == 1)
        <span class="badge badge-success">Assigned To Professional</span>
        <div class="text-primary">
          <?php
          $company_data = professionalDetail($record->professional);
          if(!empty($company_data)){
            echo "<div class='text-danger'><i class='tio-user'></i> ".$company_data->company_name."</div>";
          }
          ?>
        </div>
    @else
    <div class="hs-unfold">
      <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
         data-hs-unfold-options='{
           "target": "#action-{{$key}}",
           "type": "css-animation"
         }'>
              More <i class="tio-chevron-down ml-1"></i>
      </a>

      <div id="action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
        <a class="dropdown-item" href="{{baseUrl('assessments/edit/'.$record->unique_id)}}">Edit</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('assessments/delete/'.base64_encode($record->id))}}">Delete</a> 
      </div>
    </div>
    @endif
  </td>
</tr>
@endforeach


<script type="text/javascript">
$(document).ready(function(){
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