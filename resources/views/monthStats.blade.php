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
                    <select class="form-control select2" name="year[]" id="year" multiple="multiple">
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
                    <select class="form-control select2" name="month[]" id="month" multiple="multiple">
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
                    <label for="" style="font-weight:bold;">Select Department</label>
                    <select class="form-control select2" name="brand[]" id="depart"  multiple="multiple">
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">
                          {{ $brand->name }}
                        </option>
                    @endforeach
                  </select>
                </div>
                <div class="col-1 mt-2">
                    <button class="btn btn-primary mt-4" id="searchstats">Search</button>
                </div>
                <br><br>

            </div>
        </div><!-- br-pagebody -->

        <div class="br-pagebody">
            <div class="br-section-wrapper">
                <div class="row">
                    <div class="col-12">
                        <h4 style="background-color: white ; color: black; font-weight: bold;">Book Hamid 3 Months Stats:</h4>
                    </div>
                    <div class="col-12">
                        <table id="" class="table-dark table-hover">
                            <thead>
                                <tr role="row">
                                    <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #66B2FF; color: white; font-weight: bold; border-left: 1px solid white; border-right: 1px solid white; border-top: 1px solid white; border-bottom: none; text-align: center;" aria-sort="ascending" aria-label="First name: activate to sort column descending">Front Sales SEO</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #FF9933; color: white; font-weight: bold; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending"></th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #FF9933; color: white; font-weight: bold; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending"></th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #FF9933; color: black; font-weight: bold; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending">Apr24</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #FF9933; color: white; font-weight: bold; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending"></th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #FF9933; color: white; font-weight: bold; border-left: none; border-right: 1px solid white;  border-top: 1px solid white; border-bottom: 7px solid white; text-align: center;" aria-label="Last name: activate to sort column ascending"></th>
                                </tr>
                                <tr role="row">
                                    <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #66B2FF; color: white; border-left: 1px solid white; border-right: 1px solid white; border-top: none; border-bottom: 3px double white; text-align: center;" aria-sort="ascending" aria-label="First name: activate to sort column descending"></th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: black; color: white;  border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;" aria-label="Last name: activate to sort column ascending">Target</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: black; color: white; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;" aria-label="Last name: activate to sort column ascending">Front</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: black; color: white; border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;" aria-label="Last name: activate to sort column ascending">Back</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: black; color: #A52A2A;  border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;" aria-label="Last name: activate to sort column ascending">Refund</th>
                                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px; background-color: #808080; color: white;  border-left: none; border-right: none; border-top: 1px solid white; border-bottom: 3px double white; text-align: center;" aria-label="Last name: activate to sort column ascending">Net Revenue</th>
                                </tr>
                            </thead>
                            <tbody id="brandtodaypayment"></tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {


                $("#searchstats").click(function(event){
                    event.preventDefault();
                    let depart = $("#depart");
                    let month = $("#month");
                    let year = $("#year");
                    $.ajax({
                            url:"/api/fetch-stats",
                            type:"get",
                            data:{
                                "depart":depart.val(),
                                "month":month.val(),
                                "year":year.val()
                            },
                            beforeSend:(()=>{
                                depart.attr('disabled','disabled');
                                month.attr('disabled','disabled');
                                year.attr('disabled','disabled');
                                $("#searchstats").text("wait...");
                                $("#searchstats").attr('disabled','disabled');
                            }),
                            success:((Response)=>{
                                console.log(Response);




                                depart.removeAttr('disabled');
                                month.removeAttr('disabled');
                                year.removeAttr('disabled');
                                $("#searchstats").text("Search");
                                $("#searchstats").removeAttr('disabled');
                            }
                        ),
                            error:((error)=>{
                                console.log(error);
                                alert("Error Found Please Referesh Page And Try Again !")

                                depart.removeAttr('disabled');
                                month.removeAttr('disabled');
                                year.removeAttr('disabled');
                                $("#searchstats").text("Search");
                                $("#searchstats").removeAttr('disabled');
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

