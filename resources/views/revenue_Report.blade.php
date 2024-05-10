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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{ asset('css/bracket.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bracket.oreo.css') }}">


  </head>

  <body>


    @extends('layouts.report.revenueReport_leftpanel')
    @extends('layouts.rightpanel')

    <div class="br-mainpanel">

        {{-- <div class="br-pageheader">
        </div><!-- br-pageheader --> --}}





      <div class="br-pagebody">
        <div class="row">

            <div class="col-3 mt-4">
                <div class="card bd-gray-400 pd-20">
                  <h6 style="color: black">Brand Name: {{$gets_brand}}</h6>
                </div><!-- card -->
              </div><!-- col-4 -->

              {{-- ======================================================== --}}

              <div class="col-3 mt-4">
                <div class="card bd-gray-400 pd-20">
                  <h6 style="color: black">Seller: {{$gets_projectmanager}}</h6>
                </div><!-- card -->
              </div><!-- col-4 -->

              {{-- ======================================================== --}}
              <div class="col-3 mt-4">
                <div class="card bd-gray-400 pd-20">
                  <h6 style="color: black">Client Name: {{$gets_client}}</h6>
                </div><!-- card -->
              </div><!-- col-4 -->

              {{-- ======================================================== --}}
              <div class="col-3 mt-4">
                <div class="card bd-gray-400 pd-20">
                    <h6 style="color: black">Status: {{$gets_status}} </h6>
                </div><!-- card -->
              </div><!-- col-4 -->

              {{-- ======================================================== --}}

              <div class="col-3 mt-4">
                <div class="card bd-gray-400 pd-20">
                    <h6 style="color: black">Payment Nature: {{$get_paymentNatures}} </h6>
                </div><!-- card -->
              </div><!-- col-4 -->

              {{-- ======================================================== --}}

              <div class="col-3 mt-4">
                <div class="card bd-gray-400 pd-20">
                    <h6 style="color: black">Charging Mode: {{$get_chargingModes}} </h6>
                </div><!-- card -->
              </div><!-- col-4 -->

              {{-- ======================================================== --}}

        </div>


</div><!-- br-pagebody -->



        <div class="br-pagebody">
          <div class="br-section-wrapper">

            <style>
                .table-dark > tbody > tr > th, .table-dark > tbody > tr > td {
                    background-color: #ffffff !important;
                    color: #060708;
                    border: 0.5px solid #ecececcc !important;
                }
            </style>
            <table id="datatable1" class=" table-dark table-hover">
                <thead>
                  <tr role="row">
                    <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="First name: activate to sort column descending">Client Name</th>
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Project</th>
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Status</th>
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Seller</th>
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Nature</th>
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Mode</th>
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Date</th>
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Next Date</th>
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Amount</th>
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Paid</th>
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">view</th>
                  </tr>
                </thead>
                <tbody>
                    @if ($roles == 1)
                        @foreach ($qaforms as $qaform)
                            <tr role="row" class="odd">
                                <td tabindex="0" class="sorting_1"><a href="/client/details/{{$qaform->clientID}}">{{$qaform->paymentclientName->name}}</a></td>
                                <td>{{$qaform->paymentprojectName->name}}</td>
                                <td>

                                   @if($qaform->refundStatus == "Refund")
                                     <div class="alert alert-danger" role="alert">
                                        {{$qaform->refundStatus}}
                                    </div>
                                   @else
                                   {{$qaform->refundStatus}}
                                   @endif

                                </td>
                                @if (isset($qaform->saleEmployeesName->name) and $qaform->saleEmployeesName->name !== null)
                                <td>{{$qaform->saleEmployeesName->name}}</td>
                                @else
                                <td><p style="color: red">User Deleted</p></td>
                                @endif

                                {{-- <td>{{$qaform->Project_ProjectManager->name}}</td> --}}
                                <td>{{$qaform->paymentNature}}</td>
                                <td>{{$qaform->ChargingMode}}</td>
                                <td>{{$qaform->paymentDate}}</td>
                                <td>{{$qaform->futureDate}}</td>
                                <td>{{$qaform->TotalAmount}}</td>
                                <td>{{$qaform->Paid}}</td>
                                <td><a href="/client/project/payment/report/view/{{$qaform->id}}"><button class="btn btn-success btn-sm"><img src="https://cdn-icons-png.flaticon.com/16/3094/3094851.png" alt="" style="filter: invert(1);" > View </button></a></td>
                            </tr>
                        @endforeach
                    @else
                        <tr role="row" class="odd">
                            <td tabindex="0" class="sorting_1">--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                            <td>--</td>
                        </tr>

                    @endif

                </tbody>

            </table>
            <a href="/dashboard"><button class="btn btn-outline-primary">BACK</button></a>







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

