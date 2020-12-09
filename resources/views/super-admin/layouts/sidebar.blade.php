  <aside class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered  ">
        <div class="navbar-vertical-container">
          <div class="navbar-vertical-footer-offset">
            <div class="navbar-brand-wrapper justify-content-between">
              <!-- Logo -->
                <a class="navbar-brand" href="./index.html" aria-label="Front">
                  <img class="navbar-brand-logo" src="assets/svg/logos/logo.svg" alt="Logo">
                  <img class="navbar-brand-logo-mini" src="assets/svg/logos/logo-short.svg" alt="Logo">
                </a>
              <!-- End Logo -->

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

                <li class="nav-item">
                  <small class="nav-subtitle" title="Accounts">Accounts</small>
                  <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>
                <li class="navbar-vertical-aside-has-menu ">
                  <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ baseUrl('/user') }}">
                    <i class="tio-user-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">User</span>
                  </a>
                </li>
                <!-- Accounts -->
                <li class="navbar-vertical-aside-has-menu ">
                  <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ baseUrl('/professionals') }}">
                    <i class="tio-pages-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Professionals</span>
                  </a>
                </li>
                <!-- End Pages -->

                <!-- Apps -->
                <li class="navbar-vertical-aside-has-menu ">
                  <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle " href="javascript:;">
                    <i class="tio-settings nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Settings <span class="badge badge-info badge-pill ml-1">Modules</span></span>
                  </a>

                  <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                    <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('document-folder') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Document Folder</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('visa-services') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Visa Services</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('licence-bodies') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Licence Bodies</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('languages') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Languages</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="{{ baseUrl('privileges') }}">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Professional Privileges</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!-- End Apps -->
              </ul>
            </div>
            <!-- End Content -->

          </div>
        </div>
      </aside>