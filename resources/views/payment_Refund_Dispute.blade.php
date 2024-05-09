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

            <button class="btn btn-outline-primary">Brand: {{$client_payment[0]->paymentbrandName->name}}</button>
            <button class="btn btn-outline-primary">Client Name: {{$client_payment[0]->paymentclientName->name}}</button>
            <button class="btn btn-outline-primary">Project Name:  {{$client_payment[0]->paymentprojectName->name}} </button>
            @if (isset($client_payment[0]->pmEmployeesName->name) and $client_payment[0]->pmEmployeesName->name !== null)
            <button class="btn btn-outline-primary">Project Manager: {{$client_payment[0]->pmEmployeesName->name}}</button>
            @else
            <button class="btn btn-outline-danger">Project Manager: User Deleted</button>
            @endif
            @if (isset($client_payment[0]->saleEmployeesName->name) and $client_payment[0]->saleEmployeesName->name !== null)
            <button class="btn btn-outline-primary">Sales Person: {{$client_payment[0]->saleEmployeesName->name}}</button>
            @else
            <button class="btn btn-outline-danger">Sales Person: User Deleted</button>
            @endif
            <button class="btn btn-outline-primary">Payment Nature: {{$client_payment[0]->paymentNature}}</button>
            <button class="btn btn-outline-primary">Charging Plan: {{$client_payment[0]->ChargingPlan}}</button>
            <button class="btn btn-outline-primary">Payment Modes: {{$client_payment[0]->ChargingMode}}</button>
            <button class="btn btn-outline-primary">Payment Type: {{$client_payment[0]->PaymentType}}</button>
            <button class="btn btn-outline-primary">Payment Date: {{$client_payment[0]->paymentDate}}</button>
            <button class="btn btn-outline-primary">Next Payment Date: {{$client_payment[0]->futureDate}}</button>
            <button class="btn btn-outline-primary">Total Amount: {{$client_payment[0]->TotalAmount}}</button>
            <button class="btn btn-outline-primary">Client Paid: {{$client_payment[0]->Paid}}</button>

           <form action="/client/project/payment/RefundDispute/{{$client_payment[0]->id}}/process" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value=" {{$client_payment[0]->paymentbrandName->id}}" name="brandID">
            <input type="hidden" value=" {{$client_payment[0]->paymentclientName->id}}" name="ClientID">
            <input type="hidden" value=" {{$client_payment[0]->paymentprojectName->id}}" name="projectID">
            <input type="hidden" value=" {{$client_payment[0]->pmEmployeesName->id}}" name="pmID">
            <input type="hidden" value=" {{$client_payment[0]->saleEmployeesName->id}}" name="saleID">
            <input type="hidden" value=" {{$client_payment[0]->id}}" name="paymentID">

            <div class="row">


                <div class="col-4 mt-3">
                  <label for="" style="font-weight:bold;">Chargeback Type:</label>
                  <select class="form-control select2" required name="chargebacktype"  id="chargebacktype" >
                        <option value="Select">Select</option>
                        <option value="Refund">Refund</option>
                        <option value="Dispute">Dispute</option>
                        <option value="Partial ChargeBack">Partial ChargeBack</option>
                  </select>
                </div>

                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Chargeback Amount:</label>
                    <input type="text" class="form-control"  name="chagebackAmt">
                </div>

                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Chargeback Date:</label>
                    <input type="date" class="form-control"  name="chagebackDate">
                </div>

                <div class="col-12 mt-3">
                    <label for="" style="font-weight:bold;">Chargeback Description:</label>
                    <textarea  name="Description_of_issue" class="form-control" id="" cols="30" rows="10"></textarea>
                </div>
                <div class="col-12 mt-3">
                    <br><br>
                </div>
                @if ($client_payment[0]->PaymentType == "Split Payment")
                    <div class="col-12 mt-3" >
                        <label for="" style="font-weight:bold;font-size:150%;">Employee Shared Amount:</label>
                        <div class="row">
                            @foreach ($employee_payment as $item)
                            <div class="col-6">
                                <div class="col-12 mt-3">
                                    <label for="" style="font-weight:bold;font-size:150%;">Project Manager:</label><br>
                                    <label for="" style="font-size:150%;">{{$item->empname->name}}</label>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="col-12 mt-3">
                                    <label for="" style="font-weight:bold;font-size:150%;">Shared Amount:</label><br>
                                    <label for="" style="font-size:150%;">${{$item->amount}}</label>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="col-12 mt-3">
                                    <label for="" style="font-weight:bold;">New Amount:</label>
                                    <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="splitamount[]" value="0">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endif

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
