@extends('layouts.master')
@section("style")
<style>
   .all_services li {
   padding: 16px;
   border-bottom: 1px solid #ddd;
   }
   .sub_services li {
   border-bottom: none;
   }
</style>
@endsection
@section('content')
<div class="content container-fluid">
  <!-- Page Header -->
  <div class="page-header">
    <div class="row align-items-end">
      <div class="col-sm mb-2 mb-sm-0">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-no-gutter">
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ baseUrl('/cases') }}">Cases</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
          </ol>
        </nav>
        <h1 class="page-title">{{$pageTitle}}</h1>
      </div>

      <div class="col-sm-auto">
        <a class="btn btn-primary" href="{{baseUrl('/cases')}}">
          <i class="tio mr-1"></i> Back 
        </a>
      </div>
    </div>
    <!-- End Row -->
  </div>
  <!-- End Page Header -->

  <!-- Card -->
   <div class="row">
      <div class="col-md-8">
         <div class="card">
          <div class="card-body">
            @if($extension == 'image')
              <img src="{{$url}}" class="img-responsive" />
            @else
             <iframe src="http://docs.google.com/viewer?url=https://immigratly.com/public/uploads/test.xlsx&embedded=true" style="margin:0 auto; width:100%; height:700px;" frameborder="0"></iframe>
            @endif
          </div>
         </div>
      </div>
      <div class="col-md-4">
         <div class="card" style="margin:0 auto; width:100%; height:750px;">
          <div class="card-body">

          </div>
         </div>
      </div>
   </div>
</div>
@endsection