@extends('layouts.master')

@section('content')
<style type="text/css">
.comments{
  min-height: 400px;
}
</style>
<!-- Content -->
<div class="content container-fluid">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/chat-groups') }}">Chat Groups</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>

        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{ baseUrl('/chat-groups') }}">
          <i class="tio mr-1"></i> Back 
        </a>
      </div>
    </div>
    <!-- End Row -->
  </div>
  <!-- End Page Header -->

  <!-- Card -->
  <div class="card">

    <div class="card-body">
      
        <div class="row justify-content-lg-center">
        <div class="col-lg-12">
          <!-- Alert -->
          <div class="alert alert-soft-dark mb-5 mb-lg-7" role="alert">
            <div class="media align-items-top">
              <img class="avatar avatar-xl mr-3" src="./assets/svg/illustrations/yelling-reverse.svg" alt="Image Description">

              <div class="media-body">
                <h3 class="alert-heading mb-1">{{$record->group_title}}</h3>
                <p class="mb-0">
                  <?php echo $record->description ?>
                </p>
              </div>
            </div>
          </div>
          <!-- End Alert -->

          <!-- Step -->
          <div class="comments">
          <ul class="step">
            <!-- Step Item -->
            <li class="step-item">
              <div class="step-content-wrapper">
                <small class="step-divider">Today</small>
              </div>
            </li>
            <!-- End Step Item -->

            <!-- Step Item -->
            <li class="step-item">
              <div class="step-content-wrapper">
                <div class="step-avatar">
                  <img class="step-avatar-img" src="./assets/img/160x160/img9.jpg" alt="Image Description">
                </div>

                <div class="step-content">
                  <h5 class="mb-1">
                    <a class="text-dark" href="#">Iana Robinson</a>
                  </h5>

                  <p class="font-size-sm">Uploaded weekly reports to the task <a class="text-uppercase" href="#"><i class="tio-folder-bookmarked"></i></a></p>

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
                </div>
              </div>
            </li>
            <!-- End Step Item -->

            <!-- Step Item -->
            <li class="step-item">
              <div class="step-content-wrapper">
                <span class="step-icon step-icon-soft-dark">B</span>

                <div class="step-content">
                  <h5 class="mb-1">
                    <a class="text-dark" href="#">Bob Dean</a>
                  </h5>

                  <p class="font-size-sm">Marked project status as <span class="badge badge-soft-primary badge-pill"><span class="legend-indicator bg-primary"></span>"In progress"</span></p>
                </div>
              </div>
            </li>
            <!-- End Step Item -->

            <!-- Step Item -->
            <li class="step-item">
              <div class="step-content-wrapper">
                <small class="step-divider">Yesterday</small>
              </div>
            </li>
            <!-- End Step Item -->

            <!-- Step Item -->
            <li class="step-item">
              <div class="step-content-wrapper">
                <div class="step-avatar">
                  <img class="step-avatar-img" src="./assets/img/160x160/img3.jpg" alt="Image Description">
                </div>

                <div class="step-content">
                  <h5 class="mb-1">
                    <a class="text-dark" href="#">David Harrison</a>
                  </h5>

                  <p class="font-size-sm">Added 5 new card styles to <a href="#">Payments</a></p>

                  <ul class="list-group">
                    <!-- List Item -->
                    <li class="list-group-item list-group-item-light">
                      <div class="row gx-1">
                        <div class="col">
                          <img class="img-fluid rounded" src="./assets/svg/illustrations/card-1.svg" alt="Image Description">
                        </div>
                        <div class="col">
                          <img class="img-fluid rounded" src="./assets/svg/illustrations/card-2.svg" alt="Image Description">
                        </div>
                        <div class="col">
                          <img class="img-fluid rounded" src="./assets/svg/illustrations/card-3.svg" alt="Image Description">
                        </div>
                        <div class="col">
                          <img class="img-fluid rounded" src="./assets/svg/illustrations/card-4.svg" alt="Image Description">
                        </div>
                        <div class="col">
                          <img class="img-fluid rounded" src="./assets/svg/illustrations/card-5.svg" alt="Image Description">
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
                </div>
              </div>
            </li>
            <!-- End Step Item -->

            <!-- Step Item -->
            <li class="step-item">
              <div class="step-content-wrapper">
                <span class="step-icon step-icon-soft-info">D</span>

                <div class="step-content">
                  <h5 class="mb-1">
                    <a class="text-dark" href="#">David Lidell</a>
                  </h5>

                  <p class="font-size-sm">Added a new member to Front Dashboard</p>
                </div>
              </div>
            </li>
            <!-- End Step Item -->

            <!-- Step Item -->
            <li class="step-item">
              <div class="step-content-wrapper">
                <div class="step-avatar">
                  <img class="step-avatar-img" src="./assets/img/160x160/img7.jpg" alt="Image Description">
                </div>

                <div class="step-content">
                  <h5 class="mb-1">
                    <a class="text-dark" href="#">Rachel King</a>
                  </h5>

                  <p class="font-size-sm">Earned a "Top endorsed" <i class="tio-verified text-primary"></i> badge</p>
                </div>
              </div>
            </li>
            <!-- End Step Item -->

            <!-- Step Item -->
            <li class="step-item">
              <div class="step-content-wrapper">
                <small class="step-divider">Last week</small>
              </div>
            </li>
            <!-- End Step Item -->

            <!-- Step Item -->
            <li class="step-item">
              <div class="step-content-wrapper">
                <div class="step-avatar">
                  <img class="step-avatar-img" src="./assets/img/160x160/img6.jpg" alt="Image Description">
                </div>

                <div class="step-content">
                  <h5 class="mb-1">
                    <a class="text-dark" href="#">Mark Williams</a>
                  </h5>

                  <p class="font-size-sm">Attached two files.</p>

                  <ul class="list-group list-group-sm">
                    <!-- List Item -->
                    <li class="list-group-item list-group-item-light">
                      <div class="media">
                        <i class="tio-attachment-diagonal mt-1 mr-2"></i>
                        <div class="media-body text-truncate">
                          <span class="d-block text-dark text-truncate">Requirements.figma</span>
                          <small class="d-block">8mb</small>
                        </div>
                      </div>
                    </li>
                    <!-- End List Item -->

                    <!-- List Item -->
                    <li class="list-group-item list-group-item-light">
                      <div class="media">
                        <i class="tio-attachment-diagonal mt-1 mr-2"></i>
                        <div class="media-body text-truncate">
                          <span class="d-block text-dark text-truncate">Requirements.sketch</span>
                          <small class="d-block">4mb</small>
                        </div>
                      </div>
                    </li>
                    <!-- End List Item -->
                  </ul>
                </div>
              </div>
            </li>
            <!-- End Step Item -->

            <!-- Step Item -->
            <li class="step-item">
              <div class="step-content-wrapper">
                <span class="step-icon step-icon-soft-primary">C</span>

                <div class="step-content">
                  <h5 class="mb-1">
                    <a class="text-dark" href="#">Costa Quinn</a>
                  </h5>

                  <p class="font-size-sm">Marked project status as <span class="badge badge-soft-primary badge-pill"><span class="legend-indicator bg-primary"></span>"In progress"</span></p>
                </div>
              </div>
            </li>
            <!-- End Step Item -->
          </ul>
          </div>
          <!-- End Step -->

          <!-- Footer -->
          <form id="form" class="js-validate" action="{{ baseUrl('chat-groups/update/'.$record->unique_id) }}" method="post">
            @csrf
            <div class="row alert alert-soft-dark">
              <div class="col-md-12 mb-2">
                <textarea name="comments" class="form-control js-count-characters" id="reviewLabelModalEg" rows="1" maxlength="100" placeholder="Place your comments here..."></textarea>
              </div>
              <div class="col-md-6 text-left">
                <label class="btn btn-sm btn-primary transition-3d-hover custom-file-btn" for="fileAttachmentBtn">
                  <span id="customFileExample5">Choose file to upload</span>
                  <input id="fileAttachmentBtn" name="custom-file" type="file" class="js-file-attach custom-file-btn-input"
                         data-hs-file-attach-options='{
                            "textTarget": "#customFileExample5"
                         }'>
                </label>
              </div>
              <div class="col-md-6 text-right">
                <button type="submit" class="btn btn-dark"><i class="fa fa-send"></i> Send</button>
              </div>
            </div>
          </form>
          <!-- End Footer -->
        </div>
      </div>
    </div>
  </div>
<!-- End Content -->
@endsection

@section('javascript')
<!-- JS Implementing Plugins -->
<script src="assets/vendor/hs-file-attach/dist/hs-file-attach.min.js"></script>
<script src="assets/vendor/hs-count-characters/dist/js/hs-count-characters.js"></script>
<script>
  $(document).on('ready', function () {
    
    initEditor("description"); 
    $('.js-count-characters').each(function () {
      new HSCountCharacters($(this)).init()
    });
    $("#form").submit(function(e){
      e.preventDefault();
      var formData = $("#form").serialize();
      var url  = $("#form").attr('action');
      $.ajax({
        url:url,
        type:"post",
        data:formData,
        dataType:"json",
        beforeSend:function(){
          showLoader();
        },
        success:function(response){
          hideLoader();
          if(response.status == true){
            successMessage(response.message);
            redirect(response.redirect_back);
          }else{
            validation(response.message);
          }
        },
        error:function(){
            internalError();
        }
      });
      
    });
  });
</script>

@endsection