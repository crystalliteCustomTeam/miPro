@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Department</a>
            <span class="breadcrumb-item active">Set Up Department</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Set Up Department</h4>
            <p class="mg-b-0">Department</p>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
            @foreach ($departdata as $departeditdata)
            <div class="row">
              <div class="col-12 mt-4">
                <table id="datatable1">
                  <thead>
                    <th>Name</th>
                    <th>Postion</th>
                    <th>Email</th>
                  </thead>
                  <tbody>
                    @foreach($employees as $employee)
                    <tr>
                        @if (in_array($employee->id, json_decode($departeditdata->users)))
                        <td><a href="/userprofile/{{ $employee->id }}">{{ $employee->name }}</td>
                      <td>{{ $employee->position }}</td>
                      <td>{{ $employee->email }}</td>
                        @endif
                    </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>
            </div>
            @endforeach





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
