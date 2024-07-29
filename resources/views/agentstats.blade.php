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

            <div class="br-section-wrapper">
                <div class="row">
                    <div class="col-12">
                        <form action="/yearly/agents/stats/{id?}" method="get">
                            <div class="row">
                                <input type="hidden" id="data1" name="datas">
                                <div class="col-3 mt-3">
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
                                    <label for="" style="font-weight:bold;">Select Agent</label>
                                    @if(isset($_GET['depart']))
                                        <select class="form-control select2" name="depart[]"  multiple="multiple" onchange="createURL3(this.value)">
                                            {{-- <option value="0" selected >Select</option> --}}
                                            @foreach ($_GET['depart'] as $item2)
                                                @foreach($brands as $brand)
                                                @if ($item2 == $brand->id)
                                                <option value="{{ $brand->id }}" selected>{{ $brand->name }}
                                                    --
                                                    @foreach($brand->deparment($brand->id)  as $dm)
                                                      <strong>{{ $dm->name }}</strong>
                                                    @endforeach
                                                </option>
                                                @endif
                                                @endforeach
                                            @endforeach

                                            @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}">
                                            {{ $brand->name }}
                                            --
                                            @foreach($brand->deparment($brand->id)  as $dm)
                                              <strong>{{ $dm->name }}</strong>
                                            @endforeach
                                            </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <select class="form-control select2" name="depart[]"  multiple="multiple" onchange="createURL3(this.value)">
                                            @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}">
                                            {{ $brand->name }}
                                            --
                                                    @foreach($brand->deparment($brand->id)  as $dm)
                                                      <strong>{{ $dm->name }}</strong>
                                                    @endforeach
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

                    @if ($role == 0)
                        <div class="col-12">
                            <div style="background-color: #4A785D; color: white; text-align: center;  border: 1px solid white; font-weight: bold;">
                                Summery
                            </div>
                            <table id="" >
                                <thead>
                                <tr>
                                    <th style="width: 510px; background-color: black; color: white;  border-left: 1px solid white; border-right: 1px solid white; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">Year</th>
                                    <th style="width: 250px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Net Revenue</th>
                                    <th style="width: 250px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Front Sales</th>
                                    <th style="width: 250px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Back Sales</th>
                                    <th style="width: 250px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Refund/Dispute</th>
                                </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="col-12">
                            <br><br>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-4">
                                    <div style="background-color: #EF8923; color: white; text-align: center;  border: 1px solid white;">
                                        Net Revenue Comparision
                                    </div>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th style="width: 160px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Month</th>
                                                    <th style="width: 115px; background-color: black; color: white;  border: 1px solid white; text-align: center;">20--</th>
                                                    <th style="width: 115px; background-color: black; color: white;  border: 1px solid white; text-align: center;">20--</th>
                                                    <th style="width: 130px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Difference %</th>
                                                </tr>
                                            </thead>
                                        </table>
                                </div>
                                <div class="col-8">
                                </div>
                            </div>

                        </div>
                        <div class="col-12">
                            <br><br>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-4">
                                    <div style="background-color: #B31B1B; color: white; text-align: center;  border: 1px solid white;">
                                        Refund/ Dispute Comparision
                                    </div>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th style="width: 160px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Month</th>
                                                    <th style="width: 115px; background-color: black; color: white;  border: 1px solid white; text-align: center;">20--</th>
                                                    <th style="width: 115px; background-color: black; color: white;  border: 1px solid white; text-align: center;">20--</th>
                                                    <th style="width: 130px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Difference %</th>
                                                </tr>
                                            </thead>
                                        </table>
                                </div>
                                <div class="col-8">
                                </div>
                            </div>

                        </div>
                        <div class="col-12">
                            <br><br>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-4">
                                    <div style="background-color: #EF8923; color: white; text-align: center;  border: 1px solid white;">
                                        Front Sale Comparision
                                    </div>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th style="width: 160px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Month</th>
                                                    <th style="width: 115px; background-color: black; color: white;  border: 1px solid white; text-align: center;">20--</th>
                                                    <th style="width: 115px; background-color: black; color: white;  border: 1px solid white; text-align: center;">20--</th>
                                                    <th style="width: 130px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Difference %</th>
                                                </tr>
                                            </thead>
                                        </table>
                                </div>
                                <div class="col-8">
                                </div>
                            </div>

                        </div>
                        <div class="col-12">
                            <br><br>
                        </div>

                        <div class="col-12">
                            <div class="row">
                                <div class="col-4">
                                    <div style="background-color: #4D78C3; color: white; text-align: center;  border: 1px solid white;">
                                        Back Sale Comparision
                                    </div>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th style="width: 160px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Month</th>
                                                    <th style="width: 115px; background-color: black; color: white;  border: 1px solid white; text-align: center;">20--</th>
                                                    <th style="width: 115px; background-color: black; color: white;  border: 1px solid white; text-align: center;">20--</th>
                                                    <th style="width: 130px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Difference %</th>
                                                </tr>
                                            </thead>
                                        </table>
                                </div>
                                <div class="col-8">
                                </div>
                            </div>

                        </div>
                        <div class="col-12">
                            <br><br>
                        </div>



                    @else
                        <div class="col-12">
                            <div style="background-color: #4A785D; color: white; text-align: center;  border: 1px solid white; font-weight: bold;">
                                Summery
                            </div>
                            <table id="" >
                                <thead>
                                <tr>
                                    <th style="width: 510px; background-color: black; color: white;  border-left: 1px solid white; border-right: 1px solid white; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">Year</th>
                                    <th style="width: 250px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Net Revenue</th>
                                    <th style="width: 250px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Front Sales</th>
                                    <th style="width: 250px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Back Sales</th>
                                    <th style="width: 250px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Refund/Dispute</th>
                                </tr>
                                </thead>
                                <tbody id="summery">
                                    @foreach ($brandwisetotal as $brandwisetotals)
                                    <tr>
                                        <td style="width: 510px; background-color: #E0E0E0;  color: black; font-weight: bold; border-left: none; border-right: none; border-top: 2px solid black; border-bottom: 2px solid black; text-align: center;">{{$brandwisetotals['name']}}</td>
                                        <td style="width: 115px; background-color: #E0E0E0 ; color: black; border-left: none; border-right: none; border-top: 2px solid black; border-bottom: 2px solid black; text-align: center;"></td>
                                        <td style="width: 115px; background-color: #E0E0E0;  color: black; border-left: none; border-right: none; border-top: 2px solid black; border-bottom: 2px solid black; text-align: center;"></td>
                                        <td style="width: 115px; background-color: #E0E0E0 ; color: black; border-left: none; border-right: none; border-top: 2px solid black; border-bottom: 2px solid black; text-align: center;"></td>
                                        <td style="width: 115px; background-color: #E0E0E0;  color: white; border-left: none; border-right: none; border-top: 2px solid black; border-bottom: 2px solid black; text-align: center;"></td>
                                    </tr>
                                    @php
                                        $totalsums = $brandwisetotals['yeartotal'];
                                    @endphp
                                    @foreach ($totalsums as $totalsum)
                                    <tr>
                                        <td style="width: 510px; background-color: #C0C0C0;  color: black;  border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">{{$totalsum['year']}}</td>
                                        <td style="width: 115px; background-color: #C1D7CC ; color: black; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">{{$totalsum['gross']}}</td>
                                        <td style="width: 115px; background-color: #4A785D;  color: white; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">{{$totalsum['front']}}</td>
                                        <td style="width: 115px; background-color: #C1D7CC ; color: black; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">{{$totalsum['back']}}</td>
                                        <td style="width: 115px; background-color: #4A785D;  color: white; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">{{$totalsum['refunddispute']}}</td>
                                    </tr>

                                    @endforeach

                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="col-12">
                            <br><br>
                        </div>
                            @foreach ($brandwise as $differ => $item)

                                <div class="col-12">
                                    <div style="background-color: #00FFFF; color: black; text-align: center;  border: 1px solid white; font-weight: bold;">
                                        {{$item['name']}}
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4">
                                            <div style="background-color: #EF8923; color: white; text-align: center;  border: 1px solid white;">
                                                Net Revenue Comparision
                                            </div>
                                                @php
                                                    $brandyear  = $item['year'];
                                                @endphp
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 160px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Month</th>
                                                                @foreach ($brandyear as $brandyears)
                                                                <th style="width: 115px; background-color: black; color: white;  border: 1px solid white; text-align: center;">{{$brandyears["year"]}}</th>
                                                                @endforeach
                                                                <th style="width: 130px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Difference %</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($brandyear as $index => $brandyears)
                                                                @php
                                                                    $yearsData[$index] = $brandyears["yeardata"];
                                                                @endphp
                                                            @endforeach

                                                            @php
                                                                $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                                                $numYears = count($yearsData);
                                                            @endphp

                                                            @foreach ($months as $monthIndex => $monthName)
                                                                <tr>
                                                                    <td style="width: 160px; background-color: #C0C0C0; color: black; font-weight: bold; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">
                                                                        {{$monthName}}
                                                                    </td>
                                                                    @foreach ($yearsData as $yearIndex => $yearData)
                                                                        <td style="width: 115px; background-color: {{$yearIndex % 2 == 0 ? '#EFC0AD' : '#EF8923'}}; color: {{$yearIndex % 2 == 0 ? 'black' : 'white'}}; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">
                                                                            @if ($yearData[$monthIndex]['net'] == 0)
                                                                            {{''}}
                                                                            @else
                                                                                ${{$yearData[$monthIndex]['net'] ?? ''}}
                                                                            @endif
                                                                        </td>
                                                                    @endforeach
                                                                    @php
                                                                        $oldValueIndex = $numYears - 2;
                                                                        $newValueIndex = $numYears - 1;
                                                                        $oldValue = $yearsData[$oldValueIndex][$monthIndex]['net'] ?? null;
                                                                        $newValue = $yearsData[$newValueIndex][$monthIndex]['net'] ?? null;
                                                                        if ($oldValue !== null && $newValue !== null && $oldValue != 0) {
                                                                            $percentageIncrease = (($newValue - $oldValue) / $oldValue) * 100;
                                                                        } else {
                                                                            $percentageIncrease = '';
                                                                        }
                                                                    @endphp
                                                                    <td style="width: 130px; background-color: #E0E0E0; color: black; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">
                                                                        {{$percentageIncrease !== '' ? number_format($percentageIncrease, 2) . '%' : ''}}
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                            <tr>
                                                                <td style="width: 160px; background-color: #C0C0C0; color: black; font-weight: bold; border-left: 1px solid white; border-right: none; border-top: 2px solid black; border-bottom: 2px solid black; text-align: center;">Total</td>
                                                                    @php
                                                                    $brandyear  = $item['year'];
                                                                    @endphp
                                                                    @foreach ($brandyear as $index => $brandyears)
                                                                        @php
                                                                        $yearsData[$index] = $brandyears["yeardata"];
                                                                        $a = $brandyears["yeardata"];
                                                                        $sum = 0;
                                                                        @endphp
                                                                        @foreach ($a as $index => $as)
                                                                        @php
                                                                        $sum += $as["net"];
                                                                        @endphp
                                                                        @endforeach
                                                                        <td style="width: 115px; background-color :#E0E0E0; color:  black; border-left: 1px solid white; border-right: 1px solid white; border-top: 2px solid black; border-bottom: 2px solid black; text-align: center;">@if($sum == 0) @else ${{$sum}} @endif</td>
                                                                        @php
                                                                        $sum = 0;
                                                                        @endphp
                                                                    @endforeach
                                                                <td style="width: 130px; background-color: #E0E0E0; color: black; border-left: none; border-right: 1px solid white; border-top: 2px solid black; border-bottom: 2px solid black; text-align: center;"></td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                        </div>
                                        <div class="col-8">
                                            <div id="chart_div_{{$differ}}" style="width: 1000px; height: 380px;"></div>
                                            {{-- <div id="chart_div"></div> --}}
                                            @php
                                                $brandyeargraph  = $item['yeargraph'];
                                                $check = json_encode($brandyeargraph);
                                                // echo("<pre>");
                                                // print_r($brandyeargraph);
                                                // die();
                                            @endphp
                                            <script type="text/javascript">
                                                google.charts.load('current', {'packages':['corechart']});
                                                google.charts.setOnLoadCallback(drawVisualization{{$differ}});

                                                function drawVisualization{{$differ}}() {
                                                // Some raw data (not necessarily accurate)
                                                var data{{$differ}} = google.visualization.arrayToDataTable(<?php echo $check; ?>);
                                                var options{{$differ}} = {
                                                    title : 'Gross Revenue',
                                                    vAxis: {title: 'Revenue'},
                                                    hAxis: {title: 'Month'},
                                                    seriesType: 'bars',
                                                    series: {5: {type: 'line'}},
                                                    // colors: generateShadesOfOrange(),
                                                    // colors: ['#FFA500', '#FF8C00', '#FF7F50', '#FF6347', '#FF4500'] // Shades of orange
                                                };

                                                var chart{{$differ}} = new google.visualization.ComboChart(document.getElementById('chart_div_{{$differ}}'));
                                                chart{{$differ}}.draw(data{{$differ}}, options{{$differ}});
                                                }

                                                // function generateShadesOfOrange(numShades) {
                                                //     const shades = [];
                                                //     const increment = Math.floor(255 / (numShades - 1)); // Adjust based on the number of shades

                                                //     for (let i = 0; i < numShades; i++) {
                                                //         const r = 255; // Fixed red value
                                                //         const g = 165 + (increment * i); // Adjust green value for shades
                                                //         const b = 0; // Fixed blue value
                                                //         shades.push(`rgba(${r}, ${g}, ${b}, 1)`); // Push each shade to the array
                                                //     }

                                                //     return shades;
                                                // }
                                            </script>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-12">
                                    <br><br>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4">
                                            <div style="background-color: #B31B1B; color: white; text-align: center;  border: 1px solid white;">
                                                Refund/ Dispute Comparision
                                            </div>
                                                @php
                                                    $brandyear1  = $item['refund'];
                                                @endphp
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 160px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Month</th>
                                                                @foreach ($brandyear1 as $brandyears)
                                                                <th style="width: 115px; background-color: black; color: white;  border: 1px solid white; text-align: center;">{{$brandyears["year"]}}</th>
                                                                @endforeach
                                                                <th style="width: 130px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Difference %</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($brandyear1 as $index => $brandyears)
                                                                @php
                                                                    $yearsData[$index] = $brandyears["yeardata"];
                                                                @endphp
                                                            @endforeach

                                                            @php
                                                                $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                                                $numYears = count($yearsData);
                                                            @endphp

                                                            @foreach ($months as $monthIndex => $monthName)
                                                                <tr>
                                                                    <td style="width: 160px; background-color: #C0C0C0; color: black; font-weight: bold; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">
                                                                        {{$monthName}}
                                                                    </td>
                                                                    @foreach ($yearsData as $yearIndex => $yearData)
                                                                        <td style="width: 115px; background-color: {{$yearIndex % 2 == 0 ? '#EB8E8E' : '#B31B1B'}}; color: {{$yearIndex % 2 == 0 ? 'black' : 'white'}}; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">
                                                                            {{-- ${{$yearData[$monthIndex]['net'] ?? ''}} --}}
                                                                            @if ($yearData[$monthIndex]['net'] == 0)
                                                                            {{''}}
                                                                            @else
                                                                                ${{$yearData[$monthIndex]['net'] ?? ''}}
                                                                            @endif
                                                                        </td>
                                                                    @endforeach
                                                                    @php
                                                                        $oldValueIndex = $numYears - 2;
                                                                        $newValueIndex = $numYears - 1;
                                                                        $oldValue = $yearsData[$oldValueIndex][$monthIndex]['net'] ?? null;
                                                                        $newValue = $yearsData[$newValueIndex][$monthIndex]['net'] ?? null;
                                                                        if ($oldValue !== null && $newValue !== null && $oldValue != 0) {
                                                                            $percentageIncrease = (($newValue - $oldValue) / $oldValue) * 100;
                                                                        } else {
                                                                            $percentageIncrease = '';
                                                                        }
                                                                    @endphp
                                                                    <td style="width: 130px; background-color: #E0E0E0; color: black; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">
                                                                        {{$percentageIncrease !== '' ? number_format($percentageIncrease, 2) . '%' : ''}}
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                            <tr>
                                                                <td style="width: 160px; background-color: #C0C0C0; color: black; font-weight: bold; border-left: 1px solid white; border-right: none; border-top: 2px solid black; border-bottom: 2px solid black; text-align: center;">Total</td>
                                                                    @php
                                                                    $brandyear1  = $item['refund'];
                                                                    @endphp
                                                                    @foreach ($brandyear1 as $index => $brandyears)
                                                                        @php
                                                                        $yearsData[$index] = $brandyears["yeardata"];
                                                                        $a1 = $brandyears["yeardata"];
                                                                        $sum1 = 0;
                                                                        @endphp
                                                                        @foreach ($a1 as $index => $as)
                                                                        @php
                                                                        $sum1 += $as["net"];
                                                                        @endphp
                                                                        @endforeach
                                                                        <td style="width: 115px; background-color :#E0E0E0; color:  black; border-left: 1px solid white; border-right: 1px solid white; border-top: 2px solid black; border-bottom: 2px solid black; text-align: center;">@if($sum1 == 0) @else ${{$sum1}} @endif</td>
                                                                        @php
                                                                        $sum1 = 0;
                                                                        @endphp
                                                                    @endforeach
                                                                <td style="width: 130px; background-color: #E0E0E0; color: black; border-left: none; border-right: 1px solid white; border-top: 2px solid black; border-bottom: 2px solid black; text-align: center;"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                        </div>
                                        <div class="col-8">
                                            <div id="chart_div1_{{$differ}}" style="width: 1000px; height: 380px;"></div>
                                                {{-- <div id="chart_div"></div> --}}
                                                @php
                                                    $brandyeargraph1  = $item['refundyeargraph'];
                                                    $check1 = json_encode($brandyeargraph1);
                                                    // echo("<pre>");
                                                    // print_r($brandyeargraph);
                                                    // die();
                                                @endphp
                                                <script type="text/javascript">
                                                    google.charts.load('current', {'packages':['corechart']});
                                                    google.charts.setOnLoadCallback(drawVisualization1{{$differ}});

                                                    function drawVisualization1{{$differ}}() {
                                                    // Some raw data (not necessarily accurate)
                                                    var data1{{$differ}} = google.visualization.arrayToDataTable(<?php echo $check1; ?>);
                                                    var options1{{$differ}} = {
                                                        title : 'Refund/Dispute',
                                                        vAxis: {title: 'Revenue'},
                                                        hAxis: {title: 'Month'},
                                                        seriesType: 'bars',
                                                        series: {5: {type: 'line'}}
                                                    };

                                                    var chart1{{$differ}} = new google.visualization.ComboChart(document.getElementById('chart_div1_{{$differ}}'));
                                                    chart1{{$differ}}.draw(data1{{$differ}}, options1{{$differ}});
                                                    }
                                                </script>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <br><br>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4">
                                            <div style="background-color: #EF8923; color: white; text-align: center;  border: 1px solid white;">
                                                Front Sale Comparision
                                            </div>
                                                @php
                                                    $brandyear2  = $item['front'];
                                                @endphp
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 160px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Month</th>
                                                                @foreach ($brandyear2 as $brandyears)
                                                                <th style="width: 115px; background-color: black; color: white;  border: 1px solid white; text-align: center;">{{$brandyears["year"]}}</th>
                                                                @endforeach
                                                                <th style="width: 130px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Difference %</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($brandyear2 as $index => $brandyears)
                                                                @php
                                                                    $yearsData[$index] = $brandyears["yeardata"];
                                                                @endphp
                                                            @endforeach

                                                            @php
                                                                $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                                                $numYears = count($yearsData);
                                                            @endphp

                                                            @foreach ($months as $monthIndex => $monthName)
                                                                <tr>
                                                                    <td style="width: 160px; background-color: #C0C0C0; color: black; font-weight: bold; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">
                                                                        {{$monthName}}
                                                                    </td>
                                                                    @foreach ($yearsData as $yearIndex => $yearData)
                                                                        <td style="width: 115px; background-color: {{$yearIndex % 2 == 0 ? '#EFC0AD' : '#EF8923'}}; color: {{$yearIndex % 2 == 0 ? 'black' : 'white'}}; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">
                                                                            {{-- ${{$yearData[$monthIndex]['net'] ?? ''}} --}}
                                                                            @if ($yearData[$monthIndex]['net'] == 0)
                                                                            {{''}}
                                                                            @else
                                                                                ${{$yearData[$monthIndex]['net'] ?? ''}}
                                                                            @endif
                                                                        </td>
                                                                    @endforeach
                                                                    @php
                                                                        $oldValueIndex = $numYears - 2;
                                                                        $newValueIndex = $numYears - 1;
                                                                        $oldValue = $yearsData[$oldValueIndex][$monthIndex]['net'] ?? null;
                                                                        $newValue = $yearsData[$newValueIndex][$monthIndex]['net'] ?? null;
                                                                        if ($oldValue !== null && $newValue !== null && $oldValue != 0) {
                                                                            $percentageIncrease = (($newValue - $oldValue) / $oldValue) * 100;
                                                                        } else {
                                                                            $percentageIncrease = '';
                                                                        }
                                                                    @endphp
                                                                    <td style="width: 130px; background-color: #E0E0E0; color: black; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">
                                                                        {{$percentageIncrease !== '' ? number_format($percentageIncrease, 2) . '%' : ''}}
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                            <tr>
                                                                <td style="width: 160px; background-color: #C0C0C0; color: black; font-weight: bold; border-left: 1px solid white; border-right: none; border-top: 2px solid black; border-bottom: 2px solid black; text-align: center;">Total</td>
                                                                    @php
                                                                    $brandyear2  = $item['front'];
                                                                    @endphp
                                                                    @foreach ($brandyear2 as $index => $brandyears)
                                                                        @php
                                                                        $yearsData[$index] = $brandyears["yeardata"];
                                                                        $a2 = $brandyears["yeardata"];
                                                                        $sum2 = 0;
                                                                        @endphp
                                                                        @foreach ($a2 as $index => $as)
                                                                        @php
                                                                        $sum2 += $as["net"];
                                                                        @endphp
                                                                        @endforeach
                                                                        <td style="width: 115px; background-color :#E0E0E0; color:  black; border-left: 1px solid white; border-right: 1px solid white; border-top: 2px solid black; border-bottom: 2px solid black; text-align: center;">@if($sum2 == 0) @else ${{$sum2}} @endif</td>
                                                                        @php
                                                                        $sum2 = 0;
                                                                        @endphp
                                                                    @endforeach
                                                                <td style="width: 130px; background-color: #E0E0E0; color: black; border-left: none; border-right: 1px solid white; border-top: 2px solid black; border-bottom: 2px solid black; text-align: center;"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                        </div>
                                        <div class="col-8">
                                            <div id="chart_div2_{{$differ}}" style="width: 1000px; height: 380px;"></div>
                                                {{-- <div id="chart_div"></div> --}}
                                                @php
                                                    $brandyeargraph2  = $item['frontyeargraph'];
                                                    $check2 = json_encode($brandyeargraph2);
                                                    // echo("<pre>");
                                                    // print_r($brandyeargraph);
                                                    // die();
                                                @endphp
                                                <script type="text/javascript">
                                                    google.charts.load('current', {'packages':['corechart']});
                                                    google.charts.setOnLoadCallback(drawVisualization2{{$differ}});

                                                    function drawVisualization2{{$differ}}() {
                                                    // Some raw data (not necessarily accurate)
                                                    var data2{{$differ}} = google.visualization.arrayToDataTable(<?php echo $check2; ?>);
                                                    var options2{{$differ}} = {
                                                        title : 'Front Sale',
                                                        vAxis: {title: 'Revenue'},
                                                        hAxis: {title: 'Month'},
                                                        seriesType: 'bars',
                                                        series: {5: {type: 'line'}}
                                                    };

                                                    var chart2{{$differ}} = new google.visualization.ComboChart(document.getElementById('chart_div2_{{$differ}}'));
                                                    chart2{{$differ}}.draw(data2{{$differ}}, options2{{$differ}});
                                                    }
                                                </script>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <br><br>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4">
                                            <div style="background-color: #4D78C3; color: white; text-align: center;  border: 1px solid white;">
                                                Back Sale Comparision
                                            </div>
                                                @php
                                                    $brandyear3  = $item['back'];
                                                @endphp
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 160px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Month</th>
                                                                @foreach ($brandyear3 as $brandyears)
                                                                <th style="width: 115px; background-color: black; color: white;  border: 1px solid white; text-align: center;">{{$brandyears["year"]}}</th>
                                                                @endforeach
                                                                <th style="width: 130px; background-color: black; color: white;  border: 1px solid white; text-align: center;">Difference %</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($brandyear3 as $index => $brandyears)
                                                                @php
                                                                    $yearsData[$index] = $brandyears["yeardata"];
                                                                @endphp
                                                            @endforeach

                                                            @php
                                                                $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                                                $numYears = count($yearsData);
                                                            @endphp

                                                            @foreach ($months as $monthIndex => $monthName)
                                                                <tr>
                                                                    <td style="width: 160px; background-color: #C0C0C0; color: black; font-weight: bold; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">
                                                                        {{$monthName}}
                                                                    </td>
                                                                    @foreach ($yearsData as $yearIndex => $yearData)
                                                                        <td style="width: 115px; background-color: {{$yearIndex % 2 == 0 ? '#9AB8E1' : '#4D78C3'}}; color: {{$yearIndex % 2 == 0 ? 'black' : 'white'}}; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">
                                                                            {{-- ${{$yearData[$monthIndex]['net'] ?? ''}} --}}
                                                                            @if ($yearData[$monthIndex]['net'] == 0)
                                                                            {{''}}
                                                                            @else
                                                                                ${{$yearData[$monthIndex]['net'] ?? ''}}
                                                                            @endif
                                                                        </td>
                                                                    @endforeach
                                                                    @php
                                                                        $oldValueIndex = $numYears - 2;
                                                                        $newValueIndex = $numYears - 1;
                                                                        $oldValue = $yearsData[$oldValueIndex][$monthIndex]['net'] ?? null;
                                                                        $newValue = $yearsData[$newValueIndex][$monthIndex]['net'] ?? null;
                                                                        if ($oldValue !== null && $newValue !== null && $oldValue != 0) {
                                                                            $percentageIncrease = (($newValue - $oldValue) / $oldValue) * 100;
                                                                        } else {
                                                                            $percentageIncrease = '';
                                                                        }
                                                                    @endphp
                                                                    <td style="width: 130px; background-color: #E0E0E0; color: black; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 1px solid white; text-align: center;">
                                                                        {{$percentageIncrease !== '' ? number_format($percentageIncrease, 2) . '%' : ''}}
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                            <tr>
                                                                <td style="width: 160px; background-color: #C0C0C0; color: black; font-weight: bold; border-left: 1px solid white; border-right: none; border-top: 2px solid black; border-bottom: 2px solid black; text-align: center;">Total</td>
                                                                    @php
                                                                    $brandyear3  = $item['back'];
                                                                    @endphp
                                                                    @foreach ($brandyear3 as $index => $brandyears)
                                                                        @php
                                                                        $yearsData[$index] = $brandyears["yeardata"];
                                                                        $a3 = $brandyears["yeardata"];
                                                                        $sum3 = 0;
                                                                        @endphp
                                                                        @foreach ($a3 as $index => $as)
                                                                        @php
                                                                        $sum3 += $as["net"];
                                                                        @endphp
                                                                        @endforeach
                                                                        <td style="width: 115px; background-color :#E0E0E0; color:  black; border-left: 1px solid white; border-right: 1px solid white; border-top: 2px solid black; border-bottom: 2px solid black; text-align: center;">@if($sum3 == 0) @else ${{$sum3}} @endif</td>
                                                                        @php
                                                                        $sum3 = 0;
                                                                        @endphp
                                                                    @endforeach
                                                                <td style="width: 130px; background-color: #E0E0E0; color: black; border-left: none; border-right: 1px solid white; border-top: 2px solid black; border-bottom: 2px solid black; text-align: center;"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                        </div>
                                        <div class="col-8">
                                            <div id="chart_div3_{{$differ}}" style="width: 1000px; height: 380px;"></div>
                                                {{-- <div id="chart_div"></div> --}}
                                                @php
                                                    $brandyeargraph3  = $item['backyeargraph'];
                                                    $check3 = json_encode($brandyeargraph3);
                                                    // echo("<pre>");
                                                    // print_r($brandyeargraph);
                                                    // die();
                                                @endphp
                                                <script type="text/javascript">
                                                    google.charts.load('current', {'packages':['corechart']});
                                                    google.charts.setOnLoadCallback(drawVisualization3{{$differ}});

                                                    function drawVisualization3{{$differ}}() {
                                                    // Some raw data (not necessarily accurate)
                                                    var data3{{$differ}} = google.visualization.arrayToDataTable(<?php echo $check3; ?>);
                                                    var options3{{$differ}} = {
                                                        title : 'Back Sale',
                                                        vAxis: {title: 'Revenue'},
                                                        hAxis: {title: 'Month'},
                                                        seriesType: 'bars',
                                                        series: {5: {type: 'line'}}
                                                    };

                                                    var chart3{{$differ}} = new google.visualization.ComboChart(document.getElementById('chart_div3_{{$differ}}'));
                                                    chart3{{$differ}}.draw(data3{{$differ}}, options3{{$differ}});
                                                    }
                                                </script>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                    @endif

                    <div class="col-4">
                        <a href="/dashboard"><button class="btn btn-outline-primary">BACK</button></a>
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
