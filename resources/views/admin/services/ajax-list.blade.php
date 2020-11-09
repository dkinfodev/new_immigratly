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
  <td> <a href="{{baseUrl('services/edit/'.base64_encode($record->id))}}"><i class="tio-edit"></i></a> &nbsp; <a href="{{baseUrl('licence-bodies/delete/'.base64_encode($record->id))}}"><i class="tio-delete"></i></a> 
  
</td>
</tr>
@endforeach
