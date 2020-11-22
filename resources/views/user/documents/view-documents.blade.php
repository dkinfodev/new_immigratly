@extends('layouts.master')
@section("style")
<style>
.all_services li {
    padding: 16px;
    border-bottom: 1px solid #ddd;
}
.sub_services li {
    border-bottom: none;
}
</style>
@endsection
@section('content')
<!-- Content -->
<div class="content container-fluid">
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>
        
        
      </div>
      <div class="col-sm-auto">
         <a onclick="showPopup('{{ baseUrl('/documents/add-folder') }}')" class="btn btn-primary" href="javascript:;">
         <i class="tio-folder-add mr-1"></i> Add folder
         </a>
      </div>
    </div>
  </div>


  

</div>
<!-- End Content -->
@endsection

@section('javascript')
<script type="text/javascript">
$(document).ready(function(){
   $('.js-hs-action').each(function () {
    var unfold = new HSUnfold($(this)).init();
   });
   if($(".row-checkbox:checked").length > 0){
      $("#datatableCounterInfo").show();
   }else{
      $("#datatableCounterInfo").hide();
   }
})

</script>
@endsection