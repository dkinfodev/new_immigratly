@if(count($records) > 0)
@foreach($records as $key => $record)
<tr>
  <th scope="row">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox parent-check" data-key="{{ $key }}" id="row-{{$key}}" value="{{ base64_encode($record->id) }}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </th>
  <td class="table-column-pl-0">
      {{$record->case_name}}
  </td>
  <td class="table-column-pl-0">
      {{$record->VisaService->name}}
  </td>
  <td class="table-column-pl-0">
      {{$record->amount_paid}}
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
        <a class="dropdown-item" href="{{baseUrl('assessments/edit/'.base64_encode($record->id))}}">Edit</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('assessments/delete/'.base64_encode($record->id))}}">Delete</a> 
      </div>
    </div>
</td>
</tr>
@endforeach
@else
<tr>
  <td colspan="3" class="text-center text-danger">No records available</td>
</tr>
@endif

<script>
$(document).ready(function(){
  $('.js-hs-action').each(function () {
    var unfold = new HSUnfold($(this)).init();
  });
  $(".parent-check").change(function(){
      var key = $(this).attr("data-key");
      if($(this).is(":checked")){
        $(".parent-"+key).prop("checked",true);
      }else{
        $(".parent-"+key).prop("checked",false);
      }
  })
})
</script>