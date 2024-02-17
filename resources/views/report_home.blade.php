<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title>Crystal Pro Panel</title>

    <!-- vendor css -->
    <link href="{{ asset('lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/rickshaw/rickshaw.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{ asset('css/bracket.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bracket.oreo.css') }}">
  </head>

  <body>


    @extends('layouts.report.report_leftpanel')



    <div class="br-mainpanel">


          <div class="br-pagetitle">
            <i class="icon ion-ios-gear-outline"></i>
            <div>
              <h4>Report:</h4>
              <p class="mg-b-0">Date:</p>
            </div>
          </div><!-- d-flex -->




        <div class="br-pagebody">

        <div class="row">

            <div class="col-3">
                <div class="card bd-gray-400 pd-20">
                  <h6 style="color: black">Client Name:</h6>
                  <h6 style="color: black">{{$clients[0]->name}}</h6>

                </div><!-- card -->
              </div><!-- col-4 -->

              {{-- ======================================================== --}}
              <div class="col-3">
                <div class="card bd-gray-400 pd-20">
                  <h6 style="color: black">Project Name:</h6>
                  <h6 style="color: black">{{$projects[0]->name}}</h6>


                </div><!-- card -->
              </div><!-- col-4 -->

              {{-- ======================================================== --}}
              <div class="col-3">
                  <div class="card bd-gray-400 bg-lightblue  pd-20">
                      <h6 style="color: black">Project Manager:</h6>
                      <h6 style="color: black">{{$projects[0]->EmployeeName->name}}</h6>


                  </div><!-- card -->
              </div><!-- col-4 -->

              <div class="col-3">
                <div class="card bd-gray-400 pd-20">
                    <h6 style="color: black">Brand Name:</h6>
                    <h6 style="color: black">{{$clients[0]->projectbrand->name}}</h6>


                </div><!-- card -->
            </div><!-- col-4 -->

            @if ($qaformlast[0]->status_of_refund == 'Going Good')

                <div class="col-3">
                    <div class="card bd-gray-400  bg-success pd-20">
                        <h6 style="color: black">Status of Refund:</h6>
                        <h6 style="color: black">{{$qaformlast[0]->status_of_refund}}</h6>


                    </div><!-- card -->
                  </div><!-- col-4 -->


            @elseif ($qaformlast[0]->status_of_refund == 'Low')

                <div class="col-3">
                    <div class="card bd-gray-400  bg-warning pd-20">
                        <h6 style="color: black">Status of Refund:</h6>
                        <h6 style="color: black">{{$qaformlast[0]->status_of_refund}}</h6>


                    </div><!-- card -->
                  </div><!-- col-4 -->

            @elseif ($qaformlast[0]->status_of_refund == 'Moderate')

                <div class="col-3">
                    <div class="card bd-gray-400  bg-primary pd-20">
                        <h6 style="color: black">Status of Refund:</h6>
                        <h6 style="color: black">{{$qaformlast[0]->status_of_refund}}</h6>


                    </div><!-- card -->
                  </div><!-- col-4 -->

            @elseif ($qaformlast[0]->status_of_refund == 'High')

                <div class="col-3">
                    <div class="card bd-gray-400  bg-danger pd-20">
                        <h6 style="color: black">Status of Refund:</h6>
                        <h6 style="color: black">{{$qaformlast[0]->status_of_refund}}</h6>


                    </div><!-- card -->
                  </div><!-- col-4 -->

            @else

                <div class="col-3">
                    <div class="card bd-gray-400  bg-secondary pd-20">
                        <h6 style="color: black">Status of Refund:</h6>
                        <h6 style="color: black">{{$qaformlast[0]->status_of_refund}}</h6>


                    </div><!-- card -->
                  </div><!-- col-4 -->

            @endif




              <div class="col-3">
                <div class="card bd-gray-400 pd-20">
                    <h6 style="color: black">Last Communication:</h6>
                    <h6 style="color: black">{{$qaformlast[0]->last_communication}}</h6>


                </div><!-- card -->
              </div><!-- col-4 -->



              @if ($qaformlast[0]->client_satisfaction == 'Extremely Satisfied')

                <div class="col-3">
                    <div class="card bd-gray-400  bg-success pd-20">
                        <h6 style="color: black">Client Satisfaction::</h6>
                        <h6 style="color: black">{{$qaformlast[0]->client_satisfaction}}</h6>


                    </div><!-- card -->
                  </div><!-- col-4 -->


            @elseif ($qaformlast[0]->client_satisfaction == 'Somewhat Satisfied')

                <div class="col-3">
                    <div class="card bd-gray-400  bg-info pd-20">
                        <h6 style="color: black">Client Satisfaction::</h6>
                        <h6 style="color: black">{{$qaformlast[0]->client_satisfaction}}</h6>


                    </div><!-- card -->
                  </div><!-- col-4 -->

            @elseif ($qaformlast[0]->client_satisfaction == 'Neither Satisfied nor Dissatisfied')

                <div class="col-3">
                    <div class="card bd-gray-400  bg-secondary pd-20">
                        <h6 style="color: black">Client Satisfaction::</h6>
                        <h6 style="color: black">{{$qaformlast[0]->client_satisfaction}}</h6>


                    </div><!-- card -->
                  </div><!-- col-4 -->

            @elseif ($qaformlast[0]->client_satisfaction == 'Somewhat Dissatisfied')

                <div class="col-3">
                    <div class="card bd-gray-400  bg-warning pd-20">
                        <h6 style="color: black">Client Satisfaction::</h6>
                        <h6 style="color: black">{{$qaformlast[0]->client_satisfaction}}</h6>


                    </div><!-- card -->
                  </div><!-- col-4 -->

            @else

                <div class="col-3">
                    <div class="card bd-gray-400  bg-danger pd-20">
                        <h6 style="color: black">Client Satisfaction::</h6>
                        <h6 style="color: black">{{$qaformlast[0]->client_satisfaction}}</h6>


                    </div><!-- card -->
                  </div><!-- col-4 -->

            @endif

              <div class="col-3">
                <div class="card bd-gray-400 pd-20">
                    <h6 style="color: black">QA Person:</h6>
                    <h6 style="color: black">{{$qaformlast[0]->QA_Person->name}}</h6>


                </div><!-- card -->
              </div><!-- col-4 -->


              <div class="col-3">
                  <div class="card bd-gray-400 pd-20">
                      <h6  style="color: black">Signature:</h6>


                  </div><!-- card -->
              </div><!-- col-4 -->



        </div>


