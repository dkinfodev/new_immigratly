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
<!-- Content -->
<div class="content container-fluid">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row align-items-end mb-3">
         <div class="col-sm mb-2 mb-sm-0">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb breadcrumb-no-gutter">
                  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
                  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/documents') }}">Documents</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
               </ol>
            </nav>
            <h1 class="page-header-title">{{$pageTitle}}</h1>
         </div>
         <div class="col-sm-auto">
            <div role="group">
               @if($user_detail->google_drive_auth != '')
               <a class="btn btn-outline-primary" onclick="showPopup('<?php echo baseUrl('documents/google-drive/folder/'.$document->unique_id) ?>')"  href="javascript:;"><i class="tio-google-drive mr-1"></i> Upload from Google Drive</a>
               @endif
               <a class="btn btn-primary"  href="javascript:;" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="tio-upload-on-cloud mr-1"></i> Upload</a>
            </div>
         </div>
      </div>
      <div id="collapseOne" class="collapse" aria-labelledby="headingOne">
        <div class="card-body">
          <!-- Dropzone -->
            <div id="attachFilesLabel" class="js-dropzone dropzone-custom custom-file-boxed"
               data-hs-dropzone-options='{
                  "url": "<?php echo baseUrl('documents/files/upload-documents') ?>?_token=<?php echo csrf_token() ?>&folder_id=<?php echo $document->unique_id ?>",
                  "thumbnailWidth": 100,
                  "thumbnailHeight": 100
               }'
            >
               <div class="dz-message custom-file-boxed-label">
                  <img class="avatar avatar-xl avatar-4by3 mb-3" src="./assets/svg/illustrations/browse.svg" alt="Image Description">
                  <h5 class="mb-1">Drag and drop your file here</h5>
                  <p class="mb-2">or</p>
                  <span class="btn btn-sm btn-white">Browse files</span>
               </div>
            </div>
            <!-- End Dropzone -->
        </div>
      </div>
      <!-- End Row -->
      <!-- Nav -->
      <!-- Nav -->
      <div class="js-nav-scroller hs-nav-scroller-horizontal">
         <span class="hs-nav-scroller-arrow-prev" style="display: none;">
         <a class="hs-nav-scroller-arrow-link" href="javascript:;">
         <i class="tio-chevron-left"></i>
         </a>
         </span>
         <span class="hs-nav-scroller-arrow-next" style="display: none;">
         <a class="hs-nav-scroller-arrow-link" href="javascript:;">
         <i class="tio-chevron-right"></i>
         </a>
         </span>
      </div>
      <!-- End Nav -->
   </div>
   <!-- End Page Header -->
   <!-- Card -->
   <div class="card">
      <!-- Header -->
      <div class="card-header">
         <div class="row justify-content-between align-items-center flex-grow-1">
            
            <div class="col-auto">
               <div class="d-flex align-items-center">
                  <div id="datatableCounterInfo" class="mr-2" style="display: none;">
                     <div class="d-flex align-items-center">
                        <span class="font-size-sm mr-3">
                        <span id="datatableCounter">0</span>
                        Selected
                        </span>
                        <a class="btn btn-sm btn-outline-danger" data-href="{{ baseUrl('documents/files/delete-multiple') }}" onclick="deleteMultiple(this)" href="javascript:;">
                        <i class="tio-delete-outlined"></i> Delete
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- End Header -->
      <!-- Table -->

      <div class="table-responsive datatable-custom">
         <table id="datatable" class="table table-borderless table-thead-bordered card-table">
            <thead class="thead-light">
               <tr>
                  <th scope="col" class="table-column-pr-0">
                     <div class="custom-control custom-checkbox">
                        <input id="datatableCheckAll" type="checkbox" class="custom-control-input">
                        <label class="custom-control-label" for="datatableCheckAll"></label>
                     </div>
                  </th>
                  <th scope="col" class="table-column-pl-0">Document Name</th>
                  <th scope="col"></th>
               </tr>
            </thead>
            <tbody>
               @foreach($user_documents as $key => $doc)
               <tr>
                  <td class="table-column-pr-0">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input row-checkbox" id="row-{{$key}}" value="{{ base64_encode($doc->id) }}">
                        <label class="custom-control-label" for="row-{{$key}}"></label>
                     </div>
                  </td>
                  <td class="table-column-pl-0">
                     <?php
                        $fileicon = fileIcon($doc->FileDetail->original_name);
                        $doc_url = $file_url."/".$doc->FileDetail->file_name;
                        $url = baseUrl('documents/files/view-document/'.$doc->unique_id.'?url='.$doc_url.'&file_name='.$doc->FileDetail->file_name.'&folder_id='.$document->unique_id);
                     ?>
                     <a class="d-flex align-items-center" href="{{$url}}">
                        <?php 
                           
                           echo $fileicon;
                           $filesize = file_size($file_dir."/".$doc->FileDetail->file_name);
                        ?>
                        <div class="ml-3">
                           <span class="d-block h5 text-hover-primary mb-0">{{$doc->FileDetail->original_name}}</span>
                           <ul class="list-inline list-separator small file-specs">
                              <li class="list-inline-item">Added on {{dateFormat($doc->created_at)}}</li>
                              <li class="list-inline-item">{{$filesize}}</li>
                           </ul>
                        </div>
                     </a>
                  </td>
                  
                  <td>
                     <!-- Unfold -->
                     <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white" href="javascript:;"
                           data-hs-unfold-options='{
                           "target": "#action-{{$key}}",
                           "type": "css-animation"
                           }'>
                        <span class="d-none d-sm-inline-block mr-1">More</span>
                        <i class="tio-chevron-down"></i>
                        </a>
                        <div id="action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right" style="min-width: 13rem;">
                          
                           <!-- <a class="dropdown-item" href="#">
                           <i class="tio-share dropdown-item-icon"></i>
                           Share file
                           </a> -->
                           <a class="dropdown-item" href="javascript:;" onclick="showPopup('<?php echo baseUrl('documents/files/file-move-to/'.$doc->unique_id) ?>')">
                           <i class="tio-folder-add dropdown-item-icon"></i>
                           Move to
                           </a>
                           <!-- <a class="dropdown-item" href="#">
                           <i class="tio-download-to dropdown-item-icon"></i>
                           Download
                           </a> -->
                           <div class="dropdown-divider"></div>
                           <!-- <a class="dropdown-item" href="#">
                           <i class="tio-chat-outlined dropdown-item-icon"></i>
                           Report
                           </a> -->
                           <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('documents/files/delete/'.base64_encode($doc->id))}}">
                           <i class="tio-delete-outlined dropdown-item-icon"></i>
                           Delete
                           </a>
                        </div>
                     </div>
                     <!-- End Unfold -->
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>

         @if(count($user_documents) <= 0)
         <div class="text-danger text-center p-2">
            No documents available
         </div>
         @endif
      </div>
      <!-- End Table -->
   </div>
   <!-- End Card -->
