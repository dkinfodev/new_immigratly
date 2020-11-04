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
                  <a class="js-navbar-vertical-aside-menu-link nav-link active" href="{{ baseUrl('/') }}" title="Dashboards">
                    <i class="tio-home-vs-1-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Dashboards</span>
                  </a>
                </li>
                <!-- End Dashboards -->

                <li class="nav-item">
                  <small class="nav-subtitle" title="Accounts">Accounts</small>
                  <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>

                <!-- Accounts -->
                <li class="navbar-vertical-aside-has-menu ">
                  <a class="js-navbar-vertical-aside-menu-link nav-link" href="{{ baseUrl('/professionals') }}" title="Professionals">
                    <i class="tio-pages-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Professionals</span>
                  </a>
                </li>
                <!-- End Pages -->

                <!-- Apps -->
                <li class="navbar-vertical-aside-has-menu ">
                  <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle " href="javascript:;" title="Apps">
                    <i class="tio-apps nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Apps <span class="badge badge-info badge-pill ml-1">Hot</span></span>
                  </a>

                  <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                    <li class="nav-item">
                      <a class="nav-link " href="./apps-kanban.html" title="Kanban">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Kanban</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="./apps-invoice-generator.html" title="Invoice generator">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Invoice generator</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="./apps-file-manager.html" title="File manager">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">File manager</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!-- End Apps -->

                <!-- Authentication -->
                <li class="navbar-vertical-aside-has-menu ">
                  <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle " href="javascript:;" title="Authentication">
                    <i class="tio-lock-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Authentication</span>
                  </a>

                  <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                    <li class="navbar-vertical-aside-has-menu ">
                      <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:;" title="Sign in">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Sign in</span>
                      </a>

                      <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                        <li class="nav-item">
                          <a class="nav-link " href="./authentication-signin-basic.html" title="Basic">
                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                            <span class="text-truncate">Basic</span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link " href="./authentication-signin-cover.html" title="Cover">
                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                            <span class="text-truncate">Cover</span>
                          </a>
                        </li>
                      </ul>
                    </li>

                    <li class="navbar-vertical-aside-has-menu ">
                      <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:;" title="Sign up">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Sign up</span>
                      </a>

                      <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                        <li class="nav-item">
                          <a class="nav-link " href="./authentication-signup-basic.html" title="Basic">
                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                            <span class="text-truncate">Basic</span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link " href="./authentication-signup-cover.html" title="Cover">
                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                            <span class="text-truncate">Cover</span>
                          </a>
                        </li>
                      </ul>
                    </li>

                    <li class="navbar-vertical-aside-has-menu ">
                      <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:;" title="Reset password">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Reset password</span>
                      </a>

                      <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                        <li class="nav-item">
                          <a class="nav-link " href="./authentication-reset-password-basic.html" title="Basic">
                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                            <span class="text-truncate">Basic</span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link " href="./authentication-reset-password-cover.html" title="Cover">
                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                            <span class="text-truncate">Cover</span>
                          </a>
                        </li>
                      </ul>
                    </li>

                    <li class="navbar-vertical-aside-has-menu ">
                      <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:;" title="Email verification">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Email verification</span>
                      </a>

                      <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                        <li class="nav-item">
                          <a class="nav-link " href="./authentication-email-verification-basic.html" title="Basic">
                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                            <span class="text-truncate">Basic</span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link " href="./authentication-email-verification-cover.html" title="Cover">
                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                            <span class="text-truncate">Cover</span>
                          </a>
                        </li>
                      </ul>
                    </li>

                    <li class="navbar-vertical-aside-has-menu ">
                      <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle" href="javascript:;" title="2-step Verification">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">2-step Verification</span>
                      </a>

                      <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                        <li class="nav-item">
                          <a class="nav-link " href="./authentication-two-step-verification-basic.html" title="Basic">
                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                            <span class="text-truncate">Basic</span>
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link " href="./authentication-two-step-verification-cover.html" title="Cover">
                            <span class="tio-circle-outlined nav-indicator-icon"></span>
                            <span class="text-truncate">Cover</span>
                          </a>
                        </li>
                      </ul>
                    </li>

                    <li class="nav-item">
                      <a class="nav-link" href="javascript:;" data-toggle="modal" data-target="#welcomeMessageModal" title="Welcome message">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Welcome message</span>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a class="nav-link " href="./error-404.html" title="Error 404">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Error 404</span>
                      </a>
                    </li>

                    <li class="nav-item">
                      <a class="nav-link " href="./error-500.html" title="Error 500">
                        <span class="tio-circle nav-indicator-icon"></span>
                        <span class="text-truncate">Error 500</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!-- End Authentication -->

                <li class="nav-item ">
                  <a class="js-nav-tooltip-link nav-link " href="./welcome-page.html" title="Welcome page" data-placement="left">
                    <i class="tio-visible-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Welcome page</span>
                  </a>
                </li>

                <li class="nav-item">
                  <small class="nav-subtitle" title="Layouts">Layouts</small>
                  <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>

                <li class="nav-item ">
                  <a class="js-nav-tooltip-link nav-link " href="./layouts/layouts.html" title="Layouts" data-placement="left">
                    <i class="tio-dashboard-vs-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Layouts</span>
                  </a>
                </li>

                <li class="nav-item">
                  <div class="nav-divider"></div>
                </li>

                <li class="nav-item">
                  <small class="nav-subtitle" title="Documentation">Documentation</small>
                  <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>

                <li class="nav-item ">
                  <a class="js-nav-tooltip-link nav-link" href="./documentation/index.html" title="Documentation" data-placement="left">
                    <i class="tio-book-opened nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Documentation <span class="badge badge-primary badge-pill ml-1">v1.0</span></span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="js-nav-tooltip-link nav-link" href="./documentation/typography.html" title="Components" data-placement="left">
                    <i class="tio-layers-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Components</span>
                  </a>
                </li>

                <li class="nav-item">
                  <small class="tio-more-horizontal nav-subtitle-replacer"></small>
                </li>

                <!-- Front Builder -->
                <li class="nav-item nav-footer-item ">
                  <a class="d-none d-md-flex js-hs-unfold-invoker nav-link nav-link-toggle" href="javascript:;"
                     data-hs-unfold-options='{
                       "target": "#styleSwitcherDropdown",
                       "type": "css-animation",
                       "animationIn": "fadeInRight",
                       "animationOut": "fadeOutRight",
                       "hasOverlay": true,
                       "smartPositionOff": true
                     }'>
                    <i class="tio-tune nav-icon"></i>
                  </a>
                  <a class="d-flex d-md-none nav-link nav-link-toggle" href="javascript:;">
                    <i class="tio-tune nav-icon"></i>
                  </a>
                </li>
                <!-- End Front Builder -->

                <!-- Help -->
                <li class="navbar-vertical-aside-has-menu nav-footer-item ">
                  <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle " href="javascript:;" title="Help">
                    <i class="tio-home-vs-1-outlined nav-icon"></i>
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Help</span>
                  </a>

                  <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                    <li class="nav-item">
                      <a class="nav-link" href="#" title="Resources &amp; tutorials">
                        <i class="tio-book-outlined dropdown-item-icon"></i> Resources &amp; tutorials
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#" title="Keyboard shortcuts">
                        <i class="tio-command-key dropdown-item-icon"></i> Keyboard shortcuts
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#" title="Connect other apps">
                        <i class="tio-alt dropdown-item-icon"></i> Connect other apps
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#" title="What's new?">
                        <i class="tio-gift dropdown-item-icon"></i> What's new?
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#" title="Contact support">
                        <i class="tio-chat-outlined dropdown-item-icon"></i> Contact support
                      </a>
                    </li>
                  </ul>
                </li>
                <!-- End Help -->

                <!-- Language -->
                <li class="navbar-vertical-aside-has-menu nav-footer-item ">
                  <a class="js-navbar-vertical-aside-menu-link nav-link nav-link-toggle " href="javascript:;" title="Language">
                    <img class="avatar avatar-xss avatar-circle" src="assets/vendor/flag-icon-css/flags/1x1/us.svg" alt="United States Flag">
                    <span class="navbar-vertical-aside-mini-mode-hidden-elements text-truncate">Language</span>
                  </a>

                  <ul class="js-navbar-vertical-aside-submenu nav nav-sub">
                    <li class="nav-item">
                      <a class="nav-link" href="#" title="English (US)">
                        <img class="avatar avatar-xss avatar-circle mr-2" src="assets/vendor/flag-icon-css/flags/1x1/us.svg" alt="Flag">
                        English (US)
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#" title="English (UK)">
                        <img class="avatar avatar-xss avatar-circle mr-2" src="assets/vendor/flag-icon-css/flags/1x1/gb.svg" alt="Flag">
                        English (UK)
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#" title="Deutsch">
                        <img class="avatar avatar-xss avatar-circle mr-2" src="assets/vendor/flag-icon-css/flags/1x1/de.svg" alt="Flag">
                        Deutsch
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#" title="Dansk">
                        <img class="avatar avatar-xss avatar-circle mr-2" src="assets/vendor/flag-icon-css/flags/1x1/dk.svg" alt="Flag">
                        Dansk
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#" title="Italiano">
                        <img class="avatar avatar-xss avatar-circle mr-2" src="assets/vendor/flag-icon-css/flags/1x1/it.svg" alt="Flag">
                        Italiano
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#" title="中文 (繁體)">
                        <img class="avatar avatar-xss avatar-circle mr-2" src="assets/vendor/flag-icon-css/flags/1x1/cn.svg" alt="Flag">
                        中文 (繁體)
                      </a>
                    </li>
                  </ul>
                </li>
                <!-- End Language -->
              </ul>
            </div>
            <!-- End Content -->

            <!-- Footer -->
            <div class="navbar-vertical-footer">
              <ul class="navbar-vertical-footer-list">
                <li class="navbar-vertical-footer-list-item">
                  <!-- Unfold -->
                  <div class="hs-unfold">
                    <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle" href="javascript:;"
                       data-hs-unfold-options='{
                        "target": "#styleSwitcherDropdown",
                        "type": "css-animation",
                        "animationIn": "fadeInRight",
                        "animationOut": "fadeOutRight",
                        "hasOverlay": true,
                        "smartPositionOff": true
                       }'>
                      <i class="tio-tune"></i>
                    </a>
                  </div>
                  <!-- End Unfold -->
                </li>

                <li class="navbar-vertical-footer-list-item">
                  <!-- Other Links -->
                  <div class="hs-unfold">
                    <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle" href="javascript:;"
                       data-hs-unfold-options='{
                        "target": "#otherLinksDropdown",
                        "type": "css-animation",
                        "animationIn": "slideInDown",
                        "hideOnScroll": true
                       }'>
                      <i class="tio-help-outlined"></i>
                    </a>

                    <div id="otherLinksDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu navbar-vertical-footer-dropdown">
                      <span class="dropdown-header">Help</span>
                      <a class="dropdown-item" href="#">
                        <i class="tio-book-outlined dropdown-item-icon"></i>
                        <span class="text-truncate pr-2" title="Resources &amp; tutorials">Resources &amp; tutorials</span>
                      </a>
                      <a class="dropdown-item" href="#">
                        <i class="tio-command-key dropdown-item-icon"></i>
                        <span class="text-truncate pr-2" title="Keyboard shortcuts">Keyboard shortcuts</span>
                      </a>
                      <a class="dropdown-item" href="#">
                        <i class="tio-alt dropdown-item-icon"></i>
                        <span class="text-truncate pr-2" title="Connect other apps">Connect other apps</span>
                      </a>
                      <a class="dropdown-item" href="#">
                        <i class="tio-gift dropdown-item-icon"></i>
                        <span class="text-truncate pr-2" title="What's new?">What's new?</span>
                      </a>
                      <div class="dropdown-divider"></div>
                      <span class="dropdown-header">Contacts</span>
                      <a class="dropdown-item" href="#">
                        <i class="tio-chat-outlined dropdown-item-icon"></i>
                        <span class="text-truncate pr-2" title="Contact support">Contact support</span>
                      </a>
                    </div>
                  </div>
                  <!-- End Other Links -->
                </li>

                <li class="navbar-vertical-footer-list-item">
                  <!-- Language -->
                  <div class="hs-unfold">
                    <a class="js-hs-unfold-invoker btn btn-icon btn-ghost-secondary rounded-circle" href="javascript:;"
                       data-hs-unfold-options='{
                        "target": "#languageDropdown",
                        "type": "css-animation",
                        "animationIn": "slideInDown",
                        "hideOnScroll": true
                       }'>
                      <img class="avatar avatar-xss avatar-circle" src="assets/vendor/flag-icon-css/flags/1x1/us.svg" alt="United States Flag">
                    </a>

                    <div id="languageDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu navbar-vertical-footer-dropdown">
                      <span class="dropdown-header">Select language</span>
                      <a class="dropdown-item" href="#">
                        <img class="avatar avatar-xss avatar-circle mr-2" src="assets/vendor/flag-icon-css/flags/1x1/us.svg" alt="Flag">
                        <span class="text-truncate pr-2" title="English">English (US)</span>
                      </a>
                      <a class="dropdown-item" href="#">
                        <img class="avatar avatar-xss avatar-circle mr-2" src="assets/vendor/flag-icon-css/flags/1x1/gb.svg" alt="Flag">
                        <span class="text-truncate pr-2" title="English">English (UK)</span>
                      </a>
                      <a class="dropdown-item" href="#">
                        <img class="avatar avatar-xss avatar-circle mr-2" src="assets/vendor/flag-icon-css/flags/1x1/de.svg" alt="Flag">
                        <span class="text-truncate pr-2" title="Deutsch">Deutsch</span>
                      </a>
                      <a class="dropdown-item" href="#">
                        <img class="avatar avatar-xss avatar-circle mr-2" src="assets/vendor/flag-icon-css/flags/1x1/dk.svg" alt="Flag">
                        <span class="text-truncate pr-2" title="Dansk">Dansk</span>
                      </a>
                      <a class="dropdown-item" href="#">
                        <img class="avatar avatar-xss avatar-circle mr-2" src="assets/vendor/flag-icon-css/flags/1x1/it.svg" alt="Flag">
                        <span class="text-truncate pr-2" title="Italiano">Italiano</span>
                      </a>
                      <a class="dropdown-item" href="#">
                        <img class="avatar avatar-xss avatar-circle mr-2" src="assets/vendor/flag-icon-css/flags/1x1/cn.svg" alt="Flag">
                        <span class="text-truncate pr-2" title="中文 (繁體)">中文 (繁體)</span>
                      </a>
                    </div>
                  </div>
                  <!-- End Language -->
                </li>
              </ul>
            </div>
            <!-- End Footer -->
          </div>
        </div>
      </aside>