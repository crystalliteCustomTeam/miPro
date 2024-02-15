@extends('layouts.app')

@section('maincontent')

<!-- ########## START: MAIN PANEL ########## -->
<div class="br-mainpanel br-profile-page">

    <div class="card widget-4 bd-0 rounded-0">
      <div class="card-header ht-75">
        <div class="hidden-xs-down">
        </div>
        <div class="tx-24 hidden-xs-down">
          <a href="" class="mg-r-10"><i class="icon ion-ios-email-outline"></i></a>
          <a href=""><i class="icon ion-more"></i></a>
        </div>
      </div><!-- card-header -->
      <div class="card-body">
        <div class="card-profile-img">
          <img src="https://cdn-icons-png.flaticon.com/512/3135/3135768.png" alt="">
        </div><!-- card-profile-img -->
        <a href="/client/details/{{$qa_data[0]->clientID }}"><h1 class="tx-normal tx-roboto tx-white">{{ $clients[0]->name }}</h1></a>

      </div><!-- card-body -->
    </div><!-- card -->

    <div class="ht-70 bg-gray-100 pd-x-20 d-flex align-items-center justify-content-center bd-b bd-gray-400">
      <ul class="nav nav-outline active-primary align-items-center flex-row" role="tablist">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#projects" role="tab">Projects</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#department" role="tab">Department</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#" role="tab">Favorites</a></li>
        <li class="nav-item hidden-xs-down"><a class="nav-link" data-toggle="tab" href="#" role="tab">Settings</a></li>
        <li><a href="/client/project/{{ $clients[0]->id }}" style="color:grey;">Create Project</a></li>
      </ul>
    </div>

    <div class="tab-content br-profile-body" >
      <div class="tab-pane fade active show" id="projects">
        <div class="row" >
          <div class="col-lg-8"  >
            <div class="media-list bg-white rounded bd bd-gray-400">
                <div class="media pd-20 pd-xs-30" >

                    <form action="/forms/editnewqaform/{{$qa_data[0]->id }}/process/" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                          <div class="col-12">
                            <h3 style="color:black" class="mb-5">Quality Assaurance Form:</h3>
                            <div class="btn-group">
                              <button class="btn btn-outline-primary">Project Name: {{$projects[0]->name }}</button>
                              <button class="btn btn-outline-primary">Project Manager: {{$projects[0]->EmployeeName->name }}</button>
                              <button class="btn btn-outline-primary">Brand: {{$projects[0]->ClientName->projectbrand->name }}</button>
                           </div>

                          </div>

                            <div class="col-6 mt-3" >
                              <label for="" style="font-weight:bold;">Last communication with client </label>
                              <input type="date" name="last_communication_with_client" value="{{$qa_data[0]->last_communication}}" class="form-control">
                            </div>

                            <div class="col-6 mt-3">
                                <label for="" style="font-weight:bold;">Medium of communication:</label>
                                <select class="form-control select2"  name="Medium_of_communication[]" multiple="multiple" value="selected">
                                    @php $mediums = json_decode($qa_data[0]->medium_of_communication) @endphp
                                    @foreach($mediums as $medium)
                                    <option value="{{ $medium }}" selected>{{ $medium }}</option>
                                    @endforeach
                                    <option value="">-----</option>
                                    <option value="Calls">Calls</option>
                                    <option value="Messages">Messages</option>
                                    <option value="Basecamp">Basecamp</option>
                                    <option value="Email">Email</option>
                                    <option value="Whatsapp">Whatsapp</option>
                                </select>
                              </div>
                              <div class="col-6 mt-3">
                                <label for="" style="font-weight:bold;">Select Production: </label>
                                <select class="form-control select2" required name="production_name" required>
                                    {{-- <option value="selected">{{$Proj_Prod[0]->DepartNameinProjectProduction->name}}</option>
                                    <option value="">-----</option> --}}
                                    @foreach($productions as $production)
                                    <option value="{{ $production->id }}"{{ $production->id == $Proj_Prod[0]->departmant ? 'selected' : '' }}>{{ $production->DepartNameinProjectProduction->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 mt-3">
                                <label for="" style="font-weight:bold;">Status:</label>
                                <select class="form-control select2" required name="status"   id="paymentType" >
                                    <option value="{{$qa_data[0]->status}}" selected>{{$qa_data[0]->status}}</option>
                                    <option value="Dispute">Dispute</option>
                                    <option value="Refund">Refund</option>
                                    <option value="On Going">On Going</option>
                                    <option value="Not Started Yet">Not Started Yet</option>
                                </select>
                            </div>

                            <div class="col-12 mt-3" id="issues">
                                <label for="" style="font-weight:bold;">Issues:</label>
                                <select class="form-control select2"  name="issues[]" multiple="multiple">
                                    @php $issues = json_decode($qa_meta[0]->issues) @endphp
                                    @foreach($issues as $issue)
                                    <option value="{{ $issue }}" selected>{{ $issue }}</option>
                                    @endforeach
                                    <option value="">-----</option>
                                    @foreach($allissues as $qaissue)
                                    <option value="{{ $qaissue->issues }}">{{ $qaissue->issues }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 mt-3" id="Description" >
                                <label for="" style="font-weight:bold;">Description of issue</label>
                                <textarea  name="Description_of_issue" class="form-control" id="" cols="30" rows="10">{{$qa_meta[0]->Description_of_issue}}</textarea>
                            </div>
                            <div class="col-12 mt-3" id="shareamount" >
                                <label for="" style="font-weight:bold;">Evidence(if any issue) </label>
                                <input type="file" name="Evidence" value="$qa_meta[0]->evidence" class="form-control">
                            </div>
                            {{-- ----------------Remarks------------------- --}}
                            <div class="col-6 mt-3" id="remark">
                                <label for="" style="font-weight:bold;">Client Satisfaction Level:</label>
                                <select class="form-control select2" name="client_satisfation" >
                                    <option value="{{$qa_data[0]->client_satisfaction}}" selected>{{$qa_data[0]->client_satisfaction}}</option>
                                    <option value="Extremely Satisfied">Extremely Satisfied</option>
                                    <option value="Somewhat Satisfied">Somewhat Satisfied</option>
                                    <option value="Neither Satisfied nor Dissatisfied">Neither Satisfied nor Dissatisfied</option>
                                    <option value="Not Started Yet">Not Started Yet</option>
                                    <option value="Somewhat Dissatisfied">Somewhat Dissatisfied</option>
                                    <option value="Extremely Dissatisfied">Extremely Dissatisfied</option>
                                </select>
                              </div>
                            <div class="col-6 mt-3" id="expected_refund">
                                <label for="" style="font-weight:bold;">Refund & Dispute Expected :</label>
                                <select class="form-control select2"  name="status_of_refund"  >
                                    <option value="{{$qa_data[0]->status_of_refund}}" selected>{{$qa_data[0]->status_of_refund}}</option>
                                    <option value="Going Good">Going Good</option>
                                    <option value="Low">Low</option>
                                    <option value="Moderate">Moderate</option>
                                    <option value="Not Started Yet">Not Started Yet</option>
                                    <option value="High">High</option>
                                </select>
                              </div>
                              <div class="col-6 mt-3" id="refund_request">
                                <label for="" style="font-weight:bold;">Refund Requested: </label>
                                <select class="form-control select2"  name="Refund_Requested" >
                                    <option value="{{$qa_data[0]->Refund_Requested}}" selected>{{$qa_data[0]->Refund_Requested}}</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                              </div>
                            <div class="col-6 mt-3" id="ref_req_attachment">
                              <label for="" style="font-weight:bold;">Refund Request Attachment </label>
                              <input type="file" name="Refund_Request_Attachment"  class="form-control">
                            </div>
                            <div class="col-12 mt-3" id="summery">
                                <label for="" style="font-weight:bold;">Summery </label>
                                <textarea  name="Refund_Request_summery"  class="form-control" id="" cols="30" rows="10">{{$qa_data[0]->Refund_Request_summery}}</textarea>
                            </div>
                            <div class="col-12">
                                <input type="submit" value="Update" class=" mt-3 btn btn-success">
                            </div>
                        </div>
                       </form>



                </div><!-- media -->




            </div><!-- card -->


          </div><!-- col-lg-8 -->
          <div class="col-lg-4 mg-t-30 mg-lg-t-0">
            <div class="card pd-20 pd-xs-30 bd-gray-400">
              <h6 class="tx-gray-800 tx-uppercase tx-semibold tx-13 mg-b-25">Contact Information</h6>

              <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Phone Number</label>
              <p class="tx-info mg-b-25">{{ $clients[0]->phone }}</p>

              <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Email Address</label>
              <p class="tx-inverse mg-b-25">{{ $clients[0]->email }}</p>

              <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Client Initail Payment</label>
              <p class="tx-inverse mg-b-25">$ {{ $clients[0]->clientMetas->amountPaid   }}</p>

              <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Client Remaining Amount</label>
              <p class="tx-inverse mg-b-25" style="color: red">$ {{  $clients[0]->clientMetas->remainingAmount }}</p>

              <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Next Payment Date:</label>
              <p class="tx-inverse mg-b-25"> {{ $clients[0]->clientMetas->nextPayment }}</p>


              <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Client Onboard</label>
              <p class="tx-inverse mg-b-25">{{ $clients[0]->clientMetas->created_at     }}</p>


              <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Client Website Or Domain</label>
              <p class="tx-inverse mg-b-25">{{ $clients[0]->website  }}</p>
                @if ($clients[0]->clientMetas->service == "seo")
              <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">ORDER DETAILS</label>
              <p class="tx-inverse mg-b-25">
                @php
                  $data = json_decode($clients[0]->clientMetas->orderDetails)->TARGET_MARKET;
                  $data2 = json_decode($clients[0]->clientMetas->orderDetails)->OTHER_SERVICE;
                @endphp

                KEYWORD COUNT : {{ json_decode($clients[0]->clientMetas->orderDetails)->KEYWORD_COUNT }}
                <br>
                TARGET MARKET :
                @for($i=0;$i < count($data);$i++ )
                      {{ $data[$i] }}
                @endfor
                <br>
                OTHER SERVICE :
                @for($i=0;$i < count($data2);$i++ )
                    <strong>  {{ $data2[$i] }} - </strong>
                @endfor
                <br>
                LEAD PLATFORM :
                {{ json_decode($clients[0]->clientMetas->orderDetails)->LEAD_PLATFORM }}
                <br><br>
                ANY COMMITMENT :
                {{ json_decode($clients[0]->clientMetas->orderDetails)->ANY_COMMITMENT }}
              </p>
            </div><!-- card -->



            @elseif ($clients[0]->clientMetas->service == "book")
            <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">ORDER DETAILS</label>
            <p class="tx-inverse mg-b-25">
              @php
                $data1 = json_decode($clients[0]->clientMetas->orderDetails)->PRODUCT;
              @endphp
              BOOK GENRE : {{ json_decode($clients[0]->clientMetas->orderDetails)->BOOK_GENRE }}
              <br>
              MENU SCRIPT : {{ json_decode($clients[0]->clientMetas->orderDetails)->MENU_SCRIPT }}
              <br>
              COVER DESIGN : {{ json_decode($clients[0]->clientMetas->orderDetails)->COVER_DESIGN }}
              <br>
              ISBN OFFERED : {{ json_decode($clients[0]->clientMetas->orderDetails)->ISBN_OFFERED }}
              <br>
              TOTAL NUMBER OF PAGES : {{ json_decode($clients[0]->clientMetas->orderDetails)->TOTAL_NUMBER_OF_PAGES }}
              <br>
              PUBLISHING PLATFORM : {{ json_decode($clients[0]->clientMetas->orderDetails)->PUBLISHING_PLATFORM }}
              <br>
              ISBN OFFERED : {{ json_decode($clients[0]->clientMetas->orderDetails)->ISBN_OFFERED }}
              <br>
              Product :
              @for($i=0;$i < count($data1);$i++ )
                    <strong>  {{ $data1[$i] }} - </strong>
              @endfor
              <br>
              LEAD PLATFORM :
              {{ json_decode($clients[0]->clientMetas->orderDetails)->LEAD_PLATFORM }}
              <br><br>
              ANY COMMITMENT :
              {{ json_decode($clients[0]->clientMetas->orderDetails)->ANY_COMMITMENT }}
            </p>
          </div><!-- card -->





          @elseif ($clients[0]->clientMetas->service == "website")
            <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">ORDER DETAILS</label>
            <p class="tx-inverse mg-b-25">
              @php
                $data = json_decode($clients[0]->clientMetas->orderDetails)->OTHER_SERVICES;
              @endphp
              OTHER SERVICE :
              @for($i=0;$i < count($data);$i++ )
                  <strong>  {{ $data[$i] }} - </strong>
              @endfor
              <br>
              LEAD PLATFORM :
              {{ json_decode($clients[0]->clientMetas->orderDetails)->LEAD_PLATFORM }}
              <br><br>
              ANY COMMITMENT :
              {{ json_decode($clients[0]->clientMetas->orderDetails)->ANY_COMMITMENT }}
            </p>
          </div><!-- card -->



          @else
            <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">ORDER DETAILS</label>
            <p class="tx-inverse mg-b-25">
              @php
                $data = json_decode($clients[0]->clientMetas->orderDetails)->OTHER_SERVICES;
              @endphp
              OTHER SERVICE :
              @for($i=0;$i < count($data);$i++ )
                  <strong>  {{ $data[$i] }} - </strong>
              @endfor
              <br>
              LEAD PLATFORM :
              {{ json_decode($clients[0]->clientMetas->orderDetails)->LEAD_PLATFORM }}
              <br><br>
              ANY COMMITMENT :
              {{ json_decode($clients[0]->clientMetas->orderDetails)->ANY_COMMITMENT }}
            </p>
          </div><!-- card -->
          @endif





























            <div class="card pd-20 pd-xs-30 bd-gray-400 mg-t-30">
              <h6 class="tx-gray-800 tx-uppercase tx-semibold tx-13 mg-b-30">Recent Clients</h6>
              <div class="media-list">
                @foreach ($recentClients as $recentClient)
                    <div class="media align-items-center pd-b-10">
                        <img src="https://via.placeholder.com/500" class="wd-45 rounded-circle" alt="">
                        <div class="media-body mg-x-15 mg-xs-x-20">
                        <h6 class="mg-b-2 tx-inverse tx-14">{{$recentClient->name}}</h6>
                        <p class="mg-b-0 tx-12">{{$recentClient->findbrand($recentClient->brand)[0]->name}}</p>
                        </div><!-- media-body -->
                        <a href="{{ url('/client/details/'.$recentClient->id) }}" class="btn btn-outline-secondary btn-icon rounded-circle mg-r-5">
                        <div><img src="https://cdn-icons-png.flaticon.com/16/3113/3113022.png" alt=""></div>
                        </a>
                  </div><!-- media -->
                @endforeach

              </div><!-- media-list -->
            </div><!-- card -->
          </div><!-- col-lg-4 -->
        </div><!-- row -->
      </div><!-- tab-pane -->
      <div class="tab-pane fade" id="department">
        <div class="row">
          <div class="col-lg-8">
            <div class="card pd-20 pd-xs-30 bd-gray-400 mg-t-30">
              <h6 class="tx-gray-800 tx-uppercase tx-semibold tx-14 mg-b-30">Recent Photos</h6>

              <div class="row row-xs">
                <div class="col-6 col-sm-4 col-md-3"><img src="https://via.placeholder.com/800" class="img-fluid" alt=""></div>
                <div class="col-6 col-sm-4 col-md-3"><img src="https://via.placeholder.com/300" class="img-fluid" alt=""></div>
                <div class="col-6 col-sm-4 col-md-3 mg-t-10 mg-sm-t-0"><img src="https://via.placeholder.com/600x600" class="img-fluid" alt=""></div>
                <div class="col-6 col-sm-4 col-md-3 mg-t-10 mg-md-t-0"><img src="https://via.placeholder.com/600x600" class="img-fluid" alt=""></div>
                <div class="col-6 col-sm-4 col-md-3 mg-t-10"><img src="https://via.placeholder.com/800" class="img-fluid" alt=""></div>
                <div class="col-6 col-sm-4 col-md-3 mg-t-10"><img src="https://via.placeholder.com/800" class="img-fluid" alt=""></div>
                <div class="col-6 col-sm-4 col-md-3 mg-t-10"><img src="https://via.placeholder.com/800" class="img-fluid" alt=""></div>
                <div class="col-6 col-sm-4 col-md-3 mg-t-10"><img src="https://via.placeholder.com/500" class="img-fluid" alt=""></div>
                <div class="col-6 col-sm-4 col-md-3 mg-t-10"><img src="http://via.placeholder.com/300x300" class="img-fluid" alt=""></div>
                <div class="col-6 col-sm-4 col-md-3 mg-t-10"><img src="http://via.placeholder.com/300x300" class="img-fluid" alt=""></div>
                <div class="col-6 col-sm-4 col-md-3 mg-t-10"><img src="http://via.placeholder.com/300x300" class="img-fluid" alt=""></div>
                <div class="col-6 col-sm-4 col-md-3 mg-t-10"><img src="http://via.placeholder.com/300x300" class="img-fluid" alt=""></div>
              </div><!-- row -->

              <p class="mg-t-20 mg-b-0">Loading more photos...</p>

            </div><!-- card -->
          </div><!-- col-lg-8 -->
          <div class="col-lg-4 mg-t-30 mg-lg-t-0">
            <div class="card pd-20 pd-xs-30 bd-gray-400 mg-t-30">
              <h6 class="tx-gray-800 tx-uppercase tx-semibold tx-14 mg-b-30">Photo Albums</h6>
              <div class="row row-xs mg-b-15">
                <div class="col"><img src="https://via.placeholder.com/800" class="img-fluid" alt=""></div>
                <div class="col"><img src="https://via.placeholder.com/800" class="img-fluid" alt=""></div>
                <div class="col">
                  <div class="overlay">
                    <img src="https://via.placeholder.com/800" class="img-fluid" alt="">
                    <div class="overlay-body bg-black-5 d-flex align-items-center justify-content-center">
                      <span class="tx-white tx-12">20+ more</span>
                    </div><!-- overlay-body -->
                  </div><!-- overlay -->
                </div>
              </div><!-- row -->
              <div class="d-flex alig-items-center justify-content-between">
                <h6 class="tx-inverse tx-14 mg-b-0">Profile Photos</h6>
                <span class="tx-12">24 Photos</span>
              </div><!-- d-flex -->

              <hr>

              <div class="row row-xs mg-b-15">
                <div class="col"><img src="https://via.placeholder.com/600x600" class="img-fluid" alt=""></div>
                <div class="col"><img src="https://via.placeholder.com/600x600" class="img-fluid" alt=""></div>
                <div class="col">
                  <div class="overlay">
                    <img src="https://via.placeholder.com/600x600" class="img-fluid" alt="">
                    <div class="overlay-body bg-black-5 d-flex align-items-center justify-content-center">
                      <span class="tx-white tx-12">20+ more</span>
                    </div><!-- overlay-body -->
                  </div><!-- overlay -->
                </div>
              </div><!-- row -->
              <div class="d-flex alig-items-center justify-content-between">
                <h6 class="tx-inverse tx-14 mg-b-0">Mobile Uploads</h6>
                <span class="tx-12">24 Photos</span>
              </div><!-- d-flex -->

              <hr>

              <div class="row row-xs mg-b-15">
                <div class="col"><img src="http://via.placeholder.com/300x300/0866C6/FFF" class="img-fluid" alt=""></div>
                <div class="col"><img src="http://via.placeholder.com/300x300/DC3545/FFF" class="img-fluid" alt=""></div>
                <div class="col">
                  <div class="overlay">
                    <img src="http://via.placeholder.com/300x300/0866C6/FFF" class="img-fluid" alt="">
                    <div class="overlay-body bg-black-5 d-flex align-items-center justify-content-center">
                      <span class="tx-white tx-12">20+ more</span>
                    </div><!-- overlay-body -->
                  </div><!-- overlay -->
                </div>
              </div><!-- row -->
              <div class="d-flex alig-items-center justify-content-between">
                <h6 class="tx-inverse tx-14 mg-b-0">Mobile Uploads</h6>
                <span class="tx-12">24 Photos</span>
              </div><!-- d-flex -->

              <a href="" class="d-block mg-t-20"><i class="fa fa-angle-down mg-r-5"></i> Show 8 more albums</a>
            </div><!-- card -->
          </div><!-- col-lg-4 -->
        </div><!-- row -->
      </div><!-- tab-pane -->
    </div><!-- br-pagebody -->

  </div><!-- br-mainpanel -->
  <!-- ########## END: MAIN PANEL ########## -->

@endsection
