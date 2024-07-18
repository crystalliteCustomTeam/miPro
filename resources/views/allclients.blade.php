@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Clients</a>
            <span class="breadcrumb-item active">Manage Clients</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Client List</h4>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">




            <table id="datatable1" class="table-dark table-hover">
                <thead>
                  <tr role="row">
                    <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="First name: activate to sort column descending">Name</th>
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Email</th>
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Phone</th>
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Brand</th>
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Date</th>
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Projects</th>
                    {{-- <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">Users</th> --}}
                  </tr>
                </thead>
                <tbody>
                    @if ($user_id == 0)

                        @foreach($clients as $department)
                        <tr role="row" class="odd">
                        <td tabindex="0" class="sorting_1">{{ $department['name'] }}</td>
                        @if (isset($department->clientMetas->otheremail) && $department->clientMetas->otheremail != null)
                            <td>
                                @php
                                    $aa = json_decode($department->clientMetas->otheremail);
                                @endphp
                                <ul>
                                    @foreach($aa as $dm)
                                    <li><strong>{{ $dm }}</strong></li>
                                    @endforeach
                                </ul>
                            </td>
                        @else
                            {{-- <td>{{ $department->email }}</td> --}}
                            <td>
                                <ul>
                                    <li><strong>{{ $department->email }}</strong></li>
                                    <li>undefined</li>
                                </ul>
                            </td>
                        @endif
                        <td>{{ $department->phone }}</td>
                        <td>{{ $department->projectbrand->name }}</td>
                        <td>{{ $department->created_at }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="/client/details/{{$department->id }}" class="btn btn-success">View</a>
                                <a href="/forms/kyc/edit/{{$department->id }}" class="btn btn-info">Edit</a>
                                <a href="/generate/report/{{$department->id}}" class="btn btn-danger">Generate Report</a>
                            </div>
                        </td>

                        </tr>
                        @endforeach

                    @elseif ($user_id == 1)
                        @foreach($clients as $department)
                        <tr role="row" class="odd">
                        <td tabindex="0" class="sorting_1">{{ $department->clientname->name }}</td>
                        {{-- <td>{{ $department->clientname->email }}</td> --}}
                        <td>
                            @php
                                $aa = json_decode($department->clientMetas->otheremail);
                            @endphp
                            <ul>
                                @foreach($aa as $dm)
                                <li><strong>{{ $dm }}</strong></li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $department->clientname->phone }}</td>
                        <td>{{ $department->clientname->projectbrand->name }}</td>
                        <td>{{ $department->clientname->created_at }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="/client/details/{{$department->client }}" class="btn btn-success">View</a>
                                <a href="/forms/kyc/edit/{{$department->clientname->id }}" class="btn btn-info">Edit</a>
                                {{-- <a href="/forms/kyc/edit/{{$department->client }}" class="btn btn-info">Edit</a> --}}
                                {{-- <a href="/generate/report/{{$department->id}}" class="btn btn-danger">Generate Report</a> --}}
                            </div>
                        </td>

                        </tr>
                        @endforeach


                    @else
                    <p>No Client Assigned</p>
                    @endif



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
