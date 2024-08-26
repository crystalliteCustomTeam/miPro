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
    <form action="/project/report/{id?}" method="get">
        <div class="row pd-20">

        <input type="hidden" id="data" name="datas">

        <div class="col-3 mt-3">
            {{-- <label for="">Start Date:</label><br> --}}
            <label for="" style="font-weight:bold;">Start Date:</label>
            @if(isset($_GET['startdate']))
                  <input onchange="createURL(this.value)" value="{{ $_GET['startdate'] }}" class="form-control" type="Date" name="startdate">
            @else
             <input onchange="createURL(this.value)"  class="form-control" type="Date" name="startdate">
            @endif

        </div>

        <div class="col-3 mt-3">
            {{-- <label for="">End Date:</label><br> --}}
            <label for="" style="font-weight:bold;">End Date:</label>
            @if(isset($_GET['enddate']))

                  <input onchange="createURL1(this.value)"   value="{{ $_GET['enddate'] }}" class="form-control" type="Date" name="enddate">
            @else
                <input onchange="createURL1(this.value)"    class="form-control" type="Date" name="enddate">
            @endif

        </div>

        <div class="col-3 mt-3">
            <label for="" style="font-weight:bold;">Select Brand:</label>
            <select class="form-control select2"  name="brand" onchange="createURL2(this.value)" >
                @if(isset($_GET['brand']) && $_GET['brand'] != 0)
                    @foreach($brands as $brand)
                    <option value="{{ $brand->id }}"{{ $brand->id == $_GET['brand'] ? "selected":"" }}>
                      {{ $brand->name }}
                    </option>
                    @endforeach
                @else
                    <option value="0" >Select</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">
                        {{ $brand->name }}
                        </option>
                    @endforeach
                @endif
          </select>
        </div>

        <div class="col-3 mt-3">
            <label for="" style="font-weight:bold;">Project Manager:</label>
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
        </div>

        <div class="col-3 mt-3">
            <label for="" style="font-weight:bold;">Select Client:</label>
            <select class="form-control select2"  name="client" onchange="createURL4(this.value)" >
                @if(isset($_GET['client']) and $_GET['client'] != 0)
                @foreach($clients as $client)
                <option value="{{ $client->id }}"{{ $client->id == $_GET['client'] ? "selected":"" }}>
                  {{ $client->name }}
                </option>
                @endforeach

               @else
                <option value="0" >Select</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" >
                  {{ $client->name }}
                </option>
            @endforeach
            @endif
          </select>
        </div>

        <div class="col-3 mt-3">
            <label for="" style="font-weight:bold;">Select Department:</label>
            <select class="form-control select2"  name="Production" onchange="createURL5(this.value)" >
                @if(isset($_GET['Production']) and $_GET['Production'] != 0)
                @foreach($departments as $department)
                <option value="{{ $department->id }}"{{ $department->id == $_GET['Production'] ? "selected":"" }}>
                  {{ $department->name }}
                </option>
                @endforeach

               @else
                <option value="0" >Select</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}" >
                  {{ $department->name }}
                </option>
            @endforeach
            @endif
          </select>
        </div>

        <div class="col-3 mt-3">
            <label for="" style="font-weight:bold;">Status:</label>
            <select class="form-control select2"  name="status" onchange="createURL7(this.value)">
                @if(isset($_GET['status']) and $_GET['status'] != 0)
                <option value="{{ $_GET['status'] }}" selected>{{ $_GET['status'] }}</option>
                @endif
                <option value="0" >Select</option>
                <option value="Dispute">Dispute</option>
                <option value="Refund">Refund</option>
                <option value="On Going">On Going</option>
                <option value="Not Started Yet">Not Started Yet</option>
            </select>
        </div>

        <div class="col-3 mt-3">
            <label for="" style="font-weight:bold;">Client Satisfaction Level:</label>
            <select class="form-control select2"  name="remarks" onchange="createURL8(this.value)">
                @if(isset($_GET['remarks']) and $_GET['remarks'] != 0)
                <option value="{{ $_GET['remarks'] }}" selected>{{ $_GET['remarks'] }}</option>
                @endif
                <option value="0" >Select</option>
                <option value="Extremely Satisfied">Extremely Satisfied</option>
                <option value="Somewhat Satisfied">Somewhat Satisfied</option>
                <option value="Neither Satisfied nor Dissatisfied">Neither Satisfied nor Dissatisfied</option>
                <option value="Somewhat Dissatisfied">Somewhat Dissatisfied</option>
                <option value="Extremely Dissatisfied">Extremely Dissatisfied</option>
            </select>
        </div>

        <div class="col-3 mt-3">
            <label for="" style="font-weight:bold;">Refund & Dispute Expected:</label>
            <select class="form-control select2"  name="expectedRefund" onchange="createURL9(this.value)">
                @if(isset($_GET['expectedRefund']) and $_GET['expectedRefund'] != 0)
                <option value="{{ $_GET['expectedRefund'] }}" selected>{{ $_GET['expectedRefund'] }}</option>
                @endif
                <option value="0" >Select</option>
                <option value="Going Good">Going Good</option>
                <option value="Low">Low</option>
                <option value="Moderate">Moderate</option>
                <option value="High">High</option>
            </select>
        </div>

        <div class="col-3 mt-3">
            <label for="" style="font-weight:bold;">Issues:</label>
            <select class="form-control select2"  name="issues" onchange="createURL10(this.value)">
                @if(isset($_GET['issues']) and $_GET['issues'] != 0)
                @foreach($issues as $issue)
                <option value="{{ $issue->issues }}"{{ $issue->issues == $_GET['issues'] ? "selected":"" }}>
                  {{ $issue->issues }}
                </option>
                @endforeach
               @endif

                <option value="0" >Select</option>
                @foreach($issues as $issue)
                    <option value="{{ $issue->issues }}">
                        {{ $issue->issues }}
                    </option>
                @endforeach
            </select>
        </div>


        <div class="col-3 mt-4">
           <input type="submit" value="Search" onsubmit="url()" class=" mt-3 btn btn-success">
        </div>
    </div>
    </form>

    <script>
        var baseURL = {
                    "start" : 0,
                    "end" : 0,
                    "brand" : 0,
                    "projectmanager" : 0,
                    "client": 0,
                    "production": 0,
                    "status": 0,
                    "remarks": 0,
                    "expectedRefund": 0,
                    "issue": 0,
                };


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

        function createURL5(value) {
            if (baseURL.hasOwnProperty("production")) {
                // Update the existing "start" property
                baseURL["production"] = value;
            } else {
                // If "start" property doesn't exist, add it
                baseURL["production"] = value;
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

        function createURL8(value) {
            if (baseURL.hasOwnProperty("remarks")) {
                // Update the existing "start" property
                baseURL["remarks"] = value;
            } else {
                // If "start" property doesn't exist, add it
                baseURL["remarks"] = value;
            }
            console.log(baseURL);
        }

        function createURL9(value) {
            if (baseURL.hasOwnProperty("expectedRefund")) {
                // Update the existing "start" property
                baseURL["expectedRefund"] = value;
            } else {
                // If "start" property doesn't exist, add it
                baseURL["expectedRefund"] = value;
            }
            console.log(baseURL);
        }

        function createURL10(value) {
            if (baseURL.hasOwnProperty("issue")) {
                // Update the existing "start" property
                baseURL["issue"] = value;
            } else {
                // If "start" property doesn't exist, add it
                baseURL["issue"] = value;
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
              <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Project Manager</th>
              <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Production</th>
              <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Issue</th>
              <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">view</th>
            </tr>
          </thead>
          <tbody>
              @if ($roles == 1)
                  @foreach ($qaforms as $qaform)
                      <tr role="row" class="odd">
                          <td tabindex="0" class="sorting_1"><a href="/client/details/{{$qaform->clientID}}">{{$qaform->Client_Name->name}}</a></td>
                          <td>{{$qaform->Project_Name->name}}</td>
                          <td>

                             @if($qaform->status == "Refund")
                               <div class="alert alert-danger" role="alert">
                                  {{$qaform->status}}
                              </div>
                             @else
                             {{$qaform->status}}
                             @endif

                          </td>
                          @if (isset($qaform->Project_Name->EmployeeName->name) and $qaform->Project_Name->EmployeeName->name !== null)
                          <td>{{$qaform->Project_Name->EmployeeName->name}}</td>
                          @else
                          <td><p style="color: red">User Deleted</p></td>
                          @endif
                          @if (isset($qaform->GETDEPARTMENT->DepartNameinProjectProduction->name) and $qaform->GETDEPARTMENT->DepartNameinProjectProduction->name !== null)
                          <td>{{$qaform->GETDEPARTMENT->DepartNameinProjectProduction->name}}</td>
                          @else
                          <td><p style="color: red">Production Deleted</p></td>
                          @endif

                          {{-- <td>{{$qaform->Project_ProjectManager->name}}</td> --}}
                          @if ($qaform->status != "Not Started Yet")
                              @foreach ($qaform->QA_META_DATA($qaform->qaformID) as $meta)
                              @php

                              $qa_issues = json_decode($meta->issues)
                              @endphp
                              <td>
                                  @if(isset($qa_issues))
                                  @foreach ($qa_issues as $issue)
                                      <ul>
                                          <li>{{$issue}}</li>
                                      </ul>
                                  @endforeach
                                  @else
                                  <p>Issue Undefined</p>
                                  @endif

                              </td>
                              @endforeach
                          @else
                              <td>--</td>

                          @endif

                          <td><a href="/client/project/qaform/view/{{$qaform->mainID}}"><button class="btn btn-success btn-sm"><img src="https://cdn-icons-png.flaticon.com/16/3094/3094851.png" alt="" style="filter: invert(1);" > View </button></a></td>
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

