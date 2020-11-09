@foreach($records as $key => $record)
<tr>
  <td class="table-column-pr-0">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td>
      @if(!empty($record->Service($record->service_id)))
        {{$record->Service($record->service_id)->name}}
      @else
        Service Removed by adminstrator
      @endif
  </td>
  <td>{{$record->price}}</td>
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
        <a class="dropdown-item" href="{{baseUrl('services/edit/'.base64_encode($record->id))}}">Edit</a>
        <a class="dropdown-item" href="{{baseUrl('services/folders/'.base64_encode($record->id))}}">Document Folders</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger" href="{{baseUrl('services/delete/'.base64_encode($record->id))}}">Delete</a>
      </div>
    </div>
  </td>
</tr>
@endforeach


<script type="text/javascript">
$(document).ready(function(){
  $('.js-hs-action').each(function () {
    var unfold = new HSUnfold($(this)).init();
  });
})
</script>