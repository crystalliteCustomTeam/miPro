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
            <h4 style="font-weight:bold;">Client General Information:</h4>
           <form action="/forms/kyc/process/client" method="POST">
            @csrf

            <div class="row">
                <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Client Name:</label>
                    <input type="text" required name="name" class="form-control" required>
                </div>
                <div class="col-3 mt-3">
                    <label for=""style="font-weight:bold;">Phone Number:</label>
                    <input type="text" required name="phone" required class="form-control">
                </div>
                <div class="col-3 mt-3">
                    <label for=""style="font-weight:bold;">Email:</label>
                    <input type="email" required name="email" required class="form-control">
                </div>
                <div class="col-3 mt-3">
                  <label for="" style="font-weight:bold;">Brand:</label>
                  <select class="form-control" id="select2forme" required name="brand">

                  @foreach ($Brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                  @endforeach
                  </select>
                </div>
                <div class="col-5 mt-3">
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
                  <input type="text" required name="website" required class="form-control">
                </div>

                <div class="col-3 mt-3">
                  <label for="" style="font-weight:bold;">Select Services</label>
                  <select class="form-control" name="selectCategory">
                      <option value="0">Select Category For Kyc</option>
                      <option value="1">SEO</option>
                      <option value="2">BWC</option>
                      <option value="3">CLD</option>
                      <option value="4">WEB</option>
                  </select>
                </div>

                <div class="col-12 mt-3">
                  <hr>

                   <div class="row" id="seo">
                    <div class="col-12">
                      <h2>SEO SERVICES KYC </h2>
                    </div>
                      <div class="col-3 mt-3">
                        <label for="" style="font-weight:bold;">Package Name</label>
                        <input type="text" class="form-control" name="package">
                      </div>
                      <div class="col-3 mt-3">
                        <label for="" style="font-weight:bold;">Keyword Count</label>
                        <input type="text" class="form-control" name="KeywordCount">
                      </div>
                      <div class="col-3 mt-3">
                        <label for="" style="font-weight:bold;">Target Market</label>
                        <select class="form-control select2"  required name="TargetMarket[]" multiple="multiple">
                            <option value="Global">Global</option>
                            <option value="Nationwide">Nationwide</option>
                            <option value="Local">Local</option>
                        </select>
                      </div>
                      <div class="col-3 mt-3">
                        <label for="" style="font-weight:bold;">Other Services</label>
                        <select class="form-control select2"  required name="OtherServices[]" multiple="multiple">
                            <option value="SMM">SMM</option>
                            <option value="GMB">GMB</option>
                            <option value="Adword Campaign">Adword Campaign</option>
                            <option value="Facebook Campaign">Facebook Campaign</option>
                            <option value="Website">Website</option>
                            <option value="NFT">NFT</option>
                            <option value="NFT Marketing only">NFT Marketing only</option>
                        </select>
                      </div>
                      <div class="col-3 mt-3">
                        <label for="" style="font-weight:bold;">Charging Plan</label>
                        <select class="form-control select2"  required name="seo_ChargingPlan">
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
                      <div class="col-3 mt-3">
                        <label for="" style="font-weight:bold;">Paid Amount</label>
                        <input type="text" class="form-control" name="seo_paidamount">
                      </div>
                      <div class="col-3 mt-3">
                        <label for="" style="font-weight:bold;">Next Amount</label>
                        <input type="text" class="form-control" name="seo_nextamount">
                      </div>
                      <div class="col-3 mt-3">
                        <label for="" style="font-weight:bold;">Lead Platform</label>
                        <select class="form-control select2"  required name="seo_leadplatform">
                            <option value="Google Ads">Google Ads</option>
                            <option value="Bark Lead">Bark Lead</option>
                            <option value="UpWork Lead">UpWork Lead</option>
                            <option value="Freelancer">Freelances</option>
                            <option value="Facebook">Facebook</option>
                            <option value="Thumbtack">Thumbtack</option>
                            <option value="Email Marketing">Email Marketing</option>
                        </select>
                      </div>
                      <div class="col-3 mt-3">
                        <label for="" style="font-weight:bold;">Production:</label>
                        <select class="form-control" id="select2forme" required name="production">

                        @foreach ($departments as $department)
                              <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                        </select>
                      </div>
                      <div class="col-9 mt-3">
                        <label for="" style="font-weight:bold;">Anymore commitment?</label>
                        <input type="text" class="form-control" name="seo_anycommitment">
                      </div>
                   </div>
                </div>

                <div class="col-12 mt-3">
                    <hr>

                     <div class="row" id="book">
                      <div class="col-12">
                        <h2>BOOK SERVICES KYC </h2>
                      </div>
                      <div class="col-3 mt-3">
                        <label for="" style="font-weight:bold;">Product</label>
                        <select class="form-control select2"  required name="TargetMarket[]" multiple="multiple">
                            <option value="Editing & Proofreading">Editing & Proofreading</option>
                            <option value="Ghost Writing">Ghost Writing</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Only Proofreading">Only Proofreading</option>

                        </select>
                      </div>
                      <div class="col-3 mt-3">
                        <label for="" style="font-weight:bold;">MenuScript Provided?</label>
                        <select class="form-control select2"  required name="menuscript">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                      </div>
                        <div class="col-3 mt-3">
                          <label for="" style="font-weight:bold;">Genre of the book?</label>
                          <input type="text" class="form-control" name="bookgenre">
                        </div>
                        <div class="col-3 mt-3">
                            <label for="" style="font-weight:bold;">Cover design included?</label>
                            <select class="form-control select2"  required name="coverdesign">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                          </div>
                        <div class="col-3 mt-3">
                          <label for="" style="font-weight:bold;">Total number of pages</label>
                          <input type="text" class="form-control" name="totalnumberofpages">
                        </div>
                        <div class="col-3 mt-3">
                            <label for="" style="font-weight:bold;">Publishing platforms offered?</label>
                            <input type="text" class="form-control" name="publishingplatform">
                          </div>
                          <div class="col-3 mt-3">
                            <label for="" style="font-weight:bold;">ISBN Offered or Bar Code?</label>
                            <select class="form-control select2"  required name="isbn_offered">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                          </div>
                          <div class="col-3 mt-3">
                            <label for="" style="font-weight:bold;">Lead Platform</label>
                            <select class="form-control select2"  required name="book_leadplatform">
                                <option value="Google Ads">Google Ads</option>
                                <option value="Bark Lead">Bark Lead</option>
                                <option value="UpWork Lead">UpWork Lead</option>
                                <option value="Freelancer">Freelances</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Thumbtack">Thumbtack</option>
                                <option value="Email Marketing">Email Marketing</option>

                            </select>
                          </div>
                          <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Charging Plan</label>
                            <select class="form-control select2"  required name="book_ChargingPlan">
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
                            <label for="" style="font-weight:bold;">Paid Amount</label>
                            <input type="text" class="form-control" name="book_paidamount">
                          </div>
                          <div class="col-4 mt-3">
                            <label for="" style="font-weight:bold;">Next Amount</label>
                            <input type="text" class="form-control" name="book_nextamount">
                          </div>
                          <div class="col-12 mt-3">
                            <label for="" style="font-weight:bold;">Anymore commitment?</label>
                            <input type="text" class="form-control" name="book_anycommitment">
                          </div>
                     </div>
                  </div>


                  <div class="col-12 mt-3">
                    <hr>

                     <div class="row" id="book">
                      <div class="col-12">
                        <h2>Website KYC </h2>
                      </div>
                      <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Package</label>
                        <select class="form-control select2"  required name="website_package[]" multiple="multiple">
                            <option value="Website Design Only">Website Design Only</option>
                            <option value="Website Development Only">Website Development Only</option>
                            <option value="Website Design & Development">Website Design & Development</option>
                            <option value="Website Revamp">Website Revamp</option>

                        </select>
                      </div>
                      <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Other Services</label>
                        <select class="form-control select2"  required name="website_other_services[]" multiple="multiple">
                            <option value="Logo">Logo</option>
                            <option value="Hosting">Hosting</option>
                            <option value="Content">Content</option>
                            <option value="SEO Marketing">SEO Marketing</option>
                            <option value="SMM Marketing">SMM Marketing</option>

                        </select>
                      </div>
                      <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Lead Platform</label>
                        <select class="form-control select2"  required name="website_leadplatform">
                            <option value="Google Ads">Google Ads</option>
                            <option value="Bark Lead">Bark Lead</option>
                            <option value="UpWork Lead">UpWork Lead</option>
                            <option value="Freelancer">Freelances</option>
                            <option value="Facebook">Facebook</option>
                            <option value="Thumbtack">Thumbtack</option>
                            <option value="Email Marketing">Email Marketing</option>

                        </select>
                      </div>
                      <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Charging Plan</label>
                        <select class="form-control select2"  required name="website_ChargingPlan">
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
                        <label for="" style="font-weight:bold;">Paid Amount</label>
                        <input type="text" class="form-control" name="website_paidamount">
                      </div>
                      <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Next Amount</label>
                        <input type="text" class="form-control" name="website_nextamount">
                      </div>
                          <div class="col-12 mt-3">
                            <label for="" style="font-weight:bold;">Other Service Details?</label>
                            <input type="text" class="form-control" name="website_anyotherservice">
                          </div>
                     </div>
                  </div>

                  <div class="col-12 mt-3">
                    <hr>

                     <div class="row" id="book">
                      <div class="col-12">
                        <h2>CLD KYC </h2>
                      </div>
                      <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Package</label>
                        <select class="form-control select2"  required name="cld_package[]" multiple="multiple">
                            <option value="Website Design Only">Website Design Only</option>
                            <option value="Website Development Only">Website Development Only</option>
                            <option value="Website Design & Development">Website Design & Development</option>
                            <option value="Website Revamp">Website Revamp</option>

                        </select>
                      </div>
                      <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Other Services</label>
                        <select class="form-control select2"  required name="cld_other_services[]" multiple="multiple">
                            <option value="Logo">Logo</option>
                            <option value="Hosting">Hosting</option>
                            <option value="Content">Content</option>
                            <option value="SEO Marketing">SEO Marketing</option>
                            <option value="SMM Marketing">SMM Marketing</option>

                        </select>
                      </div>
                      <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Lead Platform</label>
                        <select class="form-control select2"  required name="cld_leadplatform">
                            <option value="Google Ads">Google Ads</option>
                            <option value="Bark Lead">Bark Lead</option>
                            <option value="UpWork Lead">UpWork Lead</option>
                            <option value="Freelancer">Freelances</option>
                            <option value="Facebook">Facebook</option>
                            <option value="Thumbtack">Thumbtack</option>
                            <option value="Email Marketing">Email Marketing</option>

                        </select>
                      </div>
                      <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Charging Plan</label>
                        <select class="form-control select2"  required name="cld_ChargingPlan">
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
                        <label for="" style="font-weight:bold;">Paid Amount</label>
                        <input type="text" class="form-control" name="cld_paidamount">
                      </div>
                      <div class="col-4 mt-3">
                        <label for="" style="font-weight:bold;">Next Amount</label>
                        <input type="text" class="form-control" name="cld_nextamount">
                      </div>
                          <div class="col-12 mt-3">
                            <label for="" style="font-weight:bold;">Other Service Details?</label>
                            <input type="text" class="form-control" name="cld_anyotherservice">
                          </div>
                     </div>
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
