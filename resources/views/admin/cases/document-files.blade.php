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

   .chat-log {
      padding: 20px 14px;
      height: auto;
      overflow: auto;
   }

   .chat-log__item {
      background: #fafafa;
      padding: 10px;
      margin: 0 auto 10px;
      max-width: 80%;
      float: left;
      border-radius: 4px;
      box-shadow: 0 1px 2px rgba(0,0,0,.1);
      clear: both;
      font-size: 14px;
   }

   .chat-log__item.chat-log__item--own {
      float: right;
      background: #DCF8C6;
      text-align: right;
   }
   .chat-log__author {
      margin: 0 auto .5em;
      font-size: 12px;
      font-weight: bold;
   }

   textarea::-webkit-scrollbar {
      display: none;
      resize: none;
   }
   textarea{
      resize: none;
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
                  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li>
                  <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases/case-documents/documents/'.base64_encode($record->id)) }}">Documents</a></li>
                  <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
               </ol>
            </nav>
            <h1 class="page-header-title">{{$pageTitle}}</h1>
            <div clas="d-block">
               @if(!empty($service->Service($service->service_id)))
                <h4 class="text-primary p-2">{{$service->Service($service->service_id)->name}}</h4>
               @else
                <h4 class="text-primary p-2">Service not found</h4>
               @endif
            </div>
         </div>
         <div class="col-sm-auto">
            <div class="btn-group" role="group">
               <a class="btn btn-primary"  href="javascript:;" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="tio-upload-on-cloud mr-1"></i> Upload</a>
            </div>
         </div>
      </div>
      <div id="collapseOne" class="collapse" aria-labelledby="headingOne">
        <div class="card-body">
          <!-- Dropzone -->
            <div id="attachFilesLabel" class="js-dropzone dropzone-custom custom-file-boxed"
               data-hs-dropzone-options='{
                  "url": "<?php echo baseUrl('cases/case-documents/upload-documents/'.base64_encode($record->id)) ?>?_token=<?php echo csrf_token() ?>&folder_id=<?php echo $document->unique_id ?>&doc_type=<?php echo $doc_type ?>",
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
            <div class="col-12 col-md">
               <form>
                  <div class="input-group input-group-merge input-group-borderless">
                     <div class="input-group-prepend">
                        <div class="input-group-text">
                           <i class="tio-search"></i>
                        </div>
                     </div>
                     <input id="datatableSearch" type="search" class="form-control" placeholder="Search users" aria-label="Search users">
                  </div>
               </form>
            </div>
            <div class="col-auto">
               <div class="d-flex align-items-center">
                  <div id="datatableCounterInfo" class="mr-2" style="display: none;">
                     <div class="d-flex align-items-center">
                        <span class="font-size-sm mr-3">
                        <span id="datatableCounter">0</span>
                        Selected
                        </span>
                        <a class="btn btn-sm btn-outline-danger" data-href="{{ baseUrl('cases/case-documents/delete-multiple') }}" onclick="deleteMultiple(this)" href="javascript:;">
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
      <!-- Sidebar -->
      <div id="activitySidebar" class="hs-unfold-content sidebar sidebar-bordered sidebar-box-shadow">
         <div class="card card-lg sidebar-card sidebar-scrollbar">
            <div class="card-header">
               <h4 class="card-header-title">Sidebar title</h4>
               <!-- Toggle Button -->
               <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-ghost-dark ml-2" href="javascript:;"
                  data-hs-unfold-options='{
                  "target": "#activitySidebar",
                  "type": "css-animation",
                  "animationIn": "fadeInRight",
                  "animationOut": "fadeOutRight",
                  "hasOverlay": true,
                  "smartPositionOff": true
                  }'>
               <i class="tio-clear tio-lg"></i>
               </a>
               <!-- End Toggle Button -->
            </div>
            <!-- Body -->
            <div class="card-body sidebar-body">
               
               <div class="container" style="height:400px;overflow-y: scroll;">
                <div class="chat-log">
                  
                  <div class="chat-log__item">
                    <h3 class="chat-log__author">Felipe <small>14:30</small></h3>
                    <div class="chat-log__message">Yo man</div>
                  </div>

                  <div class="chat-log__item chat-log__item--own">
                    <h3 class="chat-log__author">Fabrício <small>14:30</small></h3>
                    <div class="chat-log__message">BRB</div>
                  </div>

                  <div class="chat-log__item chat-log__item--own">
                    <h3 class="chat-log__author">Fabrício <small>14:30</small></h3>
                    <div class="chat-log__message">Lorem ipsum Dolor Lorem ipsum Dolor Lorem ipsum Dolor Lorem ipsum Dolor Lorem ipsum Dolor</div>
                  </div>

                  <div class="chat-log__item">
                    <h3 class="chat-log__author">Felipe <small>14:30</small></h3>
                    <div class="chat-log__message">Lorem ipsum Dolor Lorem ipsum Dolor Lorem ipsum Dolor Lorem ipsum Dolor Lorem ipsum Dolor</div>
                  </div>


                </div>
              </div>
                  
            </div>
            <!-- End Body -->
            <li style="border:10px;padding:10px;list-style: none;">
                  
                  <form>
                    <div class="form form-inline">
                      <div class="col-12">
                        <!--<input type="text" name="message" class="form-control" style="">-->
                        <textarea class="form-control" rows=2 style="border:1px solid #377dff !important;padding: 1px 12px;border-radius:34px;"></textarea>



                        <button type="button" class="btn btn-primary btn-md" style="background:#377dff;border-radius: 50%;margin-left: 10px;border:0;"><i class="tio-send"></i></button>
                        <button id="yourBtn" type="button" class="btn btn-primary btn-md" style="background:#00c9db;border-radius: 50%;margin-left: 10px;border:0;cursor:pointer;"><i class="tio-attachment" onclick="getFile()"></i></button>
                        <!--<input type="file" id="myFile" name="filename" class="custom-file-input" style="background:#377dff;border-radius: 50%;margin-left: 10px;" value="">-->
