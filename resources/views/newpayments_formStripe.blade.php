@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Payments</a>
            <span class="breadcrumb-item active">Manage Payments</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Payments Form Stripe:</h4>
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
                  <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="First name: activate to sort column descending">Client Email</th>
                  <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">TransactionID</th>
                  <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">Amount Received</th>
                  <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">Card Brand</th>
                  <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">Date</th>
                  <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">Create Payment</th>
                </tr>
              </thead>
              <tbody>

                @foreach($details as $detail)
                <tr role="row" class="odd">
                    <form action="/client/new/payment/process" method="POST">
                        @csrf
                    <input type="hidden" name="transactionID" value="{{ $detail->id }}">
                  <td tabindex="0" class="sorting_1">{{ $detail->billing_details['email'] }}</td>
                  <td tabindex="0" class="sorting_1">{{ $detail->id }}</td>
                  <td>${{ $detail->amount_captured / 100 }}</td>
                  <td>{{ $detail->payment_method_details->card->brand }}</td>
                  <td>{{ date('Y-m-d',$detail->created) }}</td>
                  <td>
                    <input type="submit" value="Add Payment" name="" class="btn btn-success mt-2">
                  </td>
                </form>
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
