@foreach($records as $key => $record)
<tr>
  <td class="table-column-pr-0">
    <div class="custom-control custom-checkbox">
      <input type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($record->id) }}" id="row-{{$key}}">
      <label class="custom-control-label" for="row-{{$key}}"></label>
    </div>
  </td>
  <td class="table-column-pl-0">
    {{ $record->task_title }}
  </td>
  
  <td>
    @if($record->status == 'pending')
    <span class="badge badge-soft-warning p-2">Pending</span>
    @elseif($record->status == 'completed')
    <span class="badge badge-soft-success p-2">Completed</span>
    @endif
  </td>
   <td></td>
</tr>
@endforeach
<script type="text/javascript">
$(document).ready(function(){
  $('.js-nav-tooltip-link').tooltip({ boundary: 'window' })
  $('.js-hs-action').each(function () {
    var unfold = new HSUnfold($(this)).init();
  });
})
</script>