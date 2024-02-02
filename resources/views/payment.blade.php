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

           <form action="" method="POST">
            @csrf
            <input type="hidden" name="project" value=" {{$projectmanager[0]->id }} ">

            <div class="row">


                <div class="col-4 mt-3">
                    <h5>Client Name:</h5>
                     {{$projectmanager[0]->ClientName->name }}
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Project:</label>
                     {{$projectmanager[0]->name }}
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Project Manager:</label>
                    {{$projectmanager[0]->EmployeeName->name }}
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
                    <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="paidamount">
                  </div>
                <div class="col-6 mt-3">
                    <label for="" style="font-weight:bold;">Payment Type</label>
                    <select  class="form-control select2"  name="paymentType">
                        <option value="Full Payment">Full Payment</option>
                        <option value="Split Payment">Split Payment</option>
                    </select>
                </div>
                <div class="col-6 mt-3">
                    <label for="" style="font-weight:bold;">Select Project Manager:</label>
                    <select class="form-control select2" required name="pm">
                      @foreach ($employee as $client)
                          <option value="{{ $client->id }}">{{ $client->name }} </option>
                      @endforeach
                    </select>
                  </div>


                <div class="col-6 mt-3">
                    <label for="" style="font-weight:bold;">Remaining Payment</label>
                    <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="paidamount">
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







@endsection
