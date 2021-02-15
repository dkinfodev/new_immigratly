@extends('frontend.layouts.master')
  <!-- Hero Section -->
@section('style')


@endsection

@section('content')
<!-- Search Section -->
<div class="bg-dark">
  <div class="bg-img-hero-center" style="background-image: url({{asset('assets/frontend/svg/components/abstract-shapes-19.svg')}});padding-top: 94px;">
    <div class="container space-1">
      <div class="w-lg-80 mx-lg-auto">
        <!-- Input -->
        <h1 class="text-lh-sm text-white">{{$record->group_title}}</h1>
        <!-- End Input -->
      </div>
    </div>
  </div>
</div>
<div class="container space-bottom-2">
  <div class="w-lg-80 mx-lg-auto">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-no-gutter font-size-1 space-1">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ url('discussions') }}">Discussions</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$record->group_title}}</li>
      </ol>
    </nav>
    <!-- End Breadcrumbs -->

    <!-- Article -->
    <div class="card card-bordered p-4 p-md-7">
      <!-- <h1 class="h2">What's Front?</h1> -->
      <!-- <p>How Front works, what it can do for your business and what makes it different to other solutions.</p> -->

      <!-- Article Authors -->
      <div class="media mb-5">
        <div class="avatar avatar-xs avatar-circle mr-2">
          <img class="avatar-img" src="{{ userProfile($record->created_by,'m') }}" alt="Image Description">
        </div>

        <div class="media-body">
          <small class="d-block">
            <span class="text-muted">Added by</span>
            <span class="text-dark">{{$record->User->first_name." ".$record->User->last_name}}</span>
          </small>
          <small class="d-block text-body">
            {{dateFormat($record->created_at)}}
          </small>
        </div>
      </div>
      <!-- End Article Authors -->
      <div class="description">
        <?php echo $record->description ?>
      </div>

    </div>
    <!-- End Article -->
  </div>
</div>
@endsection