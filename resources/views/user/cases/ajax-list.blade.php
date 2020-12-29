<?php /*
 @foreach($records as $key => $record)
          <tr>
            <td class="table-column-pr-0">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input row-checkbox" value="{{ base64_encode($record->id) }}" id="row-{{$key}}">
                <label class="custom-control-label" for="row-{{$key}}"></label>
              </div>
            </td>
            <td class="table-column-pl-0">
              <a class="d-flex align-items-center" href="{{baseUrl('cases/edit/'.base64_encode($record->id))}}">
                @if(!empty($record->Client($record->client_id)))
                <?php
                $client = $record->Client($record->client_id);
                ?>
                <div class="avatar avatar-soft-primary mt-4 avatar-circle">
                  <span class="avatar-initials">{{userInitial($client)}}</span>
                </div>
                @else
                <div class="avatar avatar-soft-primary mt-4 avatar-circle">
                  <span class="avatar-initials">UN</span>
                </div>
                @endif
                <!-- <img class="avatar" src="assets/svg/brands/capsule.svg" alt="Image Description"> -->
                <div class="ml-3">
                  <span class="d-block h5 text-hover-primary mb-0">{{ $record->case_title }}</span>
                  <span class="d-block font-size-sm text-body">Created on {{ dateFormat($record->created_at) }}</span>
                </div>
              </a>
            </td>
            <td>
              @if(!empty($record->Client($record->client_id)))
              <?php
              $client = $record->Client($record->client_id);
              ?>
              <span class="text-primary h4">{{$client->first_name." ".$client->last_name}}</span>
              @else
              <span class="text-danger h4">Client not found</span>
              @endif
            </td>
            <td>
              @if(!empty($record->Service($record->VisaService->service_id)))
              <span class="badge badge-soft-info p-2">{{$record->Service($record->VisaService->service_id)->name}}</span>
              @else
              <span class="badge badge-soft-info p-2">Service not found</span>
              @endif
            </td>
            
             <td>
              <!-- Avatar Group -->
              <div class="avatar-group avatar-group-xs avatar-circle">
                <?php 
                  $more_file = 0;
                ?>
                @foreach($record->AssingedMember as $key => $member)
                  <?php 
                  if($key > 1){
                    $more_file++;
                  }else{
                  ?>  
                  <a class="avatar js-nav-tooltip-link" href="javascript:;" data-toggle="tooltip" data-placement="top" title="{{ $member->Member->first_name." ".$member->Member->last_name }}">
                    <img class="avatar-img" src="{{ professionalProfile($member->Member->unique_id,'t',$subdomain) }}" alt="Image Description">
                  </a>
                  <?php } ?>
                @endforeach
                @if($more_file > 0)
                  <span class="avatar avatar-light js-nav-tooltip-link avatar-circle" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ $member->first_name." ".$member->last_name }}">
                    <span class="avatar-initials">{{ $more_file }}+</span>
                  </span>
                @endif
              </div>
            </td>
            
            <td>
                <div class="hs-unfold">
                <a class="js-hs-action btn btn-sm btn-white" href="javascript:;"
                   data-hs-unfold-options='{
                     "target": "#action-{{$key}}",
                     "type": "css-animation"
                   }'>
                        More <i class="tio-chevron-down ml-1"></i>
                </a>
                <div id="action-{{$key}}" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="{{baseUrl('cases/edit/'.base64_encode($record->id))}}">
                   <i class="tio-edit dropdown-item-icon"></i>
                   Edit
                  </a>
                  <a class="dropdown-item" href="{{baseUrl('cases/case-documents/documents/'.base64_encode($record->id))}}">
                   <i class="tio-pages-outlined dropdown-item-icon"></i>
                   Case Documents
                  </a>
                  <a class="dropdown-item" href="{{baseUrl('cases/invoices/list/'.base64_encode($record->id))}}">
                   <i class="tio-dollar dropdown-item-icon"></i>
                   Invoices
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item text-danger" href="javascript:;" onclick="confirmAction(this)" data-href="{{baseUrl('cases/delete/'.base64_encode($record->id))}}">
                   <i class="tio-delete-outlined dropdown-item-icon"></i>
                   Delete
                  </a>
                </div>
              </div>
             </td>
          </tr>
          @endforeach
*/ ?>