@extends($theme == 1 ? 'layouts.darktheme' : 'layouts.app')

@section($theme == 1 ? 'maincontent1' : 'maincontent')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Agent</a>
            <span class="breadcrumb-item active">Set Up Edit Target</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Edit Agent Target:</h4>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
            @foreach ($brandedit as $brandeditdata)
           <form action="/setagenttarget/edit/process/{{$brandeditdata->id}}" method="post">
            @csrf
            <div class="row">
                {{-- <div class="col-3 mt-3">
                </div> --}}
                <div class="col-4 mt-3">
                        <label for="">Select Agent</label>
                        <select class="form-control select2" required name="brands" disabled>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}"{{ $brand->id == $brandeditdata->AgentID ? 'selected' : '' }}>
                              {{ $brand->name }}
                            </option>
                        @endforeach
                      </select>
                      <input type="hidden" name="brand" value="{{$brandeditdata->AgentID}}">
                </div>
                <div class="col-4 mt-3">
                    <label for="">Select Role</label>
                    <select class="form-control select2" required name="role">
                        <option value="{{ $brandeditdata->salesrole }}" selected>{{ $brandeditdata->salesrole }}</option>
                        <option value="Front">Front</option>
                        <option value="Support">Support</option>
                  </select>
                </div>
                <div class="col-4 mt-3">
                    <label for="">Select Year</label>
                    <select class="form-control select2" required name="years" disabled>
                        <option value="{{ $brandeditdata->Year }}" selected>{{ $brandeditdata->Year }}</option>
                  </select>
                  <input type="hidden" name="selectedyear" value="{{$brandeditdata->Year}}">
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
                                @if ($theme == 1)
                                <td><input type="text"class="form-control-dark wd-200" onkeypress="return /[0-9]/i.test(event.key)" name="jan" required style="height: 50px;" value="{{$brandeditdata->January}}"></td>
                                @else
                                <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="jan" required value="{{$brandeditdata->January}}"></td>
                                @endif
                            </tr>
                            <tr>
                                <td >February</td>
                                @if ($theme == 1)
                                <td><input type="text"class="form-control-dark wd-200" onkeypress="return /[0-9]/i.test(event.key)" name="feb" required style="height: 50px;" value="{{$brandeditdata->February}}"></td>
                                @else
                                <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="feb" required value="{{$brandeditdata->February}}"></td>
                                @endif
                            </tr>
                            <tr>
                                <td >March</td>
                                @if ($theme == 1)
                                <td><input type="text"class="form-control-dark wd-200" onkeypress="return /[0-9]/i.test(event.key)" name="mar" required style="height: 50px;" value="{{$brandeditdata->March}}"></td>
                                @else
                                <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="mar" required value="{{$brandeditdata->March}}"></td>
                                @endif
                            </tr>
                            <tr>
                                <td>April</td>
                                @if ($theme == 1)
                                <td><input type="text"class="form-control-dark wd-200" onkeypress="return /[0-9]/i.test(event.key)" name="apr" required style="height: 50px;" value="{{$brandeditdata->April}}"></td>
                                @else
                                <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="apr" required value="{{$brandeditdata->April}}"></td>
                                @endif
                            </tr>
                            <tr>
                                <td>May</td>
                                @if ($theme == 1)
                                <td><input type="text"class="form-control-dark wd-200" onkeypress="return /[0-9]/i.test(event.key)" name="may" required style="height: 50px;" value="{{$brandeditdata->May}}"></td>
                                @else
                                <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="may" required value="{{$brandeditdata->May}}"></td>
                                @endif
                            </tr>
                            <tr>
                                <td >June</td>
                                @if ($theme == 1)
                                <td><input type="text"class="form-control-dark wd-200" onkeypress="return /[0-9]/i.test(event.key)" name="june" required style="height: 50px;" value="{{$brandeditdata->June}}"></td>
                                @else
                                <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="june" required value="{{$brandeditdata->June}}"></td>
                                @endif
                            </tr>
                            <tr>
                                <td >July</td>
                                @if ($theme == 1)
                                <td><input type="text"class="form-control-dark wd-200" onkeypress="return /[0-9]/i.test(event.key)" name="july" required style="height: 50px;" value="{{$brandeditdata->July}}"></td>
                                @else
                                <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="july" required value="{{$brandeditdata->July}}"></td>
                                @endif
                            </tr>
                            <tr>
                                <td >August</td>
                                @if ($theme == 1)
                                <td><input type="text"class="form-control-dark wd-200" onkeypress="return /[0-9]/i.test(event.key)" name="aug" required style="height: 50px;" value="{{$brandeditdata->August}}"></td>
                                @else
                                <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="aug" required value="{{$brandeditdata->August}}"></td>
                                @endif
                            </tr>
                            <tr>
                                <td>September</td>
                                @if ($theme == 1)
                                <td><input type="text"class="form-control-dark wd-200" onkeypress="return /[0-9]/i.test(event.key)" name="sept" required style="height: 50px;" value="{{$brandeditdata->September}}"></td>
                                @else
                                <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="sept" required value="{{$brandeditdata->September}}"></td>
                                @endif
                            </tr>
                            <tr>
                                <td >October</td>
                                @if ($theme == 1)
                                <td><input type="text"class="form-control-dark wd-200" onkeypress="return /[0-9]/i.test(event.key)" name="oct" required style="height: 50px;" value="{{$brandeditdata->October}}"></td>
                                @else
                                <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="oct" required value="{{$brandeditdata->October}}"></td>
                                @endif
                            </tr>
                            <tr>
                                <td >November</td>
                                @if ($theme == 1)
                                <td><input type="text"class="form-control-dark wd-200" onkeypress="return /[0-9]/i.test(event.key)" name="nov" required style="height: 50px;" value="{{$brandeditdata->November}}"></td>
                                @else
                                <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="nov" required value="{{$brandeditdata->November}}"></td>
                                @endif
                            </tr>
                            <tr>
                                <td >December</td>
                                @if ($theme == 1)
                                <td><input type="text"class="form-control-dark wd-200" onkeypress="return /[0-9]/i.test(event.key)" name="dec" required style="height: 50px;" value="{{$brandeditdata->December}}"></td>
                                @else
                                <td><input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="dec" required value="{{$brandeditdata->December}}"></td>
                                @endif
                            </tr>
                    </tbody>
                      </table>


                </div>

            </div>
            <div class="row mt-3">
                <div class="col-3">
                    <br>
                    <input type="submit" value="Update"  name="" class="btn btn-success mt-2">
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
