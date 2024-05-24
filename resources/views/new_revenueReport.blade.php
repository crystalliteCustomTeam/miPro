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

@php
    if($superUser == 0){
    $ID = $LoginUser->id;
    $Name = $LoginUser->goodName;
    $Email = $LoginUser->userEmail;


    }else{
    $ID = $LoginUser[0]->id;
    $Name = $LoginUser[0]->name;
    $Email = $LoginUser[0]->email;
    }

@endphp

<!-- ########## START: HEAD PANEL ########## -->
<div class="br-header">
    <div class="br-header-left">
      <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href=""><i class="icon ion-navicon-round"></i></a></div>

    </div><!-- br-header-left -->
    <div class="br-header-right">
      <nav class="nav">

        <div class="dropdown">
          <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
            <span class="logged-name hidden-md-down">{{ $Name  }}</span>
            <img src="https://via.placeholder.com/500" class="wd-32 rounded-circle" alt="">
            <span class="square-10 bg-success"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-header wd-250">
            <div class="tx-center">
              <a href=""><img src="https://via.placeholder.com/500" class="wd-80 rounded-circle" alt=""></a>
              <h6 class="logged-fullname">{{ $Name  }}</h6>
              <p>{{ $Email }}</p>
            </div>
            <hr>
            <ul class="list-unstyled user-profile-nav">
              <li><a href="/logout"><i class="icon ion-power"></i> Sign Out</a></li>
            </ul>
          </div><!-- dropdown-menu -->
        </div><!-- dropdown -->
      </nav>
    </div><!-- br-header-right -->
</div><!-- br-header -->
<div class="br-logo"><a href=""><span>[</span>Crystal <i>pro</i><span>]</span></a></div>
<!-- ########## END: HEAD PANEL ########## -->



