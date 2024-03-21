@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
        <div class="br-mainpanel">
            <div class="br-pagetitle">
              <i class="icon ion-ios-home-outline tx-70 lh-0"></i>
              <div>
                <h4>Dashboard</h4>
                <p class="mg-b-0">Do bigger things with Crystal Pro.</p>
              </div>
            </div><!-- d-flex -->

            <div class="br-pagebody">
                <!-- hidden on purpose using d-none class to have a different look with the original -->
                <!-- feel free to unhide by removing the d-none class below -->
@if ($superUser == 0)
                <div class="row row-sm mg-b-20 d-none">
                    <div class="col-sm-6 col-xl-3">
                        <div class="bg-info rounded overflow-hidden">
                            <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                            <i class="ion ion-earth tx-60 lh-0 tx-white op-7"></i>
                            <div class="mg-l-20">
                                <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Today's Visits</p>
                                <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">1,975,224</p>
                                <span class="tx-11 tx-roboto tx-white-8">24% higher yesterday</span>
                            </div>
                            </div>
                            <div id="ch1" class="ht-50 tr-y-1"></div>
                        </div>
                    </div><!-- col-3 -->
                    <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
                    <div class="bg-purple rounded overflow-hidden">
                        <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-bag tx-60 lh-0 tx-white op-7"></i>
                        <div class="mg-l-20">
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Today Sales</p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">$329,291</p>
                            <span class="tx-11 tx-roboto tx-white-8">$390,212 before tax</span>
                        </div>
                        </div>
                        <div id="ch3" class="ht-50 tr-y-1"></div>
                    </div>
                    </div><!-- col-3 -->
                    <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                    <div class="bg-teal rounded overflow-hidden">
                        <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-monitor tx-60 lh-0 tx-white op-7"></i>
                        <div class="mg-l-20">
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">% Unique Visits</p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">54.45%</p>
                            <span class="tx-11 tx-roboto tx-white-8">23% average duration</span>
                        </div>
                        </div>
                        <div id="ch2" class="ht-50 tr-y-1"></div>
                    </div>
                    </div><!-- col-3 -->
                    <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                    <div class="bg-primary rounded overflow-hidden">
                        <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                        <i class="ion ion-clock tx-60 lh-0 tx-white op-7"></i>
                        <div class="mg-l-20">
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Bounce Rate</p>
                            <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">32.16%</p>
                            <span class="tx-11 tx-roboto tx-white-8">65.45% on average time</span>
                        </div>
                        </div>
                        <div id="ch4" class="ht-50 tr-y-1"></div>
                    </div>
                    </div><!-- col-3 -->
                </div><!-- row -->

                <div class="row row-sm">
                    @foreach ($eachPersonqaform as $item)

                    <div class="col-3 mg-b-15">
                        <div class="card bd-gray-400 pd-20">
                            <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15"><a href="/userprofile/{{$item[0][0]->id}}">{{$item[0][0]->name}}</a></h6>
                            <div class="d-flex mg-b-10">
                            <div class="bd-r pd-r-10">
                                <label class="tx-12">Total Client</label>
                                <p class="tx-lato tx-inverse tx-bold">{{$item[1]}}</p>
                            </div>
                            <div class="bd-r pd-x-10">
                                <label class="tx-12">Today Forms</label>
                                <p class="tx-lato tx-inverse tx-bold">{{$item[2]}}</p>
                            </div>
                            <div class="bd-r pd-x-10">
                                <label class="tx-12">Month Refund</label>
                                <p class="tx-lato tx-inverse tx-bold">{{$item[3]}}</p>
                            </div>
                            <div class="pd-l-10">
                                <label class="tx-12">Month Dispute</label>
                                <p class="tx-lato tx-inverse tx-bold">{{$item[4]}}</p>
                            </div>
                        </div><!-- d-flex -->
                        <div class="progress mg-b-10">
                            <div class="progress-bar bg-info wd-100p" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div><!-- card -->
                        </div><!-- col-4 -->

                    @endforeach



                </div><!-- row -->

                <div class="row row-sm mg-t-20">
                    <div class="col-4">
                    <div class="card bd-gray-400 pd-20">
                        <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15">Brand 1</h6>
                        <div class="d-flex mg-b-10">
                        <div class="bd-r pd-r-10">
                            <label class="tx-12">Clients</label>
                            <p class="tx-lato tx-inverse tx-bold">0</p>
                        </div>
                        <div class="bd-r pd-x-10">
                            <label class="tx-12">Refund</label>
                            <p class="tx-lato tx-inverse tx-bold">0</p>
                        </div>
                        <div class="pd-l-10">
                            <label class="tx-12">Dispute</label>
                            <p class="tx-lato tx-inverse tx-bold">0</p>
                        </div>
                        </div><!-- d-flex -->
                        <div class="progress mg-b-10">
                            <div class="progress-bar bg-purple wd-70p" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">70%</div>
                        </div>
                        <p class="tx-12 mg-b-0">Maecenas tempus, tellus eget condimentum rhoncus</p>
                    </div><!-- card -->
                    </div><!-- col-4 -->
                    <div class="col-4">
                    <div class="card bd-gray-400 pd-20">
                        <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15">Brand 2</h6>
                        <div class="d-flex mg-b-10">
                        <div class="bd-r pd-r-10">
                            <label class="tx-12">Clients</label>
                            <p class="tx-lato tx-inverse tx-bold">0</p>
                        </div>
                        <div class="bd-r pd-x-10">
                            <label class="tx-12">Refund</label>
                            <p class="tx-lato tx-inverse tx-bold">0</p>
                        </div>
                        <div class="pd-l-10">
                            <label class="tx-12">Dispute</label>
                            <p class="tx-lato tx-inverse tx-bold">0</p>
                        </div>
                        </div><!-- d-flex -->
                        <div class="progress mg-b-10">
                        <div class="progress-bar bg-purple wd-70p" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">70%</div>
                        </div>
                        <p class="tx-12 mg-b-0">Maecenas tempus, tellus eget condimentum rhoncus</p>
                    </div><!-- card -->
                    </div><!-- col-4 -->
                    <div class="col-4">
                    <div class="card bd-gray-400 pd-20">
                        <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15">Brand 2</h6>
                        <div class="d-flex mg-b-10">
                        <div class="bd-r pd-r-10">
                            <label class="tx-12">Clients</label>
                            <p class="tx-lato tx-inverse tx-bold">0</p>
                        </div>
                        <div class="bd-r pd-x-10">
                            <label class="tx-12">Refund</label>
                            <p class="tx-lato tx-inverse tx-bold">0</p>
                        </div>
                        <div class="pd-l-10">
                            <label class="tx-12">Dispute</label>
                            <p class="tx-lato tx-inverse tx-bold">0</p>
                        </div>
                        </div><!-- d-flex -->
                        <div class="progress mg-b-10">
                        <div class="progress-bar bg-success wd-35p" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100">35%</div>
                        </div>
                        <p class="tx-12 mg-b-0">Maecenas tempus, tellus eget condimentum rhoncus</p>
                    </div><!-- card -->
                    </div><!-- col-4 -->
                </div><!-- row -->

                <div class="row row-sm mg-t-20">
                    <div class="col-lg-8">

                        <div class="row">

                            <div class="col-6">
                                @if ($last5qaformstatus > 0)
                                <div class="card bd-0 mg-t-20">
                                    <div id="carousel12" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#carousel12" data-slide-to="0" class="active"></li>
                                        <li data-target="#carousel12" data-slide-to="1"></li>
                                        <li data-target="#carousel12" data-slide-to="2"></li>
                                    </ol>
                                    <div class="carousel-inner" role="listbox">

                                        @foreach ($last5qaform as $item)

                                        @if ($item == $last5qaform[0])

                                        <div class="carousel-item active">
                                            <div class="bg-br-primary pd-30 ht-300 pos-relative d-flex align-items-center rounded">
                                                <div class="tx-white">
                                                <p class="tx-uppercase tx-11 tx-semibold tx-mont tx-spacing-2 tx-white-5">Client: <a href="/client/details/{{$item->clientID}}">{{$item->Client_Name->name}}</a></p>
                                                <p class="lh-5 mg-b-20">{{$last5qaform[0]->Refund_Request_summery}}</p>
                                                <nav class="nav flex-row tx-13">
                                                    <a href="" class="tx-white-8 hover-white pd-l-0 pd-r-5">Brand: {{$item->Brand_Name->name}}</a>
                                                    <a href="" class="tx-white-8 hover-white pd-l-0 pd-r-5">Project: {{$item->Project_Name->name}}</a>
                                                    <a href="/userprofile/{{$item->projectmanagerID}}" class="tx-white-8 hover-white pd-x-5">PM: {{$item->Project_ProjectManager->name}}</a>
                                                    <a href="/userprofile/{{$item->qaPerson}}" class="tx-white-8 hover-white pd-x-5">QA: {{$item->QA_Person->name}}</a>
                                                    <a href="/client/project/qareport/view/{{$item->id}}" class="tx-white-8 hover-white pd-x-5">View</a>
                                                </nav>
                                                </div>
                                            </div><!-- d-flex -->
                                        </div>

                                        @else

                                        <div class="carousel-item">
                                            <div class="bg-info pd-30 ht-300 pos-relative d-flex align-items-center rounded">
                                            <div class="tx-white">
                                                <p class="tx-uppercase tx-11 tx-semibold tx-mont tx-spacing-2 tx-white-5">Client: <a href="/client/details/{{$item->clientID}}">{{$item->Client_Name->name}}</a></p>
                                                <p class="lh-5 mg-b-20">{{$item->Refund_Request_summery}}</p>
                                                <nav class="nav flex-row tx-13">
                                                    <a href="" class="tx-white-8 hover-white pd-l-0 pd-r-5">Brand: {{$item->Brand_Name->name}}</a>
                                                    <a href="" class="tx-white-8 hover-white pd-l-0 pd-r-5">Project: {{$item->Project_Name->name}}</a>
                                                    <a href="/userprofile/{{$item->projectmanagerID}}" class="tx-white-8 hover-white pd-x-5">PM: {{$item->Project_ProjectManager->name}}</a>
                                                    <a href="/userprofile/{{$item->qaPerson}}" class="tx-white-8 hover-white pd-x-5">QA: {{$item->QA_Person->name}}</a>
                                                    <a href="/client/project/qareport/view/{{$item->id}}" class="tx-white-8 hover-white pd-x-5">View</a>
                                                </nav>
                                            </div>
                                            </div><!-- d-flex -->
                                        </div>

                                        @endif



                                        @endforeach


                                    </div><!-- carousel-inner -->
                                    </div><!-- carousel -->
                                </div><!-- card -->

                                @else
                                <div class="card bd-0 mg-t-20">
                                    <div id="carousel12" class="carousel slide" data-ride="carousel">

                                    <div class="carousel-inner" role="listbox">

                                        <div class="carousel-item active">
                                            <div class="bg-white pd-30 ht-300 pos-relative d-flex align-items-center rounded">
                                                <div class="tx-black">
                                                <p class="lh-5 mg-b-20">No Client on Refund</p>
                                                </div>
                                            </div><!-- d-flex -->
                                        </div>


                                    </div><!-- carousel-inner -->
                                    </div><!-- carousel -->
                                </div><!-- card -->

                                @endif



                            </div>

                            <div class="col-6">
                                <div class="card bd-gray-400 mg-t-20">
                                    <div id="carousel3" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#carousel3" data-slide-to="0" class="active"></li>
                                        <li data-target="#carousel3" data-slide-to="1"></li>
                                    </ol>
                                    <div class="carousel-inner" role="listbox">
                                        <div class="carousel-item active">
                                        <div class="bg-white ht-300 pos-relative overflow-hidden d-flex flex-column align-items-start rounded">
                                            <div class="pos-absolute t-15 r-25">
                                            <a href="" class="tx-gray-500 hover-info mg-l-7"><i class="icon ion-more tx-20"></i></a>
                                            </div>
                                            <div class="pd-x-30 pd-t-30 mg-b-auto">
                                            <p class="tx-info tx-uppercase tx-11 tx-semibold tx-mont mg-b-5">Brand #1</p>
                                            <h5 class="tx-inverse mg-b-20">Expected:</h5>
                                            <div class="row">
                                                <div class="col-6">
                                                    <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Refund</p>
                                                    <h2 class="tx-inverse tx-lato tx-bold mg-b-0">36</h2>
                                                </div>
                                                <div class="col-6">
                                                    <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Upsell</p>
                                                    <h2 class="tx-inverse tx-lato tx-bold mg-b-0">23</h2>
                                                </div>
                                                <div class="col-6">
                                                    <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Renewal</p>
                                                    <h2 class="tx-inverse tx-lato tx-bold mg-b-0">26</h2>
                                                </div>
                                                <div class="col-6">
                                                    <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Recurring</p>
                                                    <h2 class="tx-inverse tx-lato tx-bold mg-b-0">66</h2>
                                                </div>

                                                </div>
                                            </div>
                                            <div id="ch10" class="ht-100 tr-y-1"></div>
                                        </div><!-- d-flex -->
                                        </div>
                                        <div class="carousel-item">
                                        <div class="bg-white ht-300 pos-relative overflow-hidden d-flex flex-column align-items-start rounded">
                                            <div class="pos-absolute t-15 r-25">
                                            <a href="" class="tx-gray-500 hover-info mg-l-7"><i class="icon ion-more tx-20"></i></a>
                                            </div>
                                            <div class="pd-x-30 pd-t-30 mg-b-auto">
                                            <p class="tx-info tx-uppercase tx-11 tx-semibold tx-mont mg-b-5">Brand #2</p>
                                            <h5 class="tx-inverse mg-b-20">Expected:</h5>
                                            <div class="row">
                                            <div class="col-6">
                                                <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Refund</p>
                                                <h2 class="tx-inverse tx-lato tx-bold mg-b-0">36</h2>
                                            </div>
                                            <div class="col-6">
                                                <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Upsell</p>
                                                <h2 class="tx-inverse tx-lato tx-bold mg-b-0">23</h2>
                                            </div>
                                            <div class="col-6">
                                                <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Renewal</p>
                                                <h2 class="tx-inverse tx-lato tx-bold mg-b-0">26</h2>
                                            </div>
                                            <div class="col-6">
                                                <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Recurring</p>
                                                <h2 class="tx-inverse tx-lato tx-bold mg-b-0">66</h2>
                                            </div>

                                            </div>

                                            </div>
                                            <div id="ch11" class="ht-100 tr-y-1"></div>
                                        </div><!-- d-flex -->
                                        </div><!-- cardousel-item -->
                                    </div><!-- carousel-inner -->
                                    </div><!-- carousel -->
                                </div><!-- card -->

                            </div>

                        </div>

                        <div class="card bd-gray-400 pd-25 mg-t-20">

                            <div class="row row-xs mg-t-15">
                                <div class="col-sm-4">
                                    <div class="tx-center pd-y-15 bd">
                                        <p class="mg-b-5 tx-uppercase tx-10 tx-mont tx-semibold">Total Clients</p>
                                        <h4 class="tx-lato tx-inverse tx-bold mg-b-0">{{$totalClient}}</h4>
                                    </div>
                                </div><!-- col-4 -->
                                <div class="col-sm-4 mg-t-20 mg-sm-t-0">
                                    <div class="tx-center pd-y-15 bd">
                                        <p class="mg-b-5 tx-uppercase tx-10 tx-mont tx-semibold">Total Refund</p>
                                        <h4 class="tx-lato tx-inverse tx-bold mg-b-0">{{$totalrefund}}</h4>
                                    </div>
                                </div><!-- col-4 -->
                                <div class="col-sm-4 mg-t-20 mg-sm-t-0">
                                    <div class="tx-center pd-y-15 bd">
                                        <p class="mg-b-5 tx-uppercase tx-10 tx-mont tx-semibold">Total Dispute</p>
                                        <h4 class="tx-lato tx-inverse tx-bold mg-b-0">{{$totaldispute}}</h4>
                                    </div>
                                </div><!-- col-4 -->
                            </div><!-- row -->

                        </div><!-- card -->





                    </div><!-- col-8 -->
                    <div class="col-lg-4 mg-t-20 mg-lg-t-0">

                    <div class="card bd-gray-400 overflow-hidden">
                        <div class="pd-x-25 pd-t-25">
                        <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1 mg-b-20">Upcoming Recurring Payments</h6>
                        <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0">As of Today</p>
                        <h1 class="tx-56 tx-light tx-inverse mg-b-0">755<span class="tx-teal tx-24">gb</span></h1>
                        <p><span class="tx-primary">80%</span> of free space remaining</p>
                        </div><!-- pd-x-25 -->
                        <div id="ch6" class="ht-115 mg-r--1"></div>
                        <div class="bg-teal pd-x-25 pd-b-25 d-flex justify-content-between">
                        <div class="tx-center">
                            <h3 class="tx-lato tx-white mg-b-5">989<span class="tx-light op-8 tx-20">gb</span></h3>
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0 tx-white-8">Total Space</p>
                        </div>
                        <div class="tx-center">
                            <h3 class="tx-lato tx-white mg-b-5">234<span class="tx-light op-8 tx-20">gb</span></h3>
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0 tx-white-8">Used Space</p>
                        </div>
                        <div class="tx-center">
                            <h3 class="tx-lato tx-white mg-b-5">80<span class="tx-light op-8 tx-20">%</span></h3>
                            <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0 tx-white-8">Free Space</p>
                        </div>
                        </div>
                    </div><!-- card -->


                    <div class="card card-body bd-0 pd-25 bg-primary mg-t-20">
                        <div class="d-xs-flex justify-content-between align-items-center tx-white mg-b-20">
                        <h6 class="tx-13 tx-uppercase tx-semibold tx-spacing-1 mg-b-0">Server Status</h6>
                        <span class="tx-12 tx-uppercase">Oct 2017</span>
                        </div>
                        <p class="tx-sm tx-white tx-medium mg-b-0">Hardware Monitoring</p>
                        <p class="tx-12 tx-white-7">Intel Dothraki G125H 2.5GHz</p>
                        <div class="progress bg-white-3 rounded-0 mg-b-0">
                        <div class="progress-bar bg-success wd-50p lh-3" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                        </div><!-- progress -->
                        <p class="tx-11 mg-b-0 mg-t-15 tx-white-7">Notice: Lorem ipsum dolor sit amet.</p>
                    </div><!-- card -->





                    </div><!-- col-4 -->
                </div><!-- row -->



