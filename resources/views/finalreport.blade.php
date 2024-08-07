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
                                <div class="col-9">
                                </div>
                                <div class="col-3" style="text-align: right">
                                    <label style="background-color: white; color: black; font-weight: bold; border: 1px solid white; text-align: right; font-size: 20px;">Number of Days Left:</label>
                                    <label id="remainingdays" style="background-color: #FF9933; color: black; font-weight: bold; border: 1px solid white; text-align: right; font-size: 20px;">--</label>

                                </div>
                            </div>
                        </div>
                            <table id="" class="table-dark table-hover">
                                <thead>
                                    <tr role="row">
                                        <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 253px; background-color: black; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-sort="ascending" aria-label="First name: activate to sort column descending">Brand</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: black; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Target</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #66B2FF; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Front</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #66B2FF; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Back</th>

                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #FF9933; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Upsell</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #FF9933; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Remaining</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #FF9933; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Renewal/Recurring</th>

                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #66B2FF; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Subtotal</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #FF0000; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Fee</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #FF0000; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Refund</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #FF0000; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Chargeback</th>
                                        <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: black; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Net Rev</th>
                                    </tr>
                                </thead>
                                <tbody id="startingtable">
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td style="background-color: black; color: white; font-weight: bold; border: 1px solid white; text-align: center;">Total</td>
                                        <td style="background-color: #808080; color: black; font-weight: bold; border: 1px solid white; text-align: center;"><label id="totaltargte"></label></td>
                                        <td style="background-color: #66B2FF; color: black; font-weight: bold; border: 1px solid white; text-align: center;"><label id="totalfront"></label></td>
                                        <td style="background-color: #66B2FF; color: black; font-weight: bold; border: 1px solid white; text-align: center;"><label id="totalback"></label></td>

                                        <td style="background-color: #FF9933; color: black; font-weight: bold; border: 1px solid white; text-align: center;"><label id="totalback23"></label></td>
                                        <td style="background-color: #FF9933; color: black; font-weight: bold; border: 1px solid white; text-align: center;"><label id="totalback24"></label></td>
                                        <td style="background-color: #FF9933; color: black; font-weight: bold; border: 1px solid white; text-align: center;"><label id="totalback25"></label></td>

                                        <td style="background-color: #66B2FF; color: black; font-weight: bold; border: 1px solid white; text-align: center;"><label id="totalsubtotal"></label></td>
                                        <td style="background-color: #FF9999; color: black; font-weight: bold; border: 1px solid white; text-align: center;"><label id="totalfee"></label></td>
                                        <td style="background-color: #FF9999; color: black; font-weight: bold; border: 1px solid white; text-align: center;"><label id="totalrefund"></label></td>
                                        <td style="background-color: #FF9999; color: black; font-weight: bold; border: 1px solid white; text-align: center;"><label id="totalchargeback"></label></td>
                                        <td style="background-color: black; color: white; font-weight: bold; border: 1px solid white; text-align: center;"><label id="totalnetrevenue"></label></td>
                                    </tr>
                                </tbody>
                            </table>

                    </div>
                    {{-- end set 1 --}}

                    <div class="col-12" id="alltables">
                        <br><br>
                        <table id="" class="table-dark table-hover">
                            <thead>
                                <tr role="row">
                                    <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 253px; background-color: black; color: white; font-weight: bold; text-align: center; border-top: none; border-right: none; border-left: none; border-bottom: 3px double white;" aria-sort="ascending" aria-label="First name: activate to sort column descending">Agents Name</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: black; color: white; font-weight: bold;  text-align: center; border-top: none; border-right: none; border-left: none; border-bottom: 3px double white;" aria-label="Last name: activate to sort column ascending">Target</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: black; color: white; font-weight: bold;  text-align: center; border-top: none; border-right: none; border-left: none; border-bottom: 3px double white;" aria-label="Last name: activate to sort column ascending">Revenue</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: black; color: white; font-weight: bold;  text-align: center; border-top: none; border-right: none; border-left: none; border-bottom: 3px double white;" aria-label="Last name: activate to sort column ascending">Front</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: black; color: white; font-weight: bold;  text-align: center; border-top: none; border-right: none; border-left: none; border-bottom: 3px double white;" aria-label="Last name: activate to sort column ascending">Back</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: black; color: white; font-weight: bold;  text-align: center; border-top: none; border-right: none; border-left: none; border-bottom: 3px double white;" aria-label="Last name: activate to sort column ascending">Refund</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: black; color: white; font-weight: bold;  text-align: center; border-top: none; border-right: none; border-left: none; border-bottom: 3px double white;" aria-label="Last name: activate to sort column ascending">Chargeback</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #5F9B6B; color: white; font-weight: bold;  text-align: center; border-top: none; border-right: none; border-left: none; border-bottom: 3px double white;" aria-label="Last name: activate to sort column ascending">N. Total</th>
                                </tr>
                            </thead>
                            <tbody id="employeeTableBody"></tbody>
                            <tbody >
                                <tr>
                                    <td style="background-color: black;"></td>
                                    <td style="background-color: black;"></td>
                                    <td style="background-color: black;"></td>
                                    <td style="background-color: black;"></td>
                                    <td style="background-color: black;"></td>
                                    <td style="background-color: black;"></td>
                                    <td style="background-color: black; color: white; font-weight: bold; text-align: center;">Total</td>
                                    <td style="background-color: #66B2FF; color: white; font-weight: bold; text-align: center; border:  3px double white;"><label id="agentsnettotal"></label></td>
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
                                            <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 253px; background-color: #4169E1; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-sort="ascending" aria-label="First name: activate to sort column descending">Brand</th>
                                            <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #5F9B6B; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Front</th>
                                            <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #FFCCCC; color: black; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Back</th>
                                            <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #FFCCCC; color: black; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Upsell</th>
                                            <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #FFCCCC; color: black; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Remaining</th>
                                            <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #FFCCCC; color: black; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Renewal/Recurring</th>
                                            <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #FF9933; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="brandtodaypayment"></tbody>
                                    <tbody >
                                        <tr>
                                            <td style="background-color: #4169E1; color: white; font-weight: bold; border: 1px solid white; text-align: center;">Total</td>
                                            <td style="background-color: #4169E1; color: white; font-weight: bold; border: 1px solid white; text-align: center;"><label id="brandtodayfront"></label></td>
                                            <td style="background-color: #4169E1; color: white; font-weight: bold; border: 1px solid white; text-align: center;"><label id="brandtodayback"></label></td>
                                            <td style="background-color: #4169E1; color: white; font-weight: bold; border: 1px solid white; text-align: center;"><label id="brandtodayupsell"></label></td>
                                            <td style="background-color: #4169E1; color: white; font-weight: bold; border: 1px solid white; text-align: center;"><label id="brandtodayremaining"></label></td>
                                            <td style="background-color: #4169E1; color: white; font-weight: bold; border: 1px solid white; text-align: center;"><label id="brandtodayrenewals"></label></td>
                                            <td style="background-color: #5F9B6B; color: white; font-weight: bold; border: 1px solid white; text-align: center;"><label id="brandtodaytotal"></label></td>
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
                                            <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1"  style="width: 253px; background-color: #B0C4DE; color: black; font-weight: bold; border: 1px solid white; text-align: center;"  aria-sort="ascending" aria-label="First name: activate to sort column descending">Agents Name</th>
                                            <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1"  style="width: 203px; background-color: #4169E1; color: white; font-weight: bold; border: 1px solid white; text-align: center;"  aria-label="Last name: activate to sort column ascending">Revenue</th>
                                            <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1"  style="width: 203px; background-color: #5F9B6B; color: white; font-weight: bold; border: 1px solid white; text-align: center;"  aria-label="Last name: activate to sort column ascending">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="empdailypayment"></tbody>
                                    <tbody >
                                        <tr>
                                            <td style="background-color: #4169E1; color: white; font-weight: bold; border: 1px solid white; text-align: center;"></td>
                                            <td style="background-color: #4169E1; color: white; font-weight: bold; border: 1px solid white; text-align: center;">Total</td>
                                            <td style="background-color: #5F9B6B; color: white; font-weight: bold; border: 1px solid white; text-align: center;"><label id="emptodaytotal"></label></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div>

                    <div class="col-12">
                        <br><br>
                        <div class="row">
                            <div class="col-10"><h4 style="background-color: white ; color: black; font-weight: bold; ">Refund & Disputes Report:</h4></div>
                            <div class="col-2">
                            </div>
                        </div>
                    </div>

                    <div class="col-12" id="allrefundsandcbs">


                        <table id="" class="table-dark table-hover">
                            <thead>
                                <tr role="row">
                                    <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1"  style="width: 203px; background-color: black; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-sort="ascending" aria-label="First name: activate to sort column descending">Date</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1"  style="width: 203px; background-color: black; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Brand</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1"  style="width: 203px; background-color: black; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Client Name</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1"  style="width: 203px; background-color: black; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Amount</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1"  style="width: 203px; background-color: black; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Service</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1"  style="width: 203px; background-color: black; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Support</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1"  style="width: 203px; background-color: black; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Type</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1"  style="width: 203px; background-color: black; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Front Person</th>
                                </tr>
                            </thead>
                        </table>
                    </div>


                    <div class="col-4" >
                        <br><br>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-10"><h4 style="background-color: white ; color: black; font-weight: bold; ">Dispute & Refund % Chart:</h4></div>
                                <div class="col-2"></div>
                            </div>
                            <div class="row" id="refundgraph"></div>
                        </div>

                        <script type="text/javascript">
                            function displayArrayDispute(chartId, brand_name, brand_ongoing, brand_refund, brand_chargeback) {
                                google.charts.load('current', {'packages': ['corechart']});

                                google.charts.setOnLoadCallback(function () {
                                    drawChartDispute(chartId, brand_name, brand_ongoing, brand_refund, brand_chargeback);
                                });

                                function drawChartDispute(chartId, brand_name, brand_ongoing, brand_refund, brand_chargeback) {
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
                                        colors: ['green', 'red', '#FF8C00'],
                                        'width': 500,
                                        'height': 400
                                    };

                                    var chart = new google.visualization.PieChart(document.getElementById(chartId));
                                    chart.draw(data, options);
                                }
                            }
                        </script>

                    </div>

                    <div class="col-4">
                        <br><br>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-10" id="hideornot"><h4 style="background-color: white ; color: black; font-weight: bold; ">Target Chasing Graph:</h4></div>
                                <div class="col-2"></div>
                            </div>
                            <div class="row" id="linechart_container"></div>
                        </div>

                        <script type="text/javascript">
                            function displayForecast(chartId, brandData, brandName) {
                            google.charts.load('current', {'packages': ['line']});

                            google.charts.setOnLoadCallback(function () {
                                drawChartForecast(chartId, brandData, brandName);
                            });

                            function drawChartForecast(chartId, brandData, brandName) {
                                var data = new google.visualization.DataTable();
                                data.addColumn('string', 'Date');
                                data.addColumn('number', 'Revenue');
                                data.addColumn('number', 'Forecast');
                                data.addColumn('number', 'Target');

                                // Convert brand data to rows
                                let rows = [];
                                brandData.forEach(entry => {
                                    let date = entry.date;
                                    let rowData = entry;
                                    rows.push([date, rowData.revenue, rowData.revenueforecast, rowData.Target]);
                                });

                                data.addRows(rows);

                                var options = {
                                    'title': brandName + ' Target Chasing Graph:',
                                    colors: ['green', '#1E90FF', '#EF8923'],
                                    width: 500,
                                    height: 300,
                                    titleTextStyle: {
                                    // fontSize: 18, // Adjust the font size if needed
                                    bold: true
                                    }
                                };

                                var chart = new google.charts.Line(document.getElementById(chartId));
                                chart.draw(data, google.charts.Line.convertOptions(options));
                            }
                        }
                        </script>

                    </div>

                    <div class="col-4">
                        <br><br>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-10"><h4 style="background-color: white ; color: black; font-weight: bold; ">Sales Distribution Chart:</h4></div>
                                <div class="col-2"></div>
                            </div>
                            <div class="row" id="salesgraph"></div>
                        </div>
                    </div>

                    <script type="text/javascript">
                             function displayArraySales(chartId, brand_name, brand_renewal, brand_upsell, brand_newlead) {
                                google.charts.load('current', {'packages': ['corechart']});

                                google.charts.setOnLoadCallback(function () {
                                    drawChartSales(chartId, brand_name, brand_renewal, brand_upsell, brand_newlead);
                                });

                                function drawChartSales(chartId, brand_name, brand_renewal, brand_upsell, brand_newlead) {
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
                                        colors: ['#008080', '#800080', 'green'],
                                        'width': 500,
                                        'height': 400
                                    };

                                    var chart = new google.visualization.PieChart(document.getElementById(chartId));
                                    chart.draw(data, options);
                                }
                            }
                    </script>

                    <div class="col-12 mg-b-15">
                        <br><br>
                        <div >
                            <h4 style="background-color: white ; color: black; font-weight: bold; "> Team Target Monitoring:</h4>
                            <table id="" class=" ">
                                <thead>
                                  <tr role="row">
                                    <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="First name: activate to sort column descending" style="width: 253px; background-color: #808080; color: white; font-weight: bold; border: 1px solid white; text-align: center;">Team</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #808080; color: white; font-weight: bold; border: 1px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Target</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #808080; color: white; font-weight: bold; border: 1px solid white; text-align: center;"  aria-label="Last name: activate to sort column ascending">Front</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #808080; color: white; font-weight: bold; border: 1px solid white; text-align: center;"  aria-label="Last name: activate to sort column ascending">Back</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #808080; color: white; font-weight: bold; border: 1px solid white; text-align: center;"  aria-label="Last name: activate to sort column ascending">Refund</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #808080; color: white; font-weight: bold; border: 1px solid white; text-align: center;"  aria-label="Last name: activate to sort column ascending">Net</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #808080; color: white; font-weight: bold; border: 1px solid white; text-align: center;"  aria-label="Last name: activate to sort column ascending">Team Net</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #808080; color: white; font-weight: bold; border: 1px solid white; text-align: center;"  aria-label="Last name: activate to sort column ascending">Team Target</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #808080; color: white; font-weight: bold; border: 1px solid white; text-align: center;"  aria-label="Last name: activate to sort column ascending">Achieved</th>
                                  </tr>
                                </thead>
                                <tbody id="#">
                                    @foreach ($mainsalesTeam as $mainsalesTeams)
                                    @php
                                    $a = $mainsalesTeams['totalteamtarget'];
                                    $b = $mainsalesTeams['totalteamnet'];
                                    $c = $mainsalesTeams['totalteamtarget'] - $mainsalesTeams['totalteamnet'];
                                    @endphp
                                    {{-- <tr role="row" class="table-danger"> --}}
                                    <tr role="row">
                                        <td tabindex="0" class="sorting_1" style="width: 253px; background-color: #A9A9A9; color: white; border-left: none; border-right: none; border-top: 7px solid white; border-bottom: none; text-align: left;">{{$mainsalesTeams['leadID']}}</td>
                                        <td style="background-color: #A9A9A9; color: white; border-left: none; border-right: none; border-top: 7px solid white; border-bottom: none; text-align: center;">${{$mainsalesTeams['leadtarget']}}</td>
                                        <td style="background-color: #A9A9A9; color: white; border-left: none; border-right: none; border-top: 7px solid white; border-bottom: none; text-align: center;">${{$mainsalesTeams['leadfront']}}</td>
                                        <td style="background-color: #A9A9A9; color: white; border-left: none; border-right: none; border-top: 7px solid white; border-bottom: none; text-align: center;">${{$mainsalesTeams['leadback']}}</td>
                                        <td style="background-color: #A9A9A9; color: white; border-left: none; border-right: none; border-top: 7px solid white; border-bottom: none; text-align: center;">${{$mainsalesTeams['leadrefund']}}</td>
                                        @if ($mainsalesTeams['leadnet'] > 0)
                                        <td style="background-color: black; color: #FFC680; border-left: none; border-right: none; border-top: 7px solid white; border-bottom: none; text-align: center;">${{$mainsalesTeams['leadnet']}}</td>
                                        @else
                                        <td style="background-color: #A9A9A9; color: red; border-left: none; border-right: none; border-top: 7px solid white; border-bottom: none; text-align: center;">${{$mainsalesTeams['leadnet']}}</td>
                                        @endif
                                        <td style="background-color: black; color: #FFC680; border-left: none; border-right: none; border-top: 7px solid white; border-bottom: none; text-align: center;">${{$mainsalesTeams['totalteamtarget']}}</td>
                                        <td style="background-color: black; color: #FFC680; border-left: none; border-right: none; border-top: 7px solid white; border-bottom: none; text-align: center;">${{$mainsalesTeams['totalteamnet']}}</td>
                                        @if ($c > 0)
                                        <td style="background-color: #A9A9A9; color: white; border-left: none; border-right: none; border-top: 7px solid white; border-bottom: none; text-align: center; font-weight: bold;">${{$c}}</td>
                                        @else
                                        <td style="background-color: red; color: white; border-left: none; border-right: none; border-top: 7px solid white; border-bottom: none; text-align: center; font-weight: bold;">${{$c}}</td>
                                        @endif
                                    </tr>
                                    @php
                                        $member = $mainsalesTeams['membersdata'];
                                    @endphp

                                    @foreach($member  as $dm)
                                    <tr role="row" >
                                        <td tabindex="0" class="sorting_1" style="width: 253px; background-color: #E0E0E0; color: black; text-align: left;">{{$dm['memberID']}}</td>
                                        <td style=" background-color: #E0E0E0; color: black; border-left: none ; border-right: none; border-top: none; border-bottom: 3px dotted white;  text-align: center;">${{$dm['membertarget']}}</td>
                                        <td style=" background-color: #E0E0E0; color: black; border-left: none ; border-right: none; border-top: none; border-bottom: 3px dotted white; text-align: center;">${{$dm['memberfront']}}</td>
                                        <td style=" background-color: #E0E0E0; color: black; border-left: none ; border-right: none; border-top: none; border-bottom: 3px dotted white; text-align: center;">${{$dm['memberback']}}</td>
                                        <td style=" background-color: #E0E0E0; color: black; border-left: none ; border-right: none; border-top: none; border-bottom: 3px dotted white; text-align: center;">${{$dm['memberrefund']}}</td>
                                        @if ($dm['membernet'] > 0)
                                        <td style="background-color: black; color: #FFC680; border-left: none; border-right: none; border-top: none; border-bottom: 3px dotted white; text-align: center;">${{$dm['membernet']}}</td>
                                        @else
                                        <td style=" background-color: #E0E0E0; color: red; border-left: none ; border-right: none; border-top: none; border-bottom: 3px dotted white; text-align: center;">${{$dm['membernet']}}</td>
                                        @endif
                                        <td style=" background-color: black; color: black; border-left: none ; border-right: none; border-top: none; border-bottom: none; text-align: center;"></td>
                                        <td style=" background-color: black; color: black; border-left: none ; border-right: none; border-top: none; border-bottom: none; text-align: center;"></td>
                                        @if ($c > 0)
                                        <td style=" background-color: #A9A9A9;"></td>
                                        @else
                                        <td style=" background-color: red; "></td>
                                        @endif
                                    </tr>
                                    @endforeach

                                    @endforeach
                                </tbody>
                            </table>

                        </div><!-- card -->

                    </div><!-- col-4 -->

                    <div class="col-4">
                        <a href="/dashboard"><button class="btn btn-outline-primary">BACK</button></a>
                    </div>

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

                                    let eachbrandtotalupsell = [];
                                    let eachbrandtotalremaining = [];
                                    let eachbrandtotalrenewal = [];

                                    brandrev.forEach(brandrevs => {

                                        if(brandrevs.totalfront != 0 ||  brandrevs.totalback != 0 ||  brandrevs.brandsales != 0 || brandrevs.refund  != 0 || brandrevs.dispute != 0 ||  brandrevs.net_revenue  != 0  ){

                                        let rowbrand = document.createElement('tr');

                                        let brandname = document.createElement('td');
                                        brandname.textContent = brandrevs.name;
                                        brandname.style.backgroundColor = 'white';
                                        brandname.style.fontWeight = 'bold';
                                        brandname.style.color = 'black';
                                        brandname.style.border = '1px solid #B8860B';
                                        brandname.style.textAlign = 'left';
                                        brandname.style.width = '253px';
                                        rowbrand.appendChild(brandname);

                                        let brandtarget = document.createElement('td');
                                        let o = brandrevs.brandtarget;
                                        let p = (o !== 0) ?   "$" + o : "";
                                        brandtarget.textContent =  p;
                                        brandtarget.style.backgroundColor = 'white';
                                        brandtarget.style.color = 'black';
                                        brandtarget.style.border = '1px solid #B8860B';
                                        brandtarget.style.textAlign = 'center';
                                        rowbrand.appendChild(brandtarget);

                                        let totalfront = document.createElement('td');
                                        let a = brandrevs.totalfront;
                                        let b = (a !== 0) ?   "$" + a : "";
                                        totalfront.textContent = b;
                                        totalfront.style.backgroundColor = '#CCE6FF';
                                        totalfront.style.color = 'black';
                                        totalfront.style.border = '1px solid white';
                                        totalfront.style.textAlign = 'center';
                                        rowbrand.appendChild(totalfront);

                                        let totalback = document.createElement('td');
                                        let c = brandrevs.totalback;
                                        let d = (c !== 0) ?  "$" + c : "";
                                        totalback.textContent = d;
                                        totalback.style.backgroundColor = '#CCE6FF';
                                        totalback.style.color = 'black';
                                        totalback.style.border = '1px solid white';
                                        totalback.style.textAlign = 'center';
                                        rowbrand.appendChild(totalback);

                                        let totalupsells = document.createElement('td');
                                        let cz = brandrevs.brandupsell;
                                        let dz = (cz !== 0) ?  "$" + cz : "";
                                        totalupsells.textContent = dz;
                                        totalupsells.style.backgroundColor = '#FFE6CC';
                                        totalupsells.style.color = 'black';
                                        totalupsells.style.border = '1px solid white';
                                        totalupsells.style.textAlign = 'center';
                                        rowbrand.appendChild(totalupsells);

                                        let totalremaining = document.createElement('td');
                                        let cy = brandrevs.brandremaining;
                                        let dy = (cy !== 0) ?  "$" + cy : "";
                                        totalremaining.textContent = dy;
                                        totalremaining.style.backgroundColor = '#FFE6CC';
                                        totalremaining.style.color = 'black';
                                        totalremaining.style.border = '1px solid white';
                                        totalremaining.style.textAlign = 'center';
                                        rowbrand.appendChild(totalremaining);

                                        let totalrenewals= document.createElement('td');
                                        let cx = brandrevs.sumofallrenewals;
                                        let dx = (cx !== 0) ?  "$" + cx : "";
                                        totalrenewals.textContent = dx;
                                        totalrenewals.style.backgroundColor = '#FFE6CC';
                                        totalrenewals.style.color = 'black';
                                        totalrenewals.style.border = '1px solid white';
                                        totalrenewals.style.textAlign = 'center';
                                        rowbrand.appendChild(totalrenewals);

                                        let frontBacksum = document.createElement('td');
                                        let e = brandrevs.brandsales;
                                        let f = (e !== 0) ?  "$" + e : "";
                                        frontBacksum.textContent = f;
                                        frontBacksum.style.backgroundColor = '#CCE6FF';
                                        frontBacksum.style.color = 'black';
                                        frontBacksum.style.border = '1px solid white';
                                        frontBacksum.style.textAlign = 'center';
                                        rowbrand.appendChild(frontBacksum);

                                        let disputefees = document.createElement('td');
                                        let g = brandrevs.disputefees;
                                        let h = (g !== 0) ?  "$" + g : "";
                                        disputefees.textContent = h;
                                        disputefees.style.backgroundColor = '#FFCCCC';
                                        disputefees.style.color = 'black';
                                        disputefees.style.border = '1px solid white';
                                        disputefees.style.textAlign = 'center';
                                        rowbrand.appendChild(disputefees);

                                        let refund = document.createElement('td');
                                        let i = brandrevs.refund;
                                        let j = (i !== 0) ?  "$" + i : "";
                                        refund.textContent = j;
                                        refund.style.backgroundColor = '#FFCCCC';
                                        refund.style.color = 'black';
                                        refund.style.border = '1px solid white';
                                        refund.style.textAlign = 'center';
                                        rowbrand.appendChild(refund);

                                        let dispute = document.createElement('td');
                                        let k = brandrevs.dispute;
                                        let l = (k !== 0) ?  "$" + k : "";
                                        dispute.textContent = l;
                                        dispute.style.backgroundColor = '#FFCCCC';
                                        dispute.style.color = 'black';
                                        dispute.style.border = '1px solid white';
                                        dispute.style.textAlign = 'center';
                                        rowbrand.appendChild(dispute);

                                        let net_revenue = document.createElement('td');
                                        let m = brandrevs.net_revenue;
                                        let n = (m !== 0) ?  "$" + m : "";
                                        net_revenue.textContent = n;
                                        net_revenue.style.backgroundColor = 'white';
                                        net_revenue.style.color = 'black';
                                        net_revenue.style.border = '1px solid #B8860B';
                                        net_revenue.style.textAlign = 'center';
                                        rowbrand.appendChild(net_revenue);


                                        totaltarget.push(parseFloat(brandrevs.brandtarget));
                                        totalfront1.push(parseFloat(brandrevs.totalfront));
                                        totalback1.push(parseFloat(brandrevs.totalback));
                                        totalfrontback1.push(parseFloat(brandrevs.frontBacksum));
                                        totalfrontfee1.push(parseFloat(brandrevs.disputefees));
                                        totalrefund1.push(parseFloat(brandrevs.refund));
                                        totalcb1.push(parseFloat(brandrevs.dispute));
                                        totalnetrevenue1.push(parseFloat(brandrevs.net_revenue));
                                        eachbrandtotalupsell.push(parseFloat(brandrevs.brandupsell));
                                        eachbrandtotalremaining.push(parseFloat(brandrevs.brandremaining));
                                        eachbrandtotalrenewal.push(parseFloat(brandrevs.sumofallrenewals));

                                        mytableBody.appendChild(rowbrand);
                                        };

                                    });

                                    let sumBrandtarget = totaltarget.reduce((acc, curr) => acc + curr, 0);
                                    let q = (sumBrandtarget !== 0) ? "$" + sumBrandtarget : "";
                                    document.getElementById("totaltargte").innerHTML = q;
                                    //----------------------------------------------------------------

                                    let sumBrandfront = totalfront1.reduce((acc, curr) => acc + curr, 0);
                                    let r = (sumBrandfront !== 0) ? "$" + sumBrandfront : "";
                                    document.getElementById("totalfront").innerHTML = r;
                                    //----------------------------------------------------------------

                                    let sumBrandback = totalback1.reduce((acc, curr) => acc + curr, 0);
                                    let s = (sumBrandback !== 0) ? "$" + sumBrandback : "";
                                    document.getElementById("totalback").innerHTML = s;
                                    //----------------------------------------------------------------

                                    let sumBrandfrontback = totalfrontback1.reduce((acc, curr) => acc + curr, 0);
                                    let t = (sumBrandfrontback !== 0) ? "$" + sumBrandfrontback : "";
                                    document.getElementById("totalsubtotal").innerHTML = t;
                                    //----------------------------------------------------------------

                                    let sumBrandfees = totalfrontfee1.reduce((acc, curr) => acc + curr, 0);
                                    let u = (sumBrandfees !== 0) ? "$" + sumBrandfees : "";
                                    document.getElementById("totalfee").innerHTML = u;
                                    //----------------------------------------------------------------

                                    let sumBrandrefund = totalrefund1.reduce((acc, curr) => acc + curr, 0);
                                    let v = (sumBrandrefund !== 0) ? "$" + sumBrandrefund : "";
                                    document.getElementById("totalrefund").innerHTML = v;
                                    //----------------------------------------------------------------

                                    let sumBrandcb = totalcb1.reduce((acc, curr) => acc + curr, 0);
                                    let w = (sumBrandcb !== 0) ? "$" + sumBrandcb : "";
                                    document.getElementById("totalchargeback").innerHTML = w;
                                    //----------------------------------------------------------------

                                    let sumBrandnetrevenue = totalnetrevenue1.reduce((acc, curr) => acc + curr, 0);
                                    let x = (sumBrandnetrevenue !== 0) ? "$" + sumBrandnetrevenue : "";
                                    document.getElementById("totalnetrevenue").innerHTML = x;
                                    //----------------------------------------------------------------

                                    let eachbrandtotalupsell1 = eachbrandtotalupsell.reduce((acc, curr) => acc + curr, 0);
                                    let vz = (eachbrandtotalupsell1 !== 0) ? "$" + eachbrandtotalupsell1 : "";
                                    document.getElementById("totalback23").innerHTML = vz;
                                    //----------------------------------------------------------------

                                    let eachbrandtotalremaining1 = eachbrandtotalremaining.reduce((acc, curr) => acc + curr, 0);
                                    let wz = (eachbrandtotalremaining1 !== 0) ? "$" + eachbrandtotalremaining1 : "";
                                    document.getElementById("totalback24").innerHTML = wz;
                                    //----------------------------------------------------------------

                                    let eachbrandtotalrenewal1 = eachbrandtotalrenewal.reduce((acc, curr) => acc + curr, 0);
                                    let xz = (eachbrandtotalrenewal1 !== 0) ? "$" + eachbrandtotalrenewal1 : "";
                                    document.getElementById("totalback25").innerHTML = xz;
                                    //----------------------------------------------------------------

                                    let employees11 = Response.employeepayment;
                                    let allTablesDiv = document.getElementById('alltables');
                                    allTablesDiv.innerHTML = '';

                                    employees11.forEach(employee121 => {

                                        if(employee121.check == "True"){

                                        let headingContainer = document.createElement('div');
                                        headingContainer.className = 'col-12';

                                        let rowDiv = document.createElement('div');
                                        rowDiv.className = 'row';

                                        let col10Div = document.createElement('div');
                                        col10Div.className = 'col-10';

                                        let col2Div = document.createElement('div');
                                        col2Div.className = 'col-2';

                                        let heading = document.createElement('h4');
                                        heading.style = 'background-color: white; color: black; font-weight: bold;';
                                        heading.textContent = 'Brand: ' + employee121.brandname;

                                        let lineBreak1 = document.createElement('br');
                                        let lineBreak2 = document.createElement('br');
                                        col10Div.appendChild(lineBreak1);
                                        col10Div.appendChild(lineBreak2);

                                        col10Div.appendChild(heading);
                                        rowDiv.appendChild(col10Div);
                                        rowDiv.appendChild(col2Div);
                                        headingContainer.appendChild(rowDiv);
                                        allTablesDiv.appendChild(headingContainer);



                                        let table = document.createElement('table');
                                        table.className = 'table-dark table-hover';

                                        let thead = document.createElement('thead');
                                        let headerRow = document.createElement('tr');

                                        let headers = [
                                            { text: 'Agents Name', style: 'width: 253px; background-color: black; color: white; font-weight: bold; text-align: center; border-top: none; border-right: none; border-left: none; border-bottom: 3px double white;' },
                                            { text: 'Target', style: 'width: 203px; background-color: black; color: white; font-weight: bold;  text-align: center; border-top: none; border-right: none; border-left: none; border-bottom: 3px double white;' },
                                            { text: 'Revenue', style: 'width: 203px; background-color: black; color: white; font-weight: bold;  text-align: center; border-top: none; border-right: none; border-left: none; border-bottom: 3px double white;' },
                                            { text: 'Front', style: 'width: 203px; background-color: black; color: white; font-weight: bold;  text-align: center; border-top: none; border-right: none; border-left: none; border-bottom: 3px double white;' },
                                            { text: 'Back', style: 'width: 203px; background-color: black; color: white; font-weight: bold;  text-align: center; border-top: none; border-right: none; border-left: none; border-bottom: 3px double white;' },
                                            { text: 'Refund', style: 'width: 203px; background-color: black; color: white; font-weight: bold;  text-align: center; border-top: none; border-right: none; border-left: none; border-bottom: 3px double white;' },
                                            { text: 'Chargeback', style: 'width: 203px; background-color: black; color: white; font-weight: bold;  text-align: center; border-top: none; border-right: none; border-left: none; border-bottom: 3px double white;' },
                                            { text: 'N. Total', style: 'width: 203px; background-color: #5F9B6B; color: white; font-weight: bold;  text-align: center; border-top: none; border-right: none; border-left: none; border-bottom: 3px double white;' }
                                        ];

                                        headers.forEach(header => {
                                            let th = document.createElement('th');
                                            th.textContent = header.text;
                                            th.setAttribute('style', header.style);
                                            th.classList.add('wd-15p', 'sorting');
                                            th.setAttribute('tabindex', '0');
                                            th.setAttribute('rowspan', '1');
                                            th.setAttribute('colspan', '1');
                                            headerRow.appendChild(th);
                                        });

                                        thead.appendChild(headerRow);
                                        table.appendChild(thead);

                                        let tbody = document.createElement('tbody');
                                        let eachbrandwisedata = employee121.data;
                                        let agentsnettotal1 = [];

                                        eachbrandwisedata.forEach(data => {

                                            if(data.getcompletesum != 0 ||  data.getfrontsum != 0 ||  data.getbacksum != 0 || data.refund  != 0 || data.dispute != 0 ){

                                            let row = document.createElement('tr');

                                            let agentname = document.createElement('td');
                                            agentname.textContent = data.name;
                                            // agentname.setAttribute('style', 'background-color: black; color: white; border-top: none; border-right: none; border-left: none; border-bottom: 1px dotted white; text-align: center;');
                                            agentname.style.backgroundColor = 'black';
                                            agentname.style.color = 'white';
                                            agentname.style.borderTop = 'none';
                                            agentname.style.borderRight = 'none';
                                            agentname.style.borderLeft = 'none';
                                            agentname.style.borderBottom = '1px dotted white';
                                            agentname.style.textAlign = 'left';
                                            agentname.style.width = '253px';

                                            row.appendChild(agentname);

                                            let target = document.createElement('td');
                                            target.textContent = data.agenttarget !== 0 ? "$" + data.agenttarget : "";
                                            // target.setAttribute('style', 'background-color: black; color: white; text-align: center;');
                                            target.style.backgroundColor = 'black';
                                            target.style.color = 'white';
                                            target.style.textAlign = 'center';
                                            row.appendChild(target);

                                            let revenue = document.createElement('td');
                                            revenue.textContent = data.getcompletesum !== 0 ? "$" + data.getcompletesum : "";
                                            // revenue.setAttribute('style', 'background-color: black; color: white; border-top: none; border-right: none; border-left: none; border-bottom: 1px dotted white; text-align: center;');
                                            revenue.style.backgroundColor = 'black';
                                            revenue.style.color = 'white';
                                            revenue.style.borderTop = 'none';
                                            revenue.style.borderRight = 'none';
                                            revenue.style.borderLeft = 'none';
                                            revenue.style.borderBottom = '1px dotted white';
                                            revenue.style.textAlign = 'center';
                                            row.appendChild(revenue);

                                            let front = document.createElement('td');
                                            front.textContent = data.getfrontsum !== 0 ? "$" + data.getfrontsum : "";
                                            // front.setAttribute('style', 'background-color: black; color: white; border-top: none; border-right: none; border-left: none; border-bottom: 1px dotted white; text-align: center;');
                                            front.style.backgroundColor = 'black';
                                            front.style.color = 'white';
                                            front.style.borderTop = 'none';
                                            front.style.borderRight = 'none';
                                            front.style.borderLeft = 'none';
                                            front.style.borderBottom = '1px dotted white';
                                            front.style.textAlign = 'center';
                                            row.appendChild(front);

                                            let back = document.createElement('td');
                                            back.textContent = data.getbacksum !== 0 ? "$" + data.getbacksum : "";
                                            // back.setAttribute('style', 'background-color: black; color: white; border-top: none; border-right: none; border-left: none; border-bottom: 1px dotted white; text-align: center;');
                                            back.style.backgroundColor = 'black';
                                            back.style.color = 'white';
                                            back.style.borderTop = 'none';
                                            back.style.borderRight = 'none';
                                            back.style.borderLeft = 'none';
                                            back.style.borderBottom = '1px dotted white';
                                            back.style.textAlign = 'center';
                                            row.appendChild(back);

                                            let refund = document.createElement('td');
                                            refund.textContent = data.refund !== 0 ? "$" + data.refund : "";
                                            // refund.setAttribute('style', 'background-color: black; color: white; border-top: none; border-right: none; border-left: none; border-bottom: 1px dotted white; text-align: center;');
                                            refund.style.backgroundColor = 'black';
                                            refund.style.color = 'white';
                                            refund.style.borderTop = 'none';
                                            refund.style.borderRight = 'none';
                                            refund.style.borderLeft = 'none';
                                            refund.style.borderBottom = '1px dotted white';
                                            refund.style.textAlign = 'center';
                                            row.appendChild(refund);

                                            let chargeback = document.createElement('td');
                                            chargeback.textContent = data.dispute !== 0 ? "$" + data.dispute : "";
                                            // chargeback.setAttribute('style', 'background-color: black; color: white; border-top: none; border-right: none; border-left: none; border-bottom: 1px dotted white; text-align: center;');
                                            chargeback.style.backgroundColor = 'black';
                                            chargeback.style.color = 'white';
                                            chargeback.style.borderTop = 'none';
                                            chargeback.style.borderRight = 'none';
                                            chargeback.style.borderLeft = 'none';
                                            chargeback.style.borderBottom = '1px dotted white';
                                            chargeback.style.textAlign = 'center';
                                            row.appendChild(chargeback);

                                            let ntotal = document.createElement('td');
                                            let netTotal = data.getcompletesum - data.refund - data.dispute;
                                            ntotal.textContent = netTotal !== 0 ? "$" + netTotal : "";
                                            if (data.agenttarget <= netTotal) {
                                                ntotal.setAttribute('style', 'background-color: #00FF00; color: black; border-top: none; border-right: 1px solid #00FF00; border-left: none; border-bottom: 1px dotted white; text-align: center;');
                                            } else if (data.agenttarget > netTotal) {
                                                ntotal.setAttribute('style', 'background-color: #FF0000; color: black; border-top: none; border-right: 1px solid #00FF00; border-left: none; border-bottom: 1px dotted white; text-align: center;');
                                            } else {
                                                ntotal.setAttribute('style', 'background-color: black; color: white; border-top: none; border-right: 1px solid #00FF00; border-left: none; border-bottom: 1px dotted white; text-align: center;');
                                            }

                                            row.appendChild(ntotal);

                                            agentsnettotal1.push(parseFloat(netTotal));

                                            tbody.appendChild(row);

                                        }
                                        });

                                        let sumagentstotal = agentsnettotal1.reduce((acc, curr) => acc + curr, 0);
                                        let y = (sumagentstotal !== 0) ? "$" + sumagentstotal : "";

                                        let row1 = document.createElement('tr');

                                        let blank1 = document.createElement('td');
                                        blank1.textContent = "";
                                        blank1.setAttribute('style', 'background-color: black;');
                                        row1.appendChild(blank1);

                                        let blank2 = document.createElement('td');
                                        blank2.textContent = "";
                                        blank2.setAttribute('style', 'background-color: black;');
                                        row1.appendChild(blank2);

                                        let blank3 = document.createElement('td');
                                        blank3.textContent = "";
                                        blank3.setAttribute('style', 'background-color: black;');
                                        row1.appendChild(blank3);

                                        let blank4 = document.createElement('td');
                                        blank4.textContent = "";
                                        blank4.setAttribute('style', 'background-color: black;');
                                        row1.appendChild(blank4);

                                        let blank5 = document.createElement('td');
                                        blank5.textContent = "";
                                        blank5.setAttribute('style', 'background-color: black;');
                                        row1.appendChild(blank5);

                                        let blank6 = document.createElement('td');
                                        blank6.textContent = "";
                                        blank6.setAttribute('style', 'background-color: black;');
                                        row1.appendChild(blank6);

                                        let blank7 = document.createElement('td');
                                        blank7.textContent = "Total";
                                        blank7.setAttribute('style', 'background-color: black; color: white; font-weight: bold; text-align: center;');
                                        row1.appendChild(blank7);

                                        let blank8 = document.createElement('td');
                                        blank8.textContent = y;
                                        blank8.setAttribute('style', 'background-color: #66B2FF; color: white; font-weight: bold; text-align: center; border:  3px double white;');
                                        row1.appendChild(blank8);

                                        tbody.appendChild(row1);


                                        table.appendChild(tbody);
                                        allTablesDiv.appendChild(table);
                                    }

                                    });

                                    //----------------------------------------------------------------


                                    let branddata = Response.brandtoday;
                                    let brandtodaypayment = document.getElementById('brandtodaypayment');
                                    brandtodaypayment.innerHTML = ''; // Clear existing table content
                                    let brandtodayfront1 = [];
                                    let brandtodayback1 = [];
                                    let brandtodaytotaloftotal1 = [];
                                    let brandtodayupsells1 = [];
                                    let brandtodayremaiings = [];
                                    let brandtodayrenewalsaall = [];

                                    // Populate brand data into the table
                                    branddata.forEach(branddatas => {
                                        if(branddatas){
                                            if(branddatas.front != 0 ||  branddatas.back != 0){
                                            let row1 = document.createElement('tr');

                                        // Create and append brand name cell
                                        let brandname = document.createElement('td');
                                        brandname.textContent = branddatas.name;
                                        brandname.style.backgroundColor = 'white';
                                        brandname.style.color = 'black';
                                        brandname.style.fontWeight = 'bold';
                                        brandname.style.borderTop = 'none';
                                        brandname.style.borderRight = 'none';
                                        brandname.style.borderLeft = '1px solid white';
                                        brandname.style.borderBottom = '1px dotted #4169E1';
                                        brandname.style.textAlign = 'center';
                                        row1.appendChild(brandname);

                                        // Create and append today's front payment cell
                                        let brandtodayfront = document.createElement('td');
                                        let oo = branddatas.front;
                                        let pp = (oo !==0) ?  "$" + oo : "";
                                        brandtodayfront.textContent = pp;
                                        brandtodayfront.style.backgroundColor = 'white';
                                        brandtodayfront.style.color = 'black';
                                        brandtodayfront.style.borderTop = 'none';
                                        brandtodayfront.style.borderRight = 'none';
                                        brandtodayfront.style.borderLeft = 'none';
                                        brandtodayfront.style.borderBottom = '1px dotted #4169E1';
                                        brandtodayfront.style.textAlign = 'center';
                                        row1.appendChild(brandtodayfront);

                                        // Create and append today's back payment cell
                                        let brandtodayback = document.createElement('td');
                                        let qq = branddatas.back;
                                        let rr = (qq !==0) ?  "$" + qq : "";
                                        brandtodayback.textContent = rr;
                                        brandtodayback.style.backgroundColor = 'white';
                                        brandtodayback.style.color = 'black';
                                        brandtodayback.style.borderTop = 'none';
                                        brandtodayback.style.borderRight = 'none';
                                        brandtodayback.style.borderLeft = 'none';
                                        brandtodayback.style.borderBottom = '1px dotted #4169E1';
                                        brandtodayback.style.textAlign = 'center';
                                        row1.appendChild(brandtodayback);

                                        //upsell
                                        let brandtodayupsells = document.createElement('td');
                                        let qqzz = branddatas.brandupsell;
                                        let rrzz = (qqzz !==0) ?  "$" + qqzz : "";
                                        brandtodayupsells.textContent = rrzz;
                                        brandtodayupsells.style.backgroundColor = 'white';
                                        brandtodayupsells.style.color = 'black';
                                        brandtodayupsells.style.borderTop = 'none';
                                        brandtodayupsells.style.borderRight = 'none';
                                        brandtodayupsells.style.borderLeft = 'none';
                                        brandtodayupsells.style.borderBottom = '1px dotted #4169E1';
                                        brandtodayupsells.style.textAlign = 'center';
                                        row1.appendChild(brandtodayupsells);
                                        //remaining
                                        let brandtodayremaining = document.createElement('td');
                                        let qqyy = branddatas.brandremaining;
                                        let rryy = (qqyy !==0) ?  "$" + qqyy : "";
                                        brandtodayremaining.textContent = rryy;
                                        brandtodayremaining.style.backgroundColor = 'white';
                                        brandtodayremaining.style.color = 'black';
                                        brandtodayremaining.style.borderTop = 'none';
                                        brandtodayremaining.style.borderRight = 'none';
                                        brandtodayremaining.style.borderLeft = 'none';
                                        brandtodayremaining.style.borderBottom = '1px dotted #4169E1';
                                        brandtodayremaining.style.textAlign = 'center';
                                        row1.appendChild(brandtodayremaining);
                                        //renewals
                                        let brandtodayrenewals = document.createElement('td');
                                        let qqxx = branddatas.sumofallrenewals;
                                        let rrxx = (qqxx !==0) ?  "$" + qqxx : "";
                                        brandtodayrenewals.textContent = rrxx;
                                        brandtodayrenewals.style.backgroundColor = 'white';
                                        brandtodayrenewals.style.color = 'black';
                                        brandtodayrenewals.style.borderTop = 'none';
                                        brandtodayrenewals.style.borderRight = 'none';
                                        brandtodayrenewals.style.borderLeft = 'none';
                                        brandtodayrenewals.style.borderBottom = '1px dotted #4169E1';
                                        brandtodayrenewals.style.textAlign = 'center';
                                        row1.appendChild(brandtodayrenewals);

                                        // Create and append total payment cell
                                        let brandtotal = document.createElement('td');
                                        let ss = branddatas.all;
                                        let tt = (ss !==0) ?  "$" + ss : "";
                                        brandtotal.textContent = tt;
                                        brandtotal.textContent = tt;
                                        brandtotal.style.backgroundColor = 'white';
                                        brandtotal.style.color = 'black';
                                        brandtotal.style.borderTop = 'none';
                                        brandtotal.style.borderRight = '1px solid white';
                                        brandtotal.style.borderLeft = 'none';
                                        brandtotal.style.borderBottom = '1px dotted #4169E1';
                                        brandtotal.style.textAlign = 'center';
                                        row1.appendChild(brandtotal);

                                        brandtodayfront1.push(parseFloat(branddatas.front));
                                        brandtodayback1.push(parseFloat(branddatas.back));
                                        brandtodaytotaloftotal1.push(parseFloat(branddatas.all));
                                        brandtodayupsells1.push(parseFloat(branddatas.brandupsell));
                                        brandtodayremaiings.push(parseFloat(branddatas.brandremaining));
                                        brandtodayrenewalsaall.push(parseFloat(branddatas.sumofallrenewals));

                                        // Append the row to the table
                                        brandtodaypayment.appendChild(row1);

                                        }}

                                    });

                                    let sumBrandtodayfront = brandtodayfront1.reduce((acc, curr) => acc + curr, 0);
                                    let uu = (sumBrandtodayfront !== 0) ?  "$" + sumBrandtodayfront : "";
                                    document.getElementById("brandtodayfront").innerHTML = uu;
                                    //----------------------------------------------------------------

                                    let sumBrandtodayback = brandtodayback1.reduce((acc, curr) => acc + curr, 0);
                                    let vv = (sumBrandtodayback !== 0) ?  "$" + sumBrandtodayback : "";
                                    document.getElementById("brandtodayback").innerHTML = vv;
                                    //----------------------------------------------------------------

                                    let sumBrandtodayallupsells = brandtodayupsells1.reduce((acc, curr) => acc + curr, 0);
                                    let sumBrandtodayallupsells1 = (sumBrandtodayallupsells !==0) ?  "$" + sumBrandtodayallupsells : "";
                                    document.getElementById("brandtodayupsell").innerHTML =   sumBrandtodayallupsells1;
                                    //----------------------------------------------------------------

                                    let sumBrandtodayremainings = brandtodayremaiings.reduce((acc, curr) => acc + curr, 0);
                                    let sumBrandtodayremainings1 = (sumBrandtodayremainings !==0) ?  "$" + sumBrandtodayremainings : "";
                                    document.getElementById("brandtodayremaining").innerHTML =   sumBrandtodayremainings1;
                                    //----------------------------------------------------------------

                                    let sumBrandtodayrenewals = brandtodayrenewalsaall.reduce((acc, curr) => acc + curr, 0);
                                    let sumBrandtodayrenewals1 = (sumBrandtodayrenewals !==0) ?  "$" + sumBrandtodayrenewals : "";
                                    document.getElementById("brandtodayrenewals").innerHTML =   sumBrandtodayrenewals1;
                                    //----------------------------------------------------------------

                                    let sumBrandtodayallofall = brandtodaytotaloftotal1.reduce((acc, curr) => acc + curr, 0);
                                    let ww = (sumBrandtodayallofall !== 0) ?  "$" + sumBrandtodayallofall : "";
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
                                            empname.style.backgroundColor = 'white';
                                            empname.style.color = 'black';
                                            empname.style.fontWeight = 'bold';
                                            empname.style.borderTop = 'none';
                                            empname.style.borderRight = 'none';
                                            empname.style.borderLeft = '1px solid white';
                                            empname.style.borderBottom = '1px dotted #FF9933';
                                            empname.style.textAlign = 'center';
                                            row2.appendChild(empname);

                                            let emptoday = document.createElement('td');
                                            let a1 = emptodaysdatas.allrevenue;
                                            let a2 = (a1 !==0) ?  "$" + a1 : "";
                                            emptoday.textContent = a2;
                                            emptoday.style.backgroundColor = 'white';
                                            emptoday.style.color = 'black';
                                            emptoday.style.borderTop = 'none';
                                            emptoday.style.borderRight = 'none';
                                            emptoday.style.borderLeft = 'none';
                                            emptoday.style.borderBottom = '1px dotted #FF9933';
                                            emptoday.style.textAlign = 'center';
                                            row2.appendChild(emptoday);

                                            let emptotal = document.createElement('td');
                                            let a3 =  emptodaysdatas.allrevenue;
                                            let a4 = (a3 !==0) ?  "$" + a3 : "";
                                            emptotal.textContent = a4;
                                            emptotal.style.backgroundColor = 'white';
                                            emptotal.style.color = 'black';
                                            emptotal.style.borderTop = 'none';
                                            emptotal.style.borderRight = '1px solid white';
                                            emptotal.style.borderLeft = 'none';
                                            emptotal.style.borderBottom = '1px dotted #FF9933';
                                            emptotal.style.textAlign = 'center';
                                            row2.appendChild(emptotal);

                                            emptodaytotaloftotal1.push(parseFloat(emptodaysdatas.allrevenue));

                                            emptodaypayment.appendChild(row2);

                                        }}

                                    });

                                    let sumemptodayallofall = emptodaytotaloftotal1.reduce((acc, curr) => acc + curr, 0);
                                    let xx = (sumemptodayallofall !== 0) ?  "$" + sumemptodayallofall : "";
                                    document.getElementById("emptodaytotal").innerHTML = xx;
                                    //----------------------------------------------------------------


                                    let refund = Response.combinebrandwiserefdis;
                                    let allTablesDiv1 = document.getElementById('allrefundsandcbs');
                                    allTablesDiv1.innerHTML = '';

                                    // Iterate through each brand in the refund object
                                    Object.keys(refund).forEach((brand, indexrefund) => {
                                        let refunds = refund[brand];

                                        let headingContainer = document.createElement('div');
                                        headingContainer.className = 'col-12';

                                        let rowDiv = document.createElement('div');
                                        rowDiv.className = 'row';

                                        let col10Div = document.createElement('div');
                                        col10Div.className = 'col-10';

                                        let col2Div = document.createElement('div');
                                        col2Div.className = 'col-2';

                                        let heading = document.createElement('h4');
                                        heading.style = 'background-color: white; color: black; font-weight: bold;';
                                        heading.textContent = 'Brand: ' + brand;

                                        let lineBreak1 = document.createElement('br');
                                        let lineBreak2 = document.createElement('br');
                                        col10Div.appendChild(lineBreak1);
                                        col10Div.appendChild(lineBreak2);

                                        col10Div.appendChild(heading);
                                        rowDiv.appendChild(col10Div);
                                        rowDiv.appendChild(col2Div);
                                        headingContainer.appendChild(rowDiv);
                                        allTablesDiv1.appendChild(headingContainer);

                                        let table = document.createElement('table');
                                        table.className = 'table-dark table-hover';

                                        let thead = document.createElement('thead');
                                        let headerRow = document.createElement('tr');

                                        let headers = [
                                            { text: 'Date', style: 'width: 203px; background-color: black; color: white; font-weight: bold; border: 1px solid white; text-align: center;' },
                                            { text: 'Brand', style: 'width: 203px; background-color: black; color: white; font-weight: bold; border: 1px solid white; text-align: center;' },
                                            { text: 'Client Name', style: 'width: 203px; background-color: black; color: white; font-weight: bold; border: 1px solid white; text-align: center;' },
                                            { text: 'Amount', style: 'width: 203px; background-color: black; color: white; font-weight: bold; border: 1px solid white; text-align: center;' },
                                            { text: 'Services', style: 'width: 203px; background-color: black; color: white; font-weight: bold; border: 1px solid white; text-align: center;' },
                                            { text: 'Support', style: 'width: 203px; background-color: black; color: white; font-weight: bold; border: 1px solid white; text-align: center;' },
                                            { text: 'Type', style: 'width: 203px; background-color: black; color: white; font-weight: bold; border: 1px solid white; text-align: center;' },
                                            { text: 'Front Person', style: 'width: 203px; background-color: black; color: white; font-weight: bold; border: 1px solid white; text-align: center;' }
                                        ];

                                        headers.forEach(header => {
                                            let th = document.createElement('th');
                                            th.textContent = header.text;
                                            th.setAttribute('style', header.style);
                                            th.classList.add('wd-15p', 'sorting');
                                            th.setAttribute('tabindex', '0');
                                            th.setAttribute('rowspan', '1');
                                            th.setAttribute('colspan', '1');
                                            headerRow.appendChild(th);
                                        });

                                        thead.appendChild(headerRow);
                                        table.appendChild(thead);

                                        let tbody = document.createElement('tbody');

                                        refunds.forEach(data => {
                                            let row = document.createElement('tr');

                                            let agentname = document.createElement('td');
                                            agentname.textContent = data.date;
                                            agentname.style.backgroundColor = 'white';
                                            agentname.style.color = 'black';
                                            agentname.style.border = '1px solid black';
                                            agentname.style.textAlign = 'center';

                                            row.appendChild(agentname);

                                            let target = document.createElement('td');
                                            target.textContent = data.brand !== 0 ?  data.brand : "";
                                            target.style.backgroundColor = 'white';
                                            target.style.color = 'black';
                                            target.style.border = '1px solid black';
                                            target.style.textAlign = 'center';

                                            row.appendChild(target);

                                            let revenue = document.createElement('td');
                                            revenue.textContent = data.client !== 0 ?  data.client : "";
                                            revenue.style.backgroundColor = 'white';
                                            revenue.style.fontWeight = 'bold';
                                            revenue.style.color = 'black';
                                            revenue.style.border = '1px solid black';
                                            revenue.style.textAlign = 'center';
                                            row.appendChild(revenue);

                                            let front = document.createElement('td');
                                            front.textContent = data.amount !== 0 ? "$" + data.amount : "";
                                            front.style.backgroundColor = 'white';
                                            front.style.color = 'black';
                                            front.style.border = '1px solid black';
                                            front.style.textAlign = 'center';
                                            row.appendChild(front);

                                            let back = document.createElement('td');
                                            back.textContent = data.services !== 0 ?  data.services : "";
                                            back.style.backgroundColor = 'white';
                                            back.style.color = 'black';
                                            back.style.border = '1px solid black';
                                            back.style.textAlign = 'center';
                                            row.appendChild(back);

                                            let refund = document.createElement('td');
                                            refund.textContent = data.support !== 0 ?  data.support : "";
                                            refund.style.backgroundColor = 'white';
                                            refund.style.color = 'black';
                                            refund.style.border = '1px solid black';
                                            refund.style.textAlign = 'center';
                                            row.appendChild(refund);

                                            let chargeback = document.createElement('td');
                                            chargeback.textContent = data.type !== 0 ?  data.type : "";
                                            chargeback.style.backgroundColor = 'white';
                                            chargeback.style.color = 'black';
                                            chargeback.style.border = '1px solid black';
                                            chargeback.style.textAlign = 'center';
                                            row.appendChild(chargeback);

                                            let ntotal = document.createElement('td');
                                            let netTotal = data.frontperson;
                                            ntotal.textContent = netTotal !== 0 ?  netTotal : "";
                                            ntotal.style.backgroundColor = 'white';
                                            ntotal.style.color = 'black';
                                            ntotal.style.border = '1px solid black';
                                            ntotal.style.textAlign = 'center';

                                            row.appendChild(ntotal);

                                            tbody.appendChild(row);
                                        });

                                        table.appendChild(tbody);
                                        allTablesDiv1.appendChild(table);
                                    });

                                    // -------------------------------------------------------------------------------------------------------------
                                    let totalAmount = 0;
                                    // -------------------------------------------------------------------------------------

                                    let refundGraphData = Response.disputegraph;
                                    let refundGraphContainer = document.getElementById('refundgraph');
                                       refundGraphContainer.innerHTML = '';

                                    let rowDivDispute = null;

                                    refundGraphData.forEach((refundGraphs, index) => {
                                            if (index % 3 === 0) {
                                                rowDivDispute = document.createElement('div');
                                                rowDivDispute.className = 'row';
                                                refundGraphContainer.appendChild(rowDivDispute);
                                            }

                                            let colDivDispute = document.createElement('div');
                                            colDivDispute.className = 'col-12';
                                            colDivDispute.style.height = '450px';

                                            let brand_name = refundGraphs.name;
                                            let brand_ongoing = refundGraphs.brand_ongoing;
                                            let brand_refund = refundGraphs.brand_refund;
                                            let brand_chargeback = refundGraphs.brand_chargeback;

                                            let chartId = 'chart_div_dispute' + index;
                                            let chartDiv = document.createElement('div');
                                            chartDiv.id = chartId;
                                            chartDiv.style.marginBottom = '30px';
                                            colDivDispute.appendChild(chartDiv);
                                            rowDivDispute.appendChild(colDivDispute);

                                            displayArrayDispute(chartId, brand_name, brand_ongoing, brand_refund, brand_chargeback);
                                    });


                                    let salesGraphData = Response.salesgraph;
                                    let salesGraphContainer = document.getElementById('salesgraph');
                                    salesGraphContainer.innerHTML = '';

                                    let rowDivSales = null;

                                    salesGraphData.forEach((salesDistributions, index) => {
                                        if (index % 3 === 0) {
                                            rowDivSales = document.createElement('div');
                                            rowDivSales.className = 'row';
                                            salesGraphContainer.appendChild(rowDivSales);
                                        }

                                        let colDivSales = document.createElement('div');
                                        colDivSales.className = 'col-12';
                                        colDivSales.style.height = '450px';

                                        let brand_name = salesDistributions.name;
                                        let brand_renewal = salesDistributions.brand_renewal;
                                        let brand_upsell = salesDistributions.brand_upsell;
                                        let brand_newlead = salesDistributions.brand_newlead;

                                        let chartId = 'chart_div_sales' + index;
                                        let chartDiv = document.createElement('div');
                                        chartDiv.id = chartId;
                                        chartDiv.style.marginBottom = '30px';
                                        colDivSales.appendChild(chartDiv);
                                        rowDivSales.appendChild(colDivSales);

                                        displayArraySales(chartId, brand_name, brand_renewal, brand_upsell, brand_newlead);
                                    });


                                    let salesTargetGraphData = Response.targetchasingraph;
                                    let linechartContainer = document.getElementById('linechart_container');
                                    linechartContainer.innerHTML = '';

                                    var numberofsplits = document.getElementById("hideornot");
                                    if (salesTargetGraphData[0] !== "no data") {
                                        numberofsplits.style.display = 'block';
                                    } else {
                                        numberofsplits.style.display = 'none';
                                    }

                                    let rowDivForecast = null;

                                    Object.keys(salesTargetGraphData).forEach((brandName, index) => {
                                        if (index % 3 === 0) {
                                            rowDivForecast = document.createElement('div');
                                            rowDivForecast.className = 'row';
                                            linechartContainer.appendChild(rowDivForecast);
                                        }

                                        let colDivForecast = document.createElement('div');
                                        colDivForecast.className = 'col-12';
                                        // colDivForecast.style.width = '600px';
                                        colDivForecast.style.height = '450px';

                                        let lineBreak1 = document.createElement('br');
                                        let lineBreak2 = document.createElement('br');
                                        colDivForecast.appendChild(lineBreak1);
                                        colDivForecast.appendChild(lineBreak2);

                                        let brandData = salesTargetGraphData[brandName];
                                        let chartId = 'chart_div_forecast_' + brandName.replace(/\s/g, "_");
                                        let chartDiv = document.createElement('div');
                                        chartDiv.id = chartId;
                                        chartDiv.style.marginBottom = '30px';
                                        colDivForecast.appendChild(chartDiv);
                                        rowDivForecast.appendChild(colDivForecast);

                                        displayForecast(chartId, brandData, brandName);
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
                    let brandID = $("#getbranddata");
                    $.ajax({
                            url:"/api/fetch-datewisedata",
                            type:"get",
                            data:{
                                "date_id":Date.val(),
                                "brand_id":brandID.val(),
                            },
                            beforeSend:(()=>{
                                Date.attr('disabled','disabled');
                                brandID.attr('disabled','disabled');
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

                                    let brandtodayupsells1 = [];
                                    let brandtodayremaiings = [];
                                    let brandtodayrenewalsaall = [];

                                // Populate brand data into the table
                                branddata.forEach(branddatas => {
                                    if(branddatas.front != 0 ||  branddatas.back != 0){
                                    let row1 = document.createElement('tr');

                                    // Create and append brand name cell
                                    let brandname = document.createElement('td');
                                    brandname.textContent = branddatas.name;
                                    brandname.style.backgroundColor = 'white';
                                    brandname.style.color = 'black';
                                    brandname.style.fontWeight = 'bold';
                                    brandname.style.borderTop = 'none';
                                    brandname.style.borderRight = 'none';
                                    brandname.style.borderLeft = '1px solid white';
                                    brandname.style.borderBottom = '1px dotted #4169E1';
                                    brandname.style.textAlign = 'left';
                                    brandname.style.width = '253px';
                                    row1.appendChild(brandname);

                                    // // Create and append today's front payment cell
                                    // let brandtodayfront = document.createElement('td');
                                    // brandtodayfront.textContent = branddatas.front;
                                    // row1.appendChild(brandtodayfront);

                                    // // Create and append today's back payment cell
                                    // let brandtodayback = document.createElement('td');
                                    // brandtodayback.textContent = branddatas.back;
                                    // row1.appendChild(brandtodayback);

                                    // // Create and append total payment cell
                                    // let brandtotal = document.createElement('td');
                                    // brandtotal.textContent = branddatas.all;
                                    // row1.appendChild(brandtotal);

                                    // Create and append today's front payment cell
                                    let brandtodayfront = document.createElement('td');
                                    let oo = branddatas.front;
                                    let pp = (oo !==0) ?  "$" + oo : "";
                                    brandtodayfront.textContent = pp;
                                    brandtodayfront.style.backgroundColor = 'white';
                                    brandtodayfront.style.color = 'black';
                                    brandtodayfront.style.borderTop = 'none';
                                    brandtodayfront.style.borderRight = 'none';
                                    brandtodayfront.style.borderLeft = 'none';
                                    brandtodayfront.style.borderBottom = '1px dotted #4169E1';
                                    brandtodayfront.style.textAlign = 'center';
                                    row1.appendChild(brandtodayfront);

                                    // Create and append today's back payment cell
                                    let brandtodayback = document.createElement('td');
                                    let qq = branddatas.back;
                                    let rr = (qq !==0) ?  "$" + qq : "";
                                    brandtodayback.textContent = rr;
                                    brandtodayback.style.backgroundColor = 'white';
                                    brandtodayback.style.color = 'black';
                                    brandtodayback.style.borderTop = 'none';
                                    brandtodayback.style.borderRight = 'none';
                                    brandtodayback.style.borderLeft = 'none';
                                    brandtodayback.style.borderBottom = '1px dotted #4169E1';
                                    brandtodayback.style.textAlign = 'center';
                                    row1.appendChild(brandtodayback);

                                    //upsell
                                    let brandtodayupsells = document.createElement('td');
                                    let qqzz = branddatas.brandupsell;
                                    let rrzz = (qqzz !==0) ?  "$" + qqzz : "";
                                    brandtodayupsells.textContent = rrzz;
                                    brandtodayupsells.style.backgroundColor = 'white';
                                    brandtodayupsells.style.color = 'black';
                                    brandtodayupsells.style.borderTop = 'none';
                                    brandtodayupsells.style.borderRight = 'none';
                                    brandtodayupsells.style.borderLeft = 'none';
                                    brandtodayupsells.style.borderBottom = '1px dotted #4169E1';
                                    brandtodayupsells.style.textAlign = 'center';
                                    row1.appendChild(brandtodayupsells);
                                    //remaining
                                    let brandtodayremaining = document.createElement('td');
                                    let qqyy = branddatas.brandremaining;
                                    let rryy = (qqyy !==0) ?  "$" + qqyy : "";
                                    brandtodayremaining.textContent = rryy;
                                    brandtodayremaining.style.backgroundColor = 'white';
                                    brandtodayremaining.style.color = 'black';
                                    brandtodayremaining.style.borderTop = 'none';
                                    brandtodayremaining.style.borderRight = 'none';
                                    brandtodayremaining.style.borderLeft = 'none';
                                    brandtodayremaining.style.borderBottom = '1px dotted #4169E1';
                                    brandtodayremaining.style.textAlign = 'center';
                                    row1.appendChild(brandtodayremaining);
                                    //renewals
                                    let brandtodayrenewals = document.createElement('td');
                                    let qqxx = branddatas.sumofallrenewals;
                                    let rrxx = (qqxx !==0) ?  "$" + qqxx : "";
                                    brandtodayrenewals.textContent = rrxx;
                                    brandtodayrenewals.style.backgroundColor = 'white';
                                    brandtodayrenewals.style.color = 'black';
                                    brandtodayrenewals.style.borderTop = 'none';
                                    brandtodayrenewals.style.borderRight = 'none';
                                    brandtodayrenewals.style.borderLeft = 'none';
                                    brandtodayrenewals.style.borderBottom = '1px dotted #4169E1';
                                    brandtodayrenewals.style.textAlign = 'center';
                                    row1.appendChild(brandtodayrenewals);


                                    // Create and append total payment cell
                                    let brandtotal = document.createElement('td');
                                    let ss = branddatas.all;
                                    let tt = (ss !==0) ?  "$" + ss : "";
                                    brandtotal.textContent = tt;
                                    brandtotal.style.backgroundColor = 'white';
                                    brandtotal.style.color = 'black';
                                    brandtotal.style.borderTop = 'none';
                                    brandtotal.style.borderRight = '1px solid white';
                                    brandtotal.style.borderLeft = 'none';
                                    brandtotal.style.borderBottom = '1px dotted #4169E1';
                                    brandtotal.style.textAlign = 'center';
                                    row1.appendChild(brandtotal);

                                    brandtodayfront1.push(parseFloat(branddatas.front));
                                    brandtodayback1.push(parseFloat(branddatas.back));
                                    brandtodayupsells1.push(parseFloat(branddatas.brandupsell));
                                    brandtodayremaiings.push(parseFloat(branddatas.brandremaining));
                                    brandtodayrenewalsaall.push(parseFloat(branddatas.sumofallrenewals));
                                    brandtodaytotaloftotal1.push(parseFloat(branddatas.all));

                                    // Append the row to the table
                                    brandtodaypayment.appendChild(row1);
                                    }
                                });

                                let sumBrandtodayfront = brandtodayfront1.reduce((acc, curr) => acc + curr, 0);
                                    document.getElementById("brandtodayfront").innerHTML =  "$" + sumBrandtodayfront;
                                    //----------------------------------------------------------------

                                    let sumBrandtodayback = brandtodayback1.reduce((acc, curr) => acc + curr, 0);
                                    document.getElementById("brandtodayback").innerHTML =  "$" + sumBrandtodayback;
                                    //----------------------------------------------------------------

                                    let sumBrandtodayallupsells = brandtodayupsells1.reduce((acc, curr) => acc + curr, 0);
                                    let sumBrandtodayallupsells1 = (sumBrandtodayallupsells !==0) ?  "$" + sumBrandtodayallupsells : "";
                                    document.getElementById("brandtodayupsell").innerHTML =   sumBrandtodayallupsells1;
                                    //----------------------------------------------------------------

                                    let sumBrandtodayremainings = brandtodayremaiings.reduce((acc, curr) => acc + curr, 0);
                                    let sumBrandtodayremainings1 = (sumBrandtodayremainings !==0) ?  "$" + sumBrandtodayremainings : "";
                                    document.getElementById("brandtodayremaining").innerHTML =   sumBrandtodayremainings1;
                                    //----------------------------------------------------------------

                                    let sumBrandtodayrenewals = brandtodayrenewalsaall.reduce((acc, curr) => acc + curr, 0);
                                    let sumBrandtodayrenewals1 = (sumBrandtodayrenewals !==0) ?  "$" + sumBrandtodayrenewals : "";
                                    document.getElementById("brandtodayrenewals").innerHTML =   sumBrandtodayrenewals1;
                                    //----------------------------------------------------------------

                                    let sumBrandtodayallofall = brandtodaytotaloftotal1.reduce((acc, curr) => acc + curr, 0);
                                    document.getElementById("brandtodaytotal").innerHTML =  "$" + sumBrandtodayallofall;
                                    //----------------------------------------------------------------

                                // Retrieve employee data and table element
                                let emptodaysdata = Response.employees;
                                let emptodaypayment = document.getElementById('empdailypayment');
                                emptodaypayment.innerHTML = ''; // Clear existing table content
                                let emptodaytotaloftotal1 = [];

                                // Populate employee data into the table
                                emptodaysdata.forEach(emptodaysdatas => {

                                    if(emptodaysdatas.allrevenue != 0 ||  emptodaysdatas.allrevenue != 0){

                                    let row2 = document.createElement('tr');

                                    // Create and append employee name cell
                                    let empname = document.createElement('td');
                                    empname.textContent = emptodaysdatas.name;
                                    empname.style.backgroundColor = 'white';
                                    empname.style.color = 'black';
                                    empname.style.fontWeight = 'bold';
                                    empname.style.borderTop = 'none';
                                    empname.style.borderRight = 'none';
                                    empname.style.borderLeft = '1px solid white';
                                    empname.style.borderBottom = '1px dotted #FF9933';
                                    empname.style.textAlign = 'left';
                                    empname.style.width = '253px';

                                    row2.appendChild(empname);

                                    let emptoday = document.createElement('td');
                                    let a1 = emptodaysdatas.allrevenue;
                                    let a2 = (a1 !==0) ?  "$" + a1 : "";
                                    emptoday.textContent = a2;
                                    emptoday.style.backgroundColor = 'white';
                                    emptoday.style.color = 'black';
                                    emptoday.style.borderTop = 'none';
                                    emptoday.style.borderRight = 'none';
                                    emptoday.style.borderLeft = 'none';
                                    emptoday.style.borderBottom = '1px dotted #FF9933';
                                    emptoday.style.textAlign = 'center';
                                    row2.appendChild(emptoday);

                                    let emptotal = document.createElement('td');
                                    let a3 =  emptodaysdatas.allrevenue;
                                    let a4 = (a3 !==0) ?  "$" + a3 : "";
                                    emptotal.textContent = a4;
                                    emptotal.style.backgroundColor = 'white';
                                    emptotal.style.color = 'black';
                                    emptotal.style.borderTop = 'none';
                                    emptotal.style.borderRight = '1px solid white';
                                    emptotal.style.borderLeft = 'none';
                                    emptotal.style.borderBottom = '1px dotted #FF9933';
                                    emptotal.style.textAlign = 'center';
                                    row2.appendChild(emptotal);



                                    emptodaytotaloftotal1.push(parseFloat(emptodaysdatas.allrevenue));

                                    // Append the row to the table
                                    emptodaypayment.appendChild(row2);
                                    }
                                });

                                let sumemptodayallofall = emptodaytotaloftotal1.reduce((acc, curr) => acc + curr, 0);
                                    document.getElementById("emptodaytotal").innerHTML =  "$" + sumemptodayallofall;
                                    //----------------------------------------------------------------



                                Date.removeAttr('disabled');
                                brandID.removeAttr('disabled');
                                $("#getdateagentsandbrand").text("Search");
                                $("#getdateagentsandbrand").removeAttr('disabled');


                            }),
                            error:((error)=>{
                                console.log(error);
                                alert("Error Found Please Referesh Window And Try Again !")

                                Date.removeAttr('disabled');
                                brandID.removeAttr('disabled');
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

