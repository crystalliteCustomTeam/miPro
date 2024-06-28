@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Client</a>
            <span class="breadcrumb-item active">Projects</span>
            <span class="breadcrumb-item active">Payments</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Client Payments:</h4>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
            <button class="btn btn-outline-primary">Client Name: {{$client_payment[0]->paymentclientName->name}}</button>
              <button class="btn btn-outline-primary">Project Name:
                @if (isset($client_payment[0]->paymentprojectName->name) and $client_payment[0]->paymentprojectName->name !== null)
                {{$client_payment[0]->paymentprojectName->name}}
                @else
                User Deleted
                @endif
              </button>
              @if (isset($client_payment[0]->paymentprojectName->EmployeeName->name) and $client_payment[0]->paymentprojectName->EmployeeName->name !== null)
              <button class="btn btn-outline-primary">Project Manager: {{$client_payment[0]->paymentprojectName->EmployeeName->name}}</button>
              @else
              <button class="btn btn-outline-danger">Project Manager: User Deleted</button>
              @endif

              <button class="btn btn-outline-primary">Brand: {{$client_payment[0]->paymentbrandName->name}}</button>
              <br><br>


            <table  id="datatable1"  style="width:100%"  class="table-dark table-hover">
                <tr>
                  <th>Payment Nature:</th>
                  <td>{{$client_payment[0]->paymentNature}}</td>
                </tr>

                <tr>
                  <th>Charging Plan:</th>
                  <td>{{$client_payment[0]->ChargingPlan}}</td>
                </tr>

                <tr>
                    <th>Charging Mode:</th>
                    <td>{{$client_payment[0]->ChargingMode}}</td>
                </tr>

                <tr>
                    <th>Platform:</th>
                    <td>{{$client_payment[0]->Platform}}</td>
                </tr>

                <tr>
                  <th>Card Brand:</th>
                  <td>{{$client_payment[0]->Card_Brand}}</td>
                </tr>

                <tr>
                    <th>Payment Gateway:</th>
                    <td>{{$client_payment[0]->Payment_Gateway}}</td>
                </tr>

                @if ($client_payment[0]->Payment_Gateway == "Bank Wire")
                    <tr>
                        <th>BankWire Upload:</th>
                        {{-- <td>{{$client_payment[0]->bankWireUpload}}</td> --}}
                        <td><a target="_blank" href="{{  Storage::url( $client_payment[0]->bankWireUpload ) }}">DOWNLOAD</a></td>
                    </tr>
                @endif

                <tr>
                    <th>Transaction ID:</th>
                    <td>{{$client_payment[0]->TransactionID}}</td>
                </tr>

                <tr>
                    <th>Payment Date:</th>
                    <td>{{$client_payment[0]->paymentDate}}</td>
                </tr>

                <tr>
                    <th>Future Date:</th>
                    <td>{{$client_payment[0]->futureDate}}</td>
                </tr>

                <tr>

                </tr>
                    <th>Sales Person:</th>
                    @if (isset($client_payment[0]->saleEmployeesName->name) and $client_payment[0]->saleEmployeesName->name !== null)
                        <td>{{$client_payment[0]->saleEmployeesName->name}}</td>
                    @else
                        <td><p style="color: red">User Deleted</p></td>
                    @endif
                <tr>
                    <th>Total Amount:</th>
                    <td>${{$client_payment[0]->TotalAmount}}</td>
                </tr>

                <tr>
                    <th>Paid:</th>
                    <td>${{$client_payment[0]->Paid}}</td>
                </tr>

                <tr>
                    <th>Remaining Amount:</th>
                    <td>${{$client_payment[0]->RemainingAmount}}</td>
                </tr>

                <tr>
                    <th>Payment Type:</th>
                    <td>{{$client_payment[0]->PaymentType}}</td>
                </tr>

                @if ($client_payment[0]->PaymentType == "Split Payment")
                    <tr>
                        <th>Number Of Splits:</th>
                        <td>{{$client_payment[0]->numberOfSplits}}</td>
                    </tr>

                    <tr>
                        <th>Split Project Manager:</th>
                        <td>{{$client_payment[0]->SplitProjectManager}}</td>
                    </tr>

                    <tr>
                        <th>Share Amount:</th>
                        <td>{{$client_payment[0]->ShareAmount}}</td>
                    </tr>
                @endif

                <tr>
                    <th>Description:</th>
                    <td>{{$client_payment[0]->Description}}</td>
                </tr>

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
