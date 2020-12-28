@extends('layouts.master')

@section('content')

<div class="row mr-10">
 <div class="col-1"></div>
 <div class="col-10">
<!-- Card -->
                <div class="card">
                  <!-- Header -->
                  <div class="card-header">
                    <h5 class="card-header-title">Activity stream</h5>

                    <!-- Unfold -->
                    <div class="hs-unfold">
                      <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                         data-hs-unfold-options='{
                           "target": "#contentActivityStreamDropdown",
                           "type": "css-animation"
                         }'>
                        <i class="tio-more-vertical"></i>
                      </a>

                      <div id="contentActivityStreamDropdown" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-right mt-1">
                        <span class="dropdown-header">Settings</span>

                        <a class="dropdown-item" href="#">
                          <i class="tio-share dropdown-item-icon"></i>
                          Share connections
                        </a>
                        <a class="dropdown-item" href="#">
                          <i class="tio-info-outined dropdown-item-icon"></i>
                          Suggest edits
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

                  <!-- Body -->
                  <div class="card-body card-body-height" style="height: 30rem;">
                    <!-- Step -->
                    <ul class="step step-icon-xs">
                      <!-- Step Item -->
                      <li class="step-item">
                        <div class="step-content-wrapper">
                          <span class="step-icon step-icon-pseudo step-icon-soft-dark"></span>

                          <div class="step-content">
                            <h5 class="mb-1">
                              <a class="text-dark" href="#">Task report - uploaded weekly reports</a>
                            </h5>

                            <p class="font-size-sm mb-1">Added 3 files to task <a class="text-uppercase" href="#"><i class="tio-folder-bookmarked"></i> Fd-7</a></p>

                            <ul class="list-group">
                              <!-- List Item -->
                              <li class="list-group-item list-group-item-light">
                                <div class="row gx-1">
                                  <div class="col">
                                    <div class="media">
                                      <span class="mt-1 mr-2">
                                        <img class="avatar avatar-xs" src="./assets/svg/brands/excel.svg" alt="Image Description">
                                      </span>
                                      <div class="media-body text-truncate">
                                        <span class="d-block font-size-sm text-dark text-truncate" title="weekly-reports.xls">weekly-reports.xls</span>
                                        <small class="d-block text-muted">12kb</small>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col">
                                    <div class="media">
                                      <span class="mt-1 mr-2">
                                        <img class="avatar avatar-xs" src="./assets/svg/brands/word.svg" alt="Image Description">
                                      </span>
                                      <div class="media-body text-truncate">
                                        <span class="d-block font-size-sm text-dark text-truncate" title="weekly-reports.xls">weekly-reports.xls</span>
                                        <small class="d-block text-muted">4kb</small>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col">
                                    <div class="media">
                                      <span class="mt-1 mr-2">
                                        <img class="avatar avatar-xs" src="./assets/svg/brands/word.svg" alt="Image Description">
                                      </span>
                                      <div class="media-body text-truncate">
                                        <span class="d-block font-size-sm text-dark text-truncate" title="monthly-reports.xls">monthly-reports.xls</span>
                                        <small class="d-block text-muted">8kb</small>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </li>
                              <!-- End List Item -->
                            </ul>

                            <small class="text-muted text-uppercase">Now</small>
                          </div>
                        </div>
                      </li>
                      <!-- End Step Item -->

                      <!-- Step Item -->
                      <li class="step-item">
                        <div class="step-content-wrapper">
                          <span class="step-icon step-icon-pseudo step-icon-soft-dark"></span>

                          <div class="step-content">
                            <h5 class="mb-1">
                              <a class="text-dark" href="#">Project status updated</a>
                            </h5>

                            <p class="font-size-sm mb-1">Marked <a class="text-uppercase" href="#"><i class="tio-folder-bookmarked"></i> Fr-6</a> as <span class="badge badge-soft-success badge-pill"><span class="legend-indicator bg-success"></span>"Completed"</span></p>

                            <small class="text-muted text-uppercase">Today</small>
                          </div>
                        </div>
                      </li>
                      <!-- End Step Item -->

                      <!-- Step Item -->
                      <li class="step-item">
                        <div class="step-content-wrapper">
                          <span class="step-icon step-icon-pseudo step-icon-soft-dark"></span>

                          <div class="step-content">
                            <h5 class="mb-1">
                              <a class="text-dark" href="#">New card styles added</a>
                            </h5>

                            <p class="font-size-sm mb-1">Added 5 card to <a href="#">Payments</a></p>

                            <ul class="list-group">
                              <!-- List Item -->
                              <li class="list-group-item list-group-item-light">
                                <div class="row gx-1">
                                  <div class="col">
                                    <img class="img-fluid rounded ie-card-img" src="./assets/svg/illustrations/card-1.svg" alt="Image Description">
                                  </div>
                                  <div class="col">
                                    <img class="img-fluid rounded ie-card-img" src="./assets/svg/illustrations/card-2.svg" alt="Image Description">
                                  </div>
                                  <div class="col">
                                    <img class="img-fluid rounded ie-card-img" src="./assets/svg/illustrations/card-3.svg" alt="Image Description">
                                  </div>
                                  <div class="col">
                                    <img class="img-fluid rounded ie-card-img" src="./assets/svg/illustrations/card-4.svg" alt="Image Description">
                                  </div>
                                  <div class="col">
                                    <img class="img-fluid rounded ie-card-img" src="./assets/svg/illustrations/card-5.svg" alt="Image Description">
                                  </div>
                                  <div class="col-auto align-self-center">
                                    <div class="text-center">
                                      <a href="#">+2</a>
                                    </div>
                                  </div>
                                </div>
                              </li>
                              <!-- List Item -->
                            </ul>

                            <small class="text-muted text-uppercase">May 12</small>
                          </div>
                        </div>
                      </li>
                      <!-- End Step Item -->

                      <!-- Step Item -->
                      <li class="step-item">
                        <div class="step-content-wrapper">
                          <span class="step-icon step-icon-pseudo step-icon-soft-dark"></span>

                          <div class="step-content">
                            <h5 class="mb-1">
                              <a class="text-dark" href="#">Dean added a new team member</a>
                            </h5>

                            <p class="font-size-sm mb-1">Added a new member to Front Dashboard</p>

                            <small class="text-muted text-uppercase">May 15</small>
                          </div>
                        </div>
                      </li>
                      <!-- End Step Item -->

                      <!-- Step Item -->
                      <li class="step-item">
                        <div class="step-content-wrapper">
                          <span class="step-icon step-icon-pseudo step-icon-soft-dark"></span>

                          <div class="step-content">
                            <h5 class="mb-1">
                              <a class="text-dark" href="#">Project status updated</a>
                            </h5>

                            <p class="font-size-sm mb-1">Marked <a class="text-uppercase" href="#"><i class="tio-folder-bookmarked"></i> Fr-3</a> as <span class="badge badge-soft-primary badge-pill"><span class="legend-indicator bg-primary"></span>"In progress"</span></p>

                            <small class="text-muted text-uppercase">Apr 29</small>
                          </div>
                        </div>
                      </li>
                      <!-- End Step Item -->

                      <!-- Step Item -->
                      <li class="step-item">
                        <div class="step-content-wrapper">
                          <span class="step-icon step-icon-pseudo step-icon-soft-dark"></span>

                          <div class="step-content">
                            <h5 class="mb-1">
                              <a class="text-dark" href="#">Achievements</a>
                            </h5>

                            <p class="font-size-sm mb-1">Earned a "Top endorsed" <i class="tio-verified text-primary"></i> badge</p>

                            <small class="text-muted text-uppercase">Apr 06</small>
                          </div>
                        </div>
                      </li>
                      <!-- End Step Item -->

                      <!-- Step Item -->
                      <li id="collapseActivitySection" class="step-item collapse">
                        <div class="step-content-wrapper">
                          <span class="step-icon step-icon-pseudo step-icon-soft-dark"></span>

                          <div class="step-content">
                            <h5 class="mb-1">
                              <a class="text-dark" href="#">Project status updated</a>
                            </h5>

                            <p class="font-size-sm mb-1">Updated <a class="text-uppercase" href="#"><i class="tio-folder-bookmarked"></i> Fr-3</a> as <span class="badge badge-soft-secondary badge-pill"><span class="legend-indicator bg-secondary"></span>"To do"</span></p>

                            <small class="text-muted text-uppercase">Feb 10</small>
                          </div>
                        </div>
                      </li>
                      <!-- End Step Item -->
                    </ul>
                    <!-- End Step -->
                  </div>
                  <!-- End Body -->

                  <!-- Footer -->
                  <div class="card-footer">
                    <a class="btn btn-sm btn-ghost-secondary" data-toggle="collapse" href="#collapseActivitySection" role="button" aria-expanded="false" aria-controls="collapseActivitySection">
                      <span class="btn-toggle-default">
                        <i class="tio-chevron-down mr-1"></i> View more
                      </span>
                      <span class="btn-toggle-toggled">
                        <i class="tio-chevron-up mr-1"></i> View less
                      </span>
                    </a>
                  </div>
                  <!-- End Footer -->
                </div>
                <!-- End Card -->
            </div>    
        </div>
@endsection