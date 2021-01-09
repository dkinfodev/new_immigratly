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
      {{$record->title}}
    </a>
  </td>

  <td class="table-column-pl-0">
      {{$record->fetchNewsCategory->name}}
    </a>
  </td>

  <td class="table-column-pl-0">
      {{$record->fetchUser->first_name}}{{$record->fetchUser->last_name}}
    </a>
  </td>

  <td class="table-column-pl-0">
      {{$record->news_date}}
    </a>
  </td>

  <td> 
    @if(employee_permission('news','edit-news'))
    <a href="{{baseUrl('news/edit/'.base64_encode($record->id))}}"><i class="tio-edit"></i></a> 
    @endif
    @if(employee_permission('news','delete-news'))
    <a href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('news/delete/'.base64_encode($record->id))}}"><i class="tio-delete"></i></a> 
    @endif
  
</td>
</tr>

@endforeach

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