{{-- <div class="br-mainpanel"> --}}
<div class="br-pagebody">
     <form action="/allclient/revenue/{id?}" method="get">
    <div class="row pd-20">

            <div class="col-3 mt-3">
                <label for="" style="font-weight:bold;">Type:</label>
                @if(isset($_GET['type']))
                <select class="form-control select2"  name="type" onchange="createURL10(this.value)">
                    <option value="0" >Select</option>
                    <option value="{{ $_GET['type'] }}" selected>{{ $_GET['type'] }}</option>
                    <option value="Received" >Received</option>
                    <option value="Upcoming" >Upcoming</option>
                    <option value="Missed" >Missed</option>
                </select>
                @else
                <select class="form-control select2"  name="type" onchange="createURL10(this.value)">
                    <option value="0" >Select</option>
                    <option value="Received" >Received</option>
                    <option value="Upcoming" >Upcoming</option>
                    <option value="Missed" >Missed</option>
                </select>
                @endif
                <input type="hidden" id="data" name="datas">
              </div><!-- col-4 -->

              {{-- ======================================================== --}}

              <div class="col-3 mt-3">
                {{-- <label for="">Start Date:</label><br> --}}
                <label for="" style="font-weight:bold;">Start Date:</label>
                @if(isset($_GET['startdate']))
                      <input onchange="createURL(this.value)" value="{{ $_GET['startdate'] }}" class="form-control" type="Date" name="startdate">
                @else
                 <input onchange="createURL(this.value)"  class="form-control" type="Date" name="startdate">
                @endif
              </div><!-- col-4 -->

              {{-- ======================================================== --}}
              <div class="col-3 mt-3">
                {{-- <label for="">End Date:</label><br> --}}
                <label for="" style="font-weight:bold;">End Date:</label>
                @if(isset($_GET['enddate']))

                      <input onchange="createURL1(this.value)"   value="{{ $_GET['enddate'] }}" class="form-control" type="Date" name="enddate">
                @else
                    <input onchange="createURL1(this.value)"    class="form-control" type="Date" name="enddate">
                @endif
              </div><!-- col-4 -->

              {{-- ======================================================== --}}
              <div class="col-3 mt-3">
                <label for="" style="font-weight:bold;">Select Brand:</label>
                <select class="form-control select2"  name="brand" onchange="createURL2(this.value)" >
                    @if(isset($_GET['brand']) and $_GET['brand'] != 0)
                    @foreach($brands as $brand)
                    <option value="{{ $brand->id }}"{{ $brand->id == $_GET['brand'] ? "selected":"" }}>
                      {{ $brand->name }}
                    </option>
                    @endforeach
                    <option value="0" >Select</option>
                   @else
                    <option value="0" >Select</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">
                      {{ $brand->name }}
                    </option>
                @endforeach
                @endif
              </select>
              </div><!-- col-4 -->

              {{-- ======================================================== --}}

              <div class="col-3 mt-3">
                <label for="" style="font-weight:bold;">Payment Nature:</label>
                <select class="form-control select2"  name="paymentNature" onchange="createURL12(this.value)">
                    @if(isset($_GET['paymentNature']) and $_GET['paymentNature'] != 0)
                    <option value="{{ $_GET['paymentNature'] }}" selected>{{ $_GET['paymentNature'] }}</option>
                    @endif
                    <option value="0" >Select</option>
                    <option value="New Lead">New Lead</option>
                    <option value="New Sale">New Sale</option>
                    <option value="Renewal Payment">Renewal Payment</option>
                    <option value="Recurring Payment">Recurring Payment</option>
                    <option value="Small Payment">Small Payment</option>
                    <option value="Upsell">Upsell</option>
                    <option value="Remaining">Remaining</option>
                    <option value="One Time Payment">One Time Payment</option>
                    <option value="Dispute Won">Dispute Won</option>
                    <option value="Dispute Lost">Dispute Lost</option>
                </select>
              </div><!-- col-4 -->

              {{-- ======================================================== --}}

              <div class="col-3 mt-3">
                <label for="" style="font-weight:bold;">Charging Mode:</label>
                <select class="form-control select2"  name="chargingMode" onchange="createURL11(this.value)">
                    @if(isset($_GET['chargingMode']) and $_GET['chargingMode'] != 0)
                    <option value="{{ $_GET['chargingMode'] }}" selected>{{ $_GET['chargingMode'] }}</option>
                    @endif
                    <option value="0" >Select</option>
                    <option value="Renewal">Renewal</option>
                    <option value="Recurring">Recurring</option>
                    <option value="One Time Payment">One Time Payment</option>
                </select>
              </div><!-- col-4 -->

              {{-- ======================================================== --}}

              <div class="col-3 mt-3">
                <label for="" style="font-weight:bold;">Sale Person:</label>
                <select class="form-control select2"  name="projectmanager" onchange="createURL3(this.value)">
                    @if(isset($_GET['projectmanager']) and $_GET['projectmanager'] != 0)
                    @foreach($employees as $employee)
                    <option value="{{ $employee->id }}"{{ $employee->id == $_GET['projectmanager'] ? "selected":"" }}>
                      {{ $employee->name }}
                      --
                      @foreach($employee->deparment($employee->id)  as $dm)
                                <strong>{{ $dm->name }}</strong>
                              @endforeach
                    </option>
                    @endforeach
                    <option value="0" >Select</option>

                   @else
                    <option value="0" >Select</option>
                    @foreach($employees as $employee)
                    <option value="{{ $employee->id }}">
                      {{ $employee->name }}
                      --
                      @foreach($employee->deparment($employee->id)  as $dm)
                                <strong>{{ $dm->name }}</strong>
                              @endforeach
                    </option>
                @endforeach
                @endif
              </select>
              </div><!-- col-4 -->

              {{-- ======================================================== --}}

              <div class="col-3 mt-3">
                <label for="" style="font-weight:bold;">Select Client:</label>
                <select class="form-control select2"  name="client" onchange="createURL4(this.value)" >
                    @if(isset($_GET['client']) and $_GET['client'] != 0)
                    @foreach($clients as $client)
                    <option value="{{ $client->id }}"{{ $client->id == $_GET['client'] ? "selected":"" }}>
                      {{ $client->name }}
                    </option>
                    @endforeach
                    <option value="0" >Select</option>

                   @else
                    <option value="0" >Select</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" >
                      {{ $client->name }}
                    </option>
                @endforeach
                @endif
              </select>
              </div><!-- col-4 -->

              {{-- ======================================================== --}}

              <div class="col-3 mt-3">
                <label for="" style="font-weight:bold;">Status:</label>
                <select class="form-control select2"  name="status" onchange="createURL7(this.value)">
                    @if(isset($_GET['status']) and $_GET['status'] != 0)
                    <option value="{{ $_GET['status'] }}" selected>{{ $_GET['status'] }}</option>
                    @endif
                    <option value="0" >Select</option>
                    <option value="On Going">On Going</option>
                    <option value="Dispute">Dispute</option>
                    <option value="Refund">Refund</option>
                </select>
              </div><!-- col-4 -->

              {{-- ======================================================== --}}

              <div class="col-3 mt-4">
                <input type="submit" value="Search" onsubmit="url()" class=" mt-3 btn btn-success">
             </div>

    </div>
     </form>
     <script>
        var baseURL = {
                    "type": 0,
                    "start" : 0,
                    "end" : 0,
                    "brand" : 0,
                    "chargingMode" : 0,
                    "paymentNature" : 0,
                    "projectmanager" : 0,
                    "client": 0,
                    "status": 0,
                };


        function createURL10(value) {
            if (baseURL.hasOwnProperty("type")) {
                // Update the existing "start" property
                baseURL["type"] = value;
            } else {
                // If "start" property doesn't exist, add it
                baseURL["type"] = value;
            }
            console.log(baseURL);
        }

        function createURL(value) {
            if (baseURL.hasOwnProperty("start")) {
                // Update the existing "start" property
                baseURL["start"] = value;
            } else {
                // If "start" property doesn't exist, add it
                baseURL["start"] = value;
            }
            console.log(baseURL);
        }

        function createURL1(value) {
            if (baseURL.hasOwnProperty("end")) {
                // Update the existing "start" property
                baseURL["end"] = value;
            } else {
                // If "start" property doesn't exist, add it
                baseURL["end"] = value;
            }
            console.log(baseURL);
        }

        function createURL2(value) {
            if (baseURL.hasOwnProperty("brand")) {
                // Update the existing "start" property
                baseURL["brand"] = value;
            } else {
                // If "start" property doesn't exist, add it
                baseURL["brand"] = value;
            }
            console.log(baseURL);
        }

        function createURL11(value) {
            if (baseURL.hasOwnProperty("chargingMode")) {
                // Update the existing "start" property
                baseURL["chargingMode"] = value;
            } else {
                // If "start" property doesn't exist, add it
                baseURL["chargingMode"] = value;
            }
            console.log(baseURL);
        }

        function createURL12(value) {
            if (baseURL.hasOwnProperty("paymentNature")) {
                // Update the existing "start" property
                baseURL["paymentNature"] = value;
            } else {
                // If "start" property doesn't exist, add it
                baseURL["paymentNature"] = value;
            }
            console.log(baseURL);
        }

        function createURL3(value) {
            if (baseURL.hasOwnProperty("projectmanager")) {
                // Update the existing "start" property
                baseURL["projectmanager"] = value;
            } else {
                // If "start" property doesn't exist, add it
                baseURL["projectmanager"] = value;
            }
            console.log(baseURL);
        }

        function createURL4(value) {
            if (baseURL.hasOwnProperty("client")) {
                // Update the existing "start" property
                baseURL["client"] = value;
            } else {
                // If "start" property doesn't exist, add it
                baseURL["client"] = value;
            }
            console.log(baseURL);
        }

        function createURL7(value) {
            if (baseURL.hasOwnProperty("status")) {
                // Update the existing "start" property
                baseURL["status"] = value;
            } else {
                // If "start" property doesn't exist, add it
                baseURL["status"] = value;
            }
            console.log(baseURL);
        }

        var out = [];

        function url(){
        for (var key in baseURL) {
        if (baseURL.hasOwnProperty(key)) {
            out.push(key + '=' + encodeURIComponent(baseURL[key]));
        }
        }

        out.join('&');

        document.getElementById("data").value = out



            }


    </script>

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
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Brand</th>
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
                                <td tabindex="0" class="sorting_1"><a href="/client/details/{{$qaform->ClientID}}">{{$qaform->paymentclientName->name}}</a></td>
                                <td>{{$qaform->paymentprojectName->name}}</td>
                                <td>

                                   @if($qaform->refundStatus == "Refund")
                                     <div class="alert alert-danger" role="alert">
                                        {{$qaform->refundStatus}}
                                    </div>
                                   @elseif(isset($qaform->dispute))
                                   <div class="alert alert-warning" role="alert">
                                    {{$qaform->refundStatus}}
                                   </div>
                                   @else
                                   {{$qaform->refundStatus}}
                                   @endif

                                </td>
                                <td>{{$qaform->paymentbrandName->name}}</td>
                                @if (isset($qaform->saleEmployeesName->name) and $qaform->saleEmployeesName->name !== null)
                                <td>{{$qaform->saleEmployeesName->name}}</td>
                                @else
                                <td><p style="color: red">User Deleted</p></td>
                                @endif

                                {{-- <td>{{$qaform->Project_ProjectManager->name}}</td> --}}
                                <td>{{$qaform->paymentNature}}</td>
                                <td>{{$qaform->ChargingMode}}</td>
                                @php
                                $originalDate1 = $qaform->paymentDate;
                                $newDate1 = \Carbon\Carbon::parse($originalDate1)->format('d-m-Y');
                                @endphp
                                <td>{{$newDate1}}</td>
                                @php
                                $originalDate = $qaform->futureDate;
                                $newDate = \Carbon\Carbon::parse($originalDate)->format('d-m-Y');
                                @endphp
                                <td>{{$newDate}}</td>
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
            <br><br>
            <div class="row">
                <div class="col-6">
                    {{-- <h1>Total: ${{$totalamt}}</h1> --}}
                    <h1>Total: ${{$newtotalamt}}</h1>
                </div>
                <div class="col-6">
                    <h1>Paid: ${{$newtotalamtpaid}}</h1>
                </div>
            </div>
            <br><br>
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
    {{-- </div><!-- br-mainpanel --> --}}
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

