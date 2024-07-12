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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


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

        <div class="row pd-20"></div>

        <div class="br-pagebody">
                <div class="row">
                    <div class="col-12">
                        <form action="/yearly/brand/stats/{id?}" method="get">
                            <div class="row">
                                <input type="hidden" id="data1" name="datas">
                                <div class="col-2 mt-3">
                                    <label for="" style="font-weight:bold;">Select Year</label><br>
                                    @if(isset($_GET['year']))
                                    <select class="form-control select2" name="year[]"  multiple="multiple" onchange="createURL1(this.value)">
                                        @foreach ($_GET['year'] as $item)
                                        <option value="{{ $item }}" selected>{{ $item }}</option>
                                        @endforeach
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                        <option value="2028">2028</option>
                                        <option value="2029">2029</option>
                                        <option value="2030">2030</option>
                                    </select>
                                    @else
                                    <select class="form-control select2" name="year[]" multiple="multiple" onchange="createURL1(this.value)">
                                        {{-- <option value="0" selected >Select Year</option> --}}
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                        <option value="2028">2028</option>
                                        <option value="2029">2029</option>
                                        <option value="2030">2030</option>
                                    </select>
                                    @endif
                                </div>
                                <div class="col-6 mt-3">
                                    <label for="" style="font-weight:bold;">Select Brand</label>
                                    @if(isset($_GET['depart']))
                                        <select class="form-control select2" name="depart[]"  multiple="multiple" onchange="createURL3(this.value)">
                                            {{-- <option value="0" selected >Select</option> --}}
                                            @foreach ($_GET['depart'] as $item2)
                                                @foreach($brands as $brand)
                                                @if ($item2 == $brand->id)
                                                <option value="{{ $brand->id }}" selected>{{ $brand->name }}</option>
                                                @endif
                                                @endforeach
                                            @endforeach

                                            @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}">
                                            {{ $brand->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <select class="form-control select2" name="depart[]"  multiple="multiple" onchange="createURL3(this.value)">
                                            {{-- <option value="0" selected >Select</option> --}}
                                            @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}">
                                            {{ $brand->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                <div class="col-1 mt-2">
                                    <input type="submit" value="Search" onsubmit="url1()" class="btn btn-primary mt-4">
                                </div>
                            </div>
                        </form>
                        <script>
                            var baseURL1 = {
                                        "year": 0,
                                        "depart" : 0,
                                    };


                            function createURL1(value) {
                                if (baseURL1.hasOwnProperty("year")) {
                                    baseURL1["year"] = value;
                                } else {
                                    baseURL1["year"] = value;
                                }
                                console.log(baseURL1);
                            }

                            function createURL3(value) {
                                if (baseURL1.hasOwnProperty("depart")) {
                                    baseURL1["depart"] = value;
                                } else {
                                    baseURL1["v"] = value;
                                }
                                console.log(baseURL1);
                            }

                            var out1 = [];

                            function url1(){
                                for (var key in baseURL1) {
                                    if (baseURL1.hasOwnProperty(key)) {
                                        out1.push(key + '=' + encodeURIComponent(baseURL1[key]));
                                    }
                                }

                                out1.join('&');
                                document.getElementById("data1").value = out1

                            }


                        </script>
                    </div>

                    <div class="col-12">
                        <br><br>
                    </div>

                    <div class="col-12" style="background-color: #00FFFF; color: black; text-align: center; font-weight: bold;">
                        Brand:
                    </div>


                    <div class="col-12">
                            <div class="col-4">
                                <div style="background-color: #EF8923; color: white; text-align: center;  border: 1px solid white;">
                                    Gross Revenue Comparision
                                </div>
                                @if ($role == 0)
                                    <table>
                                        <thead>
                                            <tr>
                                                <th style="width: 160px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Month</th>
                                                <th style="width: 115px; background-color: black; color: white;  border: 1px solid white; text-align: center;">20--</th>
                                                <th style="width: 115px; background-color: black; color: white;  border: 1px solid white; text-align: center;">20--</th>
                                                <th style="width: 130px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Difference %</th>
                                            </tr>
                                        </thead>
                                        {{-- <tbody>
                                            <tr>
                                                <td style="width: 160px; background-color: #C0C0C0; color: black;  font-weight: bold; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">jan</td>
                                                <td style="width: 115px; background-color: #EFC0AD; color: black;  border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">$200</td>
                                                <td style="width: 115px; background-color: #EF8923; color: white;  border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">$200</td>
                                                <td style="width: 130px; background-color: #E0E0E0; color: black;  border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">25%</td>
                                            </tr>
                                        </tbody> --}}
                                    </table>
                                @else
                                    <table>
                                        <thead>
                                            <tr>
                                                <th style="width: 160px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Month</th>
                                                <th style="width: 115px; background-color: black; color: white;  border: 1px solid white; text-align: center;">2023</th>
                                                <th style="width: 115px; background-color: black; color: white;  border: 1px solid white; text-align: center;">2024</th>
                                                <th style="width: 130px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Difference %</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="width: 160px; background-color: #C0C0C0; color: black;  font-weight: bold; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">jan</td>
                                                <td style="width: 115px; background-color: #EFC0AD; color: black;  border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">$200</td>
                                                <td style="width: 115px; background-color: #EF8923; color: white;  border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">$200</td>
                                                <td style="width: 130px; background-color: #E0E0E0; color: black;  border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">25%</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                            <div class="col-8">
                            </div>
                    </div>
                </div>
        </div>







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
