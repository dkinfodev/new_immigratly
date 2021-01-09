<!-- Card -->
<div class="card card-hover-shadow text-center h-100" style="max-width: 20rem;">
  <div class="card-progress-wrap">
    <!-- Progress -->
    <div class="progress card-progress">
      <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <!-- End Progress -->
  </div>

  <!-- Body -->
  <div class="card-body">
    <div class="row align-items-center text-left mb-4">
      <div class="col">
        <span class="badge badge-soft-secondary p-2">To do</span>
      </div>

      <div class="col-auto">
        <!-- Unfold -->
        <div class="hs-unfold card-unfold">
          <a class="js-hs-unfold-invoker btn btn-icon btn-sm btn-ghost-secondary rounded-circle" href="javascript:;"
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
        <!-- End Unfold -->
      </div>
    </div>

    <div class="d-flex justify-content-center mb-2">
      <!-- Avatar -->
      <img class="avatar avatar-lg" src="assets/svg/brands/google-webdev.svg" alt="Image Description">
    </div>

    <div class="mb-4">
      <h2 class="mb-1">Webdev</h2>

      <span class="font-size-sm">Updated 2 hours ago</span>
    </div>
    <a class="stretched-link" href="#"></a>
  </div>
  <!-- End Body -->

  <!-- Footer -->
  <div class="card-footer">
    <!-- Stats -->
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
    <!-- End Stats -->
  </div>
  <!-- End Footer -->
</div>
<!-- End Card -->
<script type="text/javascript">
$(document).ready(function(){
  $('.js-hs-unfold-invoker').each(function () {
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