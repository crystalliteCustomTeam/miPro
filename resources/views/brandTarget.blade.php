@extends('layouts.app')

@section('maincontent')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Brand</a>
            <span class="breadcrumb-item active">Set Up Target</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Brand Target:</h4>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">

           <form action="/settarget/process" method="post">
            @csrf
            <div class="row">
                {{-- <div class="col-3 mt-3">
                </div> --}}
                <div class="col-6 mt-3">
                        <label for="">Select Brand</label>
                        <select class="form-control select2" required name="brand">
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">
                              {{ $brand->name }}
                            </option>
                        @endforeach
                      </select>
                </div>
                <div class="col-6 mt-3">
                    <label for="">Select Year</label>
                    <select class="form-control select2" required name="year">
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                        <option value="2031">2031</option>
                        <option value="2032">2032</option>
                        <option value="2033">2033</option>
                        <option value="2034">2034</option>
                        <option value="2035">2035</option>
                        <option value="2036">2036</option>
                        <option value="2037">2037</option>
                        <option value="2038">2038</option>
                        <option value="2039">2039</option>
                        <option value="2040">2040</option>

                  </select>
            </div>
                <div class="col-3 mt-3">
                </div>
            </div>
            <br><br>
            <style>
                .table-dark > tbody > tr > th, .table-dark > tbody > tr > td {
                    background-color: #ffffff !important;
                    color: #060708;
                    border: 0.5px solid #ecececcc !important;
                }
            </style>
            <div class="row">
                {{-- <div class="col-5">

                </div> --}}
                <div class="col-6">
                    <table >
                        <thead>
                          <tr>
                            <th >Month</th>
                            <th >Target</th>
                          </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td >January</td>
                                    <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="jan" required></td>
                                </tr>
                                <tr>
                                    <td >February</td>
                                    <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="feb" required></td>
                                </tr>
                                <tr>
                                    <td >March</td>
                                    <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="mar" required></td>
                                </tr>
                                <tr>
                                    <td>April</td>
                                    <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="apr" required></td>
                                </tr>
                                <tr>
                                    <td>May</td>
                                    <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="may" required></td>
                                </tr>
                                <tr>
                                    <td >June</td>
                                    <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="june" required></td>
                                </tr>
                                <tr>
                                    <td >July</td>
                                    <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="july" required></td>
                                </tr>
                                <tr>
                                    <td >August</td>
                                    <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="aug" required></td>
                                </tr>
                                <tr>
                                    <td>September</td>
                                    <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="sept" required></td>
                                </tr>
                                <tr>
                                    <td >October</td>
                                    <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="oct" required></td>
                                </tr>
                                <tr>
                                    <td >November</td>
                                    <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="nov" required></td>
                                </tr>
                                <tr>
                                    <td >December</td>
                                    <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="dec" required></td>
                                </tr>
                        </tbody>
                      </table>


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







@endsection
