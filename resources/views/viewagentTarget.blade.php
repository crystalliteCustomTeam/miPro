@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Agent Target</a>
            <span class="breadcrumb-item active">Manage Agent</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Agent Targets</h4>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">


           <table id="datatable1" class="table-dark table-hover">
              <thead>
                <tr role="row">
                  <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="First name: activate to sort column descending">Agent</th>
                  <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Role</th>
                  <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Year</th>
                  <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">January</th>
                  <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">February</th>
                  <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Start date: activate to sort column ascending">March</th>
                  <th class="wd-10p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Salary: activate to sort column ascending">April</th>
                  <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">May</th>
                  <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">June</th>
                  <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">July</th>
                  <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Start date: activate to sort column ascending">August</th>
                  <th class="wd-10p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Salary: activate to sort column ascending">September</th>
                  <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">October</th>
                  <th class="wd-10p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Salary: activate to sort column ascending">November</th>
                  <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">December</th>
                  <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Action</th>
                </tr>
              </thead>
              <tbody>

                @foreach($brands as $brand)
                <tr role="row" class="odd">
                  <td tabindex="0" class="sorting_1">{{ $brand->agentoftarget->name }}</td>
                  <td>{{ $brand->salesrole }}</td>
                  <td>{{ $brand->Year }}</td>
                  <td>{{ $brand->January }}</td>
                  <td>{{ $brand->February }}</td>
                  <td>{{ $brand->March }}</td>
                  <td >{{ $brand->April }}</td>
                  <td>{{ $brand->May }}</td>
                  <td>{{ $brand->June }}</td>
                  <td>{{ $brand->July }}</td>
                  <td>{{ $brand->August }}</td>
                  <td>{{ $brand->September }}</td>
                  <td>{{ $brand->October }}</td>
                  <td>{{ $brand->November }}</td>
                  <td>{{ $brand->December }}</td>
                  <td> <a href="/setagenttarget/edit/{{$brand->id}}" class="btn btn-success">Edit</a> </td>
                </tr>
                @endforeach

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
@endsection
