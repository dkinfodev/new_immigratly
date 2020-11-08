@foreach($records as $key => $record)
<tr>
  <td class="table-column-pr-0">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td class="table-column-pl-0">
      <div class="ml-3">
        <span class="d-block h5 text-hover-primary mb-0">{{$record->first_name}} {{$record->last_name}}</span>
      </div>
    </a>
  </td>

  <td>{{$record->email}}</td>
  <td>{{$record->phone_no}}</td>
  <td>{{$record->visa_service}}</td>
  <td> <a href="{{baseUrl('quick-lead/edit/'.base64_encode($record->id))}}"><i class="tio-edit"></i></a> &nbsp; <a href="{{baseUrl('quick-lead/delete/'.base64_encode($record->id))}}"><i class="tio-delete"></i></a> 
  
</td>
</tr>
@endforeach
