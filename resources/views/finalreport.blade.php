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



        <div class="br-pagebody">
            <div class="row pd-20">
                <div class="col-2 mt-3">
                    <label for="" style="font-weight:bold;">Select Year</label>
                    <select class="form-control select2" name="year[]" id="getyeardata" multiple="multiple">
                        <option value="">Select Year</option>
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
                </div>
                <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Select Month</label>
                    <select class="form-control select2" name="month[]" id="getmonth" multiple="multiple">
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
                </div>
                <div class="col-6 mt-3">
                    <label for="" style="font-weight:bold;">Select Brand</label>
                    <select class="form-control select2" name="brand[]" id="getbranddata"  multiple="multiple">
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">
                          {{ $brand->name }}
                        </option>
                    @endforeach
                  </select>
                </div>
                <div class="col-1 mt-2">
                    <button class="btn btn-primary mt-4" id="searchallbranddata">Search</button>
                </div>
                <br><br>

            </div>
        </div><!-- br-pagebody -->

        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <div class="row">
                    {{-- set 1 --}}
                    <div class="col-12">

                        <div class="col-12">
                            <div class="row">
                                <div class="col-10"><h4>Brands:</h4></div>
                                <div class="col-2">
                                    <label>Number of Days Left:</label><label id="remainingdays">--</label>
                                </div>
                            </div>
                        </div>
                            <style>
                                .table-dark > tbody > tr > th, .table-dark > tbody > tr > td {
                                    background-color: #ffffff !important;
                                    color: #060708;
                                    border: 0.5px solid #ecececcc !important;
                                }
                            </style>
                            <table id="" class="table-dark table-hover">
                                <thead>
                                    <tr role="row">
                                        <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-sort="ascending" aria-label="First name: activate to sort column descending">Brand</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Target</th>
                                        {{-- second table --}}
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Front</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Back</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Subtoal</th>
                                        {{-- third table --}}
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Fee</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Refund</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Chargeback</th>
                                        {{-- 4 table --}}
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Net Rev</th>
                                        {{-- <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Require/Day</th> --}}
                                        {{-- <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Remaining</th> --}}
                                        {{-- <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Percentage</th>
                                         --}}
                                    </tr>
                                </thead>
                                <tbody id="startingtable">
                                </tbody>
                                <tbody >
                                    <tr>
                                        <td>Total</td>
                                        <td><label id="totaltargte"></label></td>
                                        <td><label id="totalfront"></label></td>
                                        <td><label id="totalback"></label></td>
                                        <td><label id="totalsubtotal"></label></td>
                                        <td><label id="totalfee"></label></td>
                                        <td><label id="totalrefund"></label></td>
                                        <td><label id="totalchargeback"></label></td>
                                        <td><label id="totalnetrevenue"></label></td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                    {{-- end set 1 --}}
                    <div class="col-12">
                        <br><br>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-10"><h4>Agents:</h4></div>
                                    <div class="col-2">
                                    </div>
                                </div>
                            </div>
                            <table id="" class="table-dark table-hover">
                                <thead>
                                    <tr role="row">
                                        <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-sort="ascending" aria-label="First name: activate to sort column descending">Agents Name</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Target</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Revenue</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Front</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Back</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Refund</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Chargeback</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">N. Total</th>
                                        {{-- <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Exp</th> --}}
                                        {{-- <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Net Total</th> --}}
                                    </tr>
                                </thead>
                                <tbody id="employeeTableBody"></tbody>
                                <tbody >
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Total</td>
                                        <td><label id="agentsnettotal"></label></td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>


                    <div class="col-12">
                        <br><br>
                        <div class="row">
                            <div class="col-12 mg-b-15">
                                <div class="row">
                                    {{-- <div class="col-4 mt-3">
                                    </div> --}}
                                    <div class="col-3 mt-3">
                                        <input type="date" class="form-control" required name="date" id="dateforagent">
                                    </div>
                                    <div class="col-3 mt-2">
                                        <button class="btn btn-primary mt-2" id="getdateagentsandbrand">Search</button>
                                    </div>
                                </div>
                                <br><br>
                                </div>

                            <div class="col-6">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-10"><h4>Brand Wise Daily Payment:</h4></div>
                                        <div class="col-2">
                                        </div>
                                    </div>
                                </div>
                                <table id="" class="table-dark table-hover">
                                    <thead>
                                        <tr role="row">
                                            <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-sort="ascending" aria-label="First name: activate to sort column descending">Brand</th>
                                            <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Front</th>
                                            <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Back</th>
                                            <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="brandtodaypayment"></tbody>
                                    <tbody >
                                        <tr>
                                            <td>Total</td>
                                            <td><label id="brandtodayfront"></label></td>
                                            <td><label id="brandtodayback"></label></td>
                                            <td><label id="brandtodaytotal"></label></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div class="col-6">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-10"><h4>Daily Individual Stats:</h4></div>
                                        <div class="col-2">
                                        </div>
                                    </div>
                                </div>
                                <table id="" class="table-dark table-hover">
                                    <thead>
                                        <tr role="row">
                                            <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-sort="ascending" aria-label="First name: activate to sort column descending">Agents Name</th>
                                            <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Revenue</th>
                                            <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="empdailypayment"></tbody>
                                    <tbody >
                                        <tr>
                                            <td></td>
                                            <td>Total</td>
                                            <td><label id="emptodaytotal"></label></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>

                    <div class="col-12">
                        <br><br>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-10"><h4>Dispute & Refund Report:</h4></div>
                                <div class="col-2">
                                </div>
                            </div>
                        </div>
                        <table id="" class="table-dark table-hover">
                            <thead>
                                <tr role="row">
                                    <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-sort="ascending" aria-label="First name: activate to sort column descending">Date</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Brand</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Client Name</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Amount</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Service</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Upseller</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Support</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Type</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Front Person</th>
                                </tr>
                            </thead>
                            <tbody id="dispreftable"></tbody>
                        </table>
                        <br><br>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-10"><h4>Dispute & Refund % Chart:</h4></div>
                                <div class="col-2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div id="refundgraph"></div>
                                    <script type="text/javascript">

                                        function displayArray(chartId, brand_name, brand_ongoing, brand_refund, brand_chargeback) {

                                            google.charts.load('current', {'packages': ['corechart']});


                                            google.charts.setOnLoadCallback(function () {
                                                drawChart(chartId, brand_name, brand_ongoing, brand_refund, brand_chargeback);
                                            });

                                            function drawChart(chartId, brand_name, brand_ongoing, brand_refund, brand_chargeback) {
                                                // console.log(brand_name, brand_ongoing, brand_refund, brand_chargeback);

                                                var data = new google.visualization.DataTable();
                                                data.addColumn('string', 'Category');
                                                data.addColumn('number', 'Percentage');
                                                data.addRows([
                                                    ['Ongoing', parseInt(brand_ongoing)],
                                                    ['Refund', parseInt(brand_refund)],
                                                    ['Chargeback', parseInt(brand_chargeback)]
                                                ]);


                                                var options = {
                                                    'title': brand_name + ' Dispute & Refund % Chart:',
                                                    is3D: true,
                                                    colors: ['green', 'red', 'purple'],
                                                    'width': 500,
                                                    'height': 400
                                                };

                                                var chart = new google.visualization.PieChart(document.getElementById(chartId));
                                                chart.draw(data, options);
                                            }
                                        }


                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <br><br>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-10"><h4>Daily Target Tracking:</h4></div>
                                <div class="col-2">
                                </div>
                            </div>
                        </div>
                        <table id="" class="table-dark table-hover">
                            <thead>
                                <tr role="row">
                                    <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-sort="ascending" aria-label="First name: activate to sort column descending">Date</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Brand</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Front</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Upsell</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Renewal</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Aggregated Sales</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Target</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Daily Target</th>
                                </tr>
                            </thead>
                            <tbody id="dailytargtesales"></tbody>
                            {{-- <tbody>
                                <tr role="row" class="odd">
                                    <td tabindex="0" class="sorting_1">abc</td>
                                    <td>00</td>
                                    <td>00</td>
                                    <td>00</td>
                                    <td>00</td>
                                    <td>00</td>
                                    <td>00</td>

                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>00</td>
                                    <td>00</td>
                                    <td>00</td>
                                    <td>00</td>
                                    <td>00</td>
                                    <td>00</td>
                                </tr>
                            </tbody> --}}
                        </table>
                        <br><br>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-10"><h4>Target Chasing Graph:</h4></div>
                                <div class="col-2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div id="linechart_material"></div>
                                    <script type="text/javascript">
                                        function displayforeast(chartId, brandData, brandName) {
                                            google.charts.load('current', {'packages':['line']});

                                            google.charts.setOnLoadCallback(function () {
                                                drawChart(chartId, brandData, brandName);
                                            });

                                            function drawChart(chartId, brandData, brandName) {
                                                var data = new google.visualization.DataTable();
                                                data.addColumn('string', 'Date');
                                                data.addColumn('number', 'Revenue');
                                                data.addColumn('number', 'Forecast');
                                                data.addColumn('number', 'Target');

                                                // Convert brand data to rows
                                                let rows = [];
                                                Object.keys(brandData).forEach(date => {
                                                    let rowData = brandData[date];
                                                    rows.push([date, rowData.revenue, rowData.revenueforeast, rowData.Target]);
                                                });
                                                data.addRows(rows);

                                                var options = {
                                                    'title': brandName + ' Target Chasing Graph:',
                                                    // colors: ['green', 'red', 'purple'],
                                                    width: 900,
                                                    height: 500
                                                };

                                                var chart = new google.charts.Line(document.getElementById(chartId));
                                                chart.draw(data, google.charts.Line.convertOptions(options));
                                            }
                                        }
                                    </script>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-12">
                        <br><br>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-10"><h4>Sales Distribution Chart:</h4></div>
                                <div class="col-2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div id="salesgraph"></div>
                                    <script type="text/javascript">

                                        function salesArray(chartId, brand_name, brand_renewal, brand_upsell, brand_newlead) {

                                            google.charts.load('current', {'packages': ['corechart']});


                                            google.charts.setOnLoadCallback(function () {
                                                drawChart(chartId, brand_name, brand_renewal, brand_upsell, brand_newlead);
                                            });

                                            function drawChart(chartId, brand_name, brand_renewal, brand_upsell, brand_newlead) {
                                                // console.log(brand_name,  brand_name, brand_renewal, brand_upsell, brand_newlead);

                                                var data = new google.visualization.DataTable();
                                                data.addColumn('string', 'Category');
                                                data.addColumn('number', 'Percentage');
                                                data.addRows([
                                                    ['Renewal', parseInt(brand_renewal)],
                                                    ['Upsell', parseInt(brand_upsell)],
                                                    ['New Lead', parseInt(brand_newlead)]
                                                ]);


                                                var options = {
                                                    'title': brand_name + ' Sales Distribution Chart:',
                                                    is3D: true,
                                                    colors: ['green', 'red', 'purple'],
                                                    'width': 500,
                                                    'height': 400
                                                };

                                                var chart = new google.visualization.PieChart(document.getElementById(chartId));
                                                chart.draw(data, options);
                                            }
                                        }


                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mg-b-15">
                        <br><br>
                        <div class="card bd-gray-400 pd-20">
                            <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15">Sales Team Target Monitoring:</h6>
                            {{-- <style>
                                .table-dark > tbody > tr > th, .table-dark > tbody > tr > td {
                                    background-color: #ffffff !important;
                                    color: #060708;
                                    border: 0.5px solid #ecececcc !important;
                                }
                            </style> --}}
                            <table id="" class=" ">
                                <thead>
                                  <tr role="row">
                                    <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="First name: activate to sort column descending">Team</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Target</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Front</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Back</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Refund</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Net</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Team Net</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Team Target</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Achieved</th>
                                  </tr>
                                </thead>
                                <tbody id="#">
                                    @foreach ($mainsalesTeam as $mainsalesTeams)
                                    @php
                                    $a = $mainsalesTeams['totalteamtarget'];
                                    $b = $mainsalesTeams['totalteamnet'];
                                    $c = $mainsalesTeams['totalteamtarget'] - $mainsalesTeams['totalteamnet'];
                                    @endphp
                                    <tr role="row" class="table-success">
                                        <td tabindex="0" class="sorting_1">{{$mainsalesTeams['leadID']}}</td>
                                        <td>${{$mainsalesTeams['leadtarget']}}</td>
                                        <td>${{$mainsalesTeams['leadfront']}}</td>
                                        <td>${{$mainsalesTeams['leadback']}}</td>
                                        <td>${{$mainsalesTeams['leadrefund']}}</td>
                                        <td>${{$mainsalesTeams['leadnet']}}</td>
                                        <td>${{$mainsalesTeams['totalteamtarget']}}</td>
                                        <td>${{$mainsalesTeams['totalteamnet']}}</td>
                                        <td>${{$c}}</td>
                                    </tr>
                                    @php
                                        $member = $mainsalesTeams['membersdata'];
                                    @endphp

                                    @foreach($member  as $dm)
                                    <tr role="row" >
                                        <td tabindex="0" class="sorting_1">{{$dm['memberID']}}</td>
                                        <td>${{$dm['membertarget']}}</td>
                                        <td>${{$dm['memberfront']}}</td>
                                        <td>${{$dm['memberback']}}</td>
                                        <td>${{$dm['memberrefund']}}</td>
                                        <td>${{$dm['membernet']}}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @endforeach

                                    @endforeach
                                </tbody>
                            </table>

                        </div><!-- card -->
                    </div><!-- col-4 -->

                    {{-- base end --}}
                </div>
            </div>
        </div>



        <script>
            $(document).ready(function () {


                $("#searchallbranddata").click(function(event){
                    event.preventDefault();
                    let brandID = $("#getbranddata");
                    let monthID = $("#getmonth");
                    let yearID = $("#getyeardata");
                    $.ajax({
                            url:"/api/fetch-Allbranddata",
                            type:"get",
                            data:{
                                "brand_id":brandID.val(),
                                "month_id":monthID.val(),
                                "year_id":yearID.val()
                            },
                            beforeSend:(()=>{
                                brandID.attr('disabled','disabled');
                                monthID.attr('disabled','disabled');
                                yearID.attr('disabled','disabled');
                                $("#searchallbranddata").text("wait...");
                                $("#searchallbranddata").attr('disabled','disabled');
                            }),
                            success:((Response)=>{
                                console.log(Response);

                                    let brandrev = Response.netrevenue;
                                    let mytableBody = document.getElementById('startingtable');
                                    mytableBody.innerHTML = '';
                                    let totaltarget = [];
                                    let totalfront1 = [];
                                    let totalback1 = [];
                                    let totalfrontback1 = [];
                                    let totalfrontfee1 = [];
                                    let totalrefund1 = [];
                                    let totalcb1 = [];
                                    let totalnetrevenue1 = [];

                                    brandrev.forEach(brandrevs => {

                                        let rowbrand = document.createElement('tr');

                                        let brandname = document.createElement('td');
                                        brandname.textContent = brandrevs.name;
                                        rowbrand.appendChild(brandname);

                                        let brandtarget = document.createElement('td');
                                        let o = brandrevs.brandtarget;
                                        let p = (o !== 0) ? o : "";
                                        brandtarget.textContent = p;
                                        rowbrand.appendChild(brandtarget);

                                        let totalfront = document.createElement('td');
                                        let a = brandrevs.totalfront;
                                        let b = (a !== 0) ? a : "";
                                        totalfront.textContent = b;
                                        rowbrand.appendChild(totalfront);

                                        let totalback = document.createElement('td');
                                        let c = brandrevs.totalback;
                                        let d = (c !== 0) ? c : "";
                                        totalback.textContent = d;
                                        rowbrand.appendChild(totalback);

                                        let frontBacksum = document.createElement('td');
                                        let e = brandrevs.brandsales;
                                        let f = (e !== 0) ? e : "";
                                        frontBacksum.textContent = f;
                                        rowbrand.appendChild(frontBacksum);

                                        let disputefees = document.createElement('td');
                                        let g = brandrevs.disputefees;
                                        let h = (g !== 0) ? g : "";
                                        disputefees.textContent = h;
                                        rowbrand.appendChild(disputefees);

                                        let refund = document.createElement('td');
                                        let i = brandrevs.refund;
                                        let j = (i !== 0) ? i : "";
                                        refund.textContent = j;
                                        rowbrand.appendChild(refund);

                                        let dispute = document.createElement('td');
                                        let k = brandrevs.dispute;
                                        let l = (k !== 0) ? k : "";
                                        dispute.textContent = l;
                                        rowbrand.appendChild(dispute);

                                        let net_revenue = document.createElement('td');
                                        let m = brandrevs.net_revenue;
                                        let n = (m !== 0) ? m : "";
                                        net_revenue.textContent = n;
                                        rowbrand.appendChild(net_revenue);


                                        totaltarget.push(parseFloat(brandrevs.brandtarget));
                                        totalfront1.push(parseFloat(brandrevs.totalfront));
                                        totalback1.push(parseFloat(brandrevs.totalback));
                                        totalfrontback1.push(parseFloat(brandrevs.frontBacksum));
                                        totalfrontfee1.push(parseFloat(brandrevs.disputefees));
                                        totalrefund1.push(parseFloat(brandrevs.refund));
                                        totalcb1.push(parseFloat(brandrevs.dispute));
                                        totalnetrevenue1.push(parseFloat(brandrevs.net_revenue));

                                        mytableBody.appendChild(rowbrand);

                                    });

                                    let sumBrandtarget = totaltarget.reduce((acc, curr) => acc + curr, 0);
                                    let q = (sumBrandtarget !== 0) ? sumBrandtarget : "";
                                    document.getElementById("totaltargte").innerHTML = q;
                                    //----------------------------------------------------------------

                                    let sumBrandfront = totalfront1.reduce((acc, curr) => acc + curr, 0);
                                    let r = (sumBrandfront !== 0) ? sumBrandfront : "";
                                    document.getElementById("totalfront").innerHTML = r;
                                    //----------------------------------------------------------------

                                    let sumBrandback = totalback1.reduce((acc, curr) => acc + curr, 0);
                                    let s = (sumBrandback !== 0) ? sumBrandback : "";
                                    document.getElementById("totalback").innerHTML = s;
                                    //----------------------------------------------------------------

                                    let sumBrandfrontback = totalfrontback1.reduce((acc, curr) => acc + curr, 0);
                                    let t = (sumBrandfrontback !== 0) ? sumBrandfrontback : "";
                                    document.getElementById("totalsubtotal").innerHTML = t;
                                    //----------------------------------------------------------------

                                    let sumBrandfees = totalfrontfee1.reduce((acc, curr) => acc + curr, 0);
                                    let u = (sumBrandfees !== 0) ? sumBrandfees : "";
                                    document.getElementById("totalfee").innerHTML = u;
                                    //----------------------------------------------------------------

                                    let sumBrandrefund = totalrefund1.reduce((acc, curr) => acc + curr, 0);
                                    let v = (sumBrandrefund !== 0) ? sumBrandrefund : "";
                                    document.getElementById("totalrefund").innerHTML = v;
                                    //----------------------------------------------------------------

                                    let sumBrandcb = totalcb1.reduce((acc, curr) => acc + curr, 0);
                                    let w = (sumBrandcb !== 0) ? sumBrandcb : "";
                                    document.getElementById("totalchargeback").innerHTML = w;
                                    //----------------------------------------------------------------

                                    let sumBrandnetrevenue = totalnetrevenue1.reduce((acc, curr) => acc + curr, 0);
                                    let x = (sumBrandnetrevenue !== 0) ? sumBrandnetrevenue : "";
                                    document.getElementById("totalnetrevenue").innerHTML = x;
                                    //----------------------------------------------------------------





                                    let employees = Response.emppaymentarray;
                                    let tableBody = document.getElementById('employeeTableBody');
                                    tableBody.innerHTML = '';
                                    let agentsnettotal1 = [];

                                    employees.forEach(employee => {

                                        if(employee){
                                            let row = document.createElement('tr');

                                        let agentname = document.createElement('td');
                                        agentname.textContent = employee.name;
                                        row.appendChild(agentname);

                                        let target = document.createElement('td');
                                        let aa = employee.agenttarget;
                                        let bb = (aa !== 0) ? aa : "";
                                        target.textContent = bb;
                                        row.appendChild(target);

                                        let revenue = document.createElement('td');
                                        let cc = employee.getcompletesum;
                                        let dd = (cc !== 0) ? cc : "";
                                        revenue.textContent = dd;
                                        row.appendChild(revenue);

                                        let front = document.createElement('td');
                                        let ee = employee.getfrontsum;
                                        let ff = (ee !== 0) ? ee : "";
                                        front.textContent = ff;
                                        row.appendChild(front);

                                        let back = document.createElement('td');
                                        let gg = employee.getbacksum;
                                        let hh = (gg !== 0) ? gg : "";
                                        back.textContent = hh;
                                        row.appendChild(back);

                                        let refund = document.createElement('td');
                                        let ii = employee.refund;
                                        let jj = (ii !== 0) ? ii : "";
                                        refund.textContent = jj;
                                        row.appendChild(refund);

                                        let chargeback = document.createElement('td');
                                        let kk = employee.dispute;
                                        let ll = (kk !==0) ? kk : "";
                                        chargeback.textContent = ll;
                                        row.appendChild(chargeback);

                                        let ntotal = document.createElement('td');
                                        let mm = employee.getcompletesum - employee.refund;
                                        let nn = (mm !==0) ? mm : "";
                                        ntotal.textContent = nn;
                                        row.appendChild(ntotal);

                                        agentsnettotal1.push(parseFloat(employee.getcompletesum - employee.refund));

                                        tableBody.appendChild(row);

                                        }

                                    });

                                    let sumagentstotal = agentsnettotal1.reduce((acc, curr) => acc + curr, 0);
                                    let y = (sumagentstotal !== 0) ? sumagentstotal : "";
                                    document.getElementById("agentsnettotal").innerHTML = y;
                                    //----------------------------------------------------------------


                                    let branddata = Response.brandtoday;
                                    let brandtodaypayment = document.getElementById('brandtodaypayment');
                                    brandtodaypayment.innerHTML = ''; // Clear existing table content
                                    let brandtodayfront1 = [];
                                    let brandtodayback1 = [];
                                    let brandtodaytotaloftotal1 = [];

                                    // Populate brand data into the table
                                    branddata.forEach(branddatas => {
                                        if(branddatas){
                                            if(branddatas.front != 0 ||  branddatas.back != 0){
                                            let row1 = document.createElement('tr');

                                        // Create and append brand name cell
                                        let brandname = document.createElement('td');
                                        brandname.textContent = branddatas.name;
                                        row1.appendChild(brandname);

                                        // Create and append today's front payment cell
                                        let brandtodayfront = document.createElement('td');
                                        let oo = branddatas.front;
                                        let pp = (oo !==0) ? oo : "";
                                        brandtodayfront.textContent = pp;
                                        row1.appendChild(brandtodayfront);

                                        // Create and append today's back payment cell
                                        let brandtodayback = document.createElement('td');
                                        let qq = branddatas.back;
                                        let rr = (qq !==0) ? qq : "";
                                        brandtodayback.textContent = rr;
                                        row1.appendChild(brandtodayback);

                                        // Create and append total payment cell
                                        let brandtotal = document.createElement('td');
                                        let ss = branddatas.all;
                                        let tt = (ss !==0) ? ss : "";
                                        brandtotal.textContent = tt;
                                        row1.appendChild(brandtotal);

                                        brandtodayfront1.push(parseFloat(branddatas.front));
                                        brandtodayback1.push(parseFloat(branddatas.back));
                                        brandtodaytotaloftotal1.push(parseFloat(branddatas.all));

                                        // Append the row to the table
                                        brandtodaypayment.appendChild(row1);

                                        }}

                                    });

                                    let sumBrandtodayfront = brandtodayfront1.reduce((acc, curr) => acc + curr, 0);
                                    let uu = (sumBrandtodayfront !== 0) ? sumBrandtodayfront : "";
                                    document.getElementById("brandtodayfront").innerHTML = uu;
                                    //----------------------------------------------------------------

                                    let sumBrandtodayback = brandtodayback1.reduce((acc, curr) => acc + curr, 0);
                                    let vv = (sumBrandtodayback !== 0) ? sumBrandtodayback : "";
                                    document.getElementById("brandtodayback").innerHTML = vv;
                                    //----------------------------------------------------------------

                                    let sumBrandtodayallofall = brandtodaytotaloftotal1.reduce((acc, curr) => acc + curr, 0);
                                    let ww = (sumBrandtodayallofall !== 0) ? sumBrandtodayallofall : "";
                                    document.getElementById("brandtodaytotal").innerHTML = ww;
                                    //----------------------------------------------------------------



                                        let emptodaysdata = Response.emptodayspayment;
                                        let emptodaypayment = document.getElementById('empdailypayment');
                                        emptodaypayment.innerHTML = '';
                                        let emptodaytotaloftotal1 = [];

                                    emptodaysdata.forEach(emptodaysdatas => {
                                        if(emptodaysdatas){
                                            if(emptodaysdatas.allrevenue != 0 ||  emptodaysdatas.allrevenue != 0){
                                            let row2 = document.createElement('tr');

                                            let empname = document.createElement('td');
                                            empname.textContent = emptodaysdatas.name;
                                            row2.appendChild(empname);

                                            let emptoday = document.createElement('td');
                                            let a1 = emptodaysdatas.allrevenue;
                                            let a2 = (a1 !==0) ? a1 : "";
                                            emptoday.textContent = a2;
                                            row2.appendChild(emptoday);

                                            let emptotal = document.createElement('td');
                                            let a3 =  emptodaysdatas.allrevenue;
                                            let a4 = (a3 !==0) ? a3 : "";
                                            emptotal.textContent = a4;
                                            row2.appendChild(emptotal);

                                            emptodaytotaloftotal1.push(parseFloat(emptodaysdatas.allrevenue));

                                            emptodaypayment.appendChild(row2);

                                        }}

                                    });

                                    let sumemptodayallofall = emptodaytotaloftotal1.reduce((acc, curr) => acc + curr, 0);
                                    let xx = (sumemptodayallofall !== 0) ? sumemptodayallofall : "";
                                    document.getElementById("emptodaytotal").innerHTML = xx;
                                    //----------------------------------------------------------------


                                    let disputerefunddata = Response.chargebacks;
                                        let disputetable = document.getElementById('dispreftable');
                                        disputetable.innerHTML = '';
                                        let branddispref1 = [];

                                    let totalAmount = 0;

                                    disputerefunddata.forEach(disputerefunddatas => {

                                    if(disputerefunddatas['chargebacks'][0].date != '--'){

                                        let row3 = document.createElement('tr');

                                        let disputedate = document.createElement('td');
                                        disputedate.textContent = disputerefunddatas['chargebacks'][0].date;
                                        row3.appendChild(disputedate);

                                        let disputebrand = document.createElement('td');
                                        disputebrand.textContent = disputerefunddatas['chargebacks'][0].brand;
                                        row3.appendChild(disputebrand);

                                        let disputeclient = document.createElement('td');
                                        disputeclient.textContent = disputerefunddatas['chargebacks'][0].client;
                                        row3.appendChild(disputeclient);

                                        let disputeamount = document.createElement('td');
                                        disputeamount.textContent = disputerefunddatas['chargebacks'][0].amount;
                                        row3.appendChild(disputeamount);

                                        let disputeservices = document.createElement('td');
                                        disputeservices.textContent = disputerefunddatas['chargebacks'][0].services;
                                        row3.appendChild(disputeservices);

                                        let disputeupseller = document.createElement('td');
                                        disputeupseller.textContent = disputerefunddatas['chargebacks'][0].upseller;
                                        row3.appendChild(disputeupseller);

                                        let disputesupport = document.createElement('td');
                                        disputesupport.textContent = disputerefunddatas['chargebacks'][0].support;
                                        row3.appendChild(disputesupport);

                                        let disputetype = document.createElement('td');
                                        disputetype.textContent = disputerefunddatas['chargebacks'][0].type;
                                        row3.appendChild(disputetype);

                                        let disputefrontperson = document.createElement('td');
                                        disputefrontperson.textContent = disputerefunddatas['chargebacks'][0].frontperson;
                                        row3.appendChild(disputefrontperson);

                                        disputetable.appendChild(row3);

                                    }else{

                                    }

                                    });

                                    let dailytarget = Response.days;


                                        let dailytargtesales = document.getElementById('dailytargtesales');
                                        dailytargtesales.innerHTML = '';

                                        for (let i = 0; i < dailytarget[0].data.length; i++) {
                                            dailytarget.forEach(dailytargets => {

                                                if( dailytargets.date != 'nothing'){
                                                let rowsales = document.createElement('tr');

                                                let date = document.createElement('td');
                                                date.textContent = dailytargets.date;
                                                rowsales.appendChild(date);

                                                let brand = document.createElement('td');
                                                brand.textContent = dailytargets.data[i].brand;
                                                rowsales.appendChild(brand);

                                                let front = document.createElement('td');
                                                let a4 =  dailytargets.data[i].front;
                                                let a5 = (a4 !==0) ? a4 : "";
                                                front.textContent = a5;
                                                rowsales.appendChild(front);

                                                let upsell = document.createElement('td');
                                                let a6 =  dailytargets.data[i].upsell;
                                                let a7 = (a6 !==0) ? a6 : "";
                                                upsell.textContent = a7;
                                                rowsales.appendChild(upsell);

                                                let renewal = document.createElement('td');
                                                let a8 =  dailytargets.data[i].renewal;
                                                let a9 = (a8 !==0) ? a8 : "";
                                                renewal.textContent = a9;
                                                rowsales.appendChild(renewal);

                                                let agregatesales = document.createElement('td');
                                                let a10 =  dailytargets.data[i].Aggregated_Sales;
                                                let a11 = (a10 !==0) ? a10 : "";
                                                agregatesales.textContent = a11;
                                                rowsales.appendChild(agregatesales);

                                                let target = document.createElement('td');
                                                let a12 =  dailytargets.data[i].Target;
                                                let a13 = (a12 !==0) ? a12 : "";
                                                target.textContent = a13;
                                                rowsales.appendChild(target);

                                                let dailytargetCell = document.createElement('td');
                                                let aa1 = dailytargets.data[i].Daily_Target;
                                                let aa2 = (parseInt(aa1) !== 0) ? aa1 : "-";
                                                dailytargetCell.textContent = aa2;
                                                rowsales.appendChild(dailytargetCell);

                                                dailytargtesales.appendChild(rowsales);


                                                }


                                            });

                                        //     dailytarget.forEach(dailytargets => {
                                        //     if( dailytargets.date != 'nothing'){
                                        //     let emptyRow = document.createElement('tr');
                                        //     let emptyCell = document.createElement('td');
                                        //     emptyCell.setAttribute('colspan', '8');
                                        //     emptyCell.innerHTML = '&nbsp;';
                                        //     emptyRow.appendChild(emptyCell);
                                        //     dailytargtesales.appendChild(emptyRow);
                                        // }

                                        // });
                                        }






                                    let refundgraph = Response.disputegraph;
                                    let refunddisputegraph = document.getElementById('refundgraph');
                                    refunddisputegraph.innerHTML = '';

                                    refundgraph.forEach((refundgraphs, index) => {
                                        let brand_name = refundgraphs.name;
                                        let brand_ongoing = refundgraphs.brand_ongoing;
                                        let brand_refund = refundgraphs.brand_refund;
                                        let brand_chargeback = refundgraphs.brand_chargeback;

                                        let chartId = 'chart_div' + index;
                                        let chartDiv = document.createElement('div');
                                        chartDiv.id = chartId;
                                        chartDiv.style.marginBottom = '30px';
                                        refunddisputegraph.appendChild(chartDiv);

                                        displayArray(chartId, brand_name, brand_ongoing, brand_refund, brand_chargeback);
                                    });


                                    let salesdistribution = Response.salesgraph;
                                    let salesgraph = document.getElementById('salesgraph');
                                    salesgraph.innerHTML = '';

                                    salesdistribution.forEach((salesdistributions, index) => {
                                        let brand_name = salesdistributions.name;
                                        let brand_renewal = salesdistributions.brand_renewal;
                                        let brand_upsell = salesdistributions.brand_upsell;
                                        let brand_newlead = salesdistributions.brand_newlead;

                                        let chartId = 'chart_div1' + index;
                                        let chartDiv = document.createElement('div');
                                        chartDiv.id = chartId;
                                        chartDiv.style.marginBottom = '30px';
                                        salesgraph.appendChild(chartDiv);

                                        salesArray(chartId, brand_name, brand_renewal, brand_upsell, brand_newlead);
                                    });

                                        let salestargetgraph = Response.targetchasingraph;

                                            let linechart_material = document.getElementById('linechart_material');
                                            linechart_material.innerHTML = '';

                                            // Loop through each brand's data
                                            Object.keys(salestargetgraph).forEach(brandName => {
                                                let brandData = salestargetgraph[brandName];

                                                // Create a chart div for each brand
                                                let chartDiv = document.createElement('div');
                                                let chartId = 'chart_div_' + brandName.replace(/\s/g, "_");
                                                chartDiv.id = chartId;
                                                chartDiv.style.marginBottom = '30px';
                                                linechart_material.appendChild(chartDiv);

                                                // Call displayforeast function for each brand's data
                                                displayforeast(chartId, brandData, brandName);
                                            });


                                    let remainingdys =  Response.remainingworkingdays;
                                    document.getElementById("remainingdays").innerHTML = remainingdys;

                                    brandID.removeAttr('disabled');
                                    monthID.removeAttr('disabled');
                                    yearID.removeAttr('disabled');
                                    $("#searchallbranddata").text("Search");
                                    $("#searchallbranddata").removeAttr('disabled');


                            }
                        ),
                            error:((error)=>{
                                console.log(error);
                                alert("Error Found Please Referesh Page And Try Again !")

                                brandID.removeAttr('disabled');
                                monthID.removeAttr('disabled');
                                yearID.removeAttr('disabled');
                                $("#searchallbranddata").text("Search");
                                $("#searchallbranddata").removeAttr('disabled');
                            })

                    });
                });

                $("#getdateagentsandbrand").click(function(event){
                    event.preventDefault();
                    let Date = $("#dateforagent");
                    $.ajax({
                            url:"/api/fetch-datewisedata",
                            type:"get",
                            data:{
                                "date_id":Date.val(),
                            },
                            beforeSend:(()=>{
                                Date.attr('disabled','disabled');
                                $("#getdateagentsandbrand").text("wait...");
                                $("#getdateagentsandbrand").attr('disabled','disabled');
                            }),
                            success:((Response)=>{
                                console.log(Response);

                               // Retrieve brand data and table element
                                let branddata = Response.branddata;
                                let brandtodaypayment = document.getElementById('brandtodaypayment');
                                brandtodaypayment.innerHTML = ''; // Clear existing table content
                                let brandtodayfront1 = [];
                                    let brandtodayback1 = [];
                                    let brandtodaytotaloftotal1 = [];

                                // Populate brand data into the table
                                branddata.forEach(branddatas => {
                                    let row1 = document.createElement('tr');

                                    // Create and append brand name cell
                                    let brandname = document.createElement('td');
                                    brandname.textContent = branddatas.name;
                                    row1.appendChild(brandname);

                                    // Create and append today's front payment cell
                                    let brandtodayfront = document.createElement('td');
                                    brandtodayfront.textContent = branddatas.front;
                                    row1.appendChild(brandtodayfront);

                                    // Create and append today's back payment cell
                                    let brandtodayback = document.createElement('td');
                                    brandtodayback.textContent = branddatas.back;
                                    row1.appendChild(brandtodayback);

                                    // Create and append total payment cell
                                    let brandtotal = document.createElement('td');
                                    brandtotal.textContent = branddatas.all;
                                    row1.appendChild(brandtotal);

                                    brandtodayfront1.push(parseFloat(branddatas.front));
                                        brandtodayback1.push(parseFloat(branddatas.back));
                                        brandtodaytotaloftotal1.push(parseFloat(branddatas.all));

                                    // Append the row to the table
                                    brandtodaypayment.appendChild(row1);
                                });

                                let sumBrandtodayfront = brandtodayfront1.reduce((acc, curr) => acc + curr, 0);
                                    document.getElementById("brandtodayfront").innerHTML = sumBrandtodayfront;
                                    //----------------------------------------------------------------

                                    let sumBrandtodayback = brandtodayback1.reduce((acc, curr) => acc + curr, 0);
                                    document.getElementById("brandtodayback").innerHTML = sumBrandtodayback;
                                    //----------------------------------------------------------------

                                    let sumBrandtodayallofall = brandtodaytotaloftotal1.reduce((acc, curr) => acc + curr, 0);
                                    document.getElementById("brandtodaytotal").innerHTML = sumBrandtodayallofall;
                                    //----------------------------------------------------------------

                                // Retrieve employee data and table element
                                let emptodaysdata = Response.employees;
                                let emptodaypayment = document.getElementById('empdailypayment');
                                emptodaypayment.innerHTML = ''; // Clear existing table content
                                let emptodaytotaloftotal1 = [];

                                // Populate employee data into the table
                                emptodaysdata.forEach(emptodaysdatas => {
                                    let row2 = document.createElement('tr');

                                    // Create and append employee name cell
                                    let empname = document.createElement('td');
                                    empname.textContent = emptodaysdatas.name;
                                    row2.appendChild(empname);

                                    // Create and append today's revenue cell
                                    let emptoday = document.createElement('td');
                                    emptoday.textContent = emptodaysdatas.allrevenue;
                                    row2.appendChild(emptoday);

                                    // Create and append total revenue cell
                                    let emptotal = document.createElement('td');
                                    emptotal.textContent = emptodaysdatas.allrevenue;
                                    row2.appendChild(emptotal);

                                    emptodaytotaloftotal1.push(parseFloat(emptodaysdatas.allrevenue));

                                    // Append the row to the table
                                    emptodaypayment.appendChild(row2);
                                });

                                let sumemptodayallofall = emptodaytotaloftotal1.reduce((acc, curr) => acc + curr, 0);
                                    document.getElementById("emptodaytotal").innerHTML = sumemptodayallofall;
                                    //----------------------------------------------------------------



                                Date.removeAttr('disabled');
                                $("#getdateagentsandbrand").text("Search");
                                $("#getdateagentsandbrand").removeAttr('disabled');


                            }),
                            error:((error)=>{
                                console.log(error);
                                alert("Error Found Please Referesh Window And Try Again !")

                                Date.removeAttr('disabled');
                                $("#getdateagentsandbrand").text("Search");
                                $("#getdateagentsandbrand").removeAttr('disabled');
                            })

                    });
                });


            });
        </script>








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
