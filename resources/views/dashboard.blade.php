{{-- @extends('layouts.app')

@section('maincontent') --}}
@extends($theme == 1 ? 'layouts.darktheme' : 'layouts.app')

@section($theme == 1 ? 'maincontent1' : 'maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <div class="br-mainpanel">
            <div class="br-pagetitle">
              <i class="icon ion-ios-home-outline tx-70 lh-0"></i>
              <div>
                <h4>Dashboard</h4>
                <p class="mg-b-0">Do bigger things with Crystal Pro.</p>
              </div>
            </div><!-- d-flex -->

            <div class="br-pagebody">
                <!-- hidden on purpose using d-none class to have a different look with the original -->
                <!-- feel free to unhide by removing the d-none class below -->
@if ($superUser == 0 || $departmentAccess[0]->access == 0 )
{{-- @if ($superUser == 0 ) --}}
{{-- @elseif ($superUser != 0 & $departmentAccess[0]->access == 0 ) --}}
                <div class="row row-sm mg-b-20 d-none">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-info rounded overflow-hidden">
                            <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                            <i class="ion ion-earth tx-60 lh-0 tx-white op-7"></i>
                            <div class="mg-l-20">
                                <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Today's Visits</p>
                                <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">1,975,224</p>
                                <span class="tx-11 tx-roboto tx-white-8">24% higher yesterday</span>
                            </div>
                            </div>
                            <div id="ch1" class="ht-50 tr-y-1"></div>
                        </div>
                    </div><!-- col-3 -->
                    <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
                    <div class="bg-purple rounded overflow-hidden">
                        <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-bag tx-60 lh-0 tx-white op-7"></i>
                        <div class="mg-l-20">
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Today Sales</p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">$329,291</p>
                            <span class="tx-11 tx-roboto tx-white-8">$390,212 before tax</span>
                        </div>
                        </div>
                        <div id="ch3" class="ht-50 tr-y-1"></div>
                    </div>
                    </div><!-- col-3 -->
                    <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                    <div class="bg-teal rounded overflow-hidden">
                        <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-monitor tx-60 lh-0 tx-white op-7"></i>
                        <div class="mg-l-20">
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">% Unique Visits</p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">54.45%</p>
                            <span class="tx-11 tx-roboto tx-white-8">23% average duration</span>
                        </div>
                        </div>
                        <div id="ch2" class="ht-50 tr-y-1"></div>
                    </div>
                    </div><!-- col-3 -->
                    <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                    <div class="bg-primary rounded overflow-hidden">
                        <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-clock tx-60 lh-0 tx-white op-7"></i>
                        <div class="mg-l-20">
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Bounce Rate</p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">32.16%</p>
                            <span class="tx-11 tx-roboto tx-white-8">65.45% on average time</span>
                        </div>
                        </div>
                        <div id="ch4" class="ht-50 tr-y-1"></div>
                    </div>
                    </div><!-- col-3 -->
                </div><!-- row -->

                <div class="row row-sm">
                    @foreach ($eachPersonqaform as $item)

                    <div class="col-3 mg-b-15">
                        <div class="card bd-gray-400 pd-20">
                            <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15"><a href="/userprofile/{{$item[0][0]->id}}">{{$item[0][0]->name}}</a></h6>
                            <div class="d-flex mg-b-10">
                            <div class="bd-r pd-r-10">
                                <label class="tx-12">Total Client</label>
                                @if ($theme == 1)
                                <p class="tx-lato tx-inverse tx-bold" style="color: white">{{$item[1]}}</p>
                                @else
                                <p class="tx-lato tx-inverse tx-bold">{{$item[1]}}</p>
                                @endif

                            </div>
                            <div class="bd-r pd-x-10">
                                <label class="tx-12">Today Forms</label>
                                @if ($theme == 1)
                                <p class="tx-lato tx-inverse tx-bold" style="color: white">{{$item[2]}}</p>
                                @else
                                <p class="tx-lato tx-inverse tx-bold">{{$item[2]}}</p>
                                @endif


                            </div>
                            <div class="bd-r pd-x-10">
                                <label class="tx-12">Month Refund</label>
                                @if ($theme == 1)
                                <p class="tx-lato tx-inverse tx-bold" style="color: white">{{$item[4]}}</p>
                                @else
                                <p class="tx-lato tx-inverse tx-bold">{{$item[4]}}</p>
                                @endif


                            </div>
                            <div class="pd-l-10">
                                <label class="tx-12">Month Dispute</label>
                                @if ($theme == 1)
                                <p class="tx-lato tx-inverse tx-bold" style="color: white">{{$item[3]}}</p>
                                @else
                                <p class="tx-lato tx-inverse tx-bold">{{$item[3]}}</p>
                                @endif

                            </div>
                        </div><!-- d-flex -->
                        <div class="progress mg-b-10">
                            <div class="progress-bar bg-info wd-100p" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div><!-- card -->
                        </div><!-- col-4 -->

                    @endforeach

                </div><!-- row -->

                <div class="row row-sm mg-t-20">

                    @foreach ($eachbranddatas as $eachbranddata)
                        <div class="col-3 mg-b-15">
                        <div class="card bd-gray-400 pd-20">

                            @if ($theme == 1)
                            <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15" style="color: white">{{$eachbranddata[0][0]->name}}</h6>
                                @else
                                <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15">{{$eachbranddata[0][0]->name}}</h6>
                                @endif
                            <div class="d-flex mg-b-10">
                            <div class="bd-r pd-r-10">
                                <label class="tx-12">Clients</label>
                                @if ($theme == 1)
                                <p class="tx-lato tx-inverse tx-bold" style="color: white">{{$eachbranddata[1]}}</p>
                                @else
                                <p class="tx-lato tx-inverse tx-bold">{{$eachbranddata[1]}}</p>
                                @endif
                            </div>
                            <div class="bd-r pd-x-10">
                                <label class="tx-12">M.Refund</label>
                                @if ($theme == 1)
                                <p class="tx-lato tx-inverse tx-bold" style="color: white">{{$eachbranddata[2]}}</p>
                                @else
                                <p class="tx-lato tx-inverse tx-bold">{{$eachbranddata[2]}}</p>
                                @endif

                            </div>
                            <div class="pd-l-10">
                                <label class="tx-12">M.Dispute</label>
                                @if ($theme == 1)
                                <p class="tx-lato tx-inverse tx-bold" style="color: white">{{$eachbranddata[3]}}</p>
                                @else
                                <p class="tx-lato tx-inverse tx-bold">{{$eachbranddata[3]}}</p>
                                @endif

                            </div>
                            </div><!-- d-flex -->
                            <div class="progress mg-b-10">
                                <div class="progress-bar bg-purple wd-100p" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div><!-- card -->
                    </div><!-- col-4 -->
                    @endforeach
                </div><!-- row -->


                <div class="row row-sm mg-t-20">
                    <div class="col-lg-8">

                        <div class="row">

                            <div class="col-6">
                                @if ($last5qaformstatus > 0)
                                <div class="card bd-0 mg-t-20">
                                    <div id="carousel12" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#carousel12" data-slide-to="0" class="active"></li>
                                        <li data-target="#carousel12" data-slide-to="1"></li>
                                        <li data-target="#carousel12" data-slide-to="2"></li>
                                    </ol>
                                    <div class="carousel-inner" role="listbox">

                                        @foreach ($last5qaform as $item)

                                        @if ($item == $last5qaform[0])

                                        <div class="carousel-item active">
                                            <div class="bg-br-primary pd-30 ht-300 pos-relative d-flex align-items-center rounded">
                                                <div class="tx-white">
                                                <p class="tx-uppercase tx-11 tx-semibold tx-mont tx-spacing-2 tx-white-5">Client: <a href="/client/details/{{$item->clientID}}">{{$item->Client_Name->name}}</a></p>
                                                <p class="lh-5 mg-b-20" style="display:block;text-overflow: ellipsis;width: 300px;overflow: hidden; white-space: nowrap;">{{$last5qaform[0]->Refund_Request_summery}}</p>
                                                <nav class="nav flex-row tx-13">
                                                    <a href="" class="tx-white-8 hover-white pd-l-0 pd-r-5">Brand: {{$item->Brand_Name->name}}</a>
                                                    <a href="" class="tx-white-8 hover-white pd-l-0 pd-r-5">Project: {{$item->Project_Name->name}}</a>
                                                    <a href="/userprofile/{{$item->projectmanagerID}}" class="tx-white-8 hover-white pd-x-5">PM: {{$item->Project_ProjectManager->name}}</a>
                                                    <a href="/userprofile/{{$item->qaPerson}}" class="tx-white-8 hover-white pd-x-5">QA: {{$item->QA_Person->name}}</a>
                                                    <a href="/client/project/qareport/view/{{$item->id}}" class="tx-white-8 hover-white pd-x-5">View</a>
                                                </nav>
                                                </div>
                                            </div><!-- d-flex -->
                                        </div>

                                        @else

                                        <div class="carousel-item">
                                            <div class="bg-info pd-30 ht-300 pos-relative d-flex align-items-center rounded">
                                            <div class="tx-white">
                                                <p class="tx-uppercase tx-11 tx-semibold tx-mont tx-spacing-2 tx-white-5">Client: <a href="/client/details/{{$item->clientID}}">{{$item->Client_Name->name}}</a></p>
                                                <p class="lh-5 mg-b-20" style="display:block;text-overflow: ellipsis;width: 300px;overflow: hidden; white-space: nowrap;">{{$item->Refund_Request_summery}}</p>
                                                <nav class="nav flex-row tx-13">
                                                    <a href="" class="tx-white-8 hover-white pd-l-0 pd-r-5">Brand: {{$item->Brand_Name->name}}</a>
                                                    <a href="" class="tx-white-8 hover-white pd-l-0 pd-r-5">Project: {{$item->Project_Name->name}}</a>
                                                    <a href="/userprofile/{{$item->projectmanagerID}}" class="tx-white-8 hover-white pd-x-5">PM: {{$item->Project_ProjectManager->name}}</a>
                                                    <a href="/userprofile/{{$item->qaPerson}}" class="tx-white-8 hover-white pd-x-5">QA: {{$item->QA_Person->name}}</a>
                                                    <a href="/client/project/qareport/view/{{$item->id}}" class="tx-white-8 hover-white pd-x-5">View</a>
                                                </nav>
                                            </div>
                                            </div><!-- d-flex -->
                                        </div>

                                        @endif



                                        @endforeach


                                    </div><!-- carousel-inner -->
                                    </div><!-- carousel -->
                                </div><!-- card -->

                                @else
                                <div class="card bd-0 mg-t-20">
                                    <div id="carousel12" class="carousel slide" data-ride="carousel">

                                    <div class="carousel-inner" role="listbox">

                                        <div class="carousel-item active">
                                            <div class="bg-white pd-30 ht-300 pos-relative d-flex align-items-center rounded">
                                                <div class="tx-black">
                                                <p class="lh-5 mg-b-20">No Client on Refund</p>
                                                </div>
                                            </div><!-- d-flex -->
                                        </div>


                                    </div><!-- carousel-inner -->
                                    </div><!-- carousel -->
                                </div><!-- card -->

                                @endif
                            </div>



                            <div class="col-6">
                                <div class="card bd-gray-400 mg-t-20">
                                    <div id="carousel3" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#carousel3" data-slide-to="0" class="active"></li>
                                        <li data-target="#carousel3" data-slide-to="1"></li>
                                    </ol>
                                    <div class="carousel-inner" role="listbox">

                                        @foreach ($eachbrand_RevenueStatus as $eachbrand_RevenueStatuss)
                                        @if ($eachbrand_RevenueStatuss == $eachbrand_RevenueStatus[0])
                                            <div class="carousel-item active">
                                                <div class="alert-dark ht-300 pos-relative overflow-hidden d-flex flex-column align-items-start rounded">
                                                    <div class="pos-absolute t-15 r-25">
                                                    {{-- <a href="" class="tx-gray-500 hover-info mg-l-7"><i class="icon ion-more tx-20"></i></a> --}}
                                                    </div>
                                                    <div class="pd-x-30 pd-t-30 mg-b-auto">
                                                    <p class="tx-info tx-uppercase tx-11 tx-semibold tx-mont mg-b-5">{{$eachbrand_RevenueStatuss[0][0]->name}}</p>
                                                    <h5 class="tx-inverse mg-b-20">Expected:</h5>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Renewal</p>
                                                            <h2 class="tx-inverse tx-lato tx-bold mg-b-0">{{$eachbrand_RevenueStatuss[1]}}</h2>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Recurring</p>
                                                            <h2 class="tx-inverse tx-lato tx-bold mg-b-0">{{$eachbrand_RevenueStatuss[2]}}</h2>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Refund</p>
                                                            <h2 class="tx-inverse tx-lato tx-bold mg-b-0">{{$eachbrand_RevenueStatuss[3]}}</h2>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Dispute</p>
                                                            <h2 class="tx-inverse tx-lato tx-bold mg-b-0">{{$eachbrand_RevenueStatuss[4]}}</h2>
                                                        </div>

                                                        </div>
                                                    </div>
                                                    <div id="ch10" class="ht-100 tr-y-1"></div>
                                                </div><!-- d-flex -->
                                            </div>
                                        @else

                                        <div class="carousel-item">
                                        <div class="alert-dark ht-300 pos-relative overflow-hidden d-flex flex-column align-items-start rounded">
                                            <div class="pos-absolute t-15 r-25">
                                            <a href="" class="tx-gray-500 hover-info mg-l-7"><i class="icon ion-more tx-20"></i></a>
                                            </div>
                                            <div class="pd-x-30 pd-t-30 mg-b-auto">
                                            <p class="tx-info tx-uppercase tx-11 tx-semibold tx-mont mg-b-5">{{$eachbrand_RevenueStatuss[0][0]->name}}</p>
                                            <h5 class="tx-inverse mg-b-20">Expected:</h5>
                                            <div class="row">
                                            <div class="col-6">
                                                <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Renewal</p>
                                                <h2 class="tx-inverse tx-lato tx-bold mg-b-0">{{$eachbrand_RevenueStatuss[1]}}</h2>
                                            </div>
                                            <div class="col-6">
                                                <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Recurring</p>
                                                <h2 class="tx-inverse tx-lato tx-bold mg-b-0">{{$eachbrand_RevenueStatuss[2]}}</h2>
                                            </div>
                                            <div class="col-6">
                                                <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Refund</p>
                                                <h2 class="tx-inverse tx-lato tx-bold mg-b-0">{{$eachbrand_RevenueStatuss[3]}}</h2>
                                            </div>
                                            <div class="col-6">
                                                <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Dispute</p>
                                                <h2 class="tx-inverse tx-lato tx-bold mg-b-0">{{$eachbrand_RevenueStatuss[4]}}</h2>
                                            </div>

                                            </div>

                                            </div>
                                            <div id="ch11" class="ht-100 tr-y-1"></div>
                                        </div><!-- d-flex -->
                                        </div><!-- cardousel-item -->
                                        @endif
                                        @endforeach
                                    </div><!-- carousel-inner -->
                                    </div><!-- carousel -->
                                </div><!-- card -->
                                </div>


                                @if ($theme == 1)
                                <div class="col-6" style="color: #1D2939">
                                    <div class="card bd-0 mg-t-20" style="color: #1D2939">
                                        <div id="carousel12" class="carousel slide" data-ride="carousel" style="color: #1D2939">

                                        <div class="carousel-inner" role="listbox" style="color: #1D2939">

                                            <div class="carousel-item active" style="color: #1D2939">
                                                <div class=" pd-30 ht-300 pos-relative d-flex align-items-center rounded" style="color: #1D2939">
                                                    <script type="text/javascript">

                                                        // Load the Visualization API and the corechart package.
                                                        google.charts.load('current', {'packages':['corechart']});

                                                        // Set a callback to run when the Google Visualization API is loaded.
                                                        google.charts.setOnLoadCallback(drawChart);

                                                        // Callback that creates and populates a data table,
                                                        // instantiates the pie chart, passes in the data and
                                                        // draws it.
                                                        function drawChart() {

                                                        // Create the data table.
                                                        var data = new google.visualization.DataTable();
                                                        data.addColumn('string', 'Topping');
                                                        data.addColumn('number', 'Slices');
                                                        data.addRows([
                                                            ['On Going', {{$status_OnGoing}}],
                                                            ['Dispute', {{$status_Dispute}}],
                                                            ['Refund', {{$status_Refund}}],
                                                            ['Not Started Yet', {{$status_NotStartedYet}}],
                                                        ]);

                                                        // Set chart options
                                                        var options = {'title':'Monthly Client Status',
                                                        colors: ['green', 'red', 'purple', 'blue'],
                                                        backgroundColor: '#1D2939',
                                                                        'width':400,
                                                                        'height':300,
                                                                        titleTextStyle: {
                                                                            color: 'white', // Title color
                                                                        },
                                                                        legend: {
                                                                            textStyle: {
                                                                                color: 'white' // Legend text color
                                                                            }
                                                                        },
                                                                        pieSliceTextStyle: {
                                                                            color: 'white' // Pie chart slice label color
                                                                        }
                                                                    };

                                                        // Instantiate and draw our chart, passing in some options.
                                                        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                                                        chart.draw(data, options);
                                                        }
                                                    </script>

                                                    <div id="chart_div" style="color: #1D2939"></div>
                                                </div><!-- d-flex -->
                                            </div>


                                        </div><!-- carousel-inner -->
                                        </div><!-- carousel -->
                                    </div><!-- card -->
                                </div>
                                @else
                                <div class="col-6">
                                    <div class="card bd-0 mg-t-20">
                                        <div id="carousel12" class="carousel slide" data-ride="carousel">

                                        <div class="carousel-inner" role="listbox">

                                            <div class="carousel-item active">
                                                <div class="bg-white pd-30 ht-300 pos-relative d-flex align-items-center rounded">
                                                    <script type="text/javascript">

                                                        // Load the Visualization API and the corechart package.
                                                        google.charts.load('current', {'packages':['corechart']});

                                                        // Set a callback to run when the Google Visualization API is loaded.
                                                        google.charts.setOnLoadCallback(drawChart);

                                                        // Callback that creates and populates a data table,
                                                        // instantiates the pie chart, passes in the data and
                                                        // draws it.
                                                        function drawChart() {

                                                        // Create the data table.
                                                        var data = new google.visualization.DataTable();
                                                        data.addColumn('string', 'Topping');
                                                        data.addColumn('number', 'Slices');
                                                        data.addRows([
                                                            ['On Going', {{$status_OnGoing}}],
                                                            ['Dispute', {{$status_Dispute}}],
                                                            ['Refund', {{$status_Refund}}],
                                                            ['Not Started Yet', {{$status_NotStartedYet}}],
                                                        ]);

                                                        // Set chart options
                                                        var options = {'title':'Monthly Client Status',
                                                        colors: ['green', 'red', 'purple', 'blue'],
                                                                        'width':400,
                                                                        'height':300};

                                                        // Instantiate and draw our chart, passing in some options.
                                                        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                                                        chart.draw(data, options);
                                                        }
                                                    </script>

                                                    <div id="chart_div"></div>
                                                </div><!-- d-flex -->
                                            </div>


                                        </div><!-- carousel-inner -->
                                        </div><!-- carousel -->
                                    </div><!-- card -->
                                </div>
                                @endif



                                @if ($theme == 1)
                                <div class="col-6" style="color: #1D2939">
                                    <div class="card bd-0 mg-t-20" style="color: #1D2939">
                                        <div id="carousel12" class="carousel slide" data-ride="carousel" style="color: #1D2939">

                                        <div class="carousel-inner" role="listbox" style="color: #1D2939">

                                            <div class="carousel-item active" style="color: #1D2939">
                                                <div class=" pd-30 ht-300 pos-relative d-flex align-items-center rounded" style="color: #1D2939">
                                                    <script type="text/javascript">

                                                        // Load the Visualization API and the corechart package.
                                                        google.charts.load('current', {'packages':['corechart']});

                                                        // Set a callback to run when the Google Visualization API is loaded.
                                                        google.charts.setOnLoadCallback(drawChart);

                                                        // Callback that creates and populates a data table,
                                                        // instantiates the pie chart, passes in the data and
                                                        // draws it.
                                                        function drawChart() {

                                                          // Create the data table.
                                                          var data = new google.visualization.DataTable();
                                                          data.addColumn('string', 'Topping');
                                                          data.addColumn('number', 'Slices');
                                                          data.addRows([
                                                            ['Extremely Satisfied', {{$remark_ExtremelySatisfied}}],
                                                            ['Somewhat Satisfied', {{$remark_SomewhatSatisfied}}],
                                                            ['Neither Satisfied nor Dissatisfied', {{$remark_NeitherSatisfiednorDissatisfied}}],
                                                            ['Somewhat Dissatisfied', {{$remark_SomewhatDissatisfied}}],
                                                            ['Extremely Dissatisfied', {{$remark_ExtremelyDissatisfied}}]
                                                          ]);

                                                          // Set chart options
                                                          var options = {'title':'Monthly QA Remarks',
                                                          colors: ['green', 'blue', 'yellow', 'purple', 'red'],
                                                          backgroundColor: '#1D2939',
                                                                         'width':400,
                                                                         'height':300,
                                                                         titleTextStyle: {
                                                                            color: 'white', // Title color
                                                                        },
                                                                        legend: {
                                                                            textStyle: {
                                                                                color: 'white' // Legend text color
                                                                            }
                                                                        },
                                                                        pieSliceTextStyle: {
                                                                            color: 'white' // Pie chart slice label color
                                                                        }
                                                                    };

                                                          // Instantiate and draw our chart, passing in some options.
                                                          var chart = new google.visualization.PieChart(document.getElementById('chart_div1'));
                                                          chart.draw(data, options);
                                                        }
                                                      </script>

                                                    <div id="chart_div1" style="color: #1D2939"></div>
                                                </div><!-- d-flex -->
                                            </div>


                                        </div><!-- carousel-inner -->
                                        </div><!-- carousel -->
                                    </div><!-- card -->
                                </div>
                                @else
                                <div class="col-6">
                                    <div class="card bd-0 mg-t-20">
                                        <div id="carousel12" class="carousel slide" data-ride="carousel">

                                        <div class="carousel-inner" role="listbox">

                                            <div class="carousel-item active">
                                                <div class="bg-white pd-30 ht-300 pos-relative d-flex align-items-center rounded">
                                                    <script type="text/javascript">

                                                        // Load the Visualization API and the corechart package.
                                                        google.charts.load('current', {'packages':['corechart']});

                                                        // Set a callback to run when the Google Visualization API is loaded.
                                                        google.charts.setOnLoadCallback(drawChart);

                                                        // Callback that creates and populates a data table,
                                                        // instantiates the pie chart, passes in the data and
                                                        // draws it.
                                                        function drawChart() {

                                                          // Create the data table.
                                                          var data = new google.visualization.DataTable();
                                                          data.addColumn('string', 'Topping');
                                                          data.addColumn('number', 'Slices');
                                                          data.addRows([
                                                            ['Extremely Satisfied', {{$remark_ExtremelySatisfied}}],
                                                            ['Somewhat Satisfied', {{$remark_SomewhatSatisfied}}],
                                                            ['Neither Satisfied nor Dissatisfied', {{$remark_NeitherSatisfiednorDissatisfied}}],
                                                            ['Somewhat Dissatisfied', {{$remark_SomewhatDissatisfied}}],
                                                            ['Extremely Dissatisfied', {{$remark_ExtremelyDissatisfied}}]
                                                          ]);

                                                          // Set chart options
                                                          var options = {'title':'Monthly QA Remarks',
                                                          colors: ['green', 'blue', 'yellow', 'purple', 'red'],
                                                                         'width':400,
                                                                         'height':300};

                                                          // Instantiate and draw our chart, passing in some options.
                                                          var chart = new google.visualization.PieChart(document.getElementById('chart_div1'));
                                                          chart.draw(data, options);
                                                        }
                                                      </script>

                                                    <div id="chart_div1"></div>
                                                </div><!-- d-flex -->
                                            </div>


                                        </div><!-- carousel-inner -->
                                        </div><!-- carousel -->
                                    </div><!-- card -->
                                </div>
                                @endif








                                @if ($theme == 1)
                                <div class="col-6" style="color: #1D2939">
                                    <div class="card bd-0 mg-t-20" style="color: #1D2939">
                                        <div id="carousel12" class="carousel slide" data-ride="carousel" style="color: #1D2939">

                                        <div class="carousel-inner" role="listbox" style="color: #1D2939">

                                            <div class="carousel-item active" style="color: #1D2939">
                                                <div class="pd-30 ht-300 pos-relative d-flex align-items-center rounded" style="color: #1D2939">
                                                    <script type="text/javascript">

                                                        // Load the Visualization API and the corechart package.
                                                        google.charts.load('current', {'packages':['corechart']});

                                                        // Set a callback to run when the Google Visualization API is loaded.
                                                        google.charts.setOnLoadCallback(drawChart);

                                                        // Callback that creates and populates a data table,
                                                        // instantiates the pie chart, passes in the data and
                                                        // draws it.
                                                        function drawChart() {

                                                          // Create the data table.
                                                          var data = new google.visualization.DataTable();
                                                          data.addColumn('string', 'Topping');
                                                          data.addColumn('number', 'Slices');
                                                          data.addRows([
                                                            ['Going Good', {{$ExpectedRefundDispute_GoingGood}}],
                                                            ['Low', {{$ExpectedRefundDispute_Low}}],
                                                            ['Medium', {{$ExpectedRefundDispute_Moderate}}],
                                                            ['High', {{$ExpectedRefundDispute_High}}],
                                                          ]);

                                                          // Set chart options
                                                          var options = {'title':'Monthly Expected Refund',
                                                          colors: ['green', 'yellow', 'purple', 'red'],
                                                          backgroundColor: '#1D2939',
                                                                         'width':400,
                                                                         'height':300,
                                                                         titleTextStyle: {
                                                                            color: 'white', // Title color
                                                                        },
                                                                        legend: {
                                                                            textStyle: {
                                                                                color: 'white' // Legend text color
                                                                            }
                                                                        },
                                                                        pieSliceTextStyle: {
                                                                            color: 'white' // Pie chart slice label color
                                                                        }};

                                                          // Instantiate and draw our chart, passing in some options.
                                                          var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
                                                          chart.draw(data, options);
                                                        }
                                                      </script>

                                                    <div id="chart_div2" style="color: #1D2939"></div>
                                                </div><!-- d-flex -->
                                            </div>


                                        </div><!-- carousel-inner -->
                                        </div><!-- carousel -->
                                    </div><!-- card -->
                                </div>
                                @else
                                <div class="col-6">
                                    <div class="card bd-0 mg-t-20">
                                        <div id="carousel12" class="carousel slide" data-ride="carousel">

                                        <div class="carousel-inner" role="listbox">

                                            <div class="carousel-item active">
                                                <div class="bg-white pd-30 ht-300 pos-relative d-flex align-items-center rounded">
                                                    <script type="text/javascript">

                                                        // Load the Visualization API and the corechart package.
                                                        google.charts.load('current', {'packages':['corechart']});

                                                        // Set a callback to run when the Google Visualization API is loaded.
                                                        google.charts.setOnLoadCallback(drawChart);

                                                        // Callback that creates and populates a data table,
                                                        // instantiates the pie chart, passes in the data and
                                                        // draws it.
                                                        function drawChart() {

                                                          // Create the data table.
                                                          var data = new google.visualization.DataTable();
                                                          data.addColumn('string', 'Topping');
                                                          data.addColumn('number', 'Slices');
                                                          data.addRows([
                                                            ['Going Good', {{$ExpectedRefundDispute_GoingGood}}],
                                                            ['Low', {{$ExpectedRefundDispute_Low}}],
                                                            ['Medium', {{$ExpectedRefundDispute_Moderate}}],
                                                            ['High', {{$ExpectedRefundDispute_High}}],
                                                          ]);

                                                          // Set chart options
                                                          var options = {'title':'Monthly Expected Refund',
                                                          colors: ['green', 'yellow', 'purple', 'red'],
                                                                         'width':400,
                                                                         'height':300};

                                                          // Instantiate and draw our chart, passing in some options.
                                                          var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
                                                          chart.draw(data, options);
                                                        }
                                                      </script>

                                                    <div id="chart_div2"></div>
                                                </div><!-- d-flex -->
                                            </div>


                                        </div><!-- carousel-inner -->
                                        </div><!-- carousel -->
                                    </div><!-- card -->
                                </div>
                                @endif



                            </div>





                        <div class="card bd-gray-400 pd-25 mg-t-20">

                            <div class="row row-xs mg-t-15">
                                <div class="col-sm-4">
                                    <div class="tx-center pd-y-15 bd">
                                        <p class="mg-b-5 tx-uppercase tx-10 tx-mont tx-semibold">Total Clients</p>
                                        @if ($theme == 1)
                                        <h4 class="tx-lato tx-inverse tx-bold mg-b-0" style="color: white">{{$totalClient}}</h4>
                                        @else
                                        <h4 class="tx-lato tx-inverse tx-bold mg-b-0">{{$totalClient}}</h4>
                                        @endif
                                    </div>
                                </div><!-- col-4 -->
                                <div class="col-sm-4 mg-t-20 mg-sm-t-0">
                                    <div class="tx-center pd-y-15 bd">
                                        <p class="mg-b-5 tx-uppercase tx-10 tx-mont tx-semibold">Total Refund</p>
                                        @if ($theme == 1)
                                        <h4 class="tx-lato tx-inverse tx-bold mg-b-0" style="color: white">{{$totalrefund}}</h4>
                                        @else
                                        <h4 class="tx-lato tx-inverse tx-bold mg-b-0">{{$totalrefund}}</h4>
                                        @endif

                                    </div>
                                </div><!-- col-4 -->
                                <div class="col-sm-4 mg-t-20 mg-sm-t-0">
                                    <div class="tx-center pd-y-15 bd">
                                        <p class="mg-b-5 tx-uppercase tx-10 tx-mont tx-semibold">Total Dispute</p>
                                        @if ($theme == 1)
                                        <h4 class="tx-lato tx-inverse tx-bold mg-b-0" style="color: white">{{$totaldispute}}</h4>
                                        @else
                                        <h4 class="tx-lato tx-inverse tx-bold mg-b-0">{{$totaldispute}}</h4>
                                        @endif
                                    </div>
                                </div><!-- col-4 -->
                            </div><!-- row -->

                        </div><!-- card -->

                    </div><!-- col-8 -->


                    <div class="col-lg-4 mg-t-20 mg-lg-t-0">

                        <div class="card bd-gray-400 overflow-hidden ">
                            <div class="pd-x-25 pd-t-25">
                            @if ($theme == 1)
                            <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1 mg-b-20" style="color: white">Month Renewal Payments: (${{$Renewal_Month_sums}})</h6>
                            @else
                            <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1 mg-b-20">Month Renewal Payments: (${{$Renewal_Month_sums}})</h6>
                            @endif

                            {{-- <div class="bg-teal pd-x-25 pd-b-25 d-flex justify-content-between mg-t-20">
                                <div class="tx-center">
                                    <h3 class="tx-lato tx-white mg-b-5">{{$Renewal_Month_counts}}</h3>
                                    <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0 tx-white-8">Total Number</p>
                                </div>
                                <div class="tx-center">
                                    <h3 class="tx-lato tx-white mg-b-5"><span class="tx-light op-8 tx-20">$</span>{{$Renewal_Month_sums}}</h3>
                                    <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0 tx-white-8">Total Amount</p>
                                </div>
                                <div class="tx-center">
                                    <h3 class="tx-lato tx-white mg-b-5">80<span class="tx-light op-8 tx-20">%</span></h3>
                                    <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0 tx-white-8">Free Space</p>
                                </div>
                                </div> --}}

                            @foreach ($Renewal_Months as $Renewal_Month)
                                @if ($Renewal_Month->paymentNature == "New Lead" || $Renewal_Month->paymentNature == "New Sale")
                                <div class="alert alert-primary mg-t-20" role="alert">
                                    <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0"><strong>@if(isset($Renewal_Month->paymentclientName->name) && $Renewal_Month->paymentclientName->name != null){{$Renewal_Month->paymentclientName->name}}@else Undefined @endif</strong></p>
                                    <p><span class="tx-primary">Date:{{$Renewal_Month->futureDate}}| PM:@if(isset($Renewal_Month->pmEmployeesName->name) && $Renewal_Month->pmEmployeesName->name != null){{$Renewal_Month->pmEmployeesName->name}} @else Undefined @endif| Payment Nature:{{$Renewal_Month->paymentNature}}| Amt:{{$Renewal_Month->TotalAmount}}| <a href="/client/project/payment/view/{{$Renewal_Month->id}}">view</a></span></p>
                                </div>
                                @else
                                <div class="alert alert-secondary mg-t-20" role="alert">
                                    <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0"><strong>@if(isset($Renewal_Month->paymentclientName->name) && $Renewal_Month->paymentclientName->name != null) {{$Renewal_Month->paymentclientName->name}}@else Undefined @endif</strong></p>
                                    <p><span class="tx-primary">Date:{{$Renewal_Month->futureDate}}| PM:@if(isset($Renewal_Month->pmEmployeesName->name) && $Renewal_Month->pmEmployeesName->name != null){{$Renewal_Month->pmEmployeesName->name}}@else Undefined @endif | Payment Nature:{{$Renewal_Month->paymentNature}}| Amt:{{$Renewal_Month->TotalAmount}}| <a href="/client/project/payment/view/{{$Renewal_Month->id}}">view</a></span></p>
                                </div>
                                @endif
                            @endforeach
                            </div><!-- pd-x-25 -->
                        </div><!-- card -->













                        <div class="card bd-gray-400 overflow-hidden mg-t-20">
                            <div class="pd-x-25 pd-t-25">
                            @if ($theme == 1)
                            <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1 mg-b-20" style="color: white">Month Recurring Payments: (${{$Recurring_Month_sums}})</h6>
                            @else
                            <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1 mg-b-20">Month Recurring Payments: (${{$Recurring_Month_sums}})</h6>
                            @endif

                            {{-- <div class="bg-teal pd-x-25 pd-b-25 d-flex justify-content-between">
                                <div class="tx-center">
                                    <h3 class="tx-lato tx-white mg-b-5">{{$Recurring_Month_counts}}</h3>
                                    <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0 tx-white-8">Total Number</p>
                                </div>
                                <div class="tx-center">
                                    <h3 class="tx-lato tx-white mg-b-5"><span class="tx-light op-8 tx-20">$</span>{{$Recurring_Month_sums}}</h3>
                                    <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0 tx-white-8">Total Amount</p>
                                </div>
                                <div class="tx-center">
                                    <h3 class="tx-lato tx-white mg-b-5">80<span class="tx-light op-8 tx-20">%</span></h3>
                                    <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0 tx-white-8">Free Space</p>
                                </div>
                            </div> --}}

                            @foreach ($Recurring_Months as $Recurring_Month)
                                @if ($Recurring_Month->paymentNature == "New Lead" || $Recurring_Month->paymentNature == "New Sale")
                                <div class="alert alert-primary  mg-t-20" role="alert">
                                    <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0"><strong>@if(isset($Recurring_Month->paymentclientName->name) && $Recurring_Month->paymentclientName->name != null){{$Recurring_Month->paymentclientName->name}}@else Undefined @endif</strong></p>
                                    <p><span class="tx-primary">Date:{{$Recurring_Month->futureDate}}| PM:@if(isset($Recurring_Month->pmEmployeesName->name) && $Recurring_Month->pmEmployeesName->name != null){{$Recurring_Month->pmEmployeesName->name}}@else Undefined @endif| Payment Nature:{{$Recurring_Month->paymentNature}}| Amt:{{$Recurring_Month->TotalAmount}}| <a href="/client/project/payment/view/{{$Recurring_Month->id}}">view</a></span></p>
                                </div>
                                @else
                                <div class="alert alert-secondary  mg-t-20" role="alert">
                                    <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0"><strong>{{$Recurring_Month->paymentclientName->name}}</strong></p>
                                    <p><span class="tx-primary">Date:{{$Recurring_Month->futureDate}}| PM:@if(isset($Recurring_Month->pmEmployeesName->name) && $Recurring_Month->pmEmployeesName->name != null){{$Recurring_Month->pmEmployeesName->name}}@else Undefined @endif| Payment Nature:{{$Recurring_Month->paymentNature}}| Amt:{{$Recurring_Month->TotalAmount}} | <a href="/client/project/payment/view/{{$Recurring_Month->id}}">view</a></span></p>
                                </div>
                                @endif

                            @endforeach
                            </div><!-- pd-x-25 -->
                        </div><!-- card -->












                        <div class="card bd-gray-400 overflow-hidden mg-t-20">
                            <div class="pd-x-25 pd-t-25">

                            @if ($theme == 1)
                            <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1 mg-b-20" style="color: white">Month Refunds: (${{$Refund_sum}})</h6>
                            @else
                            <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1 mg-b-20">Month Refunds: (${{$Refund_sum}})</h6>
                            @endif

                            {{-- <div class="bg-warning  pd-x-25 pd-b-25 d-flex justify-content-between">
                                <div class="tx-center">
                                    <h3 class="tx-lato tx-white mg-b-5">{{$Refund_count}}</h3>
                                    <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0 tx-white-8">Total Number</p>
                                </div>
                                <div class="tx-center">
                                    <h3 class="tx-lato tx-white mg-b-5"><span class="tx-light op-8 tx-20">$</span>{{$Refund_sum}}</h3>
                                    <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0 tx-white-8">Total Amount</p>
                                </div>
                                <div class="tx-center">
                                    <h3 class="tx-lato tx-white mg-b-5">80<span class="tx-light op-8 tx-20">%</span></h3>
                                    <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0 tx-white-8">Free Space</p>
                                </div>
                            </div> --}}

                            @foreach ($Refund_Month as $Refund_Months)
                                <div class="alert alert-warning mg-t-20" role="alert">
                                    @if (isset($Refund_Months->paymentclientName->name))
                                    <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0"><strong>{{$Refund_Months->paymentclientName->name}}</strong></p>
                                    <p><span class="tx-primary">Date:{{$Refund_Months->futureDate}}|
                                    PM:
                                    @if (isset($Refund_Months->pmEmployeesName->name))
                                    {{$Refund_Months->pmEmployeesName->name}}
                                    @else
                                    Undefied
                                    @endif|
                                    Payment Nature:{{$Refund_Months->paymentNature}}| Amt:{{$Refund_Months->TotalAmount}} | <a href="/client/project/payment/view/{{$Refund_Months->id}}">view</a></span></p>
                                    @else
                                    <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0"><strong>Undefined</strong></p>
                                    <p><span class="tx-primary">Date:{{$Refund_Months->futureDate}}| PM: --| Payment Nature:{{$Refund_Months->paymentNature}}| Amt:{{$Refund_Months->TotalAmount}} | <a href="/client/project/payment/view/{{$Refund_Months->id}}">view</a></span></p>
                                    @endif

                                </div>
                            @endforeach
                            </div><!-- pd-x-25 -->
                        </div><!-- card -->











                        <div class="card bd-gray-400 overflow-hidden mg-t-20">
                            <div class="pd-x-25 pd-t-25">

                            @if ($theme == 1)
                            <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1 mg-b-20" style="color: white">Month Disputes: (${{$Dispute_sum}})</h6>
                            @else
                            <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1 mg-b-20">Month Disputes: (${{$Dispute_sum}})</h6>
                            @endif

                            {{-- <div class="bg-danger  pd-x-25 pd-b-25 d-flex justify-content-between">
                                <div class="tx-center">
                                    <h3 class="tx-lato tx-white mg-b-5">{{$Dispute_count}}</h3>
                                    <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0 tx-white-8">Total Number</p>
                                </div>
                                <div class="tx-center">
                                    <h3 class="tx-lato tx-white mg-b-5"><span class="tx-light op-8 tx-20">$</span>{{$Dispute_sum}}</h3>
                                    <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0 tx-white-8">Total Amount</p>
                                </div>
                                <div class="tx-center">
                                    <h3 class="tx-lato tx-white mg-b-5">80<span class="tx-light op-8 tx-20">%</span></h3>
                                    <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0 tx-white-8">Free Space</p>
                                </div>
                            </div> --}}

                            @foreach ($Dispute_Month as $Dispute_Months)
                                <div class="alert alert-danger mg-b-5" role="alert">
                                    @if (isset($Refund_Months->paymentclientName->name))
                                    {{-- <p><span class="tx-primary">Date:{{$Refund_Months->disputeattack}}| --}}
                                    <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0"><strong>{{$Refund_Months->paymentclientName->name}}</strong></p>
                                    <p><span class="tx-primary">Date:{{$Dispute_Months->disputeattack}}| Payment Nature:{{$Dispute_Months->paymentNature}}| Amt:{{$Dispute_Months->TotalAmount}}  | <a href="/client/project/payment/view/{{$Dispute_Months->id}}">view</a></span></p>
                                    PM:
                                    @if (isset($Refund_Months->pmEmployeesName->name))
                                    {{$Refund_Months->pmEmployeesName->name}}
                                    @else
                                    Undefined
                                    @endif|
                                    Payment Nature:{{$Dispute_Months->paymentNature}}| Amt:{{$Dispute_Months->TotalAmount}}  | <a href="/client/project/payment/view/{{$Dispute_Months->id}}">view</a></span></p>
                                    @else
                                    <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0"><strong>Undefined</strong></p>
                                    <p><span class="tx-primary">Date:{{$Dispute_Months->futureDate}}| PM: --| Payment Nature:{{$Dispute_Months->paymentNature}}| Amt:{{$Dispute_Months->TotalAmount}}  | <a href="/client/project/payment/view/{{$Dispute_Months->id}}">view</a></span></p>
                                    @endif
                                </div>
                            @endforeach
                            </div><!-- pd-x-25 -->
                        </div><!-- card -->



                    </div><!-- col-4 -->
                </div><!-- row -->



@elseif($superUser == 1)
              <div class="row row-sm mg-b-20 d-none">
                <div class="col-sm-6 col-xl-3">
                  <div class="bg-info rounded overflow-hidden">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                      <i class="ion ion-earth tx-60 lh-0 tx-white op-7"></i>
                      <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Today's Visits</p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">1,975,224</p>
                        <span class="tx-11 tx-roboto tx-white-8">24% higher yesterday</span>
                      </div>
                    </div>
                    <div id="ch1" class="ht-50 tr-y-1"></div>
                  </div>
                </div><!-- col-3 -->
                <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
                  <div class="bg-purple rounded overflow-hidden">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                      <i class="ion ion-bag tx-60 lh-0 tx-white op-7"></i>
                      <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Today Sales</p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">$329,291</p>
                        <span class="tx-11 tx-roboto tx-white-8">$390,212 before tax</span>
                      </div>
                    </div>
                    <div id="ch3" class="ht-50 tr-y-1"></div>
                  </div>
                </div><!-- col-3 -->
                <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                  <div class="bg-teal rounded overflow-hidden">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                      <i class="ion ion-monitor tx-60 lh-0 tx-white op-7"></i>
                      <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">% Unique Visits</p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">54.45%</p>
                        <span class="tx-11 tx-roboto tx-white-8">23% average duration</span>
                      </div>
                    </div>
                    <div id="ch2" class="ht-50 tr-y-1"></div>
                  </div>
                </div><!-- col-3 -->
                <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                  <div class="bg-primary rounded overflow-hidden">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                      <i class="ion ion-clock tx-60 lh-0 tx-white op-7"></i>
                      <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Bounce Rate</p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">32.16%</p>
                        <span class="tx-11 tx-roboto tx-white-8">65.45% on average time</span>
                      </div>
                    </div>
                    <div id="ch4" class="ht-50 tr-y-1"></div>
                  </div>
                </div><!-- col-3 -->
              </div><!-- row -->

              <div class="row row-sm">
                <div class="col-4">
                  <div class="card bd-gray-400 pd-20">
                    @if ($theme == 1)
                        <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15" style="color: white">QA Forms</h6>
                        @else
                        <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15">QA Forms</h6>
                        @endif
                    <div class="d-flex mg-b-10">
                      <div class="bd-r pd-r-10">
                        <label class="tx-12">Today</label>
                        @if ($theme == 1)
                        <p class="tx-lato tx-inverse tx-bold" style="color: white">{{$todayform}}</p>
                        @else
                        <p class="tx-lato tx-inverse tx-bold">{{$todayform}}</p>
                         @endif
                      </div>
                      <div class="bd-r pd-x-10">
                        <label class="tx-12">This Week</label>
                        @if ($theme == 1)
                        <p class="tx-lato tx-inverse tx-bold" style="color: white">{{$weekform}}</p>
                        @else
                        <p class="tx-lato tx-inverse tx-bold">{{$weekform}}</p>
                        @endif
                      </div>
                      <div class="pd-l-10">
                        <label class="tx-12">This Month</label>
                        @if ($theme == 1)
                        <p class="tx-lato tx-inverse tx-bold" style="color: white">{{$monthform}}</p>
                        @else
                        <p class="tx-lato tx-inverse tx-bold">{{$monthform}}</p>
                        @endif
                      </div>
                    </div><!-- d-flex -->
                    <div class="progress mg-b-10">
                        <div class="progress-bar bg-purple wd-100p" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                      </div>
                  </div><!-- card -->
                </div><!-- col-4 -->
                <div class="col-4">
                  <div class="card bd-gray-400 pd-20">

                    @if ($theme == 1)
                    <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15" style="color: white">Client Status</h6>
                    @else
                    <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15">Client Status</h6>
                    @endif
                    <div class="d-flex mg-b-10">
                      <div class="bd-r pd-r-10">
                        <label class="tx-12">Clients</label>
                        @if ($theme == 1)
                        <p class="tx-lato tx-inverse tx-bold" style="color: white">{{$client_status}}</p>
                        @else
                        <p class="tx-lato tx-inverse tx-bold">{{$client_status}}</p>
                         @endif
                      </div>
                      <div class="bd-r pd-x-10">
                        <label class="tx-12">M. On Going</label>
                        @if ($theme == 1)
                        <p class="tx-lato tx-inverse tx-bold" style="color: white">{{$currentMonth_ongoingClients}}</p>
                        @else
                        <p class="tx-lato tx-inverse tx-bold">{{$currentMonth_ongoingClients}}</p>
                         @endif
                      </div>
                      <div class="bd-r pd-x-10">
                        <label class="tx-12">M. Dispute</label>
                        @if ($theme == 1)
                        <p class="tx-lato tx-inverse tx-bold" style="color: white">{{$currentMonth_disputedClients}}</p>
                        @else
                        <p class="tx-lato tx-inverse tx-bold">{{$currentMonth_disputedClients}}</p>
                         @endif
                      </div>
                      <div class="pd-l-10">
                        <label class="tx-12">M. Refund</label>
                        @if ($theme == 1)
                        <p class="tx-lato tx-inverse tx-bold" style="color: white">{{$currentMonth_refundClients}}</p>
                        @else
                        <p class="tx-lato tx-inverse tx-bold">{{$currentMonth_refundClients}}</p>
                         @endif
                      </div>
                    </div><!-- d-flex -->
                    <div class="progress mg-b-10">
                      <div class="progress-bar bg-info wd-100p" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                    </div>
                  </div><!-- card -->
                </div><!-- col-4 -->
                <div class="col-4">
                  <div class="card bd-gray-400 pd-20">

                    @if ($theme == 1)
                    <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15" style="color: white">Expected Refund</h6>
                    @else
                    <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15">Expected Refund</h6>
                    @endif
                    <div class="d-flex mg-b-10">
                      <div class="bd-r pd-r-10">
                        <label class="tx-12">M. Low</label>
                        @if ($theme == 1)
                        <p class="tx-lato tx-inverse tx-bold" style="color: white">{{$currentMonth_lowRiskClients}}</p>
                        @else
                        <p class="tx-lato tx-inverse tx-bold">{{$currentMonth_lowRiskClients}}</p>
                         @endif
                      </div>
                      <div class="bd-r pd-x-10">
                        <label class="tx-12">M. Moderate</label>
                        @if ($theme == 1)
                        <p class="tx-lato tx-inverse tx-bold" style="color: white">{{$currentMonth_mediumRiskClients}}</p>
                        @else
                        <p class="tx-lato tx-inverse tx-bold">{{$currentMonth_mediumRiskClients}}</p>
                         @endif
                      </div>
                      <div class="pd-l-10">
                        <label class="tx-12">M. High</label>
                        @if ($theme == 1)
                        <p class="tx-lato tx-inverse tx-bold" style="color: white">{{$currentMonth_highRiskClients}}</p>
                        @else
                        <p class="tx-lato tx-inverse tx-bold">{{$currentMonth_highRiskClients}}</p>
                         @endif
                      </div>
                    </div><!-- d-flex -->
                    <div class="progress mg-b-10">
                      <div class="progress-bar bg-danger wd-100p" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                    </div>
                  </div><!-- card -->
                </div><!-- col-4 -->
              </div><!-- row -->

              <div class="row row-sm mg-t-20 ">
                <div class="col-lg-8">

                    <div class="row">

                        <div class="col-6">
                            @if ($last5qaformstatus > 0)
                            <div class="card bd-0 mg-t-20">
                                <div id="carousel12" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carousel12" data-slide-to="0" class="active"></li>
                                    <li data-target="#carousel12" data-slide-to="1"></li>
                                    <li data-target="#carousel12" data-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner" role="listbox">

                                    @foreach ($last5qaform as $item)

                                    @if ($item == $last5qaform[0])

                                    <div class="carousel-item active">
                                        <div class="bg-br-primary pd-30 ht-300 pos-relative d-flex align-items-center rounded">
                                            <div class="tx-white">
                                            <p class="tx-uppercase tx-11 tx-semibold tx-mont tx-spacing-2 tx-white-5">Client: <a href="/client/details/{{$item->clientID}}">{{$item->Client_Name->name}}</a></p>
                                            <p class="lh-5 mg-b-20" style="display:block;text-overflow: ellipsis;width: 300px;overflow: hidden; white-space: nowrap;">{{$last5qaform[0]->Refund_Request_summery}}</p>
                                            <nav class="nav flex-row tx-13">
                                                <a href="" class="tx-white-8 hover-white pd-l-0 pd-r-5">Brand: {{$item->Brand_Name->name}}</a>
                                                <a href="" class="tx-white-8 hover-white pd-l-0 pd-r-5">Project: {{$item->Project_Name->name}}</a>
                                                <a href="/userprofile/{{$item->projectmanagerID}}" class="tx-white-8 hover-white pd-x-5">PM: {{$item->Project_ProjectManager->name}}</a>
                                                <a href="/userprofile/{{$item->qaPerson}}" class="tx-white-8 hover-white pd-x-5">QA: {{$item->QA_Person->name}}</a>
                                                <a href="/client/project/qareport/view/{{$item->id}}" class="tx-white-8 hover-white pd-x-5">View</a>
                                            </nav>
                                            </div>
                                        </div><!-- d-flex -->
                                    </div>

                                    @else

                                    <div class="carousel-item">
                                        <div class="bg-info pd-30 ht-300 pos-relative d-flex align-items-center rounded">
                                        <div class="tx-white">
                                            <p class="tx-uppercase tx-11 tx-semibold tx-mont tx-spacing-2 tx-white-5">Client: <a href="/client/details/{{$item->clientID}}">{{$item->Client_Name->name}}</a></p>
                                            <p class="lh-5 mg-b-20" style="display:block;text-overflow: ellipsis;width: 300px;overflow: hidden; white-space: nowrap;">{{$item->Refund_Request_summery}}</p>
                                            <nav class="nav flex-row tx-13">
                                                <a href="" class="tx-white-8 hover-white pd-l-0 pd-r-5">Brand: {{$item->Brand_Name->name}}</a>
                                                <a href="" class="tx-white-8 hover-white pd-l-0 pd-r-5">Project: {{$item->Project_Name->name}}</a>
                                                <a href="/userprofile/{{$item->projectmanagerID}}" class="tx-white-8 hover-white pd-x-5">PM: {{$item->Project_ProjectManager->name}}</a>
                                                <a href="/userprofile/{{$item->qaPerson}}" class="tx-white-8 hover-white pd-x-5">QA: {{$item->QA_Person->name}}</a>
                                                <a href="/client/project/qareport/view/{{$item->id}}" class="tx-white-8 hover-white pd-x-5">View</a>
                                            </nav>
                                        </div>
                                        </div><!-- d-flex -->
                                    </div>

                                    @endif



                                    @endforeach


                                </div><!-- carousel-inner -->
                                </div><!-- carousel -->
                            </div><!-- card -->

                            @else
                            <div class="card bd-0 mg-t-20">
                                <div id="carousel12" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner" role="listbox">



                                    <div class="carousel-item active">
                                        <div class="bg-white pd-30 ht-300 pos-relative d-flex align-items-center rounded">
                                            <div class="tx-black">
                                            <p class="lh-5 mg-b-20">No Client on Refund</p>
                                            </div>
                                        </div><!-- d-flex -->
                                    </div>




                                </div><!-- carousel-inner -->
                                </div><!-- carousel -->
                            </div><!-- card -->

                            @endif



                        </div>

                        <div class="col-6">
                            <div class="card bd-gray-400 mg-t-20">
                                <div id="carousel3" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carousel3" data-slide-to="0" class="active"></li>
                                    <li data-target="#carousel3" data-slide-to="1"></li>
                                </ol>
                                <div class="carousel-inner" role="listbox">
                                    <div class="carousel-item active">
                                    <div class=" ht-300 pos-relative overflow-hidden d-flex flex-column align-items-start rounded">
                                        <div class="pos-absolute t-15 r-25">
                                        <a href="" class="tx-gray-500 hover-info mg-l-7"><i class="icon ion-more tx-20"></i></a>
                                        </div>
                                        <div class="pd-x-30 pd-t-30 mg-b-auto">
                                        <p class="tx-info tx-uppercase tx-11 tx-semibold tx-mont mg-b-5">Brand #1</p>
                                        <h5 class="tx-inverse mg-b-20">Expected:</h5>
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Refund</p>
                                                <h2 class="tx-inverse tx-lato tx-bold mg-b-0">36</h2>
                                            </div>
                                            <div class="col-6">
                                                <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Upsell</p>
                                                <h2 class="tx-inverse tx-lato tx-bold mg-b-0">23</h2>
                                            </div>
                                            <div class="col-6">
                                                <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Renewal</p>
                                                <h2 class="tx-inverse tx-lato tx-bold mg-b-0">26</h2>
                                            </div>
                                            <div class="col-6">
                                                <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Recurring</p>
                                                <h2 class="tx-inverse tx-lato tx-bold mg-b-0">66</h2>
                                            </div>

                                            </div>
                                        </div>
                                        <div id="ch10" class="ht-100 tr-y-1"></div>
                                    </div><!-- d-flex -->
                                    </div>
                                    <div class="carousel-item">
                                    <div class=" ht-300 pos-relative overflow-hidden d-flex flex-column align-items-start rounded">
                                        <div class="pos-absolute t-15 r-25">
                                        <a href="" class="tx-gray-500 hover-info mg-l-7"><i class="icon ion-more tx-20"></i></a>
                                        </div>
                                        <div class="pd-x-30 pd-t-30 mg-b-auto">
                                        <p class="tx-info tx-uppercase tx-11 tx-semibold tx-mont mg-b-5">Brand #2</p>
                                        <h5 class="tx-inverse mg-b-20">Expected:</h5>
                                        <div class="row">
                                        <div class="col-6">
                                            <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Refund</p>
                                            <h2 class="tx-inverse tx-lato tx-bold mg-b-0">36</h2>
                                        </div>
                                        <div class="col-6">
                                            <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Upsell</p>
                                            <h2 class="tx-inverse tx-lato tx-bold mg-b-0">23</h2>
                                        </div>
                                        <div class="col-6">
                                            <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Renewal</p>
                                            <h2 class="tx-inverse tx-lato tx-bold mg-b-0">26</h2>
                                        </div>
                                        <div class="col-6">
                                            <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Recurring</p>
                                            <h2 class="tx-inverse tx-lato tx-bold mg-b-0">66</h2>
                                        </div>

                                        </div>

                                        </div>
                                        <div id="ch11" class="ht-100 tr-y-1"></div>
                                    </div><!-- d-flex -->
                                    </div><!-- cardousel-item -->
                                </div><!-- carousel-inner -->
                                </div><!-- carousel -->
                            </div><!-- card -->

                        </div>

                    </div>







                  <div class="card bd-gray-400 pd-25 mg-t-20">


                    <div class="row row-xs mg-t-25">
                      <div class="col-sm-4">
                        <div class="tx-center pd-y-15 bd">
                          <p class="mg-b-5 tx-uppercase tx-10 tx-mont tx-semibold">Total Clients</p>
                          @if ($theme == 1)
                            <h4 class="tx-lato tx-inverse tx-bold mg-b-0" style="color: white">{{$client_status}}</h4>
                          @else
                            <h4 class="tx-lato tx-inverse tx-bold mg-b-0">{{$client_status}}</h4>
                          @endif
                        </div>
                      </div><!-- col-4 -->
                      <div class="col-sm-4 mg-t-20 mg-sm-t-0">
                        <div class="tx-center pd-y-15 bd">
                        <p class="mg-b-5 tx-uppercase tx-10 tx-mont tx-semibold">Total Refund</p>
                        @if ($theme == 1)
                        <h4 class="tx-lato tx-inverse tx-bold mg-b-0" style="color: white">{{$Total_refundClients}}</h4>
                        @else
                          <h4 class="tx-lato tx-inverse tx-bold mg-b-0">{{$Total_refundClients}}</h4>
                        @endif
                        </div>
                      </div><!-- col-4 -->
                      <div class="col-sm-4 mg-t-20 mg-sm-t-0">
                        <div class="tx-center pd-y-15 bd">
                          <p class="mg-b-5 tx-uppercase tx-10 tx-mont tx-semibold">Total Dispute</p>
                          @if ($theme == 1)
                        <h4 class="tx-lato tx-inverse tx-bold mg-b-0" style="color: white">{{$Total_disputedClients}}</h4>
                        @else
                          <h4 class="tx-lato tx-inverse tx-bold mg-b-0">{{$Total_disputedClients}}</h4>
                        @endif
                        </div>
                      </div><!-- col-4 -->
                    </div><!-- row -->

                  </div><!-- card -->


                </div><!-- col-8 -->
                <div class="col-lg-4 mg-t-20 mg-lg-t-0">

                  <div class="card bd-gray-400 overflow-hidden">
                    <div class="pd-x-25 pd-t-25">
                      <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1 mg-b-20">Upcoming Recurring Payments</h6>
                      <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0">As of Today</p>
                      <h1 class="tx-56 tx-light tx-inverse mg-b-0">755<span class="tx-teal tx-24">gb</span></h1>
                      <p><span class="tx-primary">80%</span> of free space remaining</p>
                    </div><!-- pd-x-25 -->
                    <div id="ch6" class="ht-115 mg-r--1"></div>
                    <div class="bg-teal pd-x-25 pd-b-25 d-flex justify-content-between">
                      <div class="tx-center">
                        <h3 class="tx-lato tx-white mg-b-5">989<span class="tx-light op-8 tx-20">gb</span></h3>
                        <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0 tx-white-8">Total Space</p>
                      </div>
                      <div class="tx-center">
                        <h3 class="tx-lato tx-white mg-b-5">234<span class="tx-light op-8 tx-20">gb</span></h3>
                        <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0 tx-white-8">Used Space</p>
                      </div>
                      <div class="tx-center">
                        <h3 class="tx-lato tx-white mg-b-5">80<span class="tx-light op-8 tx-20">%</span></h3>
                        <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0 tx-white-8">Free Space</p>
                      </div>
                    </div>
                  </div><!-- card -->



                  <div class="card card-body bd-0 pd-25 bg-primary mg-t-20">
                    <div class="d-xs-flex justify-content-between align-items-center tx-white mg-b-20">
                      <h6 class="tx-13 tx-uppercase tx-semibold tx-spacing-1 mg-b-0">Server Status</h6>
                      <span class="tx-12 tx-uppercase">Oct 2017</span>
                    </div>
                    <p class="tx-sm tx-white tx-medium mg-b-0">Hardware Monitoring</p>
                    <p class="tx-12 tx-white-7">Intel Dothraki G125H 2.5GHz</p>
                    <div class="progress bg-white-3 rounded-0 mg-b-0">
                      <div class="progress-bar bg-success wd-50p lh-3" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                    </div><!-- progress -->
                    <p class="tx-11 mg-b-0 mg-t-15 tx-white-7">Notice: Lorem ipsum dolor sit amet.</p>
                  </div><!-- card -->





                </div><!-- col-4 -->
              </div><!-- row -->

@else
@endif


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
@endsection
