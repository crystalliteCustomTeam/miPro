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
    <link href="{{ asset('lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/rickshaw/rickshaw.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{ asset('css/bracket.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bracket.oreo.css') }}">
  </head>

  <body>


    @extends('layouts.report.report_leftpanel')



    <div class="br-mainpanel">


          <div class="br-pagetitle">
            <i class="icon ion-ios-gear-outline"></i>
            <div>
              <h4>Report:</h4>
              <p class="mg-b-0">Date:</p>
            </div>
          </div><!-- d-flex -->




        <div class="br-pagebody">

        <div class="row">

            <div class="col-3">
                <div class="card bd-gray-400 pd-20">
                  <h6 style="color: black">Client Name:  {{$clients[0]->name}}</h6>

                </div><!-- card -->
              </div><!-- col-4 -->

              {{-- ======================================================== --}}
              <div class="col-3">
                <div class="card bd-gray-400 pd-20">
                  <h6 style="color: black">Project Name:  {{$projects[0]->name}}</h6>


                </div><!-- card -->
              </div><!-- col-4 -->

              {{-- ======================================================== --}}
              <div class="col-3">
                  <div class="card bd-gray-400 bg-lightblue  pd-20">
                      <h6 style="color: black">Project Manager:  {{$projects[0]->EmployeeName->name}}</h6>


                  </div><!-- card -->
              </div><!-- col-4 -->

              <div class="col-3">
                <div class="card bd-gray-400 pd-20">
                    <h6 style="color: black">Brand Name:  {{$clients[0]->projectbrand->name}}</h6>


                </div><!-- card -->
            </div><!-- col-4 -->


              <div class="col-3">
                <div class="card bd-gray-400 pd-20">
                    <h6 style="color: black">Status of Refund:</h6>


                </div><!-- card -->
              </div><!-- col-4 -->



              <div class="col-3">
                <div class="card bd-gray-400 pd-20">
                    <h6 style="color: black">Last Communication:</h6>


                </div><!-- card -->
              </div><!-- col-4 -->

              <div class="col-3">
                <div class="card bd-gray-400 pd-20">
                    <h6 style="color: black">Client Satisfaction:</h6>


                </div><!-- card -->
              </div><!-- col-4 -->

              <div class="col-3">
                <div class="card bd-gray-400 pd-20">
                    <h6 style="color: black">QA Person:</h6>


                </div><!-- card -->
              </div><!-- col-4 -->


              <div class="col-3">
                  <div class="card bd-gray-400 pd-20">
                      <h6  style="color: black">Signature:</h6>


                  </div><!-- card -->
              </div><!-- col-4 -->



        </div>


</div><!-- br-pagebody -->




        <div class="br-pagebody">
          <div class="br-section-wrapper">
            <h2>PROJECT REPORT:</h2>
            <br><br>
            <div class="col-12">
                <div class="card bd-gray-400  bg-light   pd-20">
                    <h6  style="color: black">summery:</h6>


                </div><!-- card -->
            </div><!-- col-4 -->

            <br><br>


           <table id="datatable1" class="table-dark table-hover">
              <thead>
                <tr role="row">
                  <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="First name: activate to sort column descending">Production</th>
                  <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Person</th>
                  <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">Status</th>
                  <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Start date: activate to sort column ascending">Issue</th>
                  <th class="wd-10p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 127px;" aria-label="Salary: activate to sort column ascending">Description</th>
                  <th class="wd-10p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 127px;" aria-label="Salary: activate to sort column ascending">Attachment</th>
                </tr>
              </thead>
              <tbody>

                {{-- @foreach($companies as $company)
                <tr role="row" class="odd">
                  <td tabindex="0" class="sorting_1">{{ $company->name }}</td>
                  <td>{{ $company->email }}</td>
                  <td>{{ $company->tel }}</td>
                  <td>{{ $company->website }}</td>
                  <td>
                      <div class="button-group">
                        <a href="/editcompany/{{ $company->id }}" class="btn btn-sm btn-info">Edit</a>
                        <a href="/deletecompany/{{ $company->id }}" class="btn btn-sm btn-danger">Delete</a>
                        <a href="/addbrand/{{ $company->id }}" class="btn btn-sm btn-primary">Add Brand</a>
                      </div>
                  </td>
                  <td style="display: none;">{{ $company->address }}</td>
                </tr>
                @endforeach --}}

              </tbody>
            </table>



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







  </body>
</html>