@elseif($superUser == 1)
              <div class="row row-sm mg-b-20 d-none">
                <div class="col-sm-6 col-xl-3">
                  <div class="bg-info rounded overflow-hidden">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                      <i class="ion ion-earth tx-60 lh-0 tx-white op-7"></i>
                      <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Today's Visits</p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">1,975,224</p>
                        <span class="tx-11 tx-roboto tx-white-8">24% higher yesterday</span>
                      </div>
                    </div>
                    <div id="ch1" class="ht-50 tr-y-1"></div>
                  </div>
                </div><!-- col-3 -->
                <div class="col-sm-6 col-xl-3 mg-t-20 mg-sm-t-0">
                  <div class="bg-purple rounded overflow-hidden">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                      <i class="ion ion-bag tx-60 lh-0 tx-white op-7"></i>
                      <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Today Sales</p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">$329,291</p>
                        <span class="tx-11 tx-roboto tx-white-8">$390,212 before tax</span>
                      </div>
                    </div>
                    <div id="ch3" class="ht-50 tr-y-1"></div>
                  </div>
                </div><!-- col-3 -->
                <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                  <div class="bg-teal rounded overflow-hidden">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                      <i class="ion ion-monitor tx-60 lh-0 tx-white op-7"></i>
                      <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">% Unique Visits</p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">54.45%</p>
                        <span class="tx-11 tx-roboto tx-white-8">23% average duration</span>
                      </div>
                    </div>
                    <div id="ch2" class="ht-50 tr-y-1"></div>
                  </div>
                </div><!-- col-3 -->
                <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
                  <div class="bg-primary rounded overflow-hidden">
                    <div class="pd-x-20 pd-t-20 d-flex align-items-center">
                      <i class="ion ion-clock tx-60 lh-0 tx-white op-7"></i>
                      <div class="mg-l-20">
                        <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase tx-white-8 mg-b-10">Bounce Rate</p>
                        <p class="tx-24 tx-white tx-lato tx-bold mg-b-0 lh-1">32.16%</p>
                        <span class="tx-11 tx-roboto tx-white-8">65.45% on average time</span>
                      </div>
                    </div>
                    <div id="ch4" class="ht-50 tr-y-1"></div>
                  </div>
                </div><!-- col-3 -->
              </div><!-- row -->

              <div class="row row-sm">
                <div class="col-4">
                  <div class="card bd-gray-400 pd-20">
                    <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15">QA Forms</h6>
                    <div class="d-flex mg-b-10">
                      <div class="bd-r pd-r-10">
                        <label class="tx-12">Today</label>
                        <p class="tx-lato tx-inverse tx-bold">{{$todayform}}</p>
                      </div>
                      <div class="bd-r pd-x-10">
                        <label class="tx-12">This Week</label>
                        <p class="tx-lato tx-inverse tx-bold">{{$weekform}}</p>
                      </div>
                      <div class="pd-l-10">
                        <label class="tx-12">This Month</label>
                        <p class="tx-lato tx-inverse tx-bold">{{$monthform}}</p>
                      </div>
                    </div><!-- d-flex -->
                    <div class="progress mg-b-10">
                        <div class="progress-bar bg-purple wd-100p" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                      </div>
                  </div><!-- card -->
                </div><!-- col-4 -->
                <div class="col-4">
                  <div class="card bd-gray-400 pd-20">
                    <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15">Client Status</h6>
                    <div class="d-flex mg-b-10">
                      <div class="bd-r pd-r-10">
                        <label class="tx-12">Clients</label>
                        <p class="tx-lato tx-inverse tx-bold">{{$client_status}}</p>
                      </div>
                      <div class="bd-r pd-x-10">
                        <label class="tx-12">M. On Going</label>
                        <p class="tx-lato tx-inverse tx-bold">{{$currentMonth_ongoingClients}}</p>
                      </div>
                      <div class="bd-r pd-x-10">
                        <label class="tx-12">M. Dispute</label>
                        <p class="tx-lato tx-inverse tx-bold">{{$currentMonth_disputedClients}}</p>
                      </div>
                      <div class="pd-l-10">
                        <label class="tx-12">M. Refund</label>
                        <p class="tx-lato tx-inverse tx-bold">{{$currentMonth_refundClients}}</p>
                      </div>
                    </div><!-- d-flex -->
                    <div class="progress mg-b-10">
                      <div class="progress-bar bg-info wd-100p" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                    </div>
                  </div><!-- card -->
                </div><!-- col-4 -->
                <div class="col-4">
                  <div class="card bd-gray-400 pd-20">
                    <h6 class="tx-12 tx-uppercase tx-inverse tx-bold mg-b-15">Expected Refund</h6>
                    <div class="d-flex mg-b-10">
                      <div class="bd-r pd-r-10">
                        <label class="tx-12">M. Low</label>
                        <p class="tx-lato tx-inverse tx-bold">{{$currentMonth_lowRiskClients}}</p>
                      </div>
                      <div class="bd-r pd-x-10">
                        <label class="tx-12">M. Moderate</label>
                        <p class="tx-lato tx-inverse tx-bold">{{$currentMonth_mediumRiskClients}}</p>
                      </div>
                      <div class="pd-l-10">
                        <label class="tx-12">M. High</label>
                        <p class="tx-lato tx-inverse tx-bold">{{$currentMonth_highRiskClients}}</p>
                      </div>
                    </div><!-- d-flex -->
                    <div class="progress mg-b-10">
                      <div class="progress-bar bg-danger wd-100p" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                    </div>
                  </div><!-- card -->
                </div><!-- col-4 -->
              </div><!-- row -->

              <div class="row row-sm mg-t-20 ">
                <div class="col-lg-8">

                    <div class="row">

                        <div class="col-6">
                            @if ($last5qaformstatus > 0)
                            <div class="card bd-0 mg-t-20">
                                <div id="carousel12" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carousel12" data-slide-to="0" class="active"></li>
                                    <li data-target="#carousel12" data-slide-to="1"></li>
                                    <li data-target="#carousel12" data-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner" role="listbox">

                                    @foreach ($last5qaform as $item)

                                    @if ($item == $last5qaform[0])

                                    <div class="carousel-item active">
                                        <div class="bg-br-primary pd-30 ht-300 pos-relative d-flex align-items-center rounded">
                                            <div class="tx-white">
                                            <p class="tx-uppercase tx-11 tx-semibold tx-mont tx-spacing-2 tx-white-5">Client: <a href="/client/details/{{$item->clientID}}">{{$item->Client_Name->name}}</a></p>
                                            <p class="lh-5 mg-b-20">{{$last5qaform[0]->Refund_Request_summery}}</p>
                                            <nav class="nav flex-row tx-13">
                                                <a href="" class="tx-white-8 hover-white pd-l-0 pd-r-5">Brand: {{$item->Brand_Name->name}}</a>
                                                <a href="" class="tx-white-8 hover-white pd-l-0 pd-r-5">Project: {{$item->Project_Name->name}}</a>
                                                <a href="/userprofile/{{$item->projectmanagerID}}" class="tx-white-8 hover-white pd-x-5">PM: {{$item->Project_ProjectManager->name}}</a>
                                                <a href="/userprofile/{{$item->qaPerson}}" class="tx-white-8 hover-white pd-x-5">QA: {{$item->QA_Person->name}}</a>
                                                <a href="/client/project/qareport/view/{{$item->id}}" class="tx-white-8 hover-white pd-x-5">View</a>
                                            </nav>
                                            </div>
                                        </div><!-- d-flex -->
                                    </div>

                                    @else

                                    <div class="carousel-item">
                                        <div class="bg-info pd-30 ht-300 pos-relative d-flex align-items-center rounded">
                                        <div class="tx-white">
                                            <p class="tx-uppercase tx-11 tx-semibold tx-mont tx-spacing-2 tx-white-5">Client: <a href="/client/details/{{$item->clientID}}">{{$item->Client_Name->name}}</a></p>
                                            <p class="lh-5 mg-b-20">{{$item->Refund_Request_summery}}</p>
                                            <nav class="nav flex-row tx-13">
                                                <a href="" class="tx-white-8 hover-white pd-l-0 pd-r-5">Brand: {{$item->Brand_Name->name}}</a>
                                                <a href="" class="tx-white-8 hover-white pd-l-0 pd-r-5">Project: {{$item->Project_Name->name}}</a>
                                                <a href="/userprofile/{{$item->projectmanagerID}}" class="tx-white-8 hover-white pd-x-5">PM: {{$item->Project_ProjectManager->name}}</a>
                                                <a href="/userprofile/{{$item->qaPerson}}" class="tx-white-8 hover-white pd-x-5">QA: {{$item->QA_Person->name}}</a>
                                                <a href="/client/project/qareport/view/{{$item->id}}" class="tx-white-8 hover-white pd-x-5">View</a>
                                            </nav>
                                        </div>
                                        </div><!-- d-flex -->
                                    </div>

                                    @endif



                                    @endforeach


                                </div><!-- carousel-inner -->
                                </div><!-- carousel -->
                            </div><!-- card -->

                            @else
                            <div class="card bd-0 mg-t-20">
                                <div id="carousel12" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner" role="listbox">



                                    <div class="carousel-item active">
                                        <div class="bg-white pd-30 ht-300 pos-relative d-flex align-items-center rounded">
                                            <div class="tx-black">
                                            <p class="lh-5 mg-b-20">No Client on Refund</p>
                                            </div>
                                        </div><!-- d-flex -->
                                    </div>




                                </div><!-- carousel-inner -->
                                </div><!-- carousel -->
                            </div><!-- card -->

                            @endif



                        </div>

                        <div class="col-6">
                            <div class="card bd-gray-400 mg-t-20">
                                <div id="carousel3" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carousel3" data-slide-to="0" class="active"></li>
                                    <li data-target="#carousel3" data-slide-to="1"></li>
                                </ol>
                                <div class="carousel-inner" role="listbox">
                                    <div class="carousel-item active">
                                    <div class="bg-white ht-300 pos-relative overflow-hidden d-flex flex-column align-items-start rounded">
                                        <div class="pos-absolute t-15 r-25">
                                        <a href="" class="tx-gray-500 hover-info mg-l-7"><i class="icon ion-more tx-20"></i></a>
                                        </div>
                                        <div class="pd-x-30 pd-t-30 mg-b-auto">
                                        <p class="tx-info tx-uppercase tx-11 tx-semibold tx-mont mg-b-5">Brand #1</p>
                                        <h5 class="tx-inverse mg-b-20">Expected:</h5>
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Refund</p>
                                                <h2 class="tx-inverse tx-lato tx-bold mg-b-0">36</h2>
                                            </div>
                                            <div class="col-6">
                                                <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Upsell</p>
                                                <h2 class="tx-inverse tx-lato tx-bold mg-b-0">23</h2>
                                            </div>
                                            <div class="col-6">
                                                <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Renewal</p>
                                                <h2 class="tx-inverse tx-lato tx-bold mg-b-0">26</h2>
                                            </div>
                                            <div class="col-6">
                                                <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Recurring</p>
                                                <h2 class="tx-inverse tx-lato tx-bold mg-b-0">66</h2>
                                            </div>

                                            </div>
                                        </div>
                                        <div id="ch10" class="ht-100 tr-y-1"></div>
                                    </div><!-- d-flex -->
                                    </div>
                                    <div class="carousel-item">
                                    <div class="bg-white ht-300 pos-relative overflow-hidden d-flex flex-column align-items-start rounded">
                                        <div class="pos-absolute t-15 r-25">
                                        <a href="" class="tx-gray-500 hover-info mg-l-7"><i class="icon ion-more tx-20"></i></a>
                                        </div>
                                        <div class="pd-x-30 pd-t-30 mg-b-auto">
                                        <p class="tx-info tx-uppercase tx-11 tx-semibold tx-mont mg-b-5">Brand #2</p>
                                        <h5 class="tx-inverse mg-b-20">Expected:</h5>
                                        <div class="row">
                                        <div class="col-6">
                                            <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Refund</p>
                                            <h2 class="tx-inverse tx-lato tx-bold mg-b-0">36</h2>
                                        </div>
                                        <div class="col-6">
                                            <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Upsell</p>
                                            <h2 class="tx-inverse tx-lato tx-bold mg-b-0">23</h2>
                                        </div>
                                        <div class="col-6">
                                            <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Renewal</p>
                                            <h2 class="tx-inverse tx-lato tx-bold mg-b-0">26</h2>
                                        </div>
                                        <div class="col-6">
                                            <p class="tx-uppercase tx-11 tx-semibold tx-mont mg-b-0">Recurring</p>
                                            <h2 class="tx-inverse tx-lato tx-bold mg-b-0">66</h2>
                                        </div>

                                        </div>

                                        </div>
                                        <div id="ch11" class="ht-100 tr-y-1"></div>
                                    </div><!-- d-flex -->
                                    </div><!-- cardousel-item -->
                                </div><!-- carousel-inner -->
                                </div><!-- carousel -->
                            </div><!-- card -->

                        </div>

                    </div>







                  <div class="card bd-gray-400 pd-25 mg-t-20">


                    <div class="row row-xs mg-t-25">
                      <div class="col-sm-4">
                        <div class="tx-center pd-y-15 bd">
                          <p class="mg-b-5 tx-uppercase tx-10 tx-mont tx-semibold">Total Clients</p>
                          <h4 class="tx-lato tx-inverse tx-bold mg-b-0">{{$client_status}}</h4>
                        </div>
                      </div><!-- col-4 -->
                      <div class="col-sm-4 mg-t-20 mg-sm-t-0">
                        <div class="tx-center pd-y-15 bd">
                          <p class="mg-b-5 tx-uppercase tx-10 tx-mont tx-semibold">Total Refund</p>
                          <h4 class="tx-lato tx-inverse tx-bold mg-b-0">{{$Total_refundClients}}</h4>
                        </div>
                      </div><!-- col-4 -->
                      <div class="col-sm-4 mg-t-20 mg-sm-t-0">
                        <div class="tx-center pd-y-15 bd">
                          <p class="mg-b-5 tx-uppercase tx-10 tx-mont tx-semibold">Total Dispute</p>
                          <h4 class="tx-lato tx-inverse tx-bold mg-b-0">{{$Total_disputedClients}}</h4>
                        </div>
                      </div><!-- col-4 -->
                    </div><!-- row -->

                  </div><!-- card -->


                </div><!-- col-8 -->
                <div class="col-lg-4 mg-t-20 mg-lg-t-0">

                  <div class="card bd-gray-400 overflow-hidden">
                    <div class="pd-x-25 pd-t-25">
                      <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1 mg-b-20">Upcoming Recurring Payments</h6>
                      <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0">As of Today</p>
                      <h1 class="tx-56 tx-light tx-inverse mg-b-0">755<span class="tx-teal tx-24">gb</span></h1>
                      <p><span class="tx-primary">80%</span> of free space remaining</p>
                    </div><!-- pd-x-25 -->
                    <div id="ch6" class="ht-115 mg-r--1"></div>
                    <div class="bg-teal pd-x-25 pd-b-25 d-flex justify-content-between">
                      <div class="tx-center">
                        <h3 class="tx-lato tx-white mg-b-5">989<span class="tx-light op-8 tx-20">gb</span></h3>
                        <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0 tx-white-8">Total Space</p>
                      </div>
                      <div class="tx-center">
                        <h3 class="tx-lato tx-white mg-b-5">234<span class="tx-light op-8 tx-20">gb</span></h3>
                        <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0 tx-white-8">Used Space</p>
                      </div>
                      <div class="tx-center">
                        <h3 class="tx-lato tx-white mg-b-5">80<span class="tx-light op-8 tx-20">%</span></h3>
                        <p class="tx-10 tx-spacing-1 tx-mont tx-semibold tx-uppercase mg-b-0 tx-white-8">Free Space</p>
                      </div>
                    </div>
                  </div><!-- card -->



                  <div class="card card-body bd-0 pd-25 bg-primary mg-t-20">
                    <div class="d-xs-flex justify-content-between align-items-center tx-white mg-b-20">
                      <h6 class="tx-13 tx-uppercase tx-semibold tx-spacing-1 mg-b-0">Server Status</h6>
                      <span class="tx-12 tx-uppercase">Oct 2017</span>
                    </div>
                    <p class="tx-sm tx-white tx-medium mg-b-0">Hardware Monitoring</p>
                    <p class="tx-12 tx-white-7">Intel Dothraki G125H 2.5GHz</p>
                    <div class="progress bg-white-3 rounded-0 mg-b-0">
                      <div class="progress-bar bg-success wd-50p lh-3" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                    </div><!-- progress -->
                    <p class="tx-11 mg-b-0 mg-t-15 tx-white-7">Notice: Lorem ipsum dolor sit amet.</p>
                  </div><!-- card -->





                </div><!-- col-4 -->
              </div><!-- row -->

@else

@endif


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
