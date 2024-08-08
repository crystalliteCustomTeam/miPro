    {{-- <ul>
        @foreach($routes as $route)

        @if ($route->methods()[0] == "GET")
            <li>{{ $route->methods()[0] }}</li>
            <li>{{ $route->uri() }}</li>
        @endif

        @endforeach
    </ul> --}}



    @extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Authorizations</a>
            <span class="breadcrumb-item active">Set Up Authorizations</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Edit Route Roles</h4>
            <p class="mg-b-0">Edit Roles</p>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
            @foreach ($allroutes as $item)
                <form action="/assign/permissions/Edit/process/{{$item->id}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                        <button class="btn btn-outline-primary">Name: {{$item->name }}</button>
                        <button class="btn btn-outline-primary">Route: {{$item->Route }}</button>
                        </div>

                        <div class="col-12">
                            <br><br>
                            <label for="">Select Access</label>
                            @php
                            $a = json_decode($item->Role);
                            @endphp
                            <select class="form-control select2" name="access[]" multiple="multiple">
                                @if ($item->Role != null)
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
                                        <option value="{{$item}}" selected>{{$permission}}</option>
                                    @endforeach
                                @endif
                                <option value="0">Admin</option>
                                <option value="1">Project Manager Or Sales Persons</option>
                                <option value="2">QA</option>
                                <option value="3">Reporting Screen Only</option>

                            </select>
                        </div>

                    </div>
                    <div class="row mt-3">

                        <div class="col-4">
                            <br>
                            <input type="submit" value="Update" name="" class="btn btn-success mt-2">
                        </div>
                        <div class="col-4">
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
