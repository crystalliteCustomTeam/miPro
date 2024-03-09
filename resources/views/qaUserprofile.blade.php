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
          @if ($qa_client_status > 0)
            <h4 class="tx-normal tx-roboto tx-white">{{$qa_client[0]->Username->name }}</h4>
            <p class="mg-b-25">{{$qa_client[0]->Username->email }}</p>
          @else
            <h4 class="tx-normal tx-roboto tx-white">{{$employee[0]->name }}</h4>
            <p class="mg-b-25">{{$employee[0]->email }}</p>
          @endif






        </div><!-- card-body -->
      </div><!-- card -->

      <div class="ht-70 bg-gray-100 pd-x-20 d-flex align-items-center justify-content-center bd-b bd-gray-400">
        <ul class="nav nav-outline active-primary align-items-center flex-row" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#projects" role="tab">Clients</a></li>
            <li class="nav-item hidden-xs-down"><a class="nav-link" data-toggle="tab" href="#dashboard" role="tab">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#clients" role="tab">Projects</a></li>

        </ul>
      </div>

      <div class="tab-content br-profile-body">
        <div class="tab-pane fade active show" id="projects">
          <div class="row">
            <div class="col-lg-8">
                <div class="media-list bg-white rounded bd bd-gray-400">
                    @if ($qa_client_status > 0)
                        @foreach ($qa_client as $project)
                        <div class="media pd-20 pd-xs-30">
                            <img src="https://cdn-icons-png.flaticon.com/64/1087/1087815.png" alt="" class="wd-40 rounded-circle">
                            <div class="media-body mg-l-20">
                                <div class="d-flex justify-content-between mg-b-10">
                                    <div>
                                        <a href="/client/details/{{ $project->clientname->id }}"><h6 class="mg-b-2 tx-inverse tx-14">{{ $project->clientname->name }}</h6></a>
                                        <span class="tx-12 tx-gray-500">{{ $project->name }}</span><br>
                                    </div>
                                <span class="tx-12">{{ $project->created_at }}</span>
                                </div><!-- d-flex -->
                            </div><!-- media-body -->
                        </div><!-- media -->
                        @endforeach
                    @else
                        <p>No Client Assigned </p>
                    @endif


                </div><!-- card -->


            </div><!-- col-lg-8 -->
            <div class="col-lg-4 mg-t-30 mg-lg-t-0">
              <div class="card pd-20 pd-xs-30 bd-gray-400">
                <h6 class="tx-gray-800 tx-uppercase tx-semibold tx-13 mg-b-25">Contact Information</h6>

                @if ($qa_client_status > 0)

                    <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Name</label>
                    <p class="tx-info mg-b-25">{{$qa_client[0]->Username->name }}</p>

                    <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Email Address</label>
                    <p class="tx-inverse mg-b-25">{{$qa_client[0]->Username->email }}</p>

                    <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Extention</label>
                    <p class="tx-inverse mg-b-25">{{$qa_client[0]->Username->extension }}</p>

                    <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Designation</label>
                    <p class="tx-inverse mg-b-50">{{$qa_client[0]->Username->position }}</p>

                    <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Department</label>
                    <p class="tx-inverse mg-b-25">Quality Assaurance</p>
                @else
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
                @endif

              </div><!-- card -->


            </div><!-- col-lg-4 -->
          </div><!-- row -->
        </div><!-- tab-pane -->




        <div class="tab-pane fade" id="dashboard">
            <div class="row">

                <div class="col-3">
                    <div class="card bd-gray-400 pd-20">
                        <h6>Total Clients:</h6>
                        <h6>{{$qa_client_status}}</h6>
                    </div><!-- card -->
                </div><!-- col-4 -->

                <div class="col-3">
                    <div class="card bd-gray-400 pd-20">
                        <h6>Today's Forms:</h6>
                        <h6>{{$tc}}</h6>
                    </div><!-- card -->
                </div><!-- col-4 -->

                <div class="col-3">
                    <div class="card bd-gray-400 pd-20">
                        <h6>Expected Refund:</h6>
                        <h6>{{$expref}}</h6>
                    </div><!-- card -->
                </div><!-- col-4 -->

                <div class="col-3">
                    <div class="card bd-gray-400 pd-20">
                        <h6>Client on Refund:</h6>
                        <h6>{{$refd}}</h6>
                    </div><!-- card -->
                </div><!-- col-4 -->

                <div class="col-6" >
                    <div class="card bd-gray-400 bg-lightblue  pd-20">
                        <h3>Client Satisfaction:</h3>
                        <canvas id="myChart"></canvas>
                        <script>
                            const ctx = document.getElementById('myChart');

                            new Chart(ctx, {
                              type: 'pie',
                              data: {
                                labels: [
                                'Extremely Dissatisfied',
                                'Somewhat Dissatisfied',
                                'Neither Satisfied nor Dissatisfied',
                                'Somewhat Satisfied',
                                'Extremely Satisfied',
                            ],
                            datasets: [{
                                label: 'Client Satisfaction',
                                data: [{{$ed}} ,{{ $sd }}, {{$nsnd }}, {{$ss }}, {{$es}}],
                                backgroundColor: [
                                'rgb(0, 35, 102)',
                                'rgb(0, 64, 128)',
                                'rgb(0, 89, 179)',
                                'rgb(0, 115, 230)',
                                'rgb(0, 136, 255)'
                                ],
                                hoverOffset: 4
                            }]
                              }
                            });
                        </script>
                    </div><!-- card -->
                </div><!-- col-4 -->

                <div class="col-6">
                    <div class="card bd-gray-400 pd-20">
                        <h3>Client Refund Status:</h3>
                        <canvas id="myChart1"></canvas>
                        <script>
                            const ctx1 = document.getElementById('myChart1');

                            new Chart(ctx1, {
                              type: 'pie',
                              data: {
                                labels: [
                                'Dispute',
                                'Refund',
                                'Not Started Yet',
                                'On Going',
                            ],
                            datasets: [{
                                label: 'Client Satisfaction',
                                data: [{{$disp}} ,{{ $refd }}, {{$nsy}}, {{$ongo}}],
                                backgroundColor: [
                                'rgb(0, 35, 102)',
                                'rgb(0, 64, 128)',
                                'rgb(0, 89, 179)',
                                'rgb(0, 136, 255)'
                                ],
                                hoverOffset: 4
                            }]
                              }
                            });

                        </script>
                    </div><!-- card -->
                </div><!-- col-4 -->


            </div><!-- br-section-wrapper -->
        </div><!-- br-pagebody -->



            </div><!-- row -->
          </div><!-- tab-pane -->









      </div><!-- br-pagebody -->

    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->
@endsection
