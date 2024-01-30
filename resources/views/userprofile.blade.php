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
            <img src="https://via.placeholder.com/500" alt="">
          </div><!-- card-profile-img -->
          @foreach ($employee as $employees)
          <h4 class="tx-normal tx-roboto tx-white">{{$employees->name}}</h4>
          <p class="mg-b-25">{{ $employees->email }}</p>
          @endforeach





        </div><!-- card-body -->
      </div><!-- card -->

      <div class="ht-70 bg-gray-100 pd-x-20 d-flex align-items-center justify-content-center bd-b bd-gray-400">
        <ul class="nav nav-outline active-primary align-items-center flex-row" role="tablist">
          <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#projects" role="tab">Projects</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#clients" role="tab">Clients</a></li>
          <li class="nav-item hidden-xs-down"><a class="nav-link" data-toggle="tab" href="#" role="tab">Settings</a></li>
        </ul>
      </div>

      <div class="tab-content br-profile-body">
        <div class="tab-pane fade active show" id="projects">
          <div class="row">
            <div class="col-lg-8">
              <div class="media-list bg-white rounded bd bd-gray-400">
                <div class="media pd-20 pd-xs-30">

                  <div class="media-body mg-l-20">
                    <div class="d-flex justify-content-between mg-b-10">

                    </div><!-- d-flex -->
                        <table id="datatable1">
                          <thead>
                            <tr>
                                <th>Client Name</th>
                                <th>Client Email</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($ProjectManagers as $pm)
                            <tr>
                              <td>{{ $pm->name }}</td>
                              <td>{{ $pm->email }}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                    <div class="media-footer">

                    </div><!-- d-flex -->
                  </div><!-- media-body -->
                </div><!-- media -->
                <div class="media pd-20 pd-xs-30">
                  <img src="https://via.placeholder.com/500" alt="" class="wd-40 rounded-circle">
                  <div class="media-body mg-l-20">
                    <div class="d-flex justify-content-between mg-b-10">
                      <div>
                        <h6 class="mg-b-2 tx-inverse tx-14">Annie Lee</h6>
                        <span class="tx-12 tx-gray-500">@annielee</span>
                      </div>
                      <span class="tx-12">1 hour ago</span>
                    </div><!-- d-flex -->
                    <img src="https://via.placeholder.com/1000x400" class="img-fluid mg-b-10" alt="">
                    <div class="media-footer">
                      <div>
                        <a href=""><i class="fa fa-heart"></i></a>
                        <a href="" class="mg-l-10"><i class="fa fa-comment"></i></a>
                        <a href="" class="mg-l-10"><i class="fa fa-retweet"></i></a>
                        <a href="" class="mg-l-10"><i class="fa fa-ellipsis-h"></i></a>
                      </div>
                    </div><!-- d-flex -->
                  </div><!-- media-body -->
                </div><!-- media -->
                <div class="media pd-20 pd-xs-30">
                  <img src="https://via.placeholder.com/500" alt="" class="wd-40 rounded-circle">
                  <div class="media-body mg-l-20">
                    <div class="d-flex justify-content-between mg-b-10">
                      <div>
                        <h6 class="mg-b-2 tx-inverse tx-14">Annie Lee</h6>
                        <span class="tx-12 tx-gray-500">@annielee</span>
                      </div>
                      <span class="tx-12">2 hours ago</span>
                    </div><!-- d-flex -->
                    <p class="mg-b-20">To achieve this, it would be necessary to have uniform grammar, pronunciation and more common words.</p>
                    <div class="media-footer">
                      <div>
                        <a href=""><i class="fa fa-heart tx-danger"></i></a>
                        <a href="" class="mg-l-10"><i class="fa fa-comment"></i></a>
                        <a href="" class="mg-l-10"><i class="fa fa-retweet"></i></a>
                        <a href="" class="mg-l-10"><i class="fa fa-ellipsis-h"></i></a>
                      </div>
                    </div><!-- d-flex -->
                  </div><!-- media-body -->
                </div><!-- media -->
                <div class="media pd-20 pd-xs-30">
                  <img src="https://via.placeholder.com/500" alt="" class="wd-40 rounded-circle">
                  <div class="media-body mg-l-20">
                    <div class="d-flex justify-content-between mg-b-10">
                      <div>
                        <h6 class="mg-b-2 tx-inverse tx-14">Mark Anthony</h6>
                        <span class="tx-12 tx-gray-500">@markanthony</span>
                      </div>
                      <span class="tx-12">2 hours ago</span>
                    </div><!-- d-flex -->
                    <p class="lead pd-30 bg-purple tx-white">Be who you are and say what you feel, because those who mind don't matter, and those who matter don't mind.</p>
                    <div class="media-footer">
                      <div>
                        <a href=""><i class="fa fa-heart"></i></a>
                        <a href="" class="mg-l-10"><i class="fa fa-comment"></i></a>
                        <a href="" class="mg-l-10"><i class="fa fa-retweet"></i></a>
                        <a href="" class="mg-l-10"><i class="fa fa-ellipsis-h"></i></a>
                      </div>
                    </div><!-- d-flex -->
                  </div><!-- media-body -->
                </div><!-- media -->
              </div><!-- card -->

              <div class="bg-white pd-y-12 tx-center mg-t-15 mg-xs-t-30 bd bd-gray-400 rounded">
                <a href="" class="tx-gray-600 hover-info">Load more</a>
              </div>
            </div><!-- col-lg-8 -->
            <div class="col-lg-4 mg-t-30 mg-lg-t-0">
              <div class="card pd-20 pd-xs-30 bd-gray-400">
                @foreach ($employee as $employees)
                <h6 class="tx-gray-800 tx-uppercase tx-semibold tx-13 mg-b-25">Contact Information</h6>

                <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Name</label>
                <p class="tx-info mg-b-25">{{$employees->name}}</p>

                <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Email Address</label>
                <p class="tx-inverse mg-b-25">{{$employees->email}}</p>

                <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Extention</label>
                <p class="tx-inverse mg-b-25">{{$employees->extension}}</p>

                <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Designation</label>
                <p class="tx-inverse mg-b-50">{{$employees->position}}</p>
                @foreach ($department as $departments)
                <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Department</label>
                <p class="tx-inverse mg-b-25">{{$departments->name}}</p>
                @endforeach
              </div><!-- card -->
                @endforeach
              <div class="card pd-20 pd-xs-30 bd-gray-400 mg-t-30">
                <h6 class="tx-gray-800 tx-uppercase tx-semibold tx-13 mg-b-30">People You May Know</h6>
                <div class="media-list">
                  <div class="media align-items-center pd-b-10">
                    <img src="https://via.placeholder.com/500" class="wd-45 rounded-circle" alt="">
                    <div class="media-body mg-x-15 mg-xs-x-20">
                      <h6 class="mg-b-2 tx-inverse tx-14">Marilyn Tarter</h6>
                      <p class="mg-b-0 tx-12">@marilyntarter</p>
                    </div><!-- media-body -->
                    <a href="#" class="btn btn-outline-secondary btn-icon rounded-circle mg-r-5">
                      <div><i class="icon ion-android-person-add tx-16"></i></div>
                    </a>
                  </div><!-- media -->
                  <div class="media align-items-center pd-y-10">
                    <img src="https://via.placeholder.com/500" class="wd-45 rounded-circle" alt="">
                    <div class="media-body mg-x-15 mg-xs-x-20">
                      <h6 class="mg-b-2 tx-inverse tx-14">Belinda Connor</h6>
                      <p class="mg-b-0 tx-12">@bconnor</p>
                    </div><!-- media-body -->
                    <a href="#" class="btn btn-outline-secondary btn-icon rounded-circle mg-r-5">
                      <div><i class="icon ion-android-person-add tx-16"></i></div>
                    </a>
                  </div><!-- media -->
                  <div class="media align-items-center pd-y-10">
                    <img src="https://via.placeholder.com/500" class="wd-45 rounded-circle" alt="">
                    <div class="media-body mg-x-15 mg-xs-x-20">
                      <h6 class="mg-b-2 tx-inverse tx-14">Deborah Miner</h6>
                      <p class="mg-b-0 tx-12">@dminer</p>
                    </div><!-- media-body -->
                    <a href="#" class="btn btn-outline-secondary btn-icon rounded-circle mg-r-5">
                      <div><i class="icon ion-android-person-add tx-16"></i></div>
                    </a>
                  </div><!-- media -->
                  <div class="media align-items-center pd-y-10">
                    <img src="https://via.placeholder.com/500" class="wd-45 rounded-circle" alt="">
                    <div class="media-body mg-x-15 mg-xs-x-20">
                      <h6 class="mg-b-2 tx-inverse tx-14">Theodore Grestin</h6>
                      <p class="mg-b-0 tx-12">@theodore</p>
                    </div><!-- media-body -->
                    <a href="#" class="btn btn-outline-secondary btn-icon rounded-circle mg-r-5">
                      <div><i class="icon ion-android-person-add tx-16"></i></div>
                    </a>
                  </div><!-- media -->
                  <div class="media align-items-center pd-y-10">
                    <img src="https://via.placeholder.com/500" class="wd-45 rounded-circle" alt="">
                    <div class="media-body mg-x-15 mg-xs-x-20">
                      <h6 class="mg-b-2 tx-inverse tx-14">Andrew Wiggins</h6>
                      <p class="mg-b-0 tx-12">@awiggins</p>
                    </div><!-- media-body -->
                    <a href="#" class="btn btn-outline-secondary btn-icon rounded-circle mg-r-5">
                      <div><i class="icon ion-android-person-add tx-16"></i></div>
                    </a>
                  </div><!-- media -->
                </div><!-- media-list -->
              </div><!-- card -->
            </div><!-- col-lg-4 -->
          </div><!-- row -->
        </div><!-- tab-pane -->
        <div class="tab-pane fade" id="clients">
          <div class="row">
            <div class="col-lg-8">
              <div class="card pd-20 pd-xs-30 bd-gray-400 mg-t-30">
                    <h6 class="tx-gray-800 tx-uppercase tx-semibold tx-14 mg-b-30">Projects</h6>
                    <table id="datatable1">
                        <thead>
                            <tr>
                                <th>Client Name</th>
                                <th>Client Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ProjectManagers as $pm)
                            <tr>
                              <td>{{ $pm->name }}</td>
                              <td>{{ $pm->email }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
