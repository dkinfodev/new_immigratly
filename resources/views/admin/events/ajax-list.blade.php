<div class="col-md-12">
  <!-- Card -->
  <div class="card card-hover-shadow h-100">
    <div class="card-progress-wrap">
      <!-- Progress -->
      <div class="progress card-progress">
        <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <!-- End Progress -->
    </div>

    <!-- Body -->
    <div class="card-body">
      <div class="row">
        <div class="col-md-3">
            <div class="d-flex justify-content-center mb-2">
              <!-- Avatar -->
              <img class="avatar avatar-lg" src="assets/svg/brands/google-webdev.svg" alt="Image Description">
            </div>
        </div>
        <div class="col-md-9">
          <div class="content-detail">
            <div class="float-right">
              <div class="hs-unfold card-unfold">
                <a class="js-hs-action btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
                   data-hs-unfold-options='{
                     "target": "#projectsGridDropdown8",
                     "type": "css-animation"
                   }'>
                  <i class="tio-more-vertical"></i>
                </a>

                <div id="projectsGridDropdown8" class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm dropdown-menu-right">
                  <a class="dropdown-item" href="#">Rename project </a>
                  <a class="dropdown-item" href="#">Add to favorites</a>
                  <a class="dropdown-item" href="#">Archive project</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item text-danger" href="#">Delete</a>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
          
            <div class="mb-4">
              <h2 class="mb-1">Webdev</h2>

              <span class="font-size-sm">Updated 2 hours ago</span>
            </div>
            <a class="stretched-link" href="#"></a>
          </div>
          <div class="row">
            <div class="col">
              <span class="h4">19</span>
              <span class="d-block font-size-sm">Tasks</span>
            </div>

            <div class="col column-divider">
              <span class="h4">33</span>
              <span class="d-block font-size-sm">Completed</span>
            </div>

            <div class="col column-divider">
              <span class="h4">10</span>
              <span class="d-block font-size-sm">Days left</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Body -->

    <!-- Footer -->
    <div class="card-footer">
      <!-- Stats -->
      
      <!-- End Stats -->
    </div>
    <!-- End Footer -->
  </div>
  <!-- End Card -->
</div>
<script type="text/javascript">
$(document).ready(function(){
  $('.js-hs-action').each(function () {
    var unfold = new HSUnfold($(this)).init();
  });
  $(".row-checkbox").change(function(){
    if($(".row-checkbox:checked").length > 0){
      $("#datatableCounterInfo").show();
    }else{
      $("#datatableCounterInfo").show();
    }
    $("#datatableCounter").html($(".row-checkbox:checked").length);
  });
})
</script>