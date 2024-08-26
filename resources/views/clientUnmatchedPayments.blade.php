@extends($theme == 1 ? 'layouts.darktheme' : 'layouts.app')

@section($theme == 1 ? 'maincontent1' : 'maincontent')
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
            <h4>Unmatched Payments (Stripe):</h4>
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

           <table id="datatable1" class="table-dark-wrapper table-hover">
              <thead>
                <tr role="row">
                  <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="First name: activate to sort column descending">Client Email</th>
                  <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">TransactionID</th>
                  <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">Status</th>
                  <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">Amount Received</th>
                  <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">Card Brand</th>
                  <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">Date</th>
                  <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">Description</th>
                  <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">Add/Link Client</th>
                </tr>
              </thead>
              <tbody>

                @foreach($getUnmatched as $getUnmatcheds)

                    <tr role="row" class="odd">
                        {{-- <td tabindex="0" class="sorting_1">{{ $getUnmatcheds->Clientemail }}</td> --}}
                        <td tabindex="0" class="sorting_1">
                            @if ( $getUnmatcheds->stripePaymentstatus != 'Paid' )
                            <div class="alert alert-danger">
                                {{ $getUnmatcheds->Clientemail }}
                            </div>
                            @else
                            {{ $getUnmatcheds->Clientemail }}
                            @endif
                        </td>
                        <td tabindex="0" class="sorting_1">{{ $getUnmatcheds->TransactionID }}</td>
                        <td>{{ $getUnmatcheds->stripePaymentstatus }}</td>
                        <td>${{ $getUnmatcheds->Paid }}</td>
                        <td>{{ $getUnmatcheds->cardBrand }}</td>
                        <td>{{ $getUnmatcheds->paymentDate }}</td>
                        <td>{{ $getUnmatcheds->Description }}</td>
                        <td>
                            <a href="/client/newemail/{{$getUnmatcheds->Clientemail}}"  class="btn btn-danger">Link Client</a>
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
