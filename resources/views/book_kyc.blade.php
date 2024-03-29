@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Client</a>
            <span class="breadcrumb-item active">Set Up Client</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Set Up Client</h4>
            <p class="mg-b-0">Client</p>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
           <form action="/forms/kyc/process/client" method="POST">
            @csrf
            <input type="hidden" name="serviceType" id="book" value="book">

            <div class="row">
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Client Name:</label>
                    <input type="text"  name="name" class="form-control" required>
                </div>
                <div class="col-4 mt-3">
                    <label for=""style="font-weight:bold;">Phone Number:</label>
                    <input type="text"  name="phone" required class="form-control">
                </div>
                <div class="col-4 mt-3">
                    <label for=""style="font-weight:bold;">Email:</label>
                    <input type="email"  name="email" required class="form-control">
                </div>
                <div class="col-4 mt-3">
                  <label for="" style="font-weight:bold;">Brand:</label>
                  <select class="form-control" id="select2forme" required name="brand">

                  @foreach ($Brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                  @endforeach
                  </select>
                </div>
                <div class="col-4 mt-3">
                  <label for="" style="font-weight:bold;">Sales Person:</label>
                  <select class="form-control" id="frontsale"  required name="saleperson">
                  @foreach($ProjectManagers as $pm)
                      <option value="{{ $pm->id }}">
                        {{ $pm->name }}
                        --
                        @foreach($pm->deparment($pm->id)  as $dm)
                          <strong>{{ $dm->name }}</strong>
                        @endforeach
                      </option>
                  @endforeach
                </select>

                </div>


                <div class="col-4 mt-3">
                  <label for="" style="font-weight:bold;">Website If Exist Or Domain Name If Exists:</label>
                  <input type="text"  name="website" required class="form-control">
                </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Package Name</label>
                    <input type="text" class="form-control" name="package">
                  </div>
                <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">Product</label>
                    <select class="form-control select2"  required name="product[]" multiple="multiple">
                        <option value="Editing & Proofreading">Editing & Proofreading</option>
                        <option value="Ghost Writing">Ghost Writing</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Only Proofreading">Only Proofreading</option>

                        @foreach($productionservices as $productionservice)
                        <option value="{{ $productionservice->services }}">{{ $productionservice->services }}</option>
                        @endforeach

                    </select>
                  </div>
                  <div class="col-4 mt-3">
                    <label for="" style="font-weight:bold;">MenuScript Provided?</label>
                    <select class="form-control select2"  required name="menuscript">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                  </div>
                    <div class="col-4 mt-3">
                      <label for="" style="font-weight:bold;">Genre of the book?</label>
                      <input type="text" class="form-control" name="bookgenre" required>
                    </div>
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Cover design included?</label>
                        <select class="form-control select2"  required name="coverdesign">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                      </div>
                    <div class="col-4 mt-3">
                      <label for="" style="font-weight:bold;">Total number of pages</label>
                      <input type="text" class="form-control" name="totalnumberofpages" required>
                    </div>
                    <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Publishing platforms offered?</label>
                        <input type="text" class="form-control" name="publishingplatform" required>
                      </div>
                      <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">ISBN Offered or Bar Code?</label>
                        <select class="form-control select2"  required name="isbn_offered">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                      </div>
                      <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Lead Platform</label>
                        <select class="form-control select2"  required name="leadplatform">
                            <option value="Google Ads">Google Ads</option>
                            <option value="Bark Lead">Bark Lead</option>
                            <option value="UpWork Lead">UpWork Lead</option>
                            <option value="Freelancer">Freelances</option>
                            <option value="Facebook">Facebook</option>
                            <option value="Thumbtack">Thumbtack</option>
                            <option value="Email Marketing">Email Marketing</option>
                            <option value="Email Marketing">Back Data</option>
                            <option value="Email Marketing">Incoming Call</option>
                            <option value="Email Marketing">Reference</option>
                            <option value="Email Marketing">Social Media</option>

                        </select>
                      </div>
                      <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Charging Plan</label>
                        <select class="form-control select2"  required name="ChargingPlan">
                            <option value="One Time Payment">One Time Payment</option>
                            <option value="Monthly">Monthly</option>
                            <option value="2 Months">2 Months</option>
                            <option value="3 Months">3 Months</option>
                            <option value="4 Months">4 Months</option>
                            <option value="6 Months">6 Months</option>
                            <option value="7 Months">7 Months</option>
                            <option value="8 Months">8 Months</option>
                            <option value="9 Months">9 Months</option>
                            <option value="10 Months">10 Months</option>
                            <option value="11 Months">11 Months</option>
                            <option value="12 Months">12 Months</option>
                        </select>
                      </div>
                      <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Total Project Amount</label>
                        <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="projectamount" required>
                      </div>
                      <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Client Paid</label>
                        <input type="text" class="form-control" onkeypress="return /[0-9]/i.test(event.key)" name="paidamount" required>
                      </div>
                      <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Future Next Payment Date </label>
                        <input type="date" class="form-control" name="nextamount" required>
                      </div>
                      <div class="col-8 mt-3">
                        <label for="" style="font-weight:bold;">Anymore commitment?</label>
                        <input type="text" class="form-control" name="anycommitment" required>
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
