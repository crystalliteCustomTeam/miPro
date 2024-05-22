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
                    <select class="form-control select2" name="brand" id="getyeardata">
                        <option value="">Select Year</option>
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
                    <select class="form-control select2" name="brand" id="getmonth">
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
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Sales</p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1" id="brandsales"></p>
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
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Disputes</p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1" id="branddisputes"></p>
                            <span class="tx-11 tx-roboto tx-white-8">65.45% on average time</span>
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
                            <span class="tx-11 tx-roboto tx-white-8">65.45% on average time</span>

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
                                <p class="tx-lato tx-inverse tx-bold">--</p>
                            </div>
                            <div class="bd-r pd-x-10">
                                <label class="tx-12">Refund:</label>
                                <p class="tx-lato tx-inverse tx-bold" id="dispute">--</p>
                            </div>
                            <div class="pd-l-10">
                                <label class="tx-12">ChargeBack:</label>
                                <p class="tx-lato tx-inverse tx-bold" id="refund">--</p>
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
                            <br><br>
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
                                <tbody>
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
                                        </tr>


                                </tbody>
                            </table>

                        </div><!-- card -->
                    </div><!-- col-4 -->

                </div><!-- row -->











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

                                    let net_revenue = Response.net_revenue;
                                    document.getElementById("brand_net_revenue").innerHTML = net_revenue;

                                    let dispute = Response.dispute;
                                    document.getElementById("dispute").innerHTML =  dispute;

                                    let refund =  Response.refund;
                                    document.getElementById("refund").innerHTML =  refund;

                                    let front =  Response.front;
                                    document.getElementById("front").innerHTML =  front;

                                    let back =  Response.back;
                                    document.getElementById("back").innerHTML =  back;subtotal

                                    document.getElementById("subtotal").innerHTML = front + back

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


            });
        </script>
@endsection
