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
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>
        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>
      <div class="col-sm-auto">
         <a onclick="showPopup('{{ baseUrl('cases/add-folder/'.base64_encode($service->id)) }}')" class="btn btn-primary" href="javascript:;">
         <i class="tio-folder-add mr-1"></i> Add folder
         </a>
      </div>
    </div>
  </div>
  <!-- Card -->
  <div class="card">
    <!-- Header -->
    <div class="card-body">
      <h2 class="h4 mb-3">Pinned access <i class="tio-help-outlined text-muted" data-toggle="tooltip" data-placement="right" title="Pinned access to files you've been working on."></i></h2>
      <!-- Pinned Access -->
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 mb-5">
         <div class="col mb-3 mb-lg-5">
            <!-- Card -->
            <div class="card card-sm card-hover-shadow card-header-borderless h-100 text-center pinned-folders">
               <div class="card-header">
                  <small>4 Files</small>
                  <!-- Checkbox -->
                  <div class="custom-control custom-checkbox-switch card-pinned">
                     <input type="checkbox" id="starredCheckbox45" class="custom-control-input custom-checkbox-switch-input" checked>
                     <label class="custom-checkbox-switch-label btn-icon btn-xs rounded-circle" for="starredCheckbox45">
                     <span class="custom-checkbox-switch-default" data-toggle="tooltip" data-placement="top" title="Pin">
                     <i class="tio-star-outlined"></i>
                     </span>
                     <span class="custom-checkbox-switch-active" data-toggle="tooltip" data-placement="top" title="Pinned">
                     <i class="tio-star"></i>
                     </span>
                     </label>
                  </div>
                  <!-- End Checkbox -->
                  <!-- Unfold -->
                  <div class="hs-unfold ml-auto">
                     <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary card-unfold rounded-circle" href="javascript:;"
                        data-hs-unfold-options='{
                        "target": "#filesGridDropdown12",
                        "type": "css-animation"
                        }'>
                     <i class="tio-more-vertical"></i>
                     </a>
                     <div id="filesGridDropdown12" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right" style="min-width: 13rem;">
                        <span class="dropdown-header">Settings</span>
                        <a class="dropdown-item" href="#">
                        <i class="tio-share dropdown-item-icon"></i>
                        Share file
                        </a>
                        <a class="dropdown-item" href="#">
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
                        <a class="dropdown-item" href="#">
                        <i class="tio-delete-outlined dropdown-item-icon"></i>
                        Delete
                        </a>
                     </div>
                  </div>
                  <!-- End Unfold -->
               </div>
               <div class="card-body">
                  <i class="tio-folder tio-xl text-body mr-2"></i>
                  <a class="stretched-link" href="#"></a>
               </div>
               <div class="card-body">
                  <h5 class="card-title">Business opportunities</h5>
                  <p class="small">Updated 2 months ago</p>
               </div>
            </div>
            <!-- End Card -->
         </div>
         <div class="col mb-3 mb-lg-5">
            <!-- Card -->
            <!-- Card -->
            <div class="card card-sm card-hover-shadow card-header-borderless h-100 text-center pinned-folders">
               <div class="card-header">
                  <small>4 Files</small>
                  <!-- Checkbox -->
                  <div class="custom-control custom-checkbox-switch card-pinned">
                     <input type="checkbox" id="starredCheckbox46" class="custom-control-input custom-checkbox-switch-input" checked>
                     <label class="custom-checkbox-switch-label btn-icon btn-xs rounded-circle" for="starredCheckbox46">
                     <span class="custom-checkbox-switch-default" data-toggle="tooltip" data-placement="top" title="Pin">
                     <i class="tio-star-outlined"></i>
                     </span>
                     <span class="custom-checkbox-switch-active" data-toggle="tooltip" data-placement="top" title="Pinned">
                     <i class="tio-star"></i>
                     </span>
                     </label>
                  </div>
                  <!-- End Checkbox -->
                  <!-- Unfold -->
                  <div class="hs-unfold ml-auto">
                     <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary card-unfold rounded-circle" href="javascript:;"
                        data-hs-unfold-options='{
                        "target": "#filesGridDropdown13",
                        "type": "css-animation"
                        }'>
                     <i class="tio-more-vertical"></i>
                     </a>
                     <div id="filesGridDropdown13" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right" style="min-width: 13rem;">
                        <span class="dropdown-header">Settings</span>
                        <a class="dropdown-item" href="#">
                        <i class="tio-share dropdown-item-icon"></i>
                        Share file
                        </a>
                        <a class="dropdown-item" href="#">
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
                        <a class="dropdown-item" href="#">
                        <i class="tio-delete-outlined dropdown-item-icon"></i>
                        Delete
                        </a>
                     </div>
                  </div>
                  <!-- End Unfold -->
               </div>
               <div class="card-body">
                  <i class="tio-folder tio-xl text-body mr-2"></i>
                  <a class="stretched-link" href="#"></a>
               </div>
               <div class="card-body">
                  <h5 class="card-title">Business opportunities</h5>
                  <p class="small">Updated 2 months ago</p>
               </div>
            </div>
            <!-- End Card -->
            <!-- End Card -->
         </div>
         <div class="col mb-3 mb-lg-5">
            <!-- Card -->
            <div class="card card-sm card-hover-shadow card-header-borderless h-100 text-center pinned-folders">
               <div class="card-header">
                  <small>4 Files</small>
                  <!-- Checkbox -->
                  <div class="custom-control custom-checkbox-switch card-pinned">
                     <input type="checkbox" id="starredCheckbox47" class="custom-control-input custom-checkbox-switch-input" checked>
                     <label class="custom-checkbox-switch-label btn-icon btn-xs rounded-circle" for="starredCheckbox47">
                     <span class="custom-checkbox-switch-default" data-toggle="tooltip" data-placement="top" title="Pin">
                     <i class="tio-star-outlined"></i>
                     </span>
                     <span class="custom-checkbox-switch-active" data-toggle="tooltip" data-placement="top" title="Pinned">
                     <i class="tio-star"></i>
                     </span>
                     </label>
                  </div>
                  <!-- End Checkbox -->
                  <!-- Unfold -->
                  <div class="hs-unfold ml-auto">
                     <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary card-unfold rounded-circle" href="javascript:;  "
                        data-hs-unfold-options='{
                        "target": "#filesGridDropdown14",
                        "type": "css-animation"
                        }'>
                     <i class="tio-more-vertical"></i>
                     </a>
                     <div id="filesGridDropdown14" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right" style="min-width: 13rem;">
                        <span class="dropdown-header">Settings</span>
                        <a class="dropdown-item" href="#">
                        <i class="tio-share dropdown-item-icon"></i>
                        Share file
                        </a>
                        <a class="dropdown-item" href="#">
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
                        <a class="dropdown-item" href="#">
                        <i class="tio-delete-outlined dropdown-item-icon"></i>
                        Delete
                        </a>
                     </div>
                  </div>
                  <!-- End Unfold -->
               </div>
               <div class="card-body">
                  <i class="tio-folder tio-xl text-body mr-2"></i>
                  <a class="stretched-link" href="#"></a>
               </div>
               <div class="card-body">
                  <h5 class="card-title">Business opportunities</h5>
                  <p class="small">Updated 2 months ago</p>
               </div>
            </div>
            <!-- End Card -->
         </div>
         <div class="col mb-3 mb-lg-5">
            <!-- Card -->
            <!-- Card -->
            <div class="card card-sm card-hover-shadow card-header-borderless h-100 text-center pinned-folders">
               <div class="card-header">
                  <small>4 Files</small>
                  <!-- Checkbox -->
                  <div class="custom-control custom-checkbox-switch card-pinned">
                     <input type="checkbox" id="starredCheckbox48" class="custom-control-input custom-checkbox-switch-input" checked>
                     <label class="custom-checkbox-switch-label btn-icon btn-xs rounded-circle" for="starredCheckbox48">
                     <span class="custom-checkbox-switch-default" data-toggle="tooltip" data-placement="top" title="Pin">
                     <i class="tio-star-outlined"></i>
                     </span>
                     <span class="custom-checkbox-switch-active" data-toggle="tooltip" data-placement="top" title="Pinned">
                     <i class="tio-star"></i>
                     </span>
                     </label>
                  </div>
                  <!-- End Checkbox -->
                  <!-- Unfold -->
                  <div class="hs-unfold ml-auto">
                     <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary card-unfold rounded-circle" href="javascript:;"
                        data-hs-unfold-options='{
                        "target": "#filesGridDropdown16",
                        "type": "css-animation"
                        }'>
                     <i class="tio-more-vertical"></i>
                     </a>
                     <div id="filesGridDropdown16" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right" style="min-width: 13rem;">
                        <span class="dropdown-header">Settings</span>
                        <a class="dropdown-item" href="#">
                        <i class="tio-share dropdown-item-icon"></i>
                        Share file
                        </a>
                        <a class="dropdown-item" href="#">
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
                        <a class="dropdown-item" href="#">
                        <i class="tio-delete-outlined dropdown-item-icon"></i>
                        Delete
                        </a>
                     </div>
                  </div>
                  <!-- End Unfold -->
               </div>
               <div class="card-body">
                  <i class="tio-folder tio-xl text-body mr-2"></i>
                  <a class="stretched-link" href="#"></a>
               </div>
               <div class="card-body">
                  <h5 class="card-title">Business opportunities</h5>
                  <p class="small">Updated 2 months ago</p>
               </div>
            </div>
            <!-- End Card -->
            <!-- End Card -->
         </div>
      </div>
      <!-- End Pinned Access -->
      <div class="row align-items-center mb-2">
         <div class="col">
            <h2 class="h4 mb-0">Default Folders</h2>
         </div>
      </div>
      <div class="tab-content" id="connectionsTabContent">
         <div class="tab-pane fade show active" id="list" role="tabpanel" aria-labelledby="list-tab">
            <ul class="list-group">
               <!-- List Item -->
               <?php
                $default_documents = $service->DefaultDocuments($service->service_id);
               
               ?>
               @foreach($default_documents as $key => $document)
               <li class="list-group-item">
                  <div class="row align-items-center gx-2">
                     <div class="col-auto">
                        <i class="tio-folder tio-xl text-body mr-2"></i>
                     </div>
                     <div class="col">
                        <h5 class="card-title text-truncate mr-2">{{$document->name}}</h5>
                     </div>
                     <div class="hs-unfold">
                        <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
                           data-hs-unfold-options='{
                             "target": "#action-default-{{$key}}",
                             "type": "css-animation"
                           }'>
                                More <i class="tio-chevron-down ml-1"></i>
                        </a>

                        <div id="action-default-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                          <a class="dropdown-item" href="<?php echo baseUrl("cases/documents-files/".base64_encode($document->id)) ?>">View Documents</a>
                          <!-- <div class="dropdown-divider"></div> -->
                          <!-- <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('services/delete-folder/'.base64_encode($document->id))}}">Delete</a> -->
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

  @if(count($documents) > 0)
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
              
               @foreach($documents as $key => $document)
               <li class="list-group-item">
                  <div class="row align-items-center gx-2">
                     <div class="col-auto">
                        <i class="tio-folder tio-xl text-body mr-2"></i>
                     </div>
                     <div class="col">
                        <h5 class="card-title text-truncate mr-2">{{$document->name}}</h5>
                     </div>
                     <div class="hs-unfold">
                        <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
                           data-hs-unfold-options='{
                             "target": "#action-{{$key}}",
                             "type": "css-animation"
                           }'>
                                More <i class="tio-chevron-down ml-1"></i>
                        </a>

                        <div id="action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                          <a class="dropdown-item" href="javascript:;" onclick="showPopup('<?php echo baseUrl("services/edit-folder/".base64_encode($document->id)) ?>')">Edit</a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('services/delete-folder/'.base64_encode($document->id))}}">Delete</a>
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
  @endif
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
})
</script>
@endsection