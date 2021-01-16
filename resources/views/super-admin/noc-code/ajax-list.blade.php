@if(count($records) > 0)
@foreach($records as $key => $record)
<tr>
  <th scope="row">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox parent-check" data-key="{{ $key }}" id="row-{{$key}}" value="{{ base64_encode($record->id) }}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </th>

  <td>
      {{$record->name}}
  </td>

  <td>
      {{$record->fetchUser->first_name}} {{$record->fetchUser->last_name}}
  </td>

  
  <td> 

     <a onclick="showPopup('{{ baseUrl('noc-code/edit/'.base64_encode($record->id)) }}')" href="javascript:;">
          <i class="tio-edit"></i>
     </a>

    <a href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('noc-code/delete/'.base64_encode($record->id))}}"><i class="tio-delete"></i></a> 
  
</td>
</tr>

@endforeach
<<<<<<< HEAD

=======
@else
<tr>
  <td colspan="3" class="text-center text-danger">No records available</td>
</tr>
>>>>>>> e5fb5987d66674af94dc8171075020ea0d1da7aa
@endif

<script>
$(document).ready(function(){
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