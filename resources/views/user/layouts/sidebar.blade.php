  <aside class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="navbar-vertical-container">
          <div class="navbar-vertical-footer-offset">
            <div class="navbar-brand-wrapper justify-content-between">
              <!-- Logo -->
                <a class="navbar-brand" href="./index.html" aria-label="Front">
                  <img class="navbar-brand-logo" src="assets/svg/logos/logo.svg" alt="Logo">
                  <img class="navbar-brand-logo-mini" src="assets/svg/logos/logo-short.svg" alt="Logo">
                </a>

              <!-- Navbar Vertical Toggle -->
              <button type="button" class="js-navbar-vertical-aside-toggle-invoker navbar-vertical-aside-toggle btn btn-icon btn-xs btn-ghost-dark">
                <i class="tio-clear tio-lg"></i>
              </button>
              <!-- End Navbar Vertical Toggle -->
            </div>

            <!-- Content -->
            <div class="navbar-vertical-content">
              <ul class="navbar-nav navbar-nav-lg nav-tabs">
                <!-- Dashboards -->
                <li class="navbar-vertical-aside-has-menu show">
                  <a class="js-navbar-vertical-aside-menu-link nav-link active" href="{{ baseUrl('/') }}">
                    <i class="tio-home-vs-1-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Dashboards</span>
                  </a>
                </li>
                <!-- End Dashboards -->
                <!-- Personal -->
                <li class="nav-item">
                  <small class="nav-subtitle" title="Personal">Personal Links</small>
                  <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>
                
                <li class="nav-item ">
                  <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/documents') }}" data-placement="left">
                    <i class="tio-documents nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">My Documents</span>
                  </a>
                </li>

                <!-- End Personal -->

                <!-- Professionals -->
                <li class="nav-item">
                  <small class="nav-subtitle" title="Professionals">Professionals</small>
                  <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/assessments') }}" data-placement="left">
                    <i class="tio-comment-text-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Assessments</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/cases') }}" data-placement="left">
                    <i class="tio-account-square nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Cases With Professionals</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="js-nav-tooltip-link nav-link" href="{{ baseUrl('/chat-groups') }}" data-placement="left">
                    <i class="tio-book-opened nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Chat Groups</span>
                  </a>
                </li>
                <li class="navbar-vertical-aside-has-menu ">
                  <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle " href="javascript:;">
                    <i class="tio-apps nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Settings</span>
                  </a>

                  <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                    <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('/connect-apps') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Connect Apps</span>
                      </a>
                    </li>
                  </ul>
                </li>

              </ul>
            </div>
            <!-- End Content -->
          </div>
        </div>
      </aside>