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

<div class="row pd-20"></div>
        <div class="br-pagebody">
          <div class="br-section-wrapper">

            <div class="col-12">
                <div class="row">
                    <div class="col-12 mg-b-15">
                        <form action="/payment/daily/{id?}" method="get">
                                <div class="row">
                                <input type="hidden" id="data" name="datas">

                                <div class="col-3 mt-3">
                                    <label for="" style="font-weight:bold;">Start Date:</label>
                                    @if(isset($_GET['startdate']))
                                        <input onchange="createURL(this.value)" value="{{ $_GET['startdate'] }}" class="form-control" type="Date" name="startdate">
                                    @else
                                    <input onchange="createURL(this.value)"  class="form-control" type="Date" name="startdate">
                                    @endif
                                </div>

                                <div class="col-6 mt-3">
                                    <label for="" style="font-weight:bold;">Select Brand:</label>
                                        <select class="form-control select2"  name="brand[]" onchange="createURL2(this.value)"  multiple="multiple">
                                            @if(isset($_GET['brand']) and $_GET['brand'] != 0)
                                            @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}"{{ $brand->id == $_GET['brand'] ? "selected":"" }}>
                                            {{ $brand->name }}
                                            </option>
                                            @endforeach
                                        @else
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}">
                                            {{ $brand->name }}
                                            </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="col-3 mt-3">
                                    <input type="submit" value="Search" onsubmit="url()" class=" mt-4 btn btn-primary">
                                </div>
                            </div>
                        </form>
                        <script>
                                var baseURL = {
                                            "start" : 0,
                                            "brand" : 0,
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

                        <br><br>
                    </div>

                    <div class="col-8">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12"><h4 style="background-color: white ; color: black; font-weight: bold;">Brand Wise Daily Payment:</h4></div>
                                {{-- <div class="col-2">
                                </div> --}}
                            </div>
                        </div>
                        <table id="" class="table-dark table-hover">
                            <thead>
                                <tr role="row">
                                    <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #4169E1; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-sort="ascending" aria-label="First name: activate to sort column descending">Brand</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #5F9B6B; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Front</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #5F9B6B; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Back</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #FFCCCC; color: black; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Upsell</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #FFCCCC; color: black; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Remaining</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #FFCCCC; color: black; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Renewal/Recurring</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #FF9933; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Total</th>
                                </tr>
                            </thead>
                            <tbody id="brandtodaypayment">
                                @php
                                    $frontsum = 0;
                                    $backsum = 0;
                                    $allsum = 0;
                                    $upsell = 0;
                                    $remaining = 0;
                                    $renewals = 0;
                                @endphp
                                @foreach ($branddata as $item)
                                    @if ($item['front'] != 0 || $item['back'] != 0)
                                        <tr>
                                            <td  style="width: 203px; background-color: white; color: black; font-weight: bold; border-top: none; border-right: none; border-left: 1px solid white; border-bottom: 1px dotted #4169E1; text-align: center;">{{$item['name']}}</td>
                                            <td  style="width: 203px; background-color: white; color: black; border-top: none; border-right: none; border-left: none; border-bottom: 1px dotted #4169E1; text-align: center;">@if($item['front'] != 0) ${{$item['front']}} @endif</td>
                                            <td  style="width: 203px; background-color: white; color: black; border-top: none; border-right: none; border-left: none; border-bottom: 1px dotted #4169E1; text-align: center;">@if($item['back'] != 0) ${{$item['back']}} @endif</td>
                                            <td  style="width: 203px; background-color: white; color: black; border-top: none; border-right: none; border-left: none; border-bottom: 1px dotted #4169E1; text-align: center;">@if($item['brandupsell'] != 0) ${{$item['brandupsell']}} @endif</td>
                                            <td  style="width: 203px; background-color: white; color: black; border-top: none; border-right: none; border-left: none; border-bottom: 1px dotted #4169E1; text-align: center;">@if($item['brandremaining'] != 0) ${{$item['brandremaining']}} @endif</td>
                                            <td  style="width: 203px; background-color: white; color: black; border-top: none; border-right: none; border-left: none; border-bottom: 1px dotted #4169E1; text-align: center;">@if($item['sumofallrenewals'] != 0) ${{$item['sumofallrenewals']}} @endif</td>
                                            <td  style="width: 203px; background-color: white; color: black; border-top: none; border-right: none; border-left: none; border-bottom: 1px dotted #4169E1; text-align: center;">@if($item['all'] != 0) ${{$item['all']}} @endif</td>
                                        </tr>
                                    @endif
                                    @php
                                    $frontsum += $item['front'];
                                    $backsum += $item['back'];
                                    $allsum += $item['all'];

                                    $upsell += $item['brandupsell'];
                                    $remaining += $item['brandremaining'];
                                    $renewals += $item['sumofallrenewals'];
                                @endphp
                                @endforeach
                            </tbody>
                            <tbody >
                                <tr>
                                    <td style="background-color: #4169E1; color: white; font-weight: bold; border: 1px solid white; text-align: center;">Total</td>
                                    <td style="background-color: #4169E1; color: white; font-weight: bold; border: 1px solid white; text-align: center;">@if($frontsum != 0) ${{$frontsum}} @endif</td>
                                    <td style="background-color: #4169E1; color: white; font-weight: bold; border: 1px solid white; text-align: center;">@if($backsum != 0) ${{$backsum}} @endif</td>
                                    <td style="background-color: #4169E1; color: white; font-weight: bold; border: 1px solid white; text-align: center;">@if($upsell != 0) ${{$upsell}} @endif</td>
                                    <td style="background-color: #4169E1; color: white; font-weight: bold; border: 1px solid white; text-align: center;">@if($remaining != 0) ${{$remaining}} @endif</td>
                                    <td style="background-color: #4169E1; color: white; font-weight: bold; border: 1px solid white; text-align: center;">@if($renewals != 0) ${{$renewals}} @endif</td>
                                    <td style="background-color: #5F9B6B; color: white; font-weight: bold; border: 1px solid white; text-align: center;">@if($allsum != 0) ${{$allsum}} @endif</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="col-4">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-10"><h4 style="background-color: white ; color: black; font-weight: bold; ">Daily Individual Stats:</h4></div>
                                <div class="col-2">
                                </div>
                            </div>
                        </div>
                        <table id="" class="table-dark table-hover">
                            <thead>
                                <tr role="row">
                                    <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1"  style="width: 203px; background-color: #B0C4DE; color: black; font-weight: bold; border: 1px solid white; text-align: center;"  aria-sort="ascending" aria-label="First name: activate to sort column descending">Agents Name</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1"  style="width: 203px; background-color: #4169E1; color: white; font-weight: bold; border: 1px solid white; text-align: center;"  aria-label="Last name: activate to sort column ascending">Revenue</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1"  style="width: 203px; background-color: #5F9B6B; color: white; font-weight: bold; border: 1px solid white; text-align: center;"  aria-label="Last name: activate to sort column ascending">Total</th>
                                </tr>
                            </thead>
                            <tbody id="empdailypayment">
                                @php
                                $allsumemp = 0;
                                @endphp
                                @foreach ($employees as $item1)
                                    @if ($item1['allrevenue'] != 0 )
                                        <tr>
                                            <td  style="width: 203px; background-color: white; color: black; font-weight: bold; border-top: none; border-right: none; border-left: 1px solid white; border-bottom: 1px dotted #FF9933; text-align: center;">{{$item1['name']}}</td>
                                            <td  style="width: 203px; background-color: white; color: black; border-top: none; border-right: none; border-left: none; border-bottom: 1px dotted #FF9933; text-align: center;">@if($item1['allrevenue'] != 0) ${{$item1['allrevenue']}} @endif</td>
                                            <td  style="width: 203px; background-color: white; color: black; border-top: none; border-right: 1px solid white; border-left: 1px solid white; border-bottom: 1px dotted #FF9933; text-align: center;">@if($item1['allrevenue'] != 0) ${{$item1['allrevenue']}} @endif</td>
                                        </tr>
                                    @endif
                                    @php
                                    $allsumemp += $item1['allrevenue'];
                                @endphp
                                @endforeach
                            </tbody>
                            <tbody >
                                <tr>
                                    <td style="background-color: #4169E1; color: white; font-weight: bold; border: 1px solid white; text-align: center;"></td>
                                    <td style="background-color: #4169E1; color: white; font-weight: bold; border: 1px solid white; text-align: center;">Total</td>
                                    <td style="background-color: #5F9B6B; color: white; font-weight: bold; border: 1px solid white; text-align: center;">@if($allsumemp != 0) ${{$allsumemp}} @endif</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>


            <div>
                <br><br>
            </div>
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

