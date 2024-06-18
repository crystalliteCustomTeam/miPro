@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <div class="br-mainpanel">
            <div class="br-pagetitle">
              <i class="icon ion-ios-home-outline tx-70 lh-0"></i>
              <div>
                <h4>Brand Analytics</h4>
                <p class="mg-b-0">Target, Sales, Revenue, Expences.</p>
              </div>
            </div><!-- d-flex -->
            <div class="row">
                <div class="col-2 mt-3">
                </div>
                <div class="col-2 mt-3">
                    <select class="form-control select2" name="year" id="getyeardata">
                        <option value="">Select Year</option>
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
                    <select class="form-control select2" name="month" id="getmonth">
                        <option value="">Select Month</option>
                        <option value="January">January</option>
                        <option value="February">February</option>
                        <option value="March">March</option>
                        <option value="April">April</option>
                        <option value="May">May</option>
                        <option value="June">June</option>
                        <option value="July">July</option>
                        <option value="August">August</option>
                        <option value="September">September</option>
                        <option value="October">October</option>
                        <option value="November">November</option>
                        <option value="December">December</option>
                  </select>
                </div>
                <div class="col-3 mt-3">
                    <select class="form-control select2" name="brand" id="getbranddata">
                        <option value="">Select Brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">
                          {{ $brand->name }}
                        </option>
                    @endforeach
                  </select>
                </div>
                <div class="col-2 mt-2">
                    <button class="btn btn-primary mt-2" id="searchbranddata">Search</button>
                </div>

            </div>

            <div class="br-pagebody">
                <!-- hidden on purpose using d-none class to have a different look with the original -->
                <!-- feel free to unhide by removing the d-none class below -->

                <div class="row row-sm mg-b-20 ">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-info rounded overflow-hidden">
                            <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                            <i class="ion ion-earth tx-60 lh-0 tx-white op-7"></i>
                            <div class="mg-l-20">
                                <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Target</p>
                                <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1" id="brandtarget"></p>
                                {{-- <span class="tx-11 tx-roboto tx-white-8">24% higher yesterday</span> --}}
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
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Sales</p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1" id="brandsales"></p>
                            {{-- <span class="tx-11 tx-roboto tx-white-8">$390,212 before tax</span> --}}
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
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Disputes</p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1" id="branddisputes"></p>
                            {{-- <span class="tx-11 tx-roboto tx-white-8">65.45% on average time</span> --}}
                            {{-- <div class="d-flex mg-b-0">
                                <div class="bd-r pd-x-10">
                                    <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">$00</p>
                                    <span class="tx-11 tx-roboto tx-white-8">Refund</span>
                                </div>
                                <div class="pd-l-10">
                                    <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">$00</p>
                                    <span class="tx-11 tx-roboto tx-white-8">Dispute</span>
                                </div>
                            </div><!-- d-flex --> --}}
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
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Net Revenue</p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1" id="brand_net_revenue"></p>
                            {{-- <span class="tx-11 tx-roboto tx-white-8">65.45% on average time</span> --}}

                        </div>
                        </div>
                        <div id="ch4" class="ht-50 tr-y-1"></div>
                    </div>
                    </div><!-- col-3 -->
                </div><!-- row -->


                <div class="row row-sm mg-t-20">

                    <div class="col-4 mg-b-15">
                        <div class="card bd-gray-400 pd-20">
                            <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15">Month:</h6>
                            <div class="d-flex mg-b-10">
                            <div class="bd-r pd-r-10">
                                <label class="tx-12">Front</label>
                                <p class="tx-lato tx-inverse tx-bold" id="front">--</p>
                            </div>
                            <div class="bd-r pd-x-10">
                                <label class="tx-12">Back</label>
                                <p class="tx-lato tx-inverse tx-bold" id="back">--</p>
                            </div>
                            <div class="pd-l-10">
                                <label class="tx-12">Sub Total</label>
                                <p class="tx-lato tx-inverse tx-bold" id="subtotal">--</p>
                            </div>
                            </div><!-- d-flex -->
                            <div class="progress mg-b-10">
                                <div class="progress-bar bg-purple wd-100p" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div><!-- card -->
                    </div><!-- col-4 -->

                    <div class="col-4 mg-b-15">
                        <div class="card bd-gray-400 pd-20">
                            <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15">Disputes:</h6>
                            <div class="d-flex mg-b-10">
                            <div class="bd-r pd-r-10">
                                <label class="tx-12">Fee:</label>
                                <p class="tx-lato tx-inverse tx-bold" id="disputefees">--</p>
                            </div>
                            <div class="bd-r pd-x-10">
                                <label class="tx-12">Refund:</label>
                                <p class="tx-lato tx-inverse tx-bold" id="refund">--</p>
                            </div>
                            <div class="pd-l-10">
                                <label class="tx-12">ChargeBack:</label>
                                <p class="tx-lato tx-inverse tx-bold" id="dispute">--</p>
                            </div>
                            </div><!-- d-flex -->
                            <div class="progress mg-b-10">
                                <div class="progress-bar bg-danger wd-100p" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div><!-- card -->
                    </div><!-- col-4 -->


                    <div class="col-4 mg-b-15">
                        <div class="card bd-gray-400 pd-20">
                            <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15">PPC:</h6>

                            <div class="d-flex mg-b-10">
                                <div class="bd-r pd-r-10">
                                    <label class="tx-12">Fee:</label>
                                    <p class="tx-lato tx-inverse tx-bold">--</p>
                                </div>
                                </div><!-- d-flex -->

                            <div class="progress mg-b-10">
                                <div class="progress-bar bg-teal wd-100p" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div><!-- card -->
                    </div><!-- col-4 -->

                    <div class="col-4 mg-b-15">
                        <div class="card bd-gray-400 pd-20">
                            <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15">Expences:</h6>
                            <div class="d-flex mg-b-10">
                            <div class="bd-r pd-r-10">
                                <label class="tx-12">Sales Commision:</label>
                                <p class="tx-lato tx-inverse tx-bold">--</p>
                            </div>
                            <div class="bd-r pd-x-10">
                                <label class="tx-12">IN/Client Exp:</label>
                                <p class="tx-lato tx-inverse tx-bold">--</p>
                            </div>
                            <div class="pd-l-10">
                                <label class="tx-12">Total Exp:</label>
                                <p class="tx-lato tx-inverse tx-bold">--</p>
                            </div>
                            </div><!-- d-flex -->
                            <div class="progress mg-b-10">
                                <div class="progress-bar bg-info wd-100p" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div><!-- card -->
                    </div><!-- col-4 -->


                    <div class="col-4 mg-b-15">
                        <div class="card bd-gray-400 pd-20">
                            <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15">Lead:</h6>
                            <div class="d-flex mg-b-10">
                            <div class="bd-r pd-r-10">
                                <label class="tx-12">Lead Count/Converted Amount:</label>
                                <p class="tx-lato tx-inverse tx-bold">--</p>
                            </div>
                            <div class="bd-r pd-x-10">
                                <label class="tx-12">Conversion Ration:</label>
                                <p class="tx-lato tx-inverse tx-bold">--</p>
                            </div>
                            <div class="pd-l-10">
                                <label class="tx-12">ROI:</label>
                                <p class="tx-lato tx-inverse tx-bold">--</p>
                            </div>
                            </div><!-- d-flex -->
                            <div class="progress mg-b-10">
                                <div class="progress-bar bg-primary wd-100p" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div><!-- card -->
                    </div><!-- col-4 -->


                    <div class="col-4 mg-b-15">
                        <div class="card bd-gray-400 pd-20">
                            <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15">Revenue:</h6>
                            <div class="d-flex mg-b-10">
                            <div class="bd-r pd-r-10">
                                <label class="tx-12">Net Revenue:</label>
                                <p class="tx-lato tx-inverse tx-bold">--</p>
                            </div>
                            <div class="bd-r pd-x-10">
                                <label class="tx-12">Remaining:</label>
                                <p class="tx-lato tx-inverse tx-bold">--</p>
                            </div>
                            <div class="pd-l-10">
                                <label class="tx-12">Percentage:</label>
                                <p class="tx-lato tx-inverse tx-bold">--</p>
                            </div>
                            <div class="pd-l-10">
                                <label class="tx-12">Require /Day:</label>
                                <p class="tx-lato tx-inverse tx-bold">--</p>
                            </div>
                            </div><!-- d-flex -->
                            <div class="progress mg-b-10">
                                <div class="progress-bar bg-secondary wd-100p" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div><!-- card -->
                    </div><!-- col-4 -->

                    <div class="col-12 mg-b-15">
                        <div class="card bd-gray-400 pd-20">
                            <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15">Agents:</h6>
                            <style>
                                .table-dark > tbody > tr > th, .table-dark > tbody > tr > td {
                                    background-color: #ffffff !important;
                                    color: #060708;
                                    border: 0.5px solid #ecececcc !important;
                                }
                            </style>
                            <table id="" class=" table-dark table-hover">
                                <thead>
                                  <tr role="row">
                                    <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="First name: activate to sort column descending">Agent Name</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Target</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Revenue</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Front</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Back</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Refund</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Chargeback</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">N.Total</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Exp</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Net Total</th>
                                  </tr>
                                </thead>
                                <tbody id="employeeTableBody">
                                        {{-- <tr role="row" class="odd">
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
                                        </tr> --}}
                                </tbody>
                            </table>

                        </div><!-- card -->
                    </div><!-- col-4 -->



                    <div class="col-12 mg-b-15">
                    <div class="row">
                        <div class="col-4 mt-3">
                        </div>
                        <div class="col-3 mt-3">
                            <input type="date" class="form-control" required name="date" id="dateforagent">
                        </div>
                        <div class="col-3 mt-2">
                            <button class="btn btn-primary mt-2" id="getdateagentsandbrand">Search</button>
                        </div>

                    </div>
                    </div>



                    <div class="col-6 mg-b-15">
                        <div class="card bd-gray-400 pd-20">
                                    <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15">Today's Brand Payment:</h6>
                                    <style>
                                        .table-dark > tbody > tr > th, .table-dark > tbody > tr > td {
                                            background-color: #ffffff !important;
                                            color: #060708;
                                            border: 0.5px solid #ecececcc !important;
                                        }
                                    </style>
                                    <table id="" class=" table-dark table-hover">
                                        <thead>
                                          <tr role="row">
                                            <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-sort="ascending" aria-label="First name: activate to sort column descending">Brand</th>
                                            <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Front</th>
                                            <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Back</th>
                                            <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Total</th>
                                          </tr>
                                        </thead>
                                        <tbody id="brandtodaypayment">
                                                {{-- <tr role="row" class="odd">
                                                    <td tabindex="0" class="sorting_1">--</td>
                                                    <td>--</td>
                                                    <td>--</td>
                                                    <td>--</td>
                                                </tr> --}}
                                        </tbody>
                                    </table>
                        </div><!-- card -->
                    </div><!-- col-4 -->

                    <div class="col-6 mg-b-15">
                        <div class="card bd-gray-400 pd-20">
                                    <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15">Today's Individual Stats:</h6>
                                    <style>
                                        .table-dark > tbody > tr > th, .table-dark > tbody > tr > td {
                                            background-color: #ffffff !important;
                                            color: #060708;
                                            border: 0.5px solid #ecececcc !important;
                                        }
                                    </style>
                                    <table id="" class=" table-dark table-hover">
                                        <thead>
                                          <tr role="row">
                                            <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-sort="ascending" aria-label="First name: activate to sort column descending">Agent</th>
                                            <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Revenue</th>
                                            <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Total</th>
                                          </tr>
                                        </thead>
                                        <tbody id="empdailypayment">
                                                {{-- <tr role="row" class="odd">
                                                    <td tabindex="0" class="sorting_1">--</td>
                                                    <td>--</td>
                                                    <td>--</td>
                                                </tr> --}}
                                        </tbody>
                                    </table>
                        </div><!-- card -->
                    </div><!-- col-4 -->


                    <div class="col-12 mg-b-15">
                        <div class="card bd-gray-400 pd-20">
                            <h3 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15">Dispute & Refund Report:</h3>
                            <style>
                                .table-dark > tbody > tr > th, .table-dark > tbody > tr > td {
                                    background-color: #ffffff !important;
                                    color: #060708;
                                    border: 0.5px solid #ecececcc !important;
                                }
                            </style>
                            <table id="" class=" table-dark table-hover">
                                <thead>
                                  <tr role="row">
                                    <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="First name: activate to sort column descending">Date</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Brand</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Client Name</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Amount</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Services</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Upseller</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Support</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Type</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Front Person</th>
                                  </tr>
                                </thead>
                                <tbody id="dispreftable">
                                        {{-- <tr role="row" class="odd">
                                            <td tabindex="0" class="sorting_1">--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                            <td>--</td>
                                        </tr> --}}
                                </tbody>
                            </table>


                        </div><!-- col-4 -->


                    </div><!-- row -->


                    <div class="col-12 mg-b-15">
                        <div class="card bd-gray-400 pd-20">


                            <div class="row">
                                <div class="col-6">
                                    <div class="carousel-item active">
                                        <div class="bg-white pd-30 ht-300 pos-relative d-flex align-items-center rounded">
                                            <script type="text/javascript">

                                            function displaysales(brand_renewal , brand_upsell, brand_newlead) {

                                            // Load the Visualization API and the corechart package.
                                            google.charts.load('current', {'packages':['corechart']});

                                            // Set a callback to run when the Google Visualization API is loaded.
                                            google.charts.setOnLoadCallback(function() {
                                                drawChart(brand_renewal , brand_upsell, brand_newlead);
                                            });

                                            // Callback that creates and populates a data table,
                                            // instantiates the pie chart, passes in the data and
                                            // draws it.
                                            function drawChart(brand_renewal , brand_upsell, brand_newlead) {

                                                console.log(brand_renewal , brand_upsell, brand_newlead);

                                            // Create the data table.
                                            var data = new google.visualization.DataTable();
                                            data.addColumn('string', 'Topping');
                                            data.addColumn('number', 'Slices');
                                            data.addRows([
                                                // ['Ongoing', brand_ongoing],
                                                // ['Refund', brand_refund],
                                                // ['Chargeback', brand_chargeback]
                                                ['Renewal', parseInt(brand_renewal)],
                                                ['Upsell', parseInt(brand_upsell)],
                                                ['NewLead', parseInt(brand_newlead)]
                                            ]);

                                            // Set chart options
                                            var options = {'title':'Sales Distribution Graph',is3D: true,
                                            colors: ['green', 'red', 'purple'],
                                                            'width':400,
                                                            'height':300};

                                            // Instantiate and draw our chart, passing in some options.
                                            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                                            chart.draw(data, options);
                                            }

                                            };

                                            </script>

                                            <div id="chart_div"></div>
                                        </div><!-- d-flex -->
                                    </div><!-- card -->

                                </div>

                                <div class="col-6">
                                    <div class="carousel-item active">
                                        <div class="bg-white pd-30 ht-300 pos-relative d-flex align-items-center rounded">
                                            <script type="text/javascript">

                                                function displayArray(brand_ongoing , brand_refund, brand_chargeback) {

                                                // Load the Visualization API and the corechart package.
                                                google.charts.load('current', {'packages':['corechart']});

                                                // Set a callback to run when the Google Visualization API is loaded.
                                                google.charts.setOnLoadCallback(function() {
                                                    drawChart(brand_ongoing, brand_refund, brand_chargeback);
                                                });

                                                // Callback that creates and populates a data table,
                                                // instantiates the pie chart, passes in the data and
                                                // draws it.
                                                function drawChart(brand_ongoing , brand_refund, brand_chargeback) {

                                                    console.log(brand_ongoing , brand_refund, brand_chargeback);

                                                // Create the data table.
                                                var data = new google.visualization.DataTable();
                                                data.addColumn('string', 'Topping');
                                                data.addColumn('number', 'Slices');
                                                data.addRows([
                                                    // ['Ongoing', brand_ongoing],
                                                    // ['Refund', brand_refund],
                                                    // ['Chargeback', brand_chargeback]
                                                    ['Ongoing', parseInt(brand_ongoing)],
                                                    ['Refund', parseInt(brand_refund)],
                                                    ['Chargeback', parseInt(brand_chargeback)]
                                                ]);

                                                // Set chart options
                                                var options = {'title':'Dispute & Refund % Chart:',is3D: true,
                                                colors: ['green', 'red', 'purple'],
                                                                'width':400,
                                                                'height':300};

                                                // Instantiate and draw our chart, passing in some options.
                                                var chart = new google.visualization.PieChart(document.getElementById('chart_div1'));
                                                chart.draw(data, options);
                                                }

                                            };
                                            </script>

                                            <div id="chart_div1"></div>
                                        </div><!-- d-flex -->
                                    </div><!-- card -->

                                </div>
                            </div>


                        </div><!-- col-4 -->


                    </div><!-- row -->


                    <div class="col-12 mg-b-15">
                        <div class="card bd-gray-400 pd-20">
                            <div class="row">
                                <div class="col-1"></div>
                                        <div class="col-10">
                                            <script type="text/javascript">
                                                google.charts.load('current', {'packages':['line']});
                                                google.charts.setOnLoadCallback(drawChart);

                                                function drawChart() {

                                                var data = new google.visualization.DataTable();
                                                data.addColumn('number', 'Date');
                                                data.addColumn('number', 'Sales');
                                                data.addColumn('number', 'Target');
                                                data.addColumn('number', 'Trend');

                                                data.addRows([
                                                    [1,  37.8, 80.8, 41.8],
                                                    [2,  30.9, 69.5, 32.4],
                                                    [3,  25.4,   57, 25.7],
                                                    [4,  11.7, 18.8, 10.5],
                                                    [5,  11.9, 17.6, 10.4],
                                                    [6,   8.8, 13.6,  7.7],
                                                    [7,   7.6, 12.3,  9.6],
                                                    [8,  12.3, 29.2, 10.6],
                                                    [9,  16.9, 42.9, 14.8],
                                                    [10, 12.8, 30.9, 11.6],
                                                    [11,  5.3,  7.9,  4.7],
                                                    [12,  6.6,  8.4,  5.2],
                                                    [13,  4.8,  6.3,  3.6],
                                                    [14,  4.2,  6.2,  3.4]
                                                ]);

                                                var options = {
                                                    chart: {
                                                    title: 'Target Chasing Graph',
                                                    subtitle: '$'
                                                    },
                                                    width: 900,
                                                    height: 500
                                                };

                                                var chart = new google.charts.Line(document.getElementById('linechart_material'));

                                                chart.draw(data, google.charts.Line.convertOptions(options));
                                                }
                                            </script>
                                            <div id="linechart_material"></div>
                                        </div>
                            </div>
                        </div><!-- col-4 -->
                    </div><!-- row -->



                    <div class="col-12 mg-b-15">
                        <div class="card bd-gray-400 pd-20">
                            <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15">Daily Target Tracking:</h6>
                            <style>
                                .table-dark > tbody > tr > th, .table-dark > tbody > tr > td {
                                    background-color: #ffffff !important;
                                    color: #060708;
                                    border: 0.5px solid #ecececcc !important;
                                }
                            </style>
                            <table id="" class=" table-dark table-hover">
                                <thead>
                                  <tr role="row">
                                    <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="First name: activate to sort column descending">Date</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Front</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Upsell</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Renewal</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Agregated Sales</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Target</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Daily Target</th>
                                  </tr>
                                </thead>
                                <tbody id="#">
                                    {{-- @foreach ($mainsalesTeam as $mainsalesTeams)
                                        <tr role="row" class="table-success">
                                            <td tabindex="0" class="sorting_1">{{$mainsalesTeams['leadID']}}</td>
                                            <td>${{$mainsalesTeams['leadtarget']}}</td>
                                            <td>${{$mainsalesTeams['leadfront']}}</td>
                                            <td>${{$mainsalesTeams['leadback']}}</td>
                                            <td>$0</td>
                                            <td>$0</td>
                                            <td>$0</td>
                                        </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>

                        </div><!-- card -->
                    </div><!-- col-4 -->



                <div class="col-12 mg-b-15">
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

          <script>
            $(document).ready(function () {


                $("#searchbranddata").click(function(event){
                    event.preventDefault();
                    let brandID = $("#getbranddata");
                    let monthID = $("#getmonth");
                    let yearID = $("#getyeardata");
                    $.ajax({
                            url:"/api/fetch-branddata",
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
                                $("#searchbranddata").text("wait...");
                                $("#searchbranddata").attr('disabled','disabled');
                            }),
                            success:((Response)=>{
                                console.log(Response);
                                if(Response.message == "NO BRAND FOUND !"){
                                    // alert(Response.message);

                                    let brandtargetofMonth =  "No Target set";
                                    document.getElementById("brandtarget").innerHTML = brandtargetofMonth;

                                    let brandsales =  Response.brandsales;
                                    document.getElementById("brandsales").innerHTML = brandsales;

                                    let chargeback = Response.chargeback;
                                    document.getElementById("branddisputes").innerHTML = chargeback;

                                    let disputefees = Response.disputefees;
                                    document.getElementById("disputefees").innerHTML = disputefees;

                                    let net_revenue = Response.net_revenue;
                                    document.getElementById("brand_net_revenue").innerHTML = net_revenue;

                                    let dispute = Response.dispute;
                                    document.getElementById("dispute").innerHTML =  dispute;

                                    let refund =  Response.refund;
                                    document.getElementById("refund").innerHTML =  refund;

                                    let front =  Response.front;
                                    document.getElementById("front").innerHTML =  front;

                                    let back =  Response.back;
                                    document.getElementById("back").innerHTML =  back;

                                    document.getElementById("subtotal").innerHTML = front + back

                                    let employees = Response.employees;
                                    let tableBody = document.getElementById('employeeTableBody');
                                    tableBody.innerHTML = '';

                                    employees.forEach(employee => {
                                        let row = document.createElement('tr');

                                        let agentname = document.createElement('td');
                                        agentname.textContent = employee.name;
                                        row.appendChild(agentname);

                                        let target = document.createElement('td');
                                        target.textContent = employee.target;  // Assuming employee has a 'target' property
                                        row.appendChild(target);

                                        let revenue = document.createElement('td');
                                        revenue.textContent = employee.totalcomplete;  // Assuming employee has a 'revenue' property
                                        row.appendChild(revenue);

                                        let front = document.createElement('td');
                                        front.textContent = employee.totalfront;  // Assuming employee has a 'front' property
                                        row.appendChild(front);

                                        let back = document.createElement('td');
                                        back.textContent = employee.totalback;  // Assuming employee has a 'back' property
                                        row.appendChild(back);

                                        let refund = document.createElement('td');
                                        refund.textContent = employee.refund;  // Assuming employee has a 'refund' property
                                        row.appendChild(refund);

                                        let chargeback = document.createElement('td');
                                        chargeback.textContent = employee.dispute;  // Assuming employee has a 'chargeback' property
                                        row.appendChild(chargeback);

                                        let ntotal = document.createElement('td');
                                        ntotal.textContent = employee.id;  // Assuming employee has a 'ntotal' property
                                        row.appendChild(ntotal);

                                        let exp = document.createElement('td');
                                        exp.textContent = employee.id;  // Assuming employee has a 'exp' property
                                        row.appendChild(exp);

                                        let nettotal = document.createElement('td');
                                        nettotal.textContent = employee.id;  // Assuming employee has a 'nettotal' property
                                        row.appendChild(nettotal);

                                        // Append the row to the table body
                                        tableBody.appendChild(row);
                                    });

                                    let selectedbrandname = Response.selectedbrandname[0].name;
                                    let brandfronttodaypayment = Response.brandfronttodaypayment;
                                    let brandbacktodaypayment = Response.brandbacktodaypayment;
                                    let brandalltodaypayment = Response.brandalltodaypayment;
                                    let brndtodaypayment = document.getElementById('brandtodaypayment');
                                    brndtodaypayment.innerHTML = '';

                                        let row1 = document.createElement('tr');

                                        let brandname = document.createElement('td');
                                        brandname.textContent = selectedbrandname;
                                        row1.appendChild(brandname);

                                        let fronttoday = document.createElement('td');
                                        fronttoday.textContent = brandfronttodaypayment;
                                        row1.appendChild(fronttoday);

                                        let backtoday = document.createElement('td');
                                        backtoday.textContent = brandbacktodaypayment;
                                        row1.appendChild(backtoday);

                                        let totaltoday = document.createElement('td');
                                        totaltoday.textContent = brandalltodaypayment;
                                        row1.appendChild(totaltoday);

                                        brndtodaypayment.appendChild(row1);


                                        let emptodaysdata = Response.employeetodayspayment;
                                        let emptodaypayment = document.getElementById('empdailypayment');
                                        emptodaypayment.innerHTML = '';

                                    emptodaysdata.forEach(emptodaysdatas => {
                                        let row2 = document.createElement('tr');

                                        let empname = document.createElement('td');
                                        empname.textContent = emptodaysdatas.name;
                                        row2.appendChild(empname);

                                        let emptoday = document.createElement('td');
                                        emptoday.textContent = emptodaysdatas.allrevenue;
                                        row2.appendChild(emptoday);

                                        let emptotal = document.createElement('td');
                                        emptotal.textContent = emptodaysdatas.allrevenue;
                                        row2.appendChild(emptotal);

                                        emptodaypayment.appendChild(row2);
                                    });

                                    let disputerefunddata = Response.disputerefund;
                                        let disputetable = document.getElementById('dispreftable');
                                        disputetable.innerHTML = '';

                                    disputerefunddata.forEach(disputerefunddatas => {
                                        let row3 = document.createElement('tr');

                                        let disputedate = document.createElement('td');
                                        disputedate.textContent = disputerefunddatas.date;
                                        row3.appendChild(disputedate);

                                        let disputebrand = document.createElement('td');
                                        disputebrand.textContent = disputerefunddatas.brand;
                                        row3.appendChild(disputebrand);

                                        let disputeclient = document.createElement('td');
                                        disputeclient.textContent = disputerefunddatas.client;
                                        row3.appendChild(disputeclient);

                                        let disputeamount = document.createElement('td');
                                        disputeamount.textContent = disputerefunddatas.amount;
                                        row3.appendChild(disputeamount);

                                        let disputeservices = document.createElement('td');
                                        disputeservices.textContent = disputerefunddatas.services;
                                        row3.appendChild(disputeservices);

                                        let disputeupseller = document.createElement('td');
                                        disputeupseller.textContent = disputerefunddatas.upseller;
                                        row3.appendChild(disputeupseller);

                                        let disputesupport = document.createElement('td');
                                        disputesupport.textContent = disputerefunddatas.support;
                                        row3.appendChild(disputesupport);

                                        let disputetype = document.createElement('td');
                                        disputetype.textContent = disputerefunddatas.type;
                                        row3.appendChild(disputetype);

                                        let disputefrontperson = document.createElement('td');
                                        disputefrontperson.textContent = disputerefunddatas.frontperson;
                                        row3.appendChild(disputefrontperson);

                                        disputetable.appendChild(row3);
                                    });

                                    let brand_ongoing = Response.brand_ongoing;
                                    let brand_refund = Response.brand_refund;
                                    let brand_chargeback = Response.brand_chargeback;

                                    let brand_renewal = Response.brand_renewal;
                                    let brand_upsell = Response.brand_upsell;
                                    let brand_newlead = Response.brand_newlead;

                                    displayArray(brand_ongoing , brand_refund, brand_chargeback);
                                    displaysales(brand_renewal , brand_upsell, brand_newlead);


                                    brandID.removeAttr('disabled');
                                    monthID.removeAttr('disabled');
                                    yearID.removeAttr('disabled');
                                    $("#searchbranddata").text("Search");
                                    $("#searchbranddata").removeAttr('disabled');

                                    return;
                                }
                                    let brandtargetofMonth =  Response.brandtargetofMonth;
                                    document.getElementById("brandtarget").innerHTML = brandtargetofMonth;

                                    let brandsales =  Response.brandsales;
                                    document.getElementById("brandsales").innerHTML = brandsales;

                                    let chargeback = Response.chargeback;
                                    document.getElementById("branddisputes").innerHTML = chargeback;

                                    let disputefees = Response.disputefees;
                                    document.getElementById("disputefees").innerHTML = disputefees;

                                    let net_revenue = Response.net_revenue;
                                    document.getElementById("brand_net_revenue").innerHTML = net_revenue;

                                    let dispute = Response.dispute;
                                    document.getElementById("dispute").innerHTML =  dispute;

                                    let refund =  Response.refund;
                                    document.getElementById("refund").innerHTML =  refund;

                                    let front =  Response.front;
                                    document.getElementById("front").innerHTML =  front;

                                    let back =  Response.back;
                                    document.getElementById("back").innerHTML =  back;

                                    // document.getElementById("subtotal").innerHTML = '';
                                    document.getElementById("subtotal").innerHTML = front + back

                                    let employees = Response.employees;
                                    let tableBody = document.getElementById('employeeTableBody');
                                    tableBody.innerHTML = '';

                                    employees.forEach(employee => {
                                        let row = document.createElement('tr');

                                        let agentname = document.createElement('td');
                                        agentname.textContent = employee.name;
                                        row.appendChild(agentname);

                                        let target = document.createElement('td');
                                        target.textContent = employee.target;
                                        row.appendChild(target);

                                        let revenue = document.createElement('td');
                                        revenue.textContent = employee.totalcomplete;
                                        row.appendChild(revenue);

                                        let front = document.createElement('td');
                                        front.textContent = employee.totalfront;
                                        row.appendChild(front);

                                        let back = document.createElement('td');
                                        back.textContent = employee.totalback;
                                        row.appendChild(back);

                                        let refund = document.createElement('td');
                                        refund.textContent = employee.refund;
                                        row.appendChild(refund);

                                        let chargeback = document.createElement('td');
                                        chargeback.textContent = employee.dispute;
                                        row.appendChild(chargeback);

                                        let ntotal = document.createElement('td');
                                        ntotal.textContent = employee.id;
                                        row.appendChild(ntotal);

                                        let exp = document.createElement('td');
                                        exp.textContent = employee.id;
                                        row.appendChild(exp);

                                        let nettotal = document.createElement('td');
                                        nettotal.textContent = employee.id;
                                        row.appendChild(nettotal);

                                        tableBody.appendChild(row);
                                    });


                                    let selectedbrandname = Response.selectedbrandname[0].name;
                                    let brandfronttodaypayment = Response.brandfronttodaypayment;
                                    let brandbacktodaypayment = Response.brandbacktodaypayment;
                                    let brandalltodaypayment = Response.brandalltodaypayment;
                                    let brndtodaypayment = document.getElementById('brandtodaypayment');
                                    brndtodaypayment.innerHTML = '';

                                        let row1 = document.createElement('tr');

                                        let brandname = document.createElement('td');
                                        brandname.textContent = selectedbrandname;
                                        row1.appendChild(brandname);

                                        let fronttoday = document.createElement('td');
                                        fronttoday.textContent = brandfronttodaypayment;
                                        row1.appendChild(fronttoday);

                                        let backtoday = document.createElement('td');
                                        backtoday.textContent = brandbacktodaypayment;
                                        row1.appendChild(backtoday);

                                        let totaltoday = document.createElement('td');
                                        totaltoday.textContent = brandalltodaypayment;
                                        row1.appendChild(totaltoday);

                                        brndtodaypayment.appendChild(row1);


                                        let emptodaysdata = Response.employeetodayspayment;
                                        let emptodaypayment = document.getElementById('empdailypayment');
                                        emptodaypayment.innerHTML = '';

                                    emptodaysdata.forEach(emptodaysdatas => {
                                        let row2 = document.createElement('tr');

                                        let empname = document.createElement('td');
                                        empname.textContent = emptodaysdatas.name;
                                        row2.appendChild(empname);

                                        let emptoday = document.createElement('td');
                                        emptoday.textContent = emptodaysdatas.allrevenue;
                                        row2.appendChild(emptoday);

                                        let emptotal = document.createElement('td');
                                        emptotal.textContent = emptodaysdatas.allrevenue;
                                        row2.appendChild(emptotal);

                                        emptodaypayment.appendChild(row2);
                                    });


                                    let disputerefunddata = Response.disputerefund;
                                        let disputetable = document.getElementById('dispreftable');
                                        disputetable.innerHTML = '';

                                    disputerefunddata.forEach(disputerefunddatas => {
                                        let row3 = document.createElement('tr');

                                        let disputedate = document.createElement('td');
                                        disputedate.textContent = disputerefunddatas.date;
                                        row3.appendChild(disputedate);

                                        let disputebrand = document.createElement('td');
                                        disputebrand.textContent = disputerefunddatas.brand;
                                        row3.appendChild(disputebrand);

                                        let disputeclient = document.createElement('td');
                                        disputeclient.textContent = disputerefunddatas.client;
                                        row3.appendChild(disputeclient);

                                        let disputeamount = document.createElement('td');
                                        disputeamount.textContent = disputerefunddatas.amount;
                                        row3.appendChild(disputeamount);

                                        let disputeservices = document.createElement('td');
                                        disputeservices.textContent = disputerefunddatas.services;
                                        row3.appendChild(disputeservices);

                                        let disputeupseller = document.createElement('td');
                                        disputeupseller.textContent = disputerefunddatas.upseller;
                                        row3.appendChild(disputeupseller);

                                        let disputesupport = document.createElement('td');
                                        disputesupport.textContent = disputerefunddatas.support;
                                        row3.appendChild(disputesupport);

                                        let disputetype = document.createElement('td');
                                        disputetype.textContent = disputerefunddatas.type;
                                        row3.appendChild(disputetype);

                                        let disputefrontperson = document.createElement('td');
                                        disputefrontperson.textContent = disputerefunddatas.frontperson;
                                        row3.appendChild(disputefrontperson);

                                        disputetable.appendChild(row3);
                                    });

                                    let brand_ongoing = Response.brand_ongoing;
                                    let brand_refund = Response.brand_refund;
                                    let brand_chargeback = Response.brand_chargeback;

                                    let brand_renewal = Response.brand_renewal;
                                    let brand_upsell = Response.brand_upsell;
                                    let brand_newlead = Response.brand_newlead;

                                    displayArray(brand_ongoing , brand_refund, brand_chargeback);
                                    displaysales(brand_renewal , brand_upsell, brand_newlead);



                                    brandID.removeAttr('disabled');
                                    monthID.removeAttr('disabled');
                                    yearID.removeAttr('disabled');
                                    $("#searchbranddata").text("Search");
                                    $("#searchbranddata").removeAttr('disabled');


                            }),
                            error:((error)=>{
                                console.log(error);
                                alert("Error Found Please Referesh Window And Try Again !")

                                brandID.removeAttr('disabled');
                                monthID.removeAttr('disabled');
                                yearID.removeAttr('disabled');
                                $("#searchbranddata").text("Search");
                                $("#searchbranddata").removeAttr('disabled');
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

                                    // Append the row to the table
                                    brandtodaypayment.appendChild(row1);
                                });

                                // Retrieve employee data and table element
                                let emptodaysdata = Response.employees;
                                let emptodaypayment = document.getElementById('empdailypayment');
                                emptodaypayment.innerHTML = ''; // Clear existing table content

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

                                    // Append the row to the table
                                    emptodaypayment.appendChild(row2);
                                });



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
@endsection
