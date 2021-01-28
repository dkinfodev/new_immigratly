

<!-- ========== HEADER ========== -->

<header id="header" class="navbar navbar-expand-lg navbar-fixed navbar-height navbar-flush navbar-container navbar-bordered">
<div class="navbar-nav-wrap">
<div class="navbar-brand-wrapper">
<!-- Logo -->
<a class="navbar-brand" href="{{baseUrl('/')}}" aria-label="Front">
  <img class="navbar-brand-logo" src="assets/svg/logos/logo.svg" alt="Logo">
  <img class="navbar-brand-logo-mini" src="assets/svg/logos/logo-short.svg" alt="Logo">
</a>
<!-- End Logo -->
</div>

<div class="navbar-nav-wrap-content-left">
<!-- Navbar Vertical Toggle -->
<button type="button" class="js-navbar-vertical-aside-toggle-invoker close mr-3">
  <i class="tio-first-page navbar-vertical-aside-toggle-short-align" data-toggle="tooltip" data-placement="right" title="Collapse"></i>
  <i class="tio-last-page navbar-vertical-aside-toggle-full-align" data-template='<div class="tooltip d-none d-sm-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>' data-toggle="tooltip" data-placement="right" title="Expand"></i>
</button>
<!-- End Navbar Vertical Toggle -->

</div>

