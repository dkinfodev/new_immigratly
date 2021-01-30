@extends('layouts.master')

@section('content')
<div class="content container-fluid connect-apps">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-sm mb-2 mb-sm-0">
        <h1 class="page-header-title">Connect Apps</h1>
      </div>
    </div>
  </div>
  <!-- End Page Header -->
  <div class="row gx-2 gx-lg-3">
    <div class="col-md-4">
        <!-- Card -->
        <div class="card h-100" style="max-width: 20rem;">

          <!-- Body -->
          <div class="card-body text-center">
            <div class="app-icon">
              <i class="tio-google-drive"></i>
            </div>
            <h3 class="mb-1">
              <span class="text-dark">Google Drive</span>
            </h3>
            @if($user_detail->google_drive_auth != '')
              <?php
                $google_drive_auth = json_decode($user_detail->google_drive_auth,true);
                if(isset($google_drive_auth['user_email'])){
              ?>
            <div class="mb-3">
              <i class="tio-online mr-1"></i>
              <span>{{$google_drive_auth['user_email']}}</span>
            </div>
              <?php } ?>
            @endif
          </div>
          <!-- End Body -->

          <!-- Footer -->
          <div class="card-footer">
            @if($user_detail->google_drive_auth != '')
            <div class="row justify-content-between align-items-center">
              <div class="col-auto py-1">
                <a class="font-size-sm text-danger" href="{{ baseUrl('connect-apps/unlink/google') }}">Unlink Account</a>
              </div>

              <div class="col-auto py-1">
                <a href="javascript:;" type="button" class="btn btn-primary"><i class="tio-done mr-1"></i> Connected</a>
              </div>
            </div>
            @else
            <div class="row justify-content-between align-items-center">
              <div class="col-md-12 text-center">
                <a href="{{ baseUrl('/connect-apps/google-auth') }}" type="button" class="btn btn-outline-primary"><i class="tio-user-add mr-1"></i> Connect</a>
              </div>
            </div>
            @endif
          </div>
          <!-- End Footer -->
        </div>
        <!-- End Card -->
    </div>
    <div class="col-md-4">
        <!-- Card -->
        <div class="card h-100" style="max-width: 20rem;">

          <!-- Body -->
          <div class="card-body text-center">
            <div class="app-icon">
              <i class="tio-dropbox"></i>
            </div>
            <h3 class="mb-1">
              <span class="text-dark">Dropbox</span>
            </h3>
            @if($user_detail->dropbox_auth != '')
              <?php
                $dropbox_auth = json_decode($user_detail->dropbox_auth,true);
                if(isset($dropbox_auth['user_email'])){
              ?>
            <div class="mb-3">
              <i class="tio-online mr-1"></i>
              <span>{{$dropbox_auth['user_email']}}</span>
            </div>
              <?php } ?>
            @endif
          </div>
          <!-- End Body -->

          <!-- Footer -->
          <div class="card-footer">
            @if($user_detail->dropbox_auth != '')
            <div class="row justify-content-between align-items-center">
              <div class="col-auto py-1">
                <a class="font-size-sm text-danger" href="{{ baseUrl('connect-apps/unlink/dropbox') }}">Unlink Account</a>
              </div>

              <div class="col-auto py-1">
                <a href="javascript:;" type="button" class="btn btn-primary"><i class="tio-done mr-1"></i> Connected</a>
              </div>
            </div>
            @else
            <div class="row justify-content-between align-items-center">
              <div class="col-md-12 text-center">
                <a href="{{ baseUrl('/connect-apps/dropbox-auth') }}" type="button" class="btn btn-outline-primary"><i class="tio-user-add mr-1"></i> Connect</a>
              </div>
            </div>
            @endif
          </div>
          <!-- End Footer -->
        </div>
        <!-- End Card -->
    </div>
  </div>
</div>
@endsection
