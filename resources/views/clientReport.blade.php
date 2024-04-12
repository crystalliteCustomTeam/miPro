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
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- vendor css -->
    <link href="{{ asset('lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/rickshaw/rickshaw.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{ asset('css/bracket.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bracket.oreo.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head>

  <body>


    @extends('layouts.leftpanel')
    @extends('layouts.rightpanel')

    <div class="br-mainpanel">

        {{-- <div class="br-pageheader">
        </div><!-- br-pageheader --> --}}




          <div class="br-section-wrapper">
            <div class="row">
                <div class="col-6 mt-3" >
                    <h2>Client Name: {{$clients[0]->name}}</h2>
                    <h5>Email: {{$clients[0]->email}}</h5>
                    <h6>Brand: {{$clients[0]->projectbrand->name}}</h6>
                </div>
                <div class="col-6 mt-3" >
                    @if ($projectcount > 0)
                        <label for="">Projects:</label>
                        <ul>
                            @foreach ($projects as $project)
                            <li>
                                {{$project->name}}--PM:
                                @if (isset($project->EmployeeName->name) and $project->EmployeeName->name !== null)
                                {{$project->EmployeeName->name}}
                                @else
                                <label style="color: red">User Deleted</label>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    @else
                        {{-- Project is not created --}}
                    @endif
                </div>
                @if ($qaformcount > 0)
                     @if (isset($qaformlasts[0]->status) and $qaformlasts[0]->status !== null)
                        <div class="col-4 mt-3" >
                            <h5>Status: {{$qaformlasts[0]->status}}</h5>
                        </div>
                    @else
                    @endif

                    @if (isset($qaformlasts[0]->client_satisfaction) and $qaformlasts[0]->client_satisfaction !== null)
                        <div class="col-4 mt-3" >
                            <h5>Remarks: {{$qaformlasts[0]->client_satisfaction}}</h5>
                        </div>
                    @else
                    @endif

                    @if (isset($qaformlasts[0]->status_of_refund) and $qaformlasts[0]->status_of_refund !== null)
                        <div class="col-4 mt-3" >
                            <h5>Expected Refund: {{$qaformlasts[0]->status_of_refund}}</h5>
                        </div>
                    @else
                    @endif

                    @if (isset($qaformlasts[0]->Refund_Request_summery) and $qaformlasts[0]->Refund_Request_summery !== null)
                        <div class="col-12 mt-3" >
                            <h4>Summery:</h4>
                            <p> {{$qaformlasts[0]->Refund_Request_summery}}</p>
                        </div>
                    @else
                    @endif
                @endif

                <div class="col-12 mt-3">
                    <h4>Payments:</h4>
                </div>
                <div class="col-12 mt-3" >
                    @if ($clientpaymentscount > 0)
                    <table id="" class="table-dark table-hover">
                        <thead>
                          <tr role="row">
                            <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Project</th>
                            <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Payment Nature</th>
                            <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Payment Gateway</th>
                            <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Payment Date</th>
                            <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Future Date</th>
                            <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Sales Person</th>
                            <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Total Amount</th>
                            <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Paid</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($clientpayments as $clientpayment)
                            <tr role="row" class="odd">
                              <td tabindex="0" class="sorting_1">{{$clientpayment->paymentprojectName->name}}</td>
                              <td>{{$clientpayment->paymentNature}}</td>
                              <td>{{$clientpayment->Payment_Gateway}}</td>
                              <td>{{$clientpayment->paymentDate}}</td>
                              <td>{{$clientpayment->futureDate}}</td>
                              <td>{{$clientpayment->saleEmployeesName->name}}</td>
                              <td>${{$clientpayment->TotalAmount}}</td>
                              <td>${{$clientpayment->Paid}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                       <p>No Payment Received</p>
                    @endif
                </div>


                @if ($projectcount > 0)
                <div class="col-12 mt-3">
                    <h4>Production:</h4>
                </div>
                @endif

                @if ($projectcount > 0)
                    @foreach ($projects as $project)
                    <div class="col-6 mt-3" >
                        <h6>{{$project->name}}</h6>
                        <table id="" class="table-dark table-hover">
                            <thead>
                            <tr role="row">
                                <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Depart</th>
                                <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Assignee</th>
                                <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Services</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr role="row" class="odd">
                                @if (isset($project->ProjectProduction->DepartNameinProjectProduction->name) and $project->ProjectProduction->DepartNameinProjectProduction->name !== null)
                                <td tabindex="0" class="sorting_1">{{$project->ProjectProduction->DepartNameinProjectProduction->name}}</td>
                                @else
                                    <td><p style="color: red">No Production Assigned</p></td>
                                @endif

                                @if (isset($project->ProjectProduction->EmployeeNameinProjectProduction->name) and $project->ProjectProduction->EmployeeNameinProjectProduction->name !== null)
                                <td>{{ $project->ProjectProduction->EmployeeNameinProjectProduction->name }}</td>
                                @else
                                    <td><p style="color: red">User Deleted or No Production Assigned</p></td>
                                @endif
                                @if (isset($project->ProjectProduction->services) and $project->ProjectProduction->services !== null)
                                <td>{{$project->ProjectProduction->services}}</td>
                                @else
                                    <td><p style="color: red">No Production Assigned</p></td>
                                @endif
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    @endforeach

                @else
                @endif

                <div class="col-12 mt-3">
                    <h4>QA Data:</h4>
                </div>
                <div class="col-12 mt-3" >
                    @if ($qaformcount > 0)
                    <table id="datatable1" class="table-dark table-hover">
                        <thead>
                          <tr role="row">
                            <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="First name: activate to sort column descending">Project</th>
                            <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Department</th>
                            <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Status</th>
                            <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Last Communication</th>
                            <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Summery</th>
                            <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Issue</th>
                            <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Description</th>
                            <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Position: activate to sort column ascending">Date</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($qaforms as $qaform)
                            <tr role="row" class="odd">
                              <td tabindex="0" class="sorting_1">{{$qaform->Project_Name->name}}</td>
                              <td>{{$qaform->GETDEPARTMENT->DepartNameinProjectProduction->name}}</td>
                              <td>{{$qaform->status}}</td>
                              <td>{{$qaform->last_communication}}</td>
                              <td>{{$qaform->Refund_Request_summery}}</td>

                                    @foreach ($qaform->QA_META_DATA($qaform->qaformID) as $meta)
                                    @php
                                    $qa_issues = json_decode($meta->issues)
                                    @endphp
                                    <td>
                                        @foreach ($qa_issues as $issue)
                                            <ul>
                                                <li>{{$issue}}</li>
                                            </ul>
                                        @endforeach
                                    </td>
                                    <td>{{ $meta->Description_of_issue }}</td>
                                    @endforeach
                                    <td>{{$qaform->created_at}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>No QA Data</p>
                    @endif
                </div>
            </div>










          </div><!-- br-section-wrapper -->






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




      <script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
      <script src="{{ asset('lib/jquery-ui/ui/widgets/datepicker.js') }}"></script>
      <script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
      <script src="{{ asset('lib/moment/min/moment.min.js') }}"></script>
      <script src="{{ asset('lib/peity/jquery.peity.min.js') }}"></script>
      <script src="{{ asset('lib/rickshaw/vendor/d3.min.js') }}"></script>
      <script src="{{ asset('lib/rickshaw/vendor/d3.layout.min.js') }}"></script>
      <script src="{{ asset('lib/rickshaw/rickshaw.min.js') }}"></script>
      <script src="{{ asset('lib/jquery.flot/jquery.flot.js')}}"></script>
      <script src="{{ asset('lib/jquery.flot/jquery.flot.resize.js') }}"></script>
      <script src="{{ asset('lib/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
      <script src="{{ asset('lib/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
      <script src="{{ asset('lib/echarts/echarts.min.js')}}"></script>
      <script src="{{ asset('lib/select2/js/select2.full.min.js') }}"></script>
      <script src="http://maps.google.com/maps/api/js?key=AIzaSyAq8o5-8Y5pudbJMJtDFzb8aHiWJufa5fg"></script>
      <script src="{{ asset('lib/gmaps/gmaps.min.js')}}"></script>

      <script src="{{ asset('js/bracket.js') }}"></script>
      <script src="{{ asset('js/map.shiftworker.js') }}"></script>
      <script src="{{ asset('js/ResizeSensor.js') }}"></script>
      <script src="{{ asset('js/dashboard.js') }}"></script>
      <script src="{{ asset('lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
      <script src="{{ asset('lib/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>
      <script src="{{ asset('lib/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
      <script src="{{ asset('lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js') }}"></script>
      <script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>

      <script>
        $(function(){
          'use strict';

          $('#datatable1').DataTable({

          });
        });

        $(document).ready(function() {
          $('#select2forme,#frontsale,#projectmanager,.select2').select2();
          frontsale
        });

        function setwhenweset(){
          $(document).ready(function() {
          $('#select2forme,#frontsale,#projectmanager,.select2').select2();
          frontsale
        });
        }
      </script>
      <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>






  </body>
</html>

