@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Route Access</a>
            <span class="breadcrumb-item active">Manage Access</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Routes Data:</h4>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
            <style>
                .table-dark > tbody > tr > th, .table-dark > tbody > tr > td {
                    background-color: #ffffff !important;
                    color: #060708;
                    border: 0.5px solid #ecececcc !important;
                }
            </style>
            <table id="datatable1" class="table-dark table-hover">
                <thead>
                  <tr role="row">
                    <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 150px;" aria-sort="ascending" aria-label="First name: activate to sort column descending">Name</th>
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 250px;" aria-label="Last name: activate to sort column ascending">Route</th>
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 250px;" aria-label="Last name: activate to sort column ascending">Roles</th>
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 250px;" aria-label="Last name: activate to sort column ascending">Action</th>
                  </tr>
                </thead>
                <tbody>


                        @foreach($routesall as $routesalls)
                        <tr role="row" class="odd">
                        <td tabindex="0" class="sorting_1">{{ $routesalls->name  }}</td>
                        <td >{{ $routesalls->Route  }}</td>
                        @if ($routesalls->Role != null)
                            @php
                            $a = json_decode($routesalls->Role);
                            @endphp
                            <td>
                                <ul>
                                    @foreach ($a as $item)
                                        @php
                                        if ($item == 0) {
                                           $permission = "Admin";
                                        }elseif($item == 1){
                                            $permission = "Project Manager Or Sales Persons";
                                        }elseif($item == 2){
                                            $permission = "QA";
                                        } else {
                                            $permission = "Reporting Screen Only";
                                        }
                                        @endphp
                                        <li>{{$permission}}</li>
                                    @endforeach
                                </ul>
                            </td>
                        @else
                            <td>
                                --
                            </td>
                        @endif
                        <td>
                            <a href="/assign/permissions/edit/{{$routesalls->id}}" class="btn btn-primary">Edit Roles</a>
                        </td>


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
