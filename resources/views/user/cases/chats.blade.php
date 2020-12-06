@extends('layouts.master')
@section('style')
<style>
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
<div class="content container-fluid">
  <!-- Page Header -->
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
    </div>
    <!-- End Row -->
  </div>
  <!-- End Page Header -->
  <div class="card purple lighten-4 chat-room">
      <div class="card-body">
        <div class="row">
            <div class="col-lg-4">
              <!-- Navbar -->
              <div class="navbar-vertical navbar-expand-lg">
                <!-- Navbar Toggle -->
                <button type="button" class="navbar-toggler btn btn-block btn-white mb-3" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarVerticalNavMenu" data-toggle="collapse" data-target="#navbarVerticalNavMenu">
                  <span class="d-flex justify-content-between align-items-center">
                    <span class="h5 mb-0">Nav menu</span>

                    <span class="navbar-toggle-default">
                      <i class="tio-menu-hamburger"></i>
                    </span>

                    <span class="navbar-toggle-toggled">
                      <i class="tio-clear"></i>
                    </span>
                  </span>
                </button>
                <!-- End Navbar Toggle -->

                <!-- Navbar Collapse -->
                <div id="navbarVerticalNavMenu" class="collapse navbar-collapse">
                  <ul id="navbarSettings" class="js-sticky-block js-scrollspy navbar-nav navbar-nav-lg nav-tabs card card-navbar-nav"
                      data-hs-sticky-block-options='{
                       "parentSelector": "#navbarVerticalNavMenu",
                       "targetSelector": "#header",
                       "breakpoint": "lg",
                       "startPoint": "#navbarVerticalNavMenu",
                       "endPoint": "#stickyBlockEndPoint",
                       "stickyOffsetTop": 20
                     }'>
                    <li class="nav-item">
                      <a class="nav-link active" href="#basicInfo">
                        <i class="tio-user-outlined nav-icon"></i>
                        Basic information
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#emailSection">
                        <i class="tio-online nav-icon"></i>
                        Email
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#passwordSection">
                        <i class="tio-lock-outlined nav-icon"></i>
                        Password
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#preferencesSection">
                        <i class="tio-settings-outlined nav-icon"></i>
                        Preferences
                      </a>
                    </li>
                  </ul>
                </div>
                <!-- End Navbar Collapse -->
              </div>
              <!-- End Navbar -->
            </div>
            <div class="col-lg-8">
             <div class="chat-message">
                <ul class="list-unstyled chat">
                  <li class="d-flex justify-content-between mb-4">
                    <span class="avatar avatar-sm avatar-circle">
                       <img class="avatar-img" src="{{ userProfile() }}" alt="Image Description">
                    </span>
                    <div class="chat-body white p-3 ml-2 z-depth-1">
                      <div class="header">
                        <strong class="primary-font">Brad Pitt</strong>
                        <small class="pull-right text-muted"><i class="far fa-clock"></i> 12 mins ago</small>
                      </div>
                      <hr class="w-100">
                      <p class="mb-0">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.
                      </p>
                    </div>
                  </li>
                  <li class="d-flex justify-content-between mb-4">
                    <div class="chat-body white p-3 z-depth-1">
                      <div class="header">
                        <strong class="primary-font">Lara Croft</strong>
                        <small class="pull-right text-muted"><i class="far fa-clock"></i> 13 mins ago</small>
                      </div>
                      <hr class="w-100">
                      <p class="mb-0">
                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                        laudantium.
                      </p>
                    </div>
                    <span class="avatar avatar-sm avatar-circle">
                       <img class="avatar-img" src="{{ userProfile() }}" alt="Image Description">
                    </span>
                  </li>
                  <li class="d-flex justify-content-between mb-4 pb-3">
                    <span class="avatar avatar-sm avatar-circle">
                       <img class="avatar-img" src="{{ userProfile() }}" alt="Image Description">
                    </span>
                    <div class="chat-body white p-3 ml-2 z-depth-1">
                      <div class="header">
                        <strong class="primary-font">Brad Pitt</strong>
                        <small class="pull-right text-muted"><i class="far fa-clock"></i> 12 mins ago</small>
                      </div>
                      <hr class="w-100">
                      <p class="mb-0">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.
                      </p>
                    </div>
                  </li>
                  <li class="white">
                    <form class="form">  
                      <div class="row">
                        <div class="col-7 col-md-9">
                          <div class="message_input_wrapper">
                              <input class="form-control msg_textbox" id="message_input" placeholder="Type your message here..." />
                              <input type="file" name="chat_file" id="chat-attachment" style="display:none" />
                           </div>
                        </div>

                        <div class="col-5 col-md-3">
                         <div class="btn-group send-btn">
                            <button type="button" class="btn btn-primary btn-pill send-message">
                              <i class="tio-send"></i>
                            </button>
                            <button type="button" class="btn btn-info btn-pill send-attachment">
                              <i class="tio-attachment"></i>
                            </button>
                         </div>
                       </div>
                     </div>
                     <div style='height: 0px;width:0px; overflow:hidden;'><input id="upfile" type="file" value="upload"/></div>
                    </form>
                  </li>
                </ul>
             </div>
              <!-- Sticky Block End Point -->
              <div id="stickyBlockEndPoint"></div>
            </div>
        </div>
      </div>
  </div>
</div>
<!-- End Content -->
@endsection

@section('javascript')
<script src="assets/vendor/hs-scrollspy/dist/hs-scrollspy.min.js"></script>
<script src="assets/vendor/hs-sticky-block/dist/hs-sticky-block.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('.js-sticky-block').each(function () {
      var stickyBlock = new HSStickyBlock($(this)).init();
  });

    // initialization of scroll nav
  var scrollspy = new HSScrollspy($('body'), {
    // !SETTING "resolve" PARAMETER AND RETURNING "resolve('completed')" IS REQUIRED
    beforeScroll: function(resolve) {
      if (window.innerWidth < 992) {
        $('#navbarVerticalNavMenu').collapse('hide').on('hidden.bs.collapse', function () {
          return resolve('completed');
        });
      } else {
        return resolve('completed');
      }
    }
  }).init();
});
</script>
@endsection