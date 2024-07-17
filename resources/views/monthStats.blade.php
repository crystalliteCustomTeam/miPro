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
                        <form action="/stats/{id?}" method="get">
                            <div class="row">
                                <input type="hidden" id="data1" name="datas">
                                <div class="col-2 mt-3">
                                    <label for="" style="font-weight:bold;">Select Year</label><br>
                                    @if(isset($_GET['year']))
                                    <select class="form-control select2" name="year[]"  multiple="multiple" onchange="createURL1(this.value)">
                                        {{-- <option value="0" selected >Select Year</option> --}}
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
                                <div class="col-3 mt-3">
                                    <label for="" style="font-weight:bold;">Select Month</label>
                                    @if(isset($_GET['month']))
                                        <select class="form-control select2" name="month[]" multiple="multiple" onchange="createURL2(this.value)">
                                            @foreach ($_GET['month'] as $item1)
                                            @php
                                            if ($item1 == 1) {
                                                $target = "January";
                                            } elseif ($item1 == 2) {
                                                $target = "February";
                                            } elseif ($item1 == 3) {
                                                $target = "March";
                                            } elseif ($item1 == 4) {
                                                $target = "April";
                                            } elseif ($item1 == 5) {
                                                $target = "May";
                                            } elseif ($item1 == 6) {
                                                $target = "June";
                                            } elseif ($item1 == 7) {
                                                $target = "July";
                                            } elseif ($item1 == 8) {
                                                $target = "August";
                                            } elseif ($item1 == 9) {
                                                $target = "September";
                                            } elseif ($item1 == 10) {
                                                $target = "October";
                                            } elseif ($item1 == 11) {
                                                $target = "November";
                                            } elseif ($item1 == 12) {
                                                $target = "December";
                                            }
                                        @endphp
                                            <option value="{{ $item1 }}" selected>{{ $target }}</option>
                                            @endforeach
                                            {{-- <option value="0" selected >Select</option> --}}
                                            <option value="1">January</option>
                                            <option value="2">February</option>
                                            <option value="3">March</option>
                                            <option value="4">April</option>
                                            <option value="5">May</option>
                                            <option value="6">June</option>
                                            <option value="7">July</option>
                                            <option value="8">August</option>
                                            <option value="9">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    @else
                                    <select class="form-control select2" name="month[]" multiple="multiple" onchange="createURL2(this.value)">
                                        {{-- <option value="0" selected >Select</option> --}}
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                    @endif
                                </div>
                                <div class="col-6 mt-3">
                                    <label for="" style="font-weight:bold;">Select Department</label>
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
                                        "month" : 0,
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

                            function createURL2(value) {
                                if (baseURL1.hasOwnProperty("month")) {
                                    baseURL1["month"] = value;
                                } else {
                                    baseURL1["month"] = value;
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


                    @if ($role == 0)
                        <div class="col-12">
                            <br><br>
                            <table id="" class="table-dark table-hover">
                                <thead>
                                    <tr role="row">
                                        <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #66B2FF; color: white; font-weight: bold; border-left: 1px solid white; border-right: 1px solid white; border-top: 1px solid white; border-bottom: none; text-align: center;" aria-sort="ascending" aria-label="First name: activate to sort column descending">FrontSales</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: #FF9933; color: white; font-weight: bold; border-left: 3px double white; border-right: none; border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending"></th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: #FF9933; color: white; font-weight: bold; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending"></th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: #FF9933; color: black; font-weight: bold; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Apr24</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: #FF9933; color: white; font-weight: bold; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending"></th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: #FF9933; color: white; font-weight: bold; border-left: none; border-right: 1px solid white;  border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending"></th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: black; color: white; font-weight: bold; border-left: 7px solid white; border-right: none;  border-top: none; border-bottom: none; text-align: center;" aria-label="Last name: activate to sort column ascending"> AVG </th>
                                    </tr>
                                    <tr role="row">
                                        <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #66B2FF; color: white; border-left: 1px solid white; border-right: 1px solid white; border-top: none; border-bottom: 3px double white; text-align: center;" aria-sort="ascending" aria-label="First name: activate to sort column descending"></th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: black; color: white;  border-left: 3px double white; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;" aria-label="Last name: activate to sort column ascending">Target</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: black; color: white; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;" aria-label="Last name: activate to sort column ascending">Front</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: black; color: white; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;" aria-label="Last name: activate to sort column ascending">Back</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: black; color: #FF9933;  border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;" aria-label="Last name: activate to sort column ascending">Refund</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: #808080; color: white;  border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;" aria-label="Last name: activate to sort column ascending">Net Revenue</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: black; color: white; font-weight: bold; border-left: 7px solid white; border-right: none;  border-top: none; border-bottom:3px double white; text-align: center;" aria-label="Last name: activate to sort column ascending"> </th>
                                    </tr>
                                </thead>
                                <tbody id="brandtodaypayment"></tbody>
                            </table>
                        </div>
                    @else
                    <style>
                        .table-container {
                            overflow-x: auto;
                            white-space: nowrap;
                        }
                        table {
                            table-layout: fixed;
                            width: 100%;
                            border-collapse: collapse;
                        }
                        th, td {
                            text-align: center;
                        }
                        th:first-child, td:first-child {
                            position: sticky;
                            left: 0;
                            background-color: inherit; /* Ensure the background color matches */
                            z-index: 1;
                        }
                        th:first-child {
                            z-index: 2; /* Ensure the header is above the body */
                        }
                    </style>
                        {{-- <div class="col-12 table-container"> --}}
                            <div class="col-12">
                            <br><br>
                            <table style="table-layout: fixed; width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th style="width: 203px; background-color: #66B2FF; color: white; font-weight: bold; border-left: 1px solid white; border-right: 1px solid white; border-top: 1px solid white; border-bottom: none; text-align: center;">FrontSales</th>
                                        @foreach ($finalfront as $finalfronts)
                                            @php
                                                $monthwise = $finalfronts['alldata'];
                                            @endphp
                                            @foreach ($monthwise as $monthwises)
                                            @php
                                                $monthnumber = $monthwises['month'];
                                                if ($monthnumber == 1) {
                                                $monthtext = "January";
                                                } elseif ($monthnumber == 2) {
                                                    $monthtext = "February";
                                                } elseif ($monthnumber == 3) {
                                                    $monthtext = "March";
                                                } elseif ($monthnumber == 4) {
                                                    $monthtext = "April";
                                                } elseif ($monthnumber == 5) {
                                                    $monthtext = "May";
                                                } elseif ($monthnumber == 6) {
                                                    $monthtext = "June";
                                                } elseif ($monthnumber == 7) {
                                                    $monthtext = "July";
                                                } elseif ($monthnumber == 8) {
                                                    $monthtext = "August";
                                                } elseif ($monthnumber == 9) {
                                                    $monthtext = "September";
                                                } elseif ($monthnumber == 10) {
                                                    $monthtext = "October";
                                                } elseif ($monthnumber == 11) {
                                                    $monthtext = "November";
                                                } elseif ($monthnumber == 12) {
                                                    $monthtext = "December";
                                                }
                                            @endphp
                                                <th style="width: 100px; background-color: #FF9933; color: black; font-weight: bold; border-left: 3px double white; border-right: none; border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;"></th>
                                                <th style="width: 100px; background-color: #FF9933; color: black; font-weight: bold; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;"></th>
                                                <th style="width: 100px; background-color: #FF9933; color: black; font-weight: bold; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;">{{$monthtext}}{{$monthwises['year']}}</th>
                                                <th style="width: 100px; background-color: #FF9933; color: black; font-weight: bold; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;"></th>
                                                <th style="width: 100px; background-color: #FF9933; color: black; font-weight: bold; border-left: none; border-right: 1px solid white; border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;"></th>
                                            @endforeach
                                        @endforeach
                                        <th style="width: 100px; background-color: black; color: white; font-weight: bold; border-left: 7px solid white; border-right: none; border-top: none; border-bottom: none; text-align: center;"> AVG </th>
                                        <th style="width: 100px; background-color: black; color: white; font-weight: bold; border-left: 7px solid white; border-right: none; border-top: none; border-bottom: none; text-align: center;"> Short Fall </th>
                                    </tr>
                                    <tr role="row">
                                        <th style="width: 203px; background-color: #66B2FF; color: white; border-left: 1px solid white; border-right: 1px solid white; border-top: none; border-bottom: 3px double white; text-align: center;"></th>
                                        @foreach ($finalfront as $finalfronts)
                                            @php
                                                $monthwise = $finalfronts['alldata'];
                                            @endphp
                                            @foreach ($monthwise as $monthwises)
                                                <th style="width: 100px; background-color: black; color: white; border-left: 3px double white; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;">Target</th>
                                                <th style="width: 100px; background-color: black; color: white; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;">Front</th>
                                                <th style="width: 100px; background-color: black; color: white; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;">Back</th>
                                                <th style="width: 100px; background-color: black; color: #FF9933; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;">Refund</th>
                                                <th style="width: 100px; background-color: #808080; color: white; border-left: none; border-right: 3px double white; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;">Net Revenue</th>
                                            @endforeach
                                        @endforeach
                                        <th style="width: 100px; background-color: black; color: white; font-weight: bold; border-left: 7px solid white; border-right: none; border-top: none; border-bottom: 3px double white; text-align: center;"></th>
                                        <th style="width: 100px; background-color: black; color: white; font-weight: bold; border-left: 7px solid white; border-right: none; border-top: none; border-bottom: 3px double white; text-align: center;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($collectedData as $index => $personData)
                                        <tr>
                                            @php
                                                $z = 0;
                                                $z1 = 0;
                                            @endphp
                                            @foreach ($personData as $person)
                                                {{-- @if ($personData[0] == $person)
                                                    <td style="width: 100px; background-color: black; color: white;  border-left: none; border-right: none; border-top: none; border-bottom: 1px dotted white; text-align: center;">{{$person["name"]}}</td>
                                                    <td style="width: 100px; background-color: black; color: #00FFFF;  border-left: 3px double white; border-right: none; border-top: none; border-bottom: none; text-align: center;">${{$person["target"]}}</td>
                                                    <td style="width: 100px; background-color: black; color: white;  border-left: none; border-right: none; border-top: none; border-bottom: 1px dotted white; text-align: center;">${{$person["front"]}}</td>
                                                    <td style="width: 100px; background-color: black; color: white;  border-left: none; border-right: none; border-top: none; border-bottom: 1px dotted white; text-align: center;">${{$person["back"]}}</td>
                                                    <td style="width: 100px; background-color: black; color: #FF9933;  border-left: none; border-right: none; border-top: none; border-bottom: 1px dotted white; text-align: center;">${{$person["refund"]}}</td>
                                                    <td style="width: 100px; background-color: #666666; color: white;  border-left: none; border-right: 3px double white; border-top: none; border-bottom: 1px dotted white; text-align: center;">${{$person["net"]}}</td>
                                                @else
                                                    <td style="width: 100px; background-color: black; color: #00FFFF;  border-left: 3px double white; border-right: none; border-top: none; border-bottom: none; text-align: center;">${{$person["target"]}}</td>
                                                    <td style="width: 100px; background-color: black; color: white;  border-left: none; border-right: none; border-top: none; border-bottom: 1px dotted white; text-align: center;">${{$person["front"]}}</td>
                                                    <td style="width: 100px; background-color: black; color: white;  border-left: none; border-right: none; border-top: none; border-bottom: 1px dotted white; text-align: center;">${{$person["back"]}}</td>
                                                    <td style="width: 100px; background-color: black; color: #FF9933;  border-left: none; border-right: none; border-top: none; border-bottom: 1px dotted white; text-align: center;">${{$person["refund"]}}</td>
                                                    <td style="width: 100px; background-color: #666666; color: white;  border-left: none; border-right: 3px double white; border-top: none; border-bottom: 1px dotted white; text-align: center;">${{$person["net"]}}</td>
                                                @endif --}}
                                                @if ($personData[0] == $person)
                                                    <td style="width: 100px; background-color: black; color: white;  border-left: none; border-right: none; border-top:  1px dotted white; border-bottom: 1px dotted white; text-align: center;">{{$person["name"]}}</td>
                                                    <td style="width: 100px; background-color: black; color: #00FFFF;  border-left: 3px double white; border-right: none; border-top: none; border-bottom: none; text-align: center;">@if($person["target"] != 0) ${{$person["target"]}} @else  @endif</td>
                                                    <td style="width: 100px; background-color: black; color: white;  border-left: none; border-right: none; border-top: none; border-bottom: 1px dotted white; text-align: center;">@if($person["front"] != 0) ${{$person["front"]}} @else  @endif</td>
                                                    <td style="width: 100px; background-color: black; color: white;  border-left: none; border-right: none; border-top: none; border-bottom: 1px dotted white; text-align: center;">@if($person["back"] != 0) ${{$person["back"]}} @else  @endif</td>
                                                    <td style="width: 100px; background-color: black; color: #FF9933;  border-left: none; border-right: none; border-top: none; border-bottom: 1px dotted white; text-align: center;">@if($person["refund"] != 0) ${{$person["refund"]}} @else  @endif</td>
                                                    <td style="width: 100px; background-color: #666666; color: white;  border-left: none; border-right: 3px double white; border-top: none; border-bottom: 1px dotted white; text-align: center;">@if($person["net"] != 0) ${{$person["net"]}} @else  @endif</td>
                                                @else
                                                    <td style="width: 100px; background-color: black; color: #00FFFF;  border-left: 3px double white; border-right: none; border-top: none; border-bottom: none; text-align: center;">@if($person["target"] != 0) ${{$person["target"]}} @else  @endif</td>
                                                    <td style="width: 100px; background-color: black; color: white;  border-left: none; border-right: none; border-top: none; border-bottom: 1px dotted white; text-align: center;">@if($person["front"] != 0) ${{$person["front"]}} @else  @endif</td>
                                                    <td style="width: 100px; background-color: black; color: white;  border-left: none; border-right: none; border-top: none; border-bottom: 1px dotted white; text-align: center;">@if($person["back"] != 0) ${{$person["back"]}} @else  @endif</td>
                                                    <td style="width: 100px; background-color: black; color: #FF9933;  border-left: none; border-right: none; border-top: none; border-bottom: 1px dotted white; text-align: center;">@if($person["refund"] != 0) ${{$person["refund"]}} @else  @endif</td>
                                                    <td style="width: 100px; background-color: #666666; color: white;  border-left: none; border-right: 3px double white; border-top: none; border-bottom: 1px dotted white; text-align: center;">@if($person["net"] != 0) ${{$person["net"]}} @else  @endif</td>
                                                @endif
                                                @php
                                                $z += $person["net"];
                                                $z1 += $person["target"];
                                                @endphp
                                            @endforeach
                                            @php
                                            $indexCount1 = count($personData);
                                            $y = (int)$indexCount1;
                                            $currentAvgNet1 = $z / $y;
                                            $roundedAvgNet1 = round($currentAvgNet1, 2);
                                            $shortfall = $z1 - $z;
                                            @endphp
                                            <td style="width: 100px; background-color: #A0A0A0; color: white; font-weight: bold; border-left: 7px solid white; border-right: none; border-top: none; border-bottom: 1px dotted white; text-align: center;">@if($roundedAvgNet1 != 0) ${{$roundedAvgNet1}} @else  @endif</td>
                                            <td style="width: 100px; background-color: #A0A0A0; color: white; font-weight: bold; border-left: 7px solid white; border-right: none; border-top: none; border-bottom: 1px dotted white; text-align: center;">@if($shortfall != 0) ${{$shortfall}} @else  @endif</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>



                        </div>
                    @endif

                </div>

                <br><br>

                <div class="row">
                    @if ($role == 0)
                        <div class="col-12">
                            <table id="" class="table-dark table-hover">
                                <thead>
                                    <tr role="row">
                                        <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #66B2FF; color: white; font-weight: bold; border-left: 1px solid white; border-right: 1px solid white; border-top: 1px solid white; border-bottom: none; text-align: center;" aria-sort="ascending" aria-label="First name: activate to sort column descending">Support</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: #FF9933; color: white; font-weight: bold; border-left: 3px double white; border-right: none; border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending"></th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: #FF9933; color: white; font-weight: bold; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending"></th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: #FF9933; color: black; font-weight: bold; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Apr24</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: #FF9933; color: white; font-weight: bold; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending"></th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: #FF9933; color: white; font-weight: bold; border-left: none; border-right: 1px solid white;  border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending"></th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: black; color: white; font-weight: bold; border-left: 7px solid white; border-right: none;  border-top: none; border-bottom: none; text-align: center;" aria-label="Last name: activate to sort column ascending"> AVG </th>
                                    </tr>
                                    <tr role="row">
                                        <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #66B2FF; color: white; border-left: 1px solid white; border-right: 1px solid white; border-top: none; border-bottom: 3px double white; text-align: center;" aria-sort="ascending" aria-label="First name: activate to sort column descending"></th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: black; color: white;  border-left: 3px double white; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;" aria-label="Last name: activate to sort column ascending">Target</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: black; color: white; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;" aria-label="Last name: activate to sort column ascending">Front</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: black; color: white; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;" aria-label="Last name: activate to sort column ascending">Back</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: black; color: #FF9933;  border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;" aria-label="Last name: activate to sort column ascending">Refund</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: #808080; color: white;  border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;" aria-label="Last name: activate to sort column ascending">Net Revenue</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 100px; background-color: black; color: white; font-weight: bold; border-left: 7px solid white; border-right: none;  border-top: none; border-bottom:3px double white; text-align: center;" aria-label="Last name: activate to sort column ascending"> </th>
                                    </tr>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    @else
                        <div class="col-12">
                            <table style="table-layout: fixed; width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th style="width: 203px; background-color: #66B2FF; color: white; font-weight: bold; border-left: 1px solid white; border-right: 1px solid white; border-top: 1px solid white; border-bottom: none; text-align: center;">Support</th>
                                        @foreach ($finalsupport as $finalsupports)
                                            @php
                                                $monthwise1 = $finalsupports['alldata'];
                                            @endphp
                                            @foreach ($monthwise1 as $monthwisesb)
                                            @php
                                                $monthnumberb = $monthwisesb['month'];
                                                if ($monthnumberb == 1) {
                                                    $monthtextb = "January";
                                                } elseif ($monthnumberb == 2) {
                                                    $monthtextb = "February";
                                                } elseif ($monthnumberb == 3) {
                                                    $monthtextb = "March";
                                                } elseif ($monthnumberb == 4) {
                                                    $monthtextb = "April";
                                                } elseif ($monthnumberb == 5) {
                                                    $monthtextb = "May";
                                                } elseif ($monthnumberb == 6) {
                                                    $monthtextb = "June";
                                                } elseif ($monthnumberb == 7) {
                                                    $monthtextb = "July";
                                                } elseif ($monthnumberb == 8) {
                                                    $monthtextb = "August";
                                                } elseif ($monthnumberb == 9) {
                                                    $monthtextb = "September";
                                                } elseif ($monthnumberb == 10) {
                                                    $monthtextb = "October";
                                                } elseif ($monthnumberb == 11) {
                                                    $monthtextb = "November";
                                                } elseif ($monthnumberb == 12) {
                                                    $monthtextb = "December";
                                                }
                                            @endphp
                                                <th style="width: 100px; background-color: #FF9933; color: black; font-weight: bold; border-left: 3px double white; border-right: none; border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;"></th>
                                                <th style="width: 100px; background-color: #FF9933; color: black; font-weight: bold; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;"></th>
                                                <th style="width: 100px; background-color: #FF9933; color: black; font-weight: bold; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;">{{$monthtextb}}{{$monthwisesb['year']}}</th>
                                                <th style="width: 100px; background-color: #FF9933; color: black; font-weight: bold; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;"></th>
                                                <th style="width: 100px; background-color: #FF9933; color: black; font-weight: bold; border-left: none; border-right: 1px solid white; border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;"></th>
                                            @endforeach
                                        @endforeach
                                        <th style="width: 100px; background-color: black; color: white; font-weight: bold; border-left: 7px solid white; border-right: none; border-top: none; border-bottom: none; text-align: center;"> AVG </th>
                                        <th style="width: 100px; background-color: black; color: white; font-weight: bold; border-left: 7px solid white; border-right: none; border-top: none; border-bottom: none; text-align: center;"> Short Fall </th>
                                    </tr>
                                    <tr role="row">
                                        <th style="width: 203px; background-color: #66B2FF; color: white; border-left: 1px solid white; border-right: 1px solid white; border-top: none; border-bottom: 3px double white; text-align: center;"></th>
                                        @foreach ($finalsupport as $finalsupports)
                                            @php
                                                $monthwise11 = $finalsupports['alldata'];
                                            @endphp
                                            @foreach ($monthwise11 as $monthwise111)
                                                <th style="width: 100px; background-color: black; color: white; border-left: 3px double white; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;">Target</th>
                                                <th style="width: 100px; background-color: black; color: white; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;">Front</th>
                                                <th style="width: 100px; background-color: black; color: white; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;">Back</th>
                                                <th style="width: 100px; background-color: black; color: #FF9933; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;">Refund</th>
                                                <th style="width: 100px; background-color: #666666; color: white; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;">Net Revenue</th>
                                            @endforeach
                                        @endforeach
                                        <th style="width: 100px; background-color: black; color: white; font-weight: bold; border-left: 7px solid white; border-right: none; border-top: none; border-bottom: 3px double white; text-align: center;"></th>
                                        <th style="width: 100px; background-color: black; color: white; font-weight: bold; border-left: 7px solid white; border-right: none; border-top: none; border-bottom: 3px double white; text-align: center;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($collectedDatasupport as $index => $personData1)
                                        <tr>
                                            @php
                                                $a = 0;
                                                $a1 = 0;
                                            @endphp
                                            @foreach ($personData1 as $person1)
                                                @if ($personData1[0] == $person1)
                                                    <td style="width: 100px; background-color: black; color: white;  border-left: none; border-right: none; border-top: 1px dotted white; border-bottom: 1px dotted white; text-align: center;">{{$person1["name"]}}</td>
                                                    <td style="width: 100px; background-color: black; color: #00FFFF;  border-left: 3px double white; border-right: none; border-top: none; border-bottom: none; text-align: center;">@if($person1["target"] != 0) ${{$person1["target"]}} @else  @endif</td>
                                                    <td style="width: 100px; background-color: black; color: white;  border-left: none; border-right: none; border-top: none; border-bottom: 1px dotted white; text-align: center;"> @if($person1["front"] != 0) ${{$person1["front"]}} @else  @endif</td>
                                                    <td style="width: 100px; background-color: black; color: white;  border-left: none; border-right: none; border-top: none; border-bottom: 1px dotted white; text-align: center;"> @if($person1["back"] != 0) ${{$person1["back"]}} @else  @endif</td>
                                                    <td style="width: 100px; background-color: black; color: #FF9933;  border-left: none; border-right: none; border-top: none; border-bottom: 1px dotted white; text-align: center;"> @if($person1["refund"] != 0) ${{$person1["refund"]}} @else  @endif</td>
                                                    <td style="width: 100px; background-color: #666666; color: white;  border-left: none; border-right: 3px double white; border-top: none; border-bottom: 1px dotted white; text-align: center;"> @if($person1["net"] != 0) ${{$person1["net"]}} @else  @endif</td>
                                                @else
                                                    <td style="width: 100px; background-color: black; color: #00FFFF;  border-left: 3px double white; border-right: none; border-top: none; border-bottom: none; text-align: center;">@if($person1["target"] != 0) ${{$person1["target"]}} @else  @endif</td>
                                                    <td style="width: 100px; background-color: black; color: white;  border-left: none; border-right: none; border-top: none; border-bottom: 1px dotted white; text-align: center;">@if($person1["front"] != 0) ${{$person1["front"]}} @else  @endif</td>
                                                    <td style="width: 100px; background-color: black; color: white;  border-left: none; border-right: none; border-top: none; border-bottom: 1px dotted white; text-align: center;">@if($person1["back"] != 0) ${{$person1["back"]}} @else  @endif</td>
                                                    <td style="width: 100px; background-color: black; color: #FF9933;  border-left: none; border-right: none; border-top: none; border-bottom: 1px dotted white; text-align: center;">@if($person1["refund"] != 0) ${{$person1["refund"]}} @else  @endif</td>
                                                    <td style="width: 100px; background-color: #808080; color: white;  border-left: none; border-right: 3px double white; border-top: none; border-bottom: 1px dotted white; text-align: center;">@if($person1["net"] != 0) ${{$person1["net"]}} @else  @endif</td>
                                                @endif

                                                @php
                                                    $a += $person1["net"];
                                                    $a1 += $person1["target"];
                                                @endphp
                                            @endforeach
                                            @php
                                            $indexCount = count($personData1);
                                            $b = (int)$indexCount;
                                            $currentAvgNet = $a / $b;
                                            $roundedAvgNet = round($currentAvgNet, 2);
                                            $shortfall1 = $a1 - $a;
                                            @endphp
                                            <td style="width: 100px; background-color: #A0A0A0; color: white; font-weight: bold; border-left: 7px solid white; border-right: none; border-top: none; border-bottom: 1px dotted white; text-align: center;">@if($roundedAvgNet != 0) ${{$roundedAvgNet}} @else  @endif</td>
                                            <td style="width: 100px; background-color: #A0A0A0; color: white; font-weight: bold; border-left: 7px solid white; border-right: none; border-top: none; border-bottom: 1px dotted white; text-align: center;">@if($shortfall1 != 0) ${{$shortfall1}} @else  @endif</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                    @endif

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