</div>
<!-- End Content -->
<!-- End Content -->
@endsection
@section('javascript')
<script src="assets/vendor/dropzone/dist/min/dropzone.min.js"></script>
<script type="text/javascript">
   $(document).ready(function(){
      $('.js-hs-action').each(function () {
       var unfold = new HSUnfold($(this)).init();
      });
      $(".row-checkbox").change(function(){
         if($(".row-checkbox:checked").length > 0){
            $("#datatableCounterInfo").show();
         }else{
            $("#datatableCounterInfo").hide();
         }
         $("#datatableCounter").html($(".row-checkbox:checked").length);
      });
   });
   var is_error = false;
   $('.dropzone-custom').each(function () {
      var dropzone = $.HSCore.components.HSDropzone.init('#' + $(this).attr('id'));
      dropzone.on("success", function(file,response) {
        if(response.status == false){
            is_error = true;
         }
      });
      dropzone.on("queuecomplete", function() {
         if(is_error == true){
            errorMessage("Error while upload file");
         }else{
            location.reload();
         }
      });
   });      

   function deleteFiles(){
      if($(".row-checkbox:checked").length > 0){
         var files = [];
         $(".row-checkbox:checked").each(function(){
            files.push($(this).val());
         })
         $.ajax({
           type: "POST",
           url: BASEURL + '/cases/remove-documents',
           data:{
               _token:csrf_token,
               files:files,
           },
           dataType:'json',
           beforeSend:function(){
               showLoader();
           },
           success: function (data) {
               if(data.status == true){
                  location.reload();
               }else{
                  errorMessage('Error while pin the folder');
               }
           },
           error:function(){
             internalError();
           }
         });
      }else{
         errorMessage("No files selected");
      }
   }
</script>
@endsection