<!-- Secondary Content -->
<div class="navbar-nav-wrap-content-right">
<!-- Navbar -->
<ul class="navbar-nav align-items-center flex-row">
  

  <li class="nav-item d-none d-sm-inline-block">
    <!-- Notification -->
    <div class="hs-unfold">
      <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle" href="javascript:;"
         data-hs-unfold-options='{
           "target": "#notificationDropdown",
           "type": "css-animation"
         }'>
        <i class="tio-notifications-on-outlined"></i>
        <span class="btn-status btn-sm-status btn-status-danger"></span>
      </a>

      <div id="notificationDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu" style="width: 25rem;">
        <!-- Header -->
        <div class="card-header">
          <span class="card-title h4">Notifications</span>

          <!-- Unfold -->
          <div class="hs-unfold">
            <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
               data-hs-unfold-options='{
                 "target": "#notificationSettingsOneDropdown",
                 "type": "css-animation"
               }'>
              <i class="tio-more-vertical"></i>
            </a>
            <div id="notificationSettingsOneDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right">
              <span class="dropdown-header">Settings</span>
              <a class="dropdown-item" href="#">
                <i class="tio-archive dropdown-item-icon"></i>
                Archive all
              </a>
              <a class="dropdown-item" href="#">
                <i class="tio-all-done dropdown-item-icon"></i>
                Mark all as read
              </a>
              <a class="dropdown-item" href="#">
                <i class="tio-toggle-off dropdown-item-icon"></i>
                Disable notifications
              </a>
              <a class="dropdown-item" href="#">
                <i class="tio-gift dropdown-item-icon"></i>
                What's new?
              </a>
              <div class="dropdown-divider"></div>
              <span class="dropdown-header">Feedback</span>
              <a class="dropdown-item" href="#">
                <i class="tio-chat-outlined dropdown-item-icon"></i>
                Report
              </a>
            </div>
          </div>
          <!-- End Unfold -->
        </div>
        <!-- End Header -->

        <!-- Nav -->
        <ul class="nav nav-tabs nav-justified" id="notificationTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="notificationNavOne-tab" data-toggle="tab" href="#notificationNavOne" role="tab" aria-controls="notificationNavOne" aria-selected="true">Messages (3)</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="notificationNavTwo-tab" data-toggle="tab" href="#notificationNavTwo" role="tab" aria-controls="notificationNavTwo" aria-selected="false">Archived</a>
          </li>
        </ul>
        <!-- End Nav -->

        <!-- Body -->
        <div class="card-body-height">
          <!-- Tab Content -->
          <div class="tab-content" id="notificationTabContent">
            <div class="tab-pane fade show active" id="notificationNavOne" role="tabpanel" aria-labelledby="notificationNavOne-tab">
              <ul class="list-group list-group-flush navbar-card-list-group">
                <!-- Item -->
                <li class="list-group-item custom-checkbox-list-wrapper">
                  <div class="row">
                    <div class="col-auto position-static">
                      <div class="d-flex align-items-center">
                        <div class="custom-control custom-checkbox custom-checkbox-list">
                          <input type="checkbox" class="custom-control-input" id="notificationCheck1" checked>
                          <label class="custom-control-label" for="notificationCheck1"></label>
                          <span class="custom-checkbox-list-stretched-bg"></span>
                        </div>
                        <div class="avatar avatar-sm avatar-circle">
                          <img class="avatar-img" src="assets/img/160x160/img3.jpg" alt="Image Description">
                        </div>
                      </div>
                    </div>
                    <div class="col ml-n3">
                      <span class="card-title h5">Brian Warner</span>
                      <p class="card-text font-size-sm">changed an issue from "In Progress" to <span class="badge badge-success">Review</span></p>
                    </div>
                    <small class="col-auto text-muted text-cap">2hr</small>
                  </div>
                  <a class="stretched-link" href="#"></a>
                </li>
                <!-- End Item -->

                <!-- Item -->
                <li class="list-group-item custom-checkbox-list-wrapper">
                  <div class="row">
                    <div class="col-auto position-static">
                      <div class="d-flex align-items-center">
                        <div class="custom-control custom-checkbox custom-checkbox-list">
                          <input type="checkbox" class="custom-control-input" id="notificationCheck2" checked>
                          <label class="custom-control-label" for="notificationCheck2"></label>
                          <span class="custom-checkbox-list-stretched-bg"></span>
                        </div>
                        <div class="avatar avatar-sm avatar-soft-dark avatar-circle">
                          <span class="avatar-initials">K</span>
                        </div>
                      </div>
                    </div>
                    <div class="col ml-n3">
                      <span class="card-title h5">Klara Hampton</span>
                      <p class="card-text font-size-sm">mentioned you in a comment</p>
                      <blockquote class="blockquote blockquote-sm">
                        Nice work, love! You really nailed it. Keep it up!
                      </blockquote>
                    </div>
                    <small class="col-auto text-muted text-cap">10hr</small>
                  </div>
                  <a class="stretched-link" href="#"></a>
                </li>
                <!-- End Item -->

                <!-- Item -->
                <li class="list-group-item custom-checkbox-list-wrapper">
                  <div class="row">
                    <div class="col-auto position-static">
                      <div class="d-flex align-items-center">
                        <div class="custom-control custom-checkbox custom-checkbox-list">
                          <input type="checkbox" class="custom-control-input" id="notificationCheck4" checked>
                          <label class="custom-control-label" for="notificationCheck4"></label>
                          <span class="custom-checkbox-list-stretched-bg"></span>
                        </div>
                        <div class="avatar avatar-sm avatar-circle">
                          <img class="avatar-img" src="assets/img/160x160/img10.jpg" alt="Image Description">
                        </div>
                      </div>
                    </div>
                    <div class="col ml-n3">
                      <span class="card-title h5">Ruby Walter</span>
                      <p class="card-text font-size-sm">joined the Slack group HS Team</p>
                    </div>
                    <small class="col-auto text-muted text-cap">3dy</small>
                  </div>
                  <a class="stretched-link" href="#"></a>
                </li>
                <!-- End Item -->

                <!-- Item -->
                <li class="list-group-item custom-checkbox-list-wrapper">
                  <div class="row">
                    <div class="col-auto position-static">
                      <div class="d-flex align-items-center">
                        <div class="custom-control custom-checkbox custom-checkbox-list">
                          <input type="checkbox" class="custom-control-input" id="notificationCheck3">
                          <label class="custom-control-label" for="notificationCheck3"></label>
                          <span class="custom-checkbox-list-stretched-bg"></span>
                        </div>
                        <div class="avatar avatar-sm avatar-circle">
                          <img class="avatar-img" src="assets/svg/brands/google.svg" alt="Image Description">
                        </div>
                      </div>
                    </div>
                    <div class="col ml-n3">
                      <span class="card-title h5">from Google</span>
                      <p class="card-text font-size-sm">Start using forms to capture the information of prospects visiting your Google website</p>
                    </div>
                    <small class="col-auto text-muted text-cap">17dy</small>
                  </div>
                  <a class="stretched-link" href="#"></a>
                </li>
                <!-- End Item -->

                <!-- Item -->
                <li class="list-group-item custom-checkbox-list-wrapper">
                  <div class="row">
                    <div class="col-auto position-static">
                      <div class="d-flex align-items-center">
                        <div class="custom-control custom-checkbox custom-checkbox-list">
                          <input type="checkbox" class="custom-control-input" id="notificationCheck5">
                          <label class="custom-control-label" for="notificationCheck5"></label>
                          <span class="custom-checkbox-list-stretched-bg"></span>
                        </div>
                        <div class="avatar avatar-sm avatar-circle">
                          <img class="avatar-img" src="assets/img/160x160/img7.jpg" alt="Image Description">
                        </div>
                      </div>
                    </div>
                    <div class="col ml-n3">
                      <span class="card-title h5">Sara Villar</span>
                      <p class="card-text font-size-sm">completed <i class="tio-folder-bookmarked text-primary"></i> FD-7 task</p>
                    </div>
                    <small class="col-auto text-muted text-cap">2mn</small>
                  </div>
                  <a class="stretched-link" href="#"></a>
                </li>
                <!-- End Item -->
              </ul>
            </div>

            <div class="tab-pane fade" id="notificationNavTwo" role="tabpanel" aria-labelledby="notificationNavTwo-tab">
              <ul class="list-group list-group-flush navbar-card-list-group">
                <!-- Item -->
                <li class="list-group-item custom-checkbox-list-wrapper">
                  <div class="row">
                    <div class="col-auto position-static">
                      <div class="d-flex align-items-center">
                        <div class="custom-control custom-checkbox custom-checkbox-list">
                          <input type="checkbox" class="custom-control-input" id="notificationCheck7">
                          <label class="custom-control-label" for="notificationCheck7"></label>
                          <span class="custom-checkbox-list-stretched-bg"></span>
                        </div>
                        <div class="avatar avatar-sm avatar-soft-dark avatar-circle">
                          <span class="avatar-initials">A</span>
                        </div>
                      </div>
                    </div>
                    <div class="col ml-n3">
                      <span class="card-title h5">Anne Richard</span>
                      <p class="card-text font-size-sm">accepted your invitation to join Notion</p>
                    </div>
                    <small class="col-auto text-muted text-cap">1dy</small>
                  </div>
                  <a class="stretched-link" href="#"></a>
                </li>
                <!-- End Item -->

                <!-- Item -->
                <li class="list-group-item custom-checkbox-list-wrapper">
                  <div class="row">
                    <div class="col-auto position-static">
                      <div class="d-flex align-items-center">
                        <div class="custom-control custom-checkbox custom-checkbox-list">
                          <input type="checkbox" class="custom-control-input" id="notificationCheck6">
                          <label class="custom-control-label" for="notificationCheck6"></label>
                          <span class="custom-checkbox-list-stretched-bg"></span>
                        </div>
                        <div class="avatar avatar-sm avatar-circle">
                          <img class="avatar-img" src="assets/img/160x160/img5.jpg" alt="Image Description">
                        </div>
                      </div>
                    </div>
                    <div class="col ml-n3">
                      <span class="card-title h5">Finch Hoot</span>
                      <p class="card-text font-size-sm">left Slack group HS projects</p>
                    </div>
                    <small class="col-auto text-muted text-cap">3dy</small>
                  </div>
                  <a class="stretched-link" href="#"></a>
                </li>
                <!-- End Item -->

                <!-- Item -->
                <li class="list-group-item custom-checkbox-list-wrapper">
                  <div class="row">
                    <div class="col-auto position-static">
                      <div class="d-flex align-items-center">
                        <div class="custom-control custom-checkbox custom-checkbox-list">
                          <input type="checkbox" class="custom-control-input" id="notificationCheck8">
                          <label class="custom-control-label" for="notificationCheck8"></label>
                          <span class="custom-checkbox-list-stretched-bg"></span>
                        </div>
                        <div class="avatar avatar-sm avatar-dark avatar-circle">
                          <span class="avatar-initials">HS</span>
                        </div>
                      </div>
                    </div>
                    <div class="col ml-n3">
                      <span class="card-title h5">Htmlstream</span>
                      <p class="card-text font-size-sm">you earned a "Top endorsed" <i class="tio-verified text-primary"></i> badge</p>
                    </div>
                    <small class="col-auto text-muted text-cap">6dy</small>
                  </div>
                  <a class="stretched-link" href="#"></a>
                </li>
                <!-- End Item -->

                <!-- Item -->
                <li class="list-group-item custom-checkbox-list-wrapper">
                  <div class="row">
                    <div class="col-auto position-static">
                      <div class="d-flex align-items-center">
                        <div class="custom-control custom-checkbox custom-checkbox-list">
                          <input type="checkbox" class="custom-control-input" id="notificationCheck9">
                          <label class="custom-control-label" for="notificationCheck9"></label>
                          <span class="custom-checkbox-list-stretched-bg"></span>
                        </div>
                        <div class="avatar avatar-sm avatar-circle">
                          <img class="avatar-img" src="assets/img/160x160/img8.jpg" alt="Image Description">
                        </div>
                      </div>
                    </div>
                    <div class="col ml-n3">
                      <span class="card-title h5">Linda Bates</span>
                      <p class="card-text font-size-sm">Accepted your connection</p>
                    </div>
                    <small class="col-auto text-muted text-cap">17dy</small>
                  </div>
                  <a class="stretched-link" href="#"></a>
                </li>
                <!-- End Item -->

                <!-- Item -->
                <li class="list-group-item custom-checkbox-list-wrapper">
                  <div class="row">
                    <div class="col-auto position-static">
                      <div class="d-flex align-items-center">
                        <div class="custom-control custom-checkbox custom-checkbox-list">
                          <input type="checkbox" class="custom-control-input" id="notificationCheck10">
                          <label class="custom-control-label" for="notificationCheck10"></label>
                          <span class="custom-checkbox-list-stretched-bg"></span>
                        </div>
                        <div class="avatar avatar-sm avatar-soft-dark avatar-circle">
                          <span class="avatar-initials">L</span>
                        </div>
                      </div>
                    </div>
                    <div class="col ml-n3">
                      <span class="card-title h5">Lewis Clarke</span>
                      <p class="card-text font-size-sm">completed <i class="tio-folder-bookmarked text-primary"></i> FD-134 task</p>
                    </div>
                    <small class="col-auto text-muted text-cap">2mn</small>
                  </div>
                  <a class="stretched-link" href="#"></a>
                </li>
                <!-- End Item -->
              </ul>
            </div>
          </div>
          <!-- End Tab Content -->
        </div>
        <!-- End Body -->

        <!-- Card Footer -->
        <a class="card-footer text-center" href="#">
          View all notifications
          <i class="tio-chevron-right"></i>
        </a>
        <!-- End Card Footer -->
      </div>
    </div>
    <!-- End Notification -->
  </li>

  <li class="nav-item">
    <!-- Account -->
    <div class="hs-unfold">
      <a class="js-hs-unfold-invoker navbar-dropdown-account-wrapper" href="javascript:;"
         data-hs-unfold-options='{
           "target": "#accountNavbarDropdown",
           "type": "css-animation"
         }'>
        <div class="avatar avatar-sm avatar-circle">
          <img class="avatar-img" src="{{superAdminProfile()}}" alt="Image Description">
          <span class="avatar-status avatar-sm-status avatar-status-success"></span>
        </div>
      </a>

      <div id="accountNavbarDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right navbar-dropdown-menu navbar-dropdown-account" style="width: 16rem;">
        <div class="dropdown-item">
          <div class="media align-items-center">
            <div class="avatar avatar-sm avatar-circle mr-2">
              <img class="avatar-img" src="{{superAdminProfile('','t')}}" alt="Image Description">
            </div>
            <div class="media-body">
              <span class="card-title h5">{{ Auth::user()->first_name." ".Auth::user()->last_name }}</span>
              <span class="card-text">{{Auth::user()->email}}</span>
            </div>
          </div>
        </div>

        <div class="dropdown-divider"></div>


        <a class="dropdown-item" href="{{ baseUrl('/edit-profile') }}">
          <span class="text-truncate pr-2" title="Edit Profile">Edit Profile</span>
        </a>
        <a class="dropdown-item" href="{{ baseUrl('/change-password') }}">
          <span class="text-truncate pr-2" title="Change Password">Change Password</span>
        </a>
        <div class="dropdown-divider"></div>

        <a class="dropdown-item" href="{{ url('logout') }}">
          <span class="text-truncate pr-2 text-danger" title="Sign out">Sign out</span>
        </a>
      </div>
    </div>
    <!-- End Account -->
  </li>
</ul>
<!-- End Navbar -->
</div>
<!-- End Secondary Content -->
</div>
</header>