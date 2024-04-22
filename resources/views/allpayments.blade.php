@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Company</a>
            <span class="breadcrumb-item active">Manage Companies</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Payments:</h4>
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
                    <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="First name: activate to sort column descending">Project</th>
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Payment Nature</th>
                    <th class="wd-10p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Salary: activate to sort column ascending">Payment Date</th>
                    <th class="wd-10p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Salary: activate to sort column ascending">Total Amount</th>
                    <th class="wd-10p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Salary: activate to sort column ascending">Client Paid</th>
                    <th class="wd-10p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Salary: activate to sort column ascending">Descirption</th>
                    <th class="wd-10p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Salary: activate to sort column ascending">Actions</th>
                    {{-- <th class="wd-10p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Salary: activate to sort column ascending">Delete</th> --}}

                  </tr>
                </thead>
                <tbody>
                    @foreach ($clientPayments as $item)
                    <tr role="row" class="odd">
                        <td tabindex="0" class="sorting_1">
                            <strong> {{$item->paymentclientName->name}}</strong>
                            --
                            {{$item->paymentprojectName->name}}
                        </td>
                        {{-- <td tabindex="0" class="sorting_1">{{$item->paymentprojectName->name}}</td> --}}
                        <td>{{$item->paymentNature}}</td>
                        <td>{{$item->paymentDate}}</td>
                        <td>${{$item->TotalAmount}}</td>
                        <td>${{$item->Paid}}</td>
                        <td>{{$item->Description}}</td>
                        <td>
                            @if ($item->refundStatus != "On Going" && $item->refundStatus != "Pending Payment")
                            <div class="btn-group">
                                <a href="/client/project/payment/view/{{$item->id}}" class="btn btn-success">View (Refund)</a>
                            </div>
                            @else
                            <div class="btn-group">
                                <a href="/client/project/payment/report/view/{{$item->id}}" class="btn btn-success">View</a>
                                <a href="/client/project/payment/edit/{{$item->id}}" class="btn btn-primary">Edit</a>
                                <a href="#" onclick="myConfirm('{{ $item->id }}')" class="btn btn-danger">Delete</a>
                                <a href="/client/project/payment/RefundDispute/{{$item->id}}" class="btn btn-warning">Refund/Request</a>
                                @if ($item->remainingStatus == "Remaining")
                                <a href="/client/project/payment/remaining/{{$item->id}}" class="btn btn-info">Add Remaining</a>
                                @endif
                            @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <script>
                function myConfirm(id){
                    Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this !",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/client/project/payment/delete/" + id;
                        Swal.fire({
                        title: "Deleted!",
                        text: "Payment has been deleted.",
                        icon: "success"
                        });
                    }});

                }
            </script>






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
