<div class="row gx-2 gx-lg-3">
    <div class="col-sm-4 col-lg-4 mb-3 mb-lg-5">
      <!-- Card -->
      <div class="card h-100">
        <div class="card-body">
          <h6 class="card-subtitle mb-2">Total Groups</h6>

          <div class="row align-items-center gx-2">
            <div class="col">
              <span class="js-counter display-4 text-dark">{{ $total }}</span>
              <!-- <span class="text-body font-size-sm ml-1">from 22</span> -->
            </div>

            <div class="col-auto">
              <span class="badge badge-soft-success p-1">
                <!-- <i class="fa fa-eye"></i> -->
              </span>
            </div>
          </div>
          <!-- End Row -->
        </div>
      </div>
      <!-- End Card -->
    </div>

    <div class="col-sm-4 col-lg-4 mb-3 mb-lg-5">
      <!-- Card -->
      <div class="card h-100">
        <div class="card-body">
          <h6 class="card-subtitle mb-2">Open Groups</h6>

          <div class="row align-items-center gx-2">
            <div class="col">
              <span class="js-counter display-4 text-dark">{{ $my_chats }}</span>
              <span class="text-body font-size-sm ml-1">from {{ $total_chats }}</span>
            </div>

            <div class="col-auto">
              <a href="{{ baseUrl('discussions') }}" class="badge badge-soft-success p-1">
                <i class="fa fa-eye"></i> View
              </a>
            </div>
          </div>
          <!-- End Row -->
        </div>
      </div>
      <!-- End Card -->
    </div>

    <div class="col-sm-4 col-lg-4 mb-3 mb-lg-5">
      <!-- Card -->
      <div class="card h-100">
        <div class="card-body">
          <h6 class="card-subtitle mb-2">Close Groups</h6>

          <div class="row align-items-center gx-2">
            <div class="col">
              <span class="js-counter display-4 text-dark">{{ $close_group }}</span>
              
              <span class="text-body font-size-sm ml-1">from {{ $total }}</span>
            </div>

            <div class="col-auto">
              <a href="{{ baseUrl('discussions/closed') }}" class="badge badge-soft-danger p-1">
                <i class="fa fa-eye"></i> View
              </a>
            </div>
          </div>
          <!-- End Row -->
        </div>
      </div>
      <!-- End Card -->
    </div>
  </div>
