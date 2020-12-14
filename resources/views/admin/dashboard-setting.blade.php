@extends('layouts.master')

@section('content')

  <div class="content container-fluid">
          <div class="row justify-content-md-between">
      <div class="col-md-4">
        <!-- Logo -->
        <label class="custom-file-boxed custom-file-boxed-sm" for="logoUploader">
          @if($record->logo != '' &&  file_exists(professionalDir().'/profile/'.$user->profile_image))
            <img id="logoImg" class="avatar avatar-xl avatar-4by3 avatar-centered h-100 mb-2" src="{{ professionalDirUrl().'/profile/'.path }}" alt="Profile Image">
          @else
            <img id="logoImg" class="avatar avatar-xl avatar-4by3 avatar-centered h-100 mb-2" src="./assets/svg/illustrations/browse.svg" alt="Profile Image">
          @endif

          <span class="d-block">Upload your Image here</span>

          <input type="file" class="js-file-attach custom-file-boxed-input" name="logo" id="logoUploader"
          data-hs-file-attach-options='{
          "textTarget": "#logoImg",
          "mode": "image",
          "targetAttr": "src"
        }'>
      </label>
      <!-- End Logo -->
    </div>

  </div>
ajajjajaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa

@endsection
