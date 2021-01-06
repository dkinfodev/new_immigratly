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
      {{$record->name}}
    </a>
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
        <a class="dropdown-item" href="{{baseUrl('visa-services/edit/'.base64_encode($record->id))}}">Edit</a>
        <a class="dropdown-item" href="{{baseUrl('visa-services/cutoff/'.base64_encode($record->id))}}">Cutoff Points</a>
        <a class="dropdown-item" href="{{baseUrl('visa-services/content/'.base64_encode($record->id))}}">Content</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('visa-services/delete/'.base64_encode($record->id))}}">Delete</a> 
      </div>
    </div>
    <!-- <a href="{{baseUrl('visa-services/edit/'.base64_encode($record->id))}}"><i class="tio-edit"></i></a> 
    <a href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('visa-services/delete/'.base64_encode($record->id))}}"><i class="tio-delete"></i></a> 
    <a href="{{baseUrl('visa-services/cutoff/'.base64_encode($record->id))}}" class="btn btn-info"><i class="tio-survey"></i> Cutoff Points</a>  -->
  
</td>
</tr>
@foreach($record->SubServices as $key2 => $subservice)
<tr class="subservice pl-3">
  <th scope="row">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox parent-{{ $key }}" id="sub-{{$key2}}" type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($subservice->id) }}">
      <label class="custom-control-label" for="sub-{{$key2}}"></label>
    </div>
  </th>
  <td class="table-column-pl-2 text-primary">
      {{$subservice->name}}
    </a>
  </td>
  <td> 
    <div class="hs-unfold">
      <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
         data-hs-unfold-options='{
           "target": "#subaction-{{$key}}",
           "type": "css-animation"
         }'>
              More <i class="tio-chevron-down ml-1"></i>
      </a>

      <div id="subaction-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
        <a class="dropdown-item" href="{{baseUrl('visa-services/edit/'.base64_encode($subservice->id))}}">Edit</a>
        <a class="dropdown-item" href="{{baseUrl('visa-services/cutoff/'.base64_encode($record->id))}}">Cutoff Points</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('visa-services/delete/'.base64_encode($subservice->id))}}">Delete</a> 
      </div>
    </div>
    <!-- <a href="{{baseUrl('visa-services/edit/'.base64_encode($subservice->id))}}"><i class="tio-edit"></i></a> &nbsp; 
    <a href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('visa-services/delete/'.base64_encode($subservice->id))}}"><i class="tio-delete"></i></a>  -->
  </td>
</tr>
@endforeach
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