</div><!-- br-pagebody -->




        <div class="br-pagebody">
          <div class="br-section-wrapper">
            <h2>PROJECT REPORT:</h2>
            <br><br>
            <div class="col-12">
                <div class="card bd-gray-400  bg-light   pd-20">
                    <h6  style="color: black">summery:</h6>
                    {{$qaformlast[0]->Refund_Request_summery}}


                </div><!-- card -->
            </div><!-- col-4 -->

            <br><br>


           <table id="datatable1" class="table-dark table-hover">
              <thead>
                <tr role="row">
                  <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="First name: activate to sort column descending">Production</th>
                  <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Person</th>
                  <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">Status</th>
                  <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Start date: activate to sort column ascending">Issue</th>
                  <th class="wd-10p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 127px;" aria-label="Salary: activate to sort column ascending">Description</th>
                  <th class="wd-10p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 127px;" aria-label="Salary: activate to sort column ascending">Attachment</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($qaform_filtereds as $qaform)

                @if ($qaform->status == 'Not Started Yet')

                    <tr role="row" class="odd">
                        <td tabindex="0" class="sorting_1">{{$qaform->GETDEPARTMENT->DepartNameinProjectProduction->name}}</td>
                        <td>{{$qaform->GETDEPARTMENT->EmployeeNameinProjectProduction->name}}</td>
                        <td>{{ $qaform->status }}</td>
                        <td>--</td>
                        <td>--</td>
                        <td>--</td>
                    </tr>

                @else

                <tr role="row" class="odd">
                    <td tabindex="0" class="sorting_1">{{$qaform->GETDEPARTMENT->DepartNameinProjectProduction->name}}</td>
                    <td>{{$qaform->GETDEPARTMENT->EmployeeNameinProjectProduction->name}}</td>
                    <td>{{ $qaform->status }}</td>
                    @foreach ($qaform->QA_META_DATA($qaform->qaformID) as $meta)
                            <td>{{ $meta->issues }}</td>
                            <td>{{ $meta->Description_of_issue }}</td>
                            <td><a target="_blank" href="{{  Storage::url( $meta->evidence ) }}">DOWNLOAD</a></td>
                    @endforeach
                </tr>

                @endif

                @endforeach

              </tbody>
            </table>



          </div><!-- br-section-wrapper -->
        </div><!-- br-pagebody -->
        <footer class="br-footer">
          <div class="footer-left">
            <div class="mg-b-2">Copyright &copy; 2017. Crystal Pro. All Rights Reserved.</div>
            <div>Attentively and carefully made by ThemePixels.</div>
          </div>
          <div class="footer-right d-flex align-items-center">
            <span class="tx-uppercase mg-r-10">Share:</span>
            <a target="_blank" class="pd-x-5" href="https://www.facebook.com/sharer/sharer.php?u=http%3A//themepixels.me/bracketplus/intro"><i class="fab fa-facebook tx-20"></i></a>
            <a target="_blank" class="pd-x-5" href="https://twitter.com/home?status=Bracket%20Plus,%20your%20best%20choice%20for%20premium%20quality%20admin%20template%20from%20Bootstrap.%20Get%20it%20now%20at%20http%3A//themepixels.me/bracketplus/intro"><i class="fab fa-twitter tx-20"></i></a>
          </div>
        </footer>
      </div><!-- br-mainpanel -->
      <!-- ########## END: MAIN PANEL ########## -->







  </body>
</html>

