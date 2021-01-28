@extends('layouts.master')

@section('content')
<div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
          <div class="row align-items-center">
            <div class="col-sm mb-2 mb-sm-0">
              <h1 class="page-header-title">All Notifications</h1>
            </div>
          </div>
        </div>
        <!-- End Page Header -->

        <!-- Stats -->
        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
          <!-- Header -->
          <div class="card-header">
            <!-- <h5 class="card-header-title">Activity stream</h5> -->
            <!-- Nav -->
              <ul class="nav nav-tabs" id="notificationTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="chatNotification-tab" data-toggle="tab" href="#chatNotification" role="tab" aria-controls="chatNotification" aria-selected="true">Messages</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="otherNotification-tab" data-toggle="tab" href="#otherNotification" role="tab" aria-controls="otherNotification" aria-selected="false">Other</a>
                </li>
              </ul>
            <!-- End Nav -->
          </div>
          <!-- End Header -->

          <!-- Body -->
          <div class="card-body card-body-height" style="height: 30rem;">
            <!-- Step -->
            <div class="tab-content" id="notificationTabContent">
              <div class="tab-pane fade show active" id="chatNotification" role="tabpanel" aria-labelledby="chatNotification-tab">
                <ul class="step step-icon-xs">
               
                  <!-- End Step Item -->
                  @foreach($chat_notifications as $notification)
                  <!-- Step Item -->
                  <li class="step-item">
                    <div class="step-content-wrapper">
                      <span class="step-icon step-icon-pseudo step-icon-soft-dark"></span>

                      <div class="step-content">
                        <h5 class="mb-1">
                          @if($notification->url != '')
                          <a class="text-dark" href="{{url('/view-notification/'.base64_encode($notification->id))}}">{{$notification->title}}</a>
                          @else
                          <a class="text-dark" href="javascript:;">{{$notification->title}}</a>
                          @endif
                        </h5>
                        <p>
                          {{$notification->comment}}
                        </p>
                        @if(empty($notification->Read))
                        <p class="font-size-sm mb-1 text-danger">
                          Unread
                        </p>
                        @endif
                        <small class="text-muted text-uppercase">{{ dateFormat($notification->created_at) }}</small>
                      </div>
                    </div>
                  </li>
                  <!-- End Step Item -->
                  @endforeach

                </ul>
              </div>
              <div class="tab-pane fade" id="otherNotification" role="tabpanel" aria-labelledby="otherNotification-tab">
                <ul class="step step-icon-xs">
                  
                  <!-- End Step Item -->
                  @foreach($other_notifications as $notification)
                  <!-- Step Item -->
                  <li class="step-item">
                    <div class="step-content-wrapper">
                      <span class="step-icon step-icon-pseudo step-icon-soft-dark"></span>

                      <div class="step-content">
                        <h5 class="mb-1">
                          @if($notification->url != '')
                          <a class="text-dark" href="{{url('/view-notification/'.base64_encode($notification->id))}}">{{$notification->title}}</a>
                          @else
                          <a class="text-dark" href="javascript:;">{{$notification->title}}</a>
                          @endif
                        </h5>
                        <p>
                          {{$notification->comment}}
                        </p>
                        @if(empty($notification->Read))
                        <p class="font-size-sm mb-1 text-danger">
                          Unread
                        </p>
                        @endif
                        <small class="text-muted text-uppercase">{{ dateFormat($notification->created_at) }}</small>
                      </div>
                    </div>
                  </li>
                  <!-- End Step Item -->
                  @endforeach
                </ul>
              </div>
            </div>
            <!-- End Step -->
          </div>
          <!-- End Body -->

          <!-- Footer -->
          <!-- <div class="card-footer">
            <a class="btn btn-sm btn-ghost-secondary" data-toggle="collapse" href="#collapseActivitySection" role="button" aria-expanded="false" aria-controls="collapseActivitySection">
              <span class="btn-toggle-default">
                <i class="tio-chevron-down mr-1"></i> View more
              </span>
              <span class="btn-toggle-toggled">
                <i class="tio-chevron-up mr-1"></i> View less
              </span>
            </a>
          </div> -->
          <!-- End Footer -->
        </div>
        <!-- End Card -->
      </div>
@endsection
