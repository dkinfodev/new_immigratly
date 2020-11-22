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


  <div class="card mt-3">
    <!-- Header -->
    <div class="card-body">
      <div class="row align-items-center mb-2">
         <div class="col">
            <h2 class="h4 mb-0">Other Folders</h2>
         </div>
      </div>
      <div class="tab-content" id="connectionsTabContent">
         <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
            <ul class="list-group">
              
               @foreach($documents_folders as $key => $document)
               <li class="list-group-item">
                  <div class="row align-items-center gx-2">
                     <div class="col-auto">
                        <i class="tio-folder tio-xl text-body mr-2"></i>
                     </div>
                     <div class="col">
                        <h5 class="card-title text-truncate mr-2">
                           {{$document->name}}
                        </h5>
                        <ul class="list-inline list-separator small">
                           <li class="list-inline-item">4 Files</li>
                        </ul>
                     </div>
                     <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white" href="javascript:;"
                           data-hs-unfold-options='{
                           "target": "#action-extra-{{$key}}",
                           "type": "css-animation"
                           }'>
                        <span class="d-none d-sm-inline-block mr-1">More</span>
                        <i class="tio-chevron-down"></i>
                        </a>
                        <div id="action-extra-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right" style="min-width: 13rem;">
                           <a class="dropdown-item" href="#">
                           <i class="tio-share dropdown-item-icon"></i>
                           Share Folder
                           </a>
                           <a class="dropdown-item" href="{{baseUrl('documents/view-documents')}}">
                           <i class="tio-folder-add dropdown-item-icon"></i>
                           View Documents
                           </a>
                           

                           <a class="dropdown-item" href="javascript:;" onclick="showPopup('<?php echo baseUrl("documents/edit-folder/".base64_encode($document->id)) ?>')">
                           <i class="tio-edit dropdown-item-icon"></i>
                           Edit
                           </a>

                           <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('documents/delete-folder/'.base64_encode($document->id))}}">
                              <i class="tio-delete-outlined dropdown-item-icon"></i>
                              Delete
                           </a> 
                        </div>
                     </div>
                  </div>
                  <!-- End Row -->
               </li>
               @endforeach
            </ul>
         </div>
      </div>
    </div>
  </div>
  
  <!-- End Card -->
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