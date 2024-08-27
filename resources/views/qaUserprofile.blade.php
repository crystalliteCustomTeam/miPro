@extends($theme == 1 ? 'layouts.darktheme' : 'layouts.app')

@section($theme == 1 ? 'maincontent1' : 'maincontent')
    <!-- ########## START: MAIN PANEL ########## -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
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

      @if ($theme == 1)
    <div class="ht-70  bg-gray-100 pd-x-20 d-flex align-items-center justify-content-center bd-b bd-gray-400" style="background: black">
    @else
    <div class="ht-70 bg-gray-100 pd-x-20 d-flex align-items-center justify-content-center bd-b bd-gray-400">
    @endif
        <ul class="nav nav-outline active-primary align-items-center flex-row" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#projects" role="tab">Clients</a></li>
            <li class="nav-item hidden-xs-down"><a class="nav-link" data-toggle="tab" href="#dashboard" role="tab">Dashboard</a></li>
        </ul>
      </div>

      <div class="tab-content br-profile-body">
        <div class="tab-pane fade active show" id="projects">
          <div class="row">
            <div class="col-lg-8">
                @if ($theme == 1)
                <div class="media-list card-header rounded bd bd-gray-400">
                @else
                <div class="media-list bg-white rounded bd bd-gray-400">
                @endif
                    @if ($qa_client_status > 0)
                        @foreach ($qa_client as $project)
                        <div class="media pd-20 pd-xs-30">
                            <img src="https://cdn-icons-png.flaticon.com/64/1087/1087815.png" alt="" class="wd-40 rounded-circle">
                            <div class="media-body mg-l-20">
                                <div class="d-flex justify-content-between mg-b-10">
                                    <div>
                                        @if ($theme == 1)
                                        {{-- <h6 class="mg-b-2 tx-inverse tx-14" style="color: white">{{ $project->name }}</h6> --}}
                                        <a href="/client/details/{{ $project->clientname->id }}"><h6 class="mg-b-2 tx-inverse tx-14" style="color: white">{{ $project->clientname->name }}</h6></a>
                                        @else
                                        <a href="/client/details/{{ $project->clientname->id }}"><h6 class="mg-b-2 tx-inverse tx-14">{{ $project->clientname->name }}</h6></a>
                                        @endif

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
                @if ($theme == 1)
                <h6 class="tx-gray-800 tx-uppercase tx-semibold tx-13 mg-b-25" style="color: white">Contact Information</h6>
                @else
                <h6 class="tx-gray-800 tx-uppercase tx-semibold tx-13 mg-b-25">Contact Information</h6>
                @endif

                @if ($qa_client_status > 0)

                    <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Name</label>
                    <p class="tx-info mg-b-25">{{$qa_client[0]->Username->name }}</p>

                    <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Email Address</label>
                    @if ($theme == 1)
                    <p class="tx-inverse mg-b-25" style="color: white">{{$qa_client[0]->Username->email }}</p>
                    @else
                    <p class="tx-inverse mg-b-25">{{$qa_client[0]->Username->email }}</p>
                    @endif

                    <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Extention</label>
                    @if ($theme == 1)
                    <p class="tx-inverse mg-b-25" style="color: white">{{$qa_client[0]->Username->extension }}</p>
                    @else
                    <p class="tx-inverse mg-b-25">{{$qa_client[0]->Username->extension }}</p>
                    @endif

                    <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Designation</label>
                    @if ($theme == 1)
                    <p class="tx-inverse mg-b-50" style="color: white">{{$qa_client[0]->Username->position }}</p>
                    @else
                    <p class="tx-inverse mg-b-50">{{$qa_client[0]->Username->position }}</p>
                    @endif

                    <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Department</label>
                    @if ($theme == 1)
                    <p class="tx-inverse mg-b-25" style="color: white">Quality Assaurance</p>
                    @else
                    <p class="tx-inverse mg-b-25">Quality Assaurance</p>
                    @endif
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
                    <div class="card bd-gray-400 pd-25 mg-t-20">
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
                    <div class="card bd-gray-400 pd-25 mg-t-20">
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
