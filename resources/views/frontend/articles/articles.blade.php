@extends('frontend.layouts.master')
  <!-- Hero Section -->
@section('style')

<link rel="stylesheet" href="assets/frontend/vendor/hs-mega-menu/dist/hs-mega-menu.min.css">
<link rel="stylesheet" href="assets/frontend/vendor/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="assets/frontend/vendor/slick-carousel/slick/slick.css">
<link rel="stylesheet" href="assets/frontend/vendor/dzsparallaxer/dzsparallaxer.css">

@endsection

@section('content')

  <!-- Search Section -->
<div class="bg-dark">
  <div class="bg-img-hero-center" style="background-image: url({{asset('assets/frontend/svg/components/abstract-shapes-19.svg')}});padding-top: 94px;">
    <div class="container space-1">
      <div class="w-lg-80 mx-lg-auto">
        
        <h2 class="h1 text-white">Read Our Latest Articles</h2>

      </div>
    </div>
  </div>
</div>
<!-- End Search Section -->


  <!-- Courses Section -->
    <div class="container space-2 space-top-lg-3 space-bottom-lg-3">
      <div class="row">
        <div class="col-lg-3 mb-5 mb-lg-0">
          <div class="navbar-expand-lg navbar-expand-lg-collapse-block">
            <!-- Responsive Toggle Button -->
            <button type="button" class="navbar-toggler btn btn-block border py-3"
                    aria-label="Toggle navigation"
                    aria-expanded="false"
                    aria-controls="sidebarNav"
                    data-toggle="collapse"
                    data-target="#sidebarNav">
              <span class="d-flex justify-content-between align-items-center">
                <span class="h5 mb-0">View all categories</span>
                <span class="navbar-toggler-default">
                  <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                    <path fill="currentColor" d="M17.4,6.2H0.6C0.3,6.2,0,5.9,0,5.5V4.1c0-0.4,0.3-0.7,0.6-0.7h16.9c0.3,0,0.6,0.3,0.6,0.7v1.4C18,5.9,17.7,6.2,17.4,6.2z M17.4,14.1H0.6c-0.3,0-0.6-0.3-0.6-0.7V12c0-0.4,0.3-0.7,0.6-0.7h16.9c0.3,0,0.6,0.3,0.6,0.7v1.4C18,13.7,17.7,14.1,17.4,14.1z"/>
                  </svg>
                </span>
                <span class="navbar-toggler-toggled">
                  <svg width="14" height="14" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
                    <path fill="currentColor" d="M11.5,9.5l5-5c0.2-0.2,0.2-0.6-0.1-0.9l-1-1c-0.3-0.3-0.7-0.3-0.9-0.1l-5,5l-5-5C4.3,2.3,3.9,2.4,3.6,2.6l-1,1 C2.4,3.9,2.3,4.3,2.5,4.5l5,5l-5,5c-0.2,0.2-0.2,0.6,0.1,0.9l1,1c0.3,0.3,0.7,0.3,0.9,0.1l5-5l5,5c0.2,0.2,0.6,0.2,0.9-0.1l1-1 c0.3-0.3,0.3-0.7,0.1-0.9L11.5,9.5z"/>
                  </svg>
                </span>
              </span>
            </button>
            <!-- End Responsive Toggle Button -->

            <div id="sidebarNav" class="collapse navbar-collapse">
              <div class="mt-5 mt-lg-0">
                <h2 class="h4"><a class="text-inherit" href="#">Artificial Intelligence</a></h2>

                <!-- Nav Link -->
                <a class="dropdown-item d-flex justify-content-between align-items-center px-0" href="#">
                  AI Product Manager
                  <span class="badge bg-soft-secondary badge-pill">30+</span>
                </a>
                <a class="dropdown-item d-flex justify-content-between align-items-center px-0" href="#">
                  AI Programming with Python
                </a>
                <a class="dropdown-item d-flex justify-content-between align-items-center px-0" href="#">
                  Computer Vision
                  <span class="badge badge-success badge-pill ml-1">New</span>
                </a>
                <a class="dropdown-item d-flex justify-content-between align-items-center px-0" href="#">
                  Deep Learning
                </a>
                <a class="dropdown-item d-flex justify-content-between align-items-center px-0" href="#">
                  Deep Reinforcement Learning
                  <span class="badge bg-soft-secondary badge-pill">18</span>
                </a>
                <!-- End Nav Link -->

                <!-- View More - Collapse -->
                <div class="collapse" id="collapseSectionOne">
                  <a class="dropdown-item d-flex justify-content-between align-items-center px-0" href="#">
                    Machine Learning
                  </a>
                  <a class="dropdown-item d-flex justify-content-between align-items-center px-0" href="#">
                    Natural Language Processing
                  </a>
                </div>
                <!-- End View More - Collapse -->

                <!-- Link -->
                <a class="link link-collapse small font-size-1 font-weight-bold pt-1" data-toggle="collapse" href="#collapseSectionOne" role="button" aria-expanded="false" aria-controls="collapseSectionOne">
                  <span class="link-collapse-default">View more</span>
                  <span class="link-collapse-active">View less</span>
                  <span class="link-icon ml-1">+</span>
                </a>
                <!-- End Link -->
              </div>

             
            </div>
          </div>
        </div>

        <div class="col-lg-9">
          <!-- Filter -->
          <div class="border-bottom pb-3 mb-5">
            <div class="row justify-content-md-start align-items-md-center">
              <div class="col-md-4 mb-3 mb-md-0">
                <p class="font-size-1 mr-md-auto mb-0"><span class="text-dark font-weight-bold">195 courses</span> to get started</p>
              </div>

              <div class="col-md-8 text-md-right" style="">
                <!-- Select -->
                <select class="js-custom-select custom-select-sm" size="1" style="opacity: 0;"
                      data-hs-select2-options='{
                        "minimumResultsForSearch": "Infinity",
                        "customClass": "custom-select custom-select-sm mb-1",
                        "dropdownAutoWidth": true,
                        "width": "auto"
                      }'>
                  <option value="sort1">Highest rated</option>
                  <option value="sort2">Newest</option>
                  <option value="sort3">Lowest price</option>
                  <option value="sort4">Highest price</option>
                </select>
                <!-- End Select -->

                <!-- Select -->
                <select class="js-custom-select custom-select-sm" size="1" style="opacity: 0;"
                      data-hs-select2-options='{
                        "minimumResultsForSearch": "Infinity",
                        "customClass": "custom-select custom-select-sm mb-1",
                        "placeholder": "Type",
                        "dropdownAutoWidth": true,
                        "width": "auto"
                      }'>
                  <option label="empty"></option>
                  <option value="price1" selected>Paid</option>
                  <option value="price2">Free</option>
                </select>
                <!-- End Select -->

                <!-- Select -->
                <select class="js-custom-select custom-select-sm" size="1" style="opacity: 0;"
                      data-hs-select2-options='{
                        "minimumResultsForSearch": "Infinity",
                        "customClass": "custom-select custom-select-sm mb-1",
                        "placeholder": "Duration",
                        "dropdownAutoWidth": true,
                        "width": "auto"
                      }'>
                  <option label="empty"></option>
                  <option value="duration1">0-3 Hours</option>
                  <option value="duration2">3-9 Hours</option>
                  <option value="duration3">9-24 Hours</option>
                  <option value="duration4" selected>24+ Hours</option>
                </select>
                <!-- End Select -->

                <!-- Select -->
                <select class="js-custom-select custom-select-sm" size="1" style="opacity: 0;"
                      data-hs-select2-options='{
                        "minimumResultsForSearch": "Infinity",
                        "customClass": "custom-select custom-select-sm mb-1",
                        "placeholder": "Skills",
                        "dropdownAutoWidth": true,
                        "width": "auto"
                      }'>
                  <option label="empty"></option>
                  <option value="beginner" selected>Beginner</option>
                  <option value="intermediate">Intermediate</option>
                  <option value="advanced">Advanced</option>
                </select>
                <!-- End Select -->
              </div>
            </div>
          </div>
          <!-- End Filter -->

          @foreach($articles as $key=>$article)
          <!-- Card -->
          <a class="d-block border-bottom pb-5 mb-5" href="{{url('articles/'.$article->slug)}}">
            <div class="row mx-md-n2">
              <div class="col-md-4 px-md-2 mb-3 mb-md-0">
                <div class="position-relative">
                  <img class="img-fluid w-100 rounded-lg" src="assets/frontend/svg/components/graphics-1.svg" alt="Image Description">

                  <div class="position-absolute top-0 left-0 mt-3 ml-3">
                    <small class="btn btn-xs btn-success btn-pill text-uppercase shadow-soft py-1 px-2 mb-3">Popular</small>
                  </div>

                  <div class="position-absolute bottom-0 left-0 mb-3 ml-4">
                    <div class="d-flex align-items-center flex-wrap">
                      <ul class="list-inline mt-n1 mb-0 mr-2">
                        <li class="list-inline-item mx-0"><img src="assets/frontend/svg/illustrations/star.svg" alt="Review rating" width="14"></li>
                        <li class="list-inline-item mx-0"><img src="assets/frontend/svg/illustrations/star.svg" alt="Review rating" width="14"></li>
                        <li class="list-inline-item mx-0"><img src="assets/frontend/svg/illustrations/star.svg" alt="Review rating" width="14"></li>
                        <li class="list-inline-item mx-0"><img src="assets/frontend/svg/illustrations/star.svg" alt="Review rating" width="14"></li>
                        <li class="list-inline-item mx-0"><img src="assets/frontend/svg/illustrations/star.svg" alt="Review rating" width="14"></li>
                      </ul>
                      <span class="d-inline-block">
                        <small class="font-weight-bold text-white mr-1">4.91</small>
                        <small class="text-white-70">(1.5k+ reviews)</small>
                      </span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-8">
                <div class="media mb-2">
                  <div class="media-body mr-7">
                    <h3 class="text-hover-primary">{{ substr($article->title,0,100) }}<?php if(strlen($article->title)>100){echo "...";} ?></h3>
                  </div>

                  <!--
                  <div class="d-flex mt-1 ml-auto">
                    <div class="text-right">
                      <small class="d-block text-muted text-lh-sm"><del>$114.99</del></small>
                      <span class="d-block h5 text-primary text-lh-sm mb-0">$99.99</span>
                    </div>
                  </div>-->
                </div>

                <div class="d-flex justify-content-start align-items-center small text-muted mb-2">
                  <!--
                  <div class="d-flex align-items-center">
                    <div class="avatar-group">
                      <span class="avatar avatar-xs avatar-circle" data-toggle="tooltip" data-placement="top" title="Nataly Gaga">
                        <img class="avatar-img" src="assets/frontend/img/100x100/img1.jpg" alt="Image Description">
                      </span>
                    </div>
                  </div>
                  <div class="ml-auto">
                    <i class="fa fa-book-reader mr-1"></i>
                    10 lessons
                  </div>
                  <span class="text-muted mx-2">|</span>
                  <div class="d-inline-block">
                    <i class="fa fa-clock mr-1"></i>
                    3h 25m
                  </div>
                  <span class="text-muted mx-2">|</span>
                  <div class="d-inline-block">
                    <i class="fa fa-signal mr-1"></i>
                    All levels
                  </div>-->
                </div>

                <p class="font-size-1 text-body mb-0">{!! substr($article->short_description,0,300) !!}<?php if(strlen($article->short_description)>300){echo "...";} ?></p>
              </div>
            </div>
          </a>
          <!-- End Card -->
          @endforeach

        </div>
      </div>
    </div>
    <!-- End Courses Section -->



@endsection

@section('javascript')

  <script src="assets/frontend/vendor/slick-carousel/slick/slick.js"></script>
  <script src="assets/frontend/vendor/dzsparallaxer/dzsparallaxer.js"></script>

<script src="assets/frontend/vendor/hs-mega-menu/dist/hs-mega-menu.min.js"></script>
<script src="assets/frontend/vendor/select2/dist/js/select2.full.min.js"></script>

  <!-- JS Front -->
  <script src="assets/frontend/js/theme.min.js"></script>

  <!-- JS Plugins Init. -->
  <script>
    $(window).on('load', function () {

      // INITIALIZATION OF FORM VALIDATION
      // =======================================================
      $('.js-validate').each(function () {
        var validation = $.HSCore.components.HSValidation.init($(this));
      });


      // INITIALIZATION OF SLICK CAROUSEL
      // =======================================================
      $('.js-slick-carousel').each(function() {
        var slickCarousel = $.HSCore.components.HSSlickCarousel.init($(this));
      });


      // INITIALIZATION OF GO TO
      // =======================================================
      $('.js-go-to').each(function () {
        var goTo = new HSGoTo($(this)).init();
      });
    });
  </script>

@endsection