<script>
function getFile(){
     document.getElementById("upfile").click();
}
</script>
                         <!--<div id="yourBtn" style="height: 50px; width: 100px;border: 1px dashed #BBB; cursor:pointer;" >Click to upload!</div>-->
                          
                          <!-- this is your file input tag, so i hide it!-->
                          <div style='height: 0px;width:0px; overflow:hidden;'><input id="upfile" type="file" value="upload"/></div>
                          <!-- here you can have file submit button or you can write a simple script to upload the file automatically-->

                      </div>
                      <!--<div class="col-4">
                        <button class="btn btn-primary btn-md" style="background:#377dff;border-radius: 60%;">P</button>
                      </div>-->
                    </div>
                  </form>

               </li>
         </div>
      </div>
      <!-- End Sidebar -->  
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
                  <!-- <th scope="col">Folder</th> -->
                  <th scope="col"><i class="tio-chat-outlined"></i></th>
                  <th scope="col">Members</th>
                  <th scope="col"></th>
               </tr>
            </thead>
            <tbody>
               @foreach($case_documents as $key => $doc)
               <tr>
                  <td class="table-column-pr-0">
                     <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input row-checkbox" id="row-{{$key}}" value="{{ base64_encode($doc->id) }}">
                        <label class="custom-control-label" for="row-{{$key}}"></label>
                     </div>
                  </td>
                  <td class="table-column-pl-0">
                     <a class="d-flex align-items-center" href="javascript:;">
                        <?php 
                           $fileicon = fileIcon($doc->FileDetail->original_name);
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
                  <!-- <td><a class="badge badge-soft-primary p-2" href="#">Marketing team</a></td> -->
                  <td width="10%">
                     <!-- Toggle -->
                     <div class="hs-unfold">
                        <a class="js-hs-unfold-invoker text-body" href="javascript:;"
                           data-hs-unfold-options='{
                           "target": "#activitySidebar",
                           "type": "css-animation",
                           "animationIn": "fadeInRight",
                           "animationOut": "fadeOutRight",
                           "hasOverlay": true,
                           "smartPositionOff": true
                           }'>
                        <i class="tio-chat-outlined"></i> 21
                        </a>
                     </div>
                     <!-- End Toggle -->
                       
                  </td>
                  <td>
                     <div class="avatar-group avatar-group-xs avatar-circle">
                        <span class="avatar" data-toggle="tooltip" data-placement="top" title="Ella Lauda">
                        <img class="avatar-img" src="./assets/img/160x160/img9.jpg" alt="Image Description">
                        </span>
                        <span class="avatar" data-toggle="tooltip" data-placement="top" title="David Harrison">
                        <img class="avatar-img" src="./assets/img/160x160/img3.jpg" alt="Image Description">
                        </span>
                        <span class="avatar avatar-soft-dark" data-toggle="tooltip" data-placement="top" title="Antony Taylor">
                        <span class="avatar-initials">A</span>
                        </span>
                        <span class="avatar avatar-soft-info" data-toggle="tooltip" data-placement="top" title="Sara Iwens">
                        <span class="avatar-initials">S</span>
                        </span>
                        <span class="avatar" data-toggle="tooltip" data-placement="top" title="Finch Hoot">
                        <img class="avatar-img" src="./assets/img/160x160/img5.jpg" alt="Image Description">
                        </span>
                        <span class="avatar avatar-light avatar-circle" data-toggle="tooltip" data-placement="top" title="Sam Kart, Amanda Harvey and 1 more">
                        <span class="avatar-initials">+3</span>
                        </span>
                     </div>
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
                           <span class="dropdown-header">Settings</span>
                           <a class="dropdown-item" href="#">
                           <i class="tio-share dropdown-item-icon"></i>
                           Share file
                           </a>
                           <a class="dropdown-item" href="javascript:;" onclick="showPopup('<?php echo baseUrl('cases/case-documents/file-move-to/'.base64_encode($doc->id)).'/'.base64_encode($record->id).'/'.base64_encode($document->id) ?>')">
                           <i class="tio-folder-add dropdown-item-icon"></i>
                           Move to
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-star-outlined dropdown-item-icon"></i>
                           Add to stared
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-edit dropdown-item-icon"></i>
                           Rename
                           </a>
                           <a class="dropdown-item" href="#">
                           <i class="tio-download-to dropdown-item-icon"></i>
                           Download
                           </a>
                           <div class="dropdown-divider"></div>
                           <a class="dropdown-item" href="#">
                           <i class="tio-chat-outlined dropdown-item-icon"></i>
                           Report
                           </a>
                           <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('cases/case-documents/delete/'.base64_encode($doc->id))}}">
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

         @if(count($case_documents) <= 0)
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
   var is_error = false;
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