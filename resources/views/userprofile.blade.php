@extends('layouts.app')

@section('maincontent')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel br-profile-page">

      <div class="card widget-4 bd-0 rounded-0">
        <div class="card-header ht-75">
          <div class="hidden-xs-down">
          </div>
          <div class="tx-24 hidden-xs-down">
            <a href="" class="mg-r-10"><i class="icon ion-ios-email-outline"></i></a>
            <a href=""><i class="icon ion-more"></i></a>
          </div>
        </div><!-- card-header -->
        <div class="card-body">
          <div class="card-profile-img">
            <img src="https://cdn-icons-png.flaticon.com/512/1177/1177568.png" alt="">
          </div><!-- card-profile-img -->

          <h4 class="tx-normal tx-roboto tx-white">{{$employee[0]->name }}</h4>
          <p class="mg-b-25">{{$employee[0]->email }}</p>






        </div><!-- card-body -->
      </div><!-- card -->

      <div class="ht-70 bg-gray-100 pd-x-20 d-flex align-items-center justify-content-center bd-b bd-gray-400">
        <ul class="nav nav-outline active-primary align-items-center flex-row" role="tablist">
          <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#projects" role="tab">Projects</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#clients" role="tab">Clients</a></li>
          <li class="nav-item hidden-xs-down"><a class="nav-link" data-toggle="tab" href="#" role="tab">Settings</a></li>
        </ul>
      </div>

      <div class="tab-content br-profile-body">
        <div class="tab-pane fade active show" id="projects">
          <div class="row">
            <div class="col-lg-8">
              <div class="media-list bg-white rounded bd bd-gray-400">
                  @if (count($project) > 0)
                  @foreach ($project as $project)
                  <div class="media pd-20 pd-xs-30">
                      <img src="https://cdn-icons-png.flaticon.com/64/1087/1087815.png" alt="" class="wd-40 rounded-circle">
                      <div class="media-body mg-l-20">
                        <div class="d-flex justify-content-between mg-b-10">
                          <div>
                            <h6 class="mg-b-2 tx-inverse tx-14">{{ $project->name }}</h6>
                            <span class="tx-12 tx-gray-500">{{ $project->ClientName->name }}</span><br>
                            {{-- @foreach ($projectProductions as $projectProduction)
                            <span class="tx-12 tx-gray-500">Department: {{$projectProduction->DepartNameinProjectProduction->name}} ,Assignee: {{$projectProduction->EmployeeNameinProjectProduction->name}}</span>
                            @endforeach --}}
                          </div>
                          <span class="tx-12">{{ $project->created_at }}</span>
                        </div><!-- d-flex -->
                        <p class="mg-b-20">{{ $project->projectDescription }}</p>
                        <div class="media-footer">
                          <div>
                            <a href=""><i class="fa fa-heart"></i></a>
                            <a href="" class="mg-l-10"><i class="fa fa-comment"></i></a>
                            <a href="" class="mg-l-10"><i class="fa fa-retweet"></i></a>
                            <a href="" class="mg-l-10"><i class="fa fa-ellipsis-h"></i></a>
                          </div>
                        </div><!-- d-flex -->
                      </div><!-- media-body -->
                    </div><!-- media -->
                  @endforeach
                  @else
                    <p>Hello!</p>
                  @endif

                </div><!-- card -->


            </div><!-- col-lg-8 -->
            <div class="col-lg-4 mg-t-30 mg-lg-t-0">
              <div class="card pd-20 pd-xs-30 bd-gray-400">
                <h6 class="tx-gray-800 tx-uppercase tx-semibold tx-13 mg-b-25">Contact Information</h6>

                <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Name</label>
                <p class="tx-info mg-b-25">{{$employee[0]->name }}</p>

                <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Email Address</label>
                <p class="tx-inverse mg-b-25">{{$employee[0]->email }}</p>

                <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Extention</label>
                <p class="tx-inverse mg-b-25">{{$employee[0]->extension }}</p>

                <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Designation</label>
                <p class="tx-inverse mg-b-50">{{$employee[0]->position }}</p>

                <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Department</label>
                <p class="tx-inverse mg-b-25">{{$department[0]->name }}</p>

              </div><!-- card -->

      </div><!-- br-pagebody -->

    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->
@endsection
