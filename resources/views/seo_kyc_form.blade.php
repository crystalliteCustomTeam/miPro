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

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{ asset('css/bracket.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bracket.oreo.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head>

  <body>

        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
            <div>
                <h4>Set Up Client</h4>
                <p class="mg-b-0">SEO</p>
            </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">

           <form action="#" method="POST">
            @csrf
            <input type="hidden" name="serviceType" id="seo" value="seo">

            <div class="row">
                <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Client Name:</label>
                    <input type="text" required name="name" class="form-control" required>
                </div>
                <div class="col-3 mt-3">
                    <label for=""style="font-weight:bold;">Phone Number:</label>
                    <input type="text" required name="phone" required class="form-control">
                </div>
                <div class="col-3 mt-3">
                    <label for=""style="font-weight:bold;">Email:</label>
                    <input type="email" required name="email" required class="form-control">
                </div>
                <div class="col-3 mt-3">
                  <label for="" style="font-weight:bold;">Brand:</label>
                  <select class="form-control" id="select2forme" required name="brand">

                  @foreach ($Brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                  @endforeach
                  </select>
                </div>
                <div class="col-3 mt-3">
                  <label for="" style="font-weight:bold;">Sales Person:</label>
                  <select class="form-control select2"   required name="saleperson">
                  @foreach($ProjectManagers as $pm)
                      <option value="{{ $pm->id }}">
                        {{ $pm->name }}
                        --
                        @foreach($pm->deparment($pm->id)  as $dm)
                          <strong>{{ $dm->name }}</strong>
                        @endforeach
                      </option>
                  @endforeach
                </select>

                </div>


                <div class="col-3 mt-3">
                  <label for="" style="font-weight:bold;">Website If Exist Or Domain Name If Exists:</label>
                  <input type="text" required name="website" required class="form-control">
                </div>
                <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Package Name</label>
                    <input type="text" class="form-control" name="package">
                  </div>
                  <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Keyword Count</label>
                    <input type="text" class="form-control" name="KeywordCount">
                  </div>
                  <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Target Market</label>
                    <select class="form-control select2"  required name="TargetMarket[]" multiple="multiple">
                        <option value="Global">Global</option>
                        <option value="Nationwide">Nationwide</option>
                        <option value="Local">Local</option>
                    </select>
                  </div>
                  <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Other Services</label>
                    <select class="form-control select2"  required name="OtherServices[]" multiple="multiple">
                        <option value="SMM">SMM</option>
                        <option value="GMB">GMB</option>
                        <option value="Adword Campaign">Adword Campaign</option>
                        <option value="Facebook Campaign">Facebook Campaign</option>
                        <option value="Website">Website</option>
                        <option value="NFT">NFT</option>
                        <option value="NFT Marketing only">NFT Marketing only</option>
                        <option value="--">Not Applicable</option>

                        @foreach($productionservices as $productionservice)
                        <option value="{{ $productionservice->services }}">{{ $productionservice->services }}</option>
                        @endforeach

                    </select>
                  </div>
                  <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Charging Plan</label>
                    <select class="form-control select2"  required name="ChargingPlan">
                        <option value="One Time Payment">One Time Payment</option>
                        <option value="Monthly">Monthly</option>
                        <option value="2 Months">2 Months</option>
                        <option value="3 Months">3 Months</option>
                        <option value="4 Months">4 Months</option>
                        <option value="6 Months">6 Months</option>
                        <option value="7 Months">7 Months</option>
                        <option value="8 Months">8 Months</option>
                        <option value="9 Months">9 Months</option>
                        <option value="10 Months">10 Months</option>
                        <option value="11 Months">11 Months</option>
                        <option value="12 Months">12 Months</option>

                    </select>
                  </div>
                  <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Total Project Amount</label>
                    <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="projectamount">
                  </div>
                  <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Client Paid</label>
                    <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="paidamount">
                  </div>
                  <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Future Next Payment Date </label>
                    <input type="date" class="form-control" name="nextamount">
                  </div>
                  <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Lead Platform</label>
                    <select class="form-control select2"  required name="leadplatform">
                        <option value="Google Ads">Google Ads</option>
                        <option value="Bark Lead">Bark Lead</option>
                        <option value="UpWork Lead">UpWork Lead</option>
                        <option value="Freelancer">Freelances</option>
                        <option value="Facebook">Facebook</option>
                        <option value="Thumbtack">Thumbtack</option>
                        <option value="Email Marketing">Email Marketing</option>
                    </select>
                  </div>
                  <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Payment Nature</label>
                    <select class="form-control select2"  required name="paymentnature">
                        <option value="Renewal">Renewal</option>
                        <option value="Recurring">Recurring</option>
                        <option value="One Time">One Time</option>
                    </select>
                  </div>
                  <div class="col-12 mt-3">
                    <label for="" style="font-weight:bold;">Anymore commitments?</label>
                    <textarea required name="anycommitment" class="form-control" id="" cols="30" rows="10"></textarea>
                  </div>


            </div>
            <div class="row mt-3">
                <div class="col-3">
                    <br>
                    <input type="submit" value="Create"  name="" class="btn btn-success mt-2">
                </div>
                <div class="col-9">
                        @if (Session::has('Success'))

                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ Session::get('Success') }}</strong>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="alert" aria-label="Close">X</button>
                        </div>

                        @endif
                        @if (Session::has('Error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ Session::get('Error') }}</strong>
                            <button type="button" class="btn-danger" data-bs-dismiss="alert" aria-label="Close">X</button>
                        </div>
                        @endif
                </div>
            </div>
           </form>









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
      </div><!-- br-mainpanel -->
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

