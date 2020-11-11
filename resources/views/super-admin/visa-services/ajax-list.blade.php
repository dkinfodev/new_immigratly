@if(count($records) > 0)
@foreach($records as $key => $record)
<tr>
  <th scope="row">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </th>
  <td class="table-column-pl-0">
      {{$record->name}}
    </a>
  </td>
  <td> 
    <a href="{{baseUrl('visa-services/edit/'.base64_encode($record->id))}}"><i class="tio-edit"></i></a> 
    <a href="javascript:;" onclick="deleteRecord('{{ base64_encode($record->id) }}')" data-href="{{baseUrl('visa-services/delete/'.base64_encode($record->id))}}"><i class="tio-delete"></i></a> 
  
</td>
</tr>
@foreach($record->SubServices as $key2 => $subservice)
<tr class="subservice pl-3">
  <th scope="row">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input" id="sub-{{$key2}}">
      <label class="custom-control-label" for="sub-{{$key2}}"></label>
    </div>
  </th>
  <td class="table-column-pl-2 text-primary">
      {{$subservice->name}}
    </a>
  </td>
  <td> 
    <a href="{{baseUrl('visa-services/edit/'.base64_encode($subservice->id))}}"><i class="tio-edit"></i></a> &nbsp; 
    <a href="javascript:;" onclick="deleteRecord('{{ base64_encode($subservice->id) }}')" data-href="{{baseUrl('visa-services/delete/'.base64_encode($subservice->id))}}"><i class="tio-delete"></i></a> 
  </td>
</tr>
@endforeach
@endforeach
@else
<tr>
  <td colspan="3" class="text-center text-danger">No records available</td>
</tr>
@endif
