@extends('layouts.app')

@section('maincontent')

<!-- ########## START: MAIN PANEL ########## -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
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
        <h1 class="tx-normal tx-roboto tx-white">{{ $client[0]->name }}</h1>

      </div><!-- card-body -->
    </div><!-- card -->

    <div class="ht-70 bg-gray-100 pd-x-20 d-flex align-items-center justify-content-center bd-b bd-gray-400">
      <ul class="nav nav-outline active-primary align-items-center flex-row" role="tablist">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#projects" role="tab">Projects</a></li>
        <li class="nav-item hidden-xs-down"><a class="nav-link" data-toggle="tab" href="#payments" role="tab">Payments</a></li>
        <li><a href="/client/project/{{ $client[0]->id }}" style="color:grey;">Create Project</a></li>
      </ul>
    </div>

    <div class="tab-content br-profile-body" >
      <div class="tab-pane fade active show" id="projects">
        <div class="row" >
          <div class="col-lg-8"  >
            <div class="media-list bg-white rounded bd bd-gray-400">
                @if (count($projects) > 0)
                @foreach ($projects as $project)
                <div class="media pd-20 pd-xs-30" >
                    <img src="https://cdn-icons-png.flaticon.com/64/7792/7792148.png" alt="" class="wd-40 rounded-circle">
                    <div class="media-body mg-l-20">
                      <div class="d-flex justify-content-between mg-b-10" >
                        <div>
                          <h6 class="mg-b-2 tx-inverse tx-14">{{ $project->name }}</h6>
                          @if (isset($project->EmployeeName->name) and $project->EmployeeName->name !== null)
                          <span class="tx-12 tx-gray-500">{{ $project->EmployeeName->name }}</span><br>
                          @else
                          <span class="tx-12 tx-gray-500" style="color: red">User Deleted</span><br>
                          @endif
                          {{-- <span class="tx-12 tx-gray-500">{{ $project->EmployeeName->name }}</span><br> --}}
                          <span class="tx-12 tx-gray-500"><a href="{{ $project->basecampUrl }}">Basecamp,</a> <a href="/client/project/productions/users/{{$project->productionID }}">Production</a></span>
                        </div>
                        <span class="tx-12">{{ $project->created_at }}</span>
                      </div><!-- d-flex -->
                      <p class="mg-b-20">{{ $project->projectDescription }}</p>
                      <div class="media-footer">
                        <div class=" ">
                            <a href="/forms/payment/{{ $project->id }}" style="color:white;border-radius: 15px;" class="btn btn-sm   btn-success"><img src="https://cdn-icons-png.flaticon.com/16/1611/1611179.png" style="filter: invert(1); margin-right:10px" alt="" title="" class="img-small">Payment</a>
                            {{-- <a href="" class="btn btn-sm btn-primary" style="color:white;border-radius: 15px;"><img src="https://cdn-icons-png.flaticon.com/24/11524/11524412.png" style="filter: invert(1); margin-right:10px" alt="" title="" class="img-small"> Change PM </a> --}}
                            <a href="/client/editproject/{{ $project->id }}" class="btn btn-sm  btn-info" style="color:white;border-radius: 15px;"><img src="https://cdn-icons-png.flaticon.com/16/1159/1159633.png" style="filter: invert(1); margin-right:10px" alt="" title="" class="img-small"> Edit </a>
                            <a href="/forms/newqaform/{{  $project->id }}" class="btn btn-sm  btn-warning" style="color:white;border-radius: 15px;"><img src="https://cdn-icons-png.flaticon.com/16/4381/4381727.png" style="filter: invert(1); margin-right:10px" alt="" title="" class="img-small"> QA</a>
                            <a href="/client/project/qareport/{{  $project->id }}" class="btn btn-sm  btn-danger" style="color:white;border-radius: 15px;"><img src="https://cdn-icons-png.flaticon.com/16/3094/3094851.png" style="filter: invert(1); margin-right:10px" alt="" title="" class="img-small">QA Report</a>
                            {{-- <a href="/project/report/{{  $project->id }}" class="btn btn-sm  btn-success" style="color:white;border-radius: 15px;"><img src="https://cdn-icons-png.flaticon.com/24/3094/3094851.png" style="filter: invert(1); margin-right:10px" alt="" title="" class="img-small">Project Report</a> --}}
                            @if ($project->project_count == 0 && $project->payment_count == 0)
                            <a href="#" onclick="myConfirm('{{ $project->id }}')" class="btn btn-sm  btn-danger" style="color:white;border-radius: 15px;"><img src="https://cdn-icons-png.flaticon.com/16/1214/1214428.png" style="filter: invert(1); margin-right:10px" alt="" title="" class="img-small">Delete Project({{ $project->project_count }})</a>
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
                                        window.location.href = "/client/deleteproject/" + id;
                                        Swal.fire({
                                        title: "Deleted!",
                                        text: "Project has been deleted.",
                                        icon: "success"
                                        });
                                    }});

                                }
                            </script>
                            @endif
                        </div>
                      </div><!-- d-flex -->
                    </div><!-- media-body -->
                  </div><!-- media -->
                @endforeach
                @else
                  <p>No Project Created Yet ! <a href="/client/project/{{ $client[0]->id }}">Create From Here</a></p>
                @endif




            </div><!-- card -->


          </div><!-- col-lg-8 -->
          <div class="col-lg-4 mg-t-30 mg-lg-t-0">
            <div class="card pd-20 pd-xs-30 bd-gray-400">
              <h6 class="tx-gray-800 tx-uppercase tx-semibold tx-13 mg-b-25">Contact Information</h6>

              <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Brand</label>
              <p class="tx-info mg-b-25">{{ $client[0]->projectbrand->name }}</p>

              <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Phone Number</label>
              <p class="tx-info mg-b-25">{{ $client[0]->phone }}</p>

              <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Email Address</label>
              <p class="tx-inverse mg-b-25">{{ $client[0]->email }}</p>

              <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Client Initail Payment</label>
              <p class="tx-inverse mg-b-25">$ {{ $client[0]->clientMetas->amountPaid  }}</p>

              <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Client Remaining Amount</label>
              <p class="tx-inverse mg-b-25"  style="color: red">$ {{ $client[0]->clientMetas->remainingAmount }}</p>

              <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Next Payment Date:</label>
              <p class="tx-inverse mg-b-25"  > {{ $client[0]->clientMetas->nextPayment }}</p>


              <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Client Onboard</label>
              <p class="tx-inverse mg-b-25">{{ $client[0]->clientMetas->created_at     }}</p>


              <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Client Website Or Domain</label>
              <p class="tx-inverse mg-b-25">{{ $client[0]->website  }}</p>
                @if ($client[0]->clientMetas->service == "seo")
              <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">ORDER DETAILS</label>
              <p class="tx-inverse mg-b-25">
                @php
                  $data = json_decode($client[0]->clientMetas->orderDetails)->TARGET_MARKET;
                  $data2 = json_decode($client[0]->clientMetas->orderDetails)->OTHER_SERVICE;
                @endphp

                KEYWORD COUNT : {{ json_decode($client[0]->clientMetas->orderDetails)->KEYWORD_COUNT }}
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
                {{ json_decode($client[0]->clientMetas->orderDetails)->LEAD_PLATFORM }}
                <br><br>
                ANY COMMITMENT :
                {{ json_decode($client[0]->clientMetas->orderDetails)->ANY_COMMITMENT }}
                <br><br>
                Sale Person :
                {{ $client[0]->frontsale->name }}
                <br>
                @if (isset($qaAssignee[0]->Username->name))
                QA Assignee :
                {{ $qaAssignee[0]->Username->name }}
                @endif
              </p>
            </div><!-- card -->



            @elseif ($client[0]->clientMetas->service == "book")
            <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">ORDER DETAILS</label>
            <p class="tx-inverse mg-b-25">
              @php
                $data1 = json_decode($client[0]->clientMetas->orderDetails)->PRODUCT;
              @endphp
              BOOK GENRE : {{ json_decode($client[0]->clientMetas->orderDetails)->BOOK_GENRE }}
              <br>
              MENU SCRIPT : {{ json_decode($client[0]->clientMetas->orderDetails)->MENU_SCRIPT }}
              <br>
              COVER DESIGN : {{ json_decode($client[0]->clientMetas->orderDetails)->COVER_DESIGN }}
              <br>
              ISBN OFFERED : {{ json_decode($client[0]->clientMetas->orderDetails)->ISBN_OFFERED }}
              <br>
              TOTAL NUMBER OF PAGES : {{ json_decode($client[0]->clientMetas->orderDetails)->TOTAL_NUMBER_OF_PAGES }}
              <br>
              PUBLISHING PLATFORM : {{ json_decode($client[0]->clientMetas->orderDetails)->PUBLISHING_PLATFORM }}
              <br>
              ISBN OFFERED : {{ json_decode($client[0]->clientMetas->orderDetails)->ISBN_OFFERED }}
              <br>
              Product :
              @for($i=0;$i < count($data1);$i++ )
                    <strong>  {{ $data1[$i] }} - </strong>
              @endfor
              <br>
              LEAD PLATFORM :
              {{ json_decode($client[0]->clientMetas->orderDetails)->LEAD_PLATFORM }}
              <br><br>
              ANY COMMITMENT :
              {{ json_decode($client[0]->clientMetas->orderDetails)->ANY_COMMITMENT }}
              <br><br>
              Sale Person :
                {{ $client[0]->frontsale->name }}
                <br>
              @if (isset($qaAssignee[0]->Username->name))
              QA Assignee :
              {{ $qaAssignee[0]->Username->name }}
              @endif
            </p>
          </div><!-- card -->





          @elseif ($client[0]->clientMetas->service == "website")
            <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">ORDER DETAILS</label>
            <p class="tx-inverse mg-b-25">
              @php
                $data = json_decode($client[0]->clientMetas->orderDetails)->OTHER_SERVICES;
              @endphp
              OTHER SERVICE :
              @for($i=0;$i < count($data);$i++ )
                  <strong>  {{ $data[$i] }} - </strong>
              @endfor
              <br>
              LEAD PLATFORM :
              {{ json_decode($client[0]->clientMetas->orderDetails)->LEAD_PLATFORM }}
              <br><br>
              ANY COMMITMENT :
              {{ json_decode($client[0]->clientMetas->orderDetails)->ANY_COMMITMENT }}
              <br><br>
              Sale Person :
                {{ $client[0]->frontsale->name }}
                <br>
              @if (isset($qaAssignee[0]->Username->name))
              QA Assignee :
              {{ $qaAssignee[0]->Username->name }}
              @endif
            </p>
          </div><!-- card -->



          @else
            <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">ORDER DETAILS</label>
            <p class="tx-inverse mg-b-25">
              @php
                $data = json_decode($client[0]->clientMetas->orderDetails)->OTHER_SERVICES;
              @endphp
              OTHER SERVICE :
              @for($i=0;$i < count($data);$i++ )
                  <strong>  {{ $data[$i] }} - </strong>
              @endfor
              <br>
              LEAD PLATFORM :
              {{ json_decode($client[0]->clientMetas->orderDetails)->LEAD_PLATFORM }}
              <br><br>
              ANY COMMITMENT :
              {{ json_decode($client[0]->clientMetas->orderDetails)->ANY_COMMITMENT }}
              <br><br>
              Sale Person :
                {{ $client[0]->frontsale->name }}
                <br>
              @if (isset($qaAssignee[0]->Username->name))
              QA Assignee :
              {{ $qaAssignee[0]->Username->name }}
              @endif

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



      <div class="tab-pane fade" id="payments">

        <div class="br-section-wrapper">

        <table id="datatable1" class="table-dark table-hover">
            <thead>
              <tr role="row">
                <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="First name: activate to sort column descending">Project</th>
                <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Payment Nature</th>
                <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">Charging Plan</th>
                <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Start date: activate to sort column ascending">Payment_Gateway</th>
                <th class="wd-10p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Salary: activate to sort column ascending">Payment Date</th>
                <th class="wd-10p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Salary: activate to sort column ascending">Description</th>
                <th class="wd-10p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Salary: activate to sort column ascending">view</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($clientPayments as $item)
                <tr role="row" class="odd">
                    <td tabindex="0" class="sorting_1">{{$item->paymentprojectName->name}}</td>
                    <td>{{$item->paymentNature}}</td>
                    <td>{{$item->ChargingPlan}}</td>
                    <td>{{$item->Payment_Gateway}}</td>
                    <td>{{$item->paymentDate}}</td>
                    <td>{{$item->Description}}</td>
                    <td><a href="/client/project/payment/view/{{$item->id}}" class="btn btn-success">View</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
       </div><!-- br-section-wrapper -->








      </div><!-- tab-pane -->

















    </div><!-- br-pagebody -->

  </div><!-- br-mainpanel -->
  <!-- ########## END: MAIN PANEL ########## -->

@endsection
