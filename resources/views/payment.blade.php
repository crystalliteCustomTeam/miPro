@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Client</a>
            <span class="breadcrumb-item active">Client Payment</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Client Payment</h4>
            <p class="mg-b-0">Client</p>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">

           <form action="/client/payment" method="POST">
            @csrf
            <input type="hidden" name="project" value=" {{$projectmanager[0]->id }} ">
            <input type="hidden" name="clientID" value=" {{$projectmanager[0]->ClientName->id}} ">
            <input type="hidden" name="pmID" value=" {{$projectmanager[0]->EmployeeName->id}} ">

            <div class="row">


                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;font-size:150%;">Client Name:</label>
                    <label for="" style="font-size:150%;">{{$projectmanager[0]->ClientName->name }}</label>
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;font-size:150%;">Project Name:</label>
                    <label for="" style="font-size:150%;">{{$projectmanager[0]->name }}</label>
                  </div>
                 <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;font-size:150%;">Project Manager:</label>
                    <label for="" style="font-size:150%;">{{$projectmanager[0]->EmployeeName->name }}</label>
                </div>
                <div class="col-6 mt-3">
                  <label for="" style="font-weight:bold;">Payment Nature:</label>
                  <select class="form-control" id="select2forme" required name="paymentNature">
                        <option value="New Lead">Front Sale</option>
                        <option value="Upsell">Upsell</option>
                  </select>
                </div>
                <div class="col-6 mt-3">
                    <label for="" style="font-weight:bold;">Client Paid</label>
                    <input type="text" class="form-control" value="@if($AmountCheck) {{ $projectmanager[0]->ClientName->clientMetas->amountPaid }} @endif" onkeypress="return /[0-9]/i.test(event.key)" name="paidamount">
                  </div>
                <div class="col-6 mt-3">
                    <label for="" style="font-weight:bold;">Remaining Payment</label>
                    <input type="text" class="form-control" value="@if($AmountCheck) {{ $projectmanager[0]->ClientName->clientMetas->remainingAmount }} @endif" onkeypress="return /[0-9]/i.test(event.key)" name="remainingamount">
                </div>
                <div class="col-6 mt-3">
                    <label for="" style="font-weight:bold;">Payment Gateway</label>
                    <select  class="form-control select2"  name="paymentgateway">
                        <option value="Stripe">Stripe</option>
                        <option value="Bank Wire">Bank Wire</option>
                    </select>
                </div>
                <div class="col-6 mt-3">
                    <label for="" style="font-weight:bold;">Payment Type</label>
                    <select  class="form-control select2"  name="paymentType" id="paymentType" onchange="displayfields()">
                        <option value="Split Payment">Split Payment</option>
                        <option value="Full Payment">Full Payment</option>
                    </select>
                </div>

                <div class="col-6 mt-3" id="projectmanager">
                    <label for="" style="font-weight:bold;" >Project Manager (If Split):</label>
                    <select class="form-control select2"  name="shareProjectManager" id="projectmanager">
                      @foreach ($employee as $client)
                          <option value="{{ $client->id }}">{{ $client->name }} </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-6 mt-3" id="shareamount">
                    <label for="" style="font-weight:bold;" >Share Amount:</label>
                    <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="splitamount">
                  </div>
                  <script>
                    function displayfields(){
                    var paymenttype = document.getElementById("paymentType").value;
                    var projectmanager = document.getElementById("projectmanager");
                    var shareamount = document.getElementById("shareamount");

                    if (paymenttype === "Full Payment"){
                        projectmanager.style.display = 'none';
                        shareamount.style.display = 'none';
                    }else if (paymenttype === "Split Payment") {
                        projectmanager.style.display = 'block';
                        shareamount.style.display = 'block';
                    }
                    }
                  </script>

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


          </div>
        </div>

        <div class="br-pagebody">
          <div class="br-section-wrapper">
             <h2>All Payments By {{$projectmanager[0]->ClientName->name }}</h2>

             <table class="table" id="datatable1">
                <tr>
                  <td>Notice ID</td>
                  <td>Payment By</td>
                  <td>Charged Amount</td>
                  <td>Remaning Amount</td>
                  <td>Total Payment</td>
                </tr>
                <tbody>
                  @foreach ($allPayments as $payments)
                    <tr>
                      <td>{{ $payments->id }}</td>
                      <td>{{ $payments->EmployeeName->name }}</td>
                      <td>${{ $payments->clientPaid }}</td>
                      <td>${{ $payments->remainingPayment }}</td>
                      <td>${{ $payments->remainingPayment +   $payments->clientPaid}}</td>
                    </tr>
                  @endforeach
                </tbody>
             </table>
          </div>
        </div>



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
