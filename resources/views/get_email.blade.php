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


        <div class="br-pagebody blade">
          <div class="br-section-wrapper blade-wrapper">

           <form action="/auth/process" method="POST">
            @csrf
            <input type="hidden" name="serviceType" id="seo" value="seo">

            <div class="row">
                <div class="col-12 mt-3">
                    <label for=""style="font-weight:bold;">Please Enter Your Email:</label>
                    <input type="email" required name="email" required class="form-control">
                </div>

                <div class="col-8 mt-3">
                    <input type="submit" value="Submit" name="" class="btn btn-success mt-2">
                    <script>
                        function submitForm(){
                        Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "User has been created successfully!",
                        showConfirmButton: false,
                        timer: 1500
                        });
                            }
                    </script>
                </div>

                <div class="col-4 mt-3">
                        @if (Session::has('Success'))

                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ Session::get('Success') }}</strong>
                            <button type="button" class="btn btn-success" data-bs-dismiss="alert" aria-label="Close">X</button>
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

