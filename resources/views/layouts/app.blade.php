<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    
    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title>Crystal Pro Panel</title>

    <!-- vendor css -->
    <link href="{{ asset('lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/rickshaw/rickshaw.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{ asset('css/bracket.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bracket.oreo.css') }}">
  </head>

  <body>

    @extends('layouts.leftpanel')
    @extends('layouts.rightpanel')
   

    <!-- ########## START: RIGHT PANEL ########## -->
    <div class="br-sideright">
      <ul class="nav nav-tabs sidebar-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" role="tab" href="#contacts"><i class="icon ion-ios-contact-outline tx-24"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" href="#attachments"><i class="icon ion-ios-folder-outline tx-22"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" href="#calendar"><i class="icon ion-ios-calendar-outline tx-24"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" role="tab" href="#settings"><i class="icon ion-ios-gear-outline tx-24"></i></a>
        </li>
      </ul><!-- sidebar-tabs -->

      <!-- Tab panes -->
      <div class="tab-content">
        <div class="tab-pane pos-absolute a-0 mg-t-60 contact-scrollbar active" id="contacts" role="tabpanel">
          <label class="sidebar-label pd-x-25 mg-t-25">Online Contacts</label>
          <div class="contact-list pd-x-10">
            <a href="" class="contact-list-link new">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="https://via.placeholder.com/500" alt="">
                  <div class="contact-status-indicator bg-success bd-white"></div>
                </div>
                <div class="contact-person">
                  <p>Marilyn Tarter</p>
                  <span>Clemson, CA</span>
                </div>
                <span class="tx-info tx-12"><span class="square-8 bg-info rounded-circle"></span> 1 new</span>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="https://via.placeholder.com/500" alt="">
                  <div class="contact-status-indicator bg-success bd-white"></div>
                </div>
                <div class="contact-person">
                  <p class="mg-b-0 ">Belinda Connor</p>
                  <span>Fort Kent, ME</span>
                </div>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link new">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="https://via.placeholder.com/500" alt="">
                  <div class="contact-status-indicator bg-success bd-white"></div>
                </div>
                <div class="contact-person">
                  <p>Britanny Cevallos</p>
                  <span>Shiboygan Falls, WI</span>
                </div>
                <span class="tx-info tx-12"><span class="square-8 bg-info rounded-circle"></span> 3 new</span>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link new">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="https://via.placeholder.com/500" alt="">
                  <div class="contact-status-indicator bg-success bd-white"></div>
                </div>
                <div class="contact-person">
                  <p>Brandon Lawrence</p>
                  <span>Snohomish, WA</span>
                </div>
                <span class="tx-info tx-12"><span class="square-8 bg-info rounded-circle"></span> 1 new</span>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="https://via.placeholder.com/500" alt="">
                  <div class="contact-status-indicator bg-success bd-white"></div>
                </div>
                <div class="contact-person">
                  <p>Andrew Wiggins</p>
                  <span>Springfield, MA</span>
                </div>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="https://via.placeholder.com/500" alt="">
                  <div class="contact-status-indicator bg-success bd-white"></div>
                </div>
                <div class="contact-person">
                  <p>Theodore Gristen</p>
                  <span>Nashville, TN</span>
                </div>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="https://via.placeholder.com/500" alt="">
                  <div class="contact-status-indicator bg-success bd-white"></div>
                </div>
                <div class="contact-person">
                  <p>Deborah Miner</p>
                  <span>North Shore, CA</span>
                </div>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
          </div><!-- contact-list -->


          <label class="sidebar-label pd-x-25 mg-t-25">Offline Contacts</label>
          <div class="contact-list pd-x-10">
            <a href="" class="contact-list-link">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="https://via.placeholder.com/500" alt="">
                  <div class="contact-status-indicator bg-gray-500 bd-white"></div>
                </div>
                <div class="contact-person">
                  <p>Marilyn Tarter</p>
                  <span>Clemson, CA</span>
                </div>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="https://via.placeholder.com/500" alt="">
                  <div class="contact-status-indicator bg-gray-500 bd-white"></div>
                </div>
                <div class="contact-person">
                  <p>Belinda Connor</p>
                  <span>Fort Kent, ME</span>
                </div>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="https://via.placeholder.com/500" alt="">
                  <div class="contact-status-indicator bg-gray-500 bd-white"></div>
                </div>
                <div class="contact-person">
                  <p>Britanny Cevallos</p>
                  <span>Shiboygan Falls, WI</span>
                </div>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="https://via.placeholder.com/500" alt="">
                  <div class="contact-status-indicator bg-gray-500 bd-white"></div>
                </div>
                <div class="contact-person">
                  <p>Brandon Lawrence</p>
                  <span>Snohomish, WA</span>
                </div>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="https://via.placeholder.com/500" alt="">
                  <div class="contact-status-indicator bg-gray-500 bd-white"></div>
                </div>
                <div class="contact-person">
                  <p>Andrew Wiggins</p>
                  <span>Springfield, MA</span>
                </div>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="https://via.placeholder.com/500" alt="">
                  <div class="contact-status-indicator bg-gray-500 bd-white"></div>
                </div>
                <div class="contact-person">
                  <p>Theodore Gristen</p>
                  <span>Nashville, TN</span>
                </div>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
            <a href="" class="contact-list-link">
              <div class="d-flex">
                <div class="pos-relative">
                  <img src="https://via.placeholder.com/500" alt="">
                  <div class="contact-status-indicator bg-gray-500 bd-white"></div>
                </div>
                <div class="contact-person">
                  <p>Deborah Miner</p>
                  <span>North Shore, CA</span>
                </div>
              </div><!-- d-flex -->
            </a><!-- contact-list-link -->
          </div><!-- contact-list -->

        </div><!-- #contacts -->


        <div class="tab-pane pos-absolute a-0 mg-t-60 attachment-scrollbar" id="attachments" role="tabpanel">
          <label class="sidebar-label pd-x-25 mg-t-25">Recent Attachments</label>
          <div class="media-file-list">
            <div class="media">
              <div class="pd-10 bg-gray-500 bg-mojito wd-50 ht-60 tx-center d-flex align-items-center justify-content-center">
                <i class="far fa-file-image tx-28 tx-white"></i>
              </div>
              <div class="media-body tx-gray-800 mg-l-10 mg-r-auto">
                <p class="mg-b-0 tx-13">IMG_43445</p>
                <p class="mg-b-0 tx-12 op-5">JPG Image</p>
                <p class="mg-b-0 tx-12 op-5">1.2mb</p>
              </div><!-- media-body -->
              <a href="" class="more"><i class="icon ion-android-more-vertical tx-18"></i></a>
            </div><!-- media -->
            <div class="media mg-t-20">
              <div class="pd-10 bg-gray-500 bg-purple wd-50 ht-60 tx-center d-flex align-items-center justify-content-center">
                <i class="far fa-file-video tx-28 tx-white"></i>
              </div>
              <div class="media-body tx-gray-800 mg-l-10 mg-r-auto">
                <p class="mg-b-0 tx-13">VID_6543</p>
                <p class="mg-b-0 tx-12 op-5">MP4 Video</p>
                <p class="mg-b-0 tx-12 op-5">24.8mb</p>
              </div><!-- media-body -->
              <a href="" class="more"><i class="icon ion-android-more-vertical tx-18"></i></a>
            </div><!-- media -->
            <div class="media mg-t-20">
              <div class="pd-10 bg-gray-500 bg-reef wd-50 ht-60 tx-center d-flex align-items-center justify-content-center">
                <i class="far fa-file-word tx-28 tx-white"></i>
              </div>
              <div class="media-body tx-gray-800 mg-l-10 mg-r-auto">
                <p class="mg-b-0 tx-13">Tax_Form</p>
                <p class="mg-b-0 tx-12 op-5">Word Document</p>
                <p class="mg-b-0 tx-12 op-5">5.5mb</p>
              </div><!-- media-body -->
              <a href="" class="more"><i class="icon ion-android-more-vertical tx-18"></i></a>
            </div><!-- media -->
            <div class="media mg-t-20">
              <div class="pd-10 bg-gray-500 bg-firewatch wd-50 ht-60 tx-center d-flex align-items-center justify-content-center">
                <i class="far fa-file-pdf tx-28 tx-white"></i>
              </div>
              <div class="media-body tx-gray-800 mg-l-10 mg-r-auto">
                <p class="mg-b-0 tx-13">Getting_Started</p>
                <p class="mg-b-0 tx-12 op-5">PDF Document</p>
                <p class="mg-b-0 tx-12 op-5">12.7mb</p>
              </div><!-- media-body -->
              <a href="" class="more"><i class="icon ion-android-more-vertical tx-18"></i></a>
            </div><!-- media -->
            <div class="media mg-t-20">
              <div class="pd-10 bg-gray-500 bg-firewatch wd-50 ht-60 tx-center d-flex align-items-center justify-content-center">
                <i class="far fa-file-pdf tx-28 tx-white"></i>
              </div>
              <div class="media-body tx-gray-800 mg-l-10 mg-r-auto">
                <p class="mg-b-0 tx-13">Introduction</p>
                <p class="mg-b-0 tx-12 op-5">PDF Document</p>
                <p class="mg-b-0 tx-12 op-5">7.7mb</p>
              </div><!-- media-body -->
              <a href="" class="more"><i class="icon ion-android-more-vertical tx-18"></i></a>
            </div><!-- media -->
            <div class="media mg-t-20">
              <div class="pd-10 bg-gray-500 bg-mojito wd-50 ht-60 tx-center d-flex align-items-center justify-content-center">
                <i class="far fa-file-image tx-28 tx-white"></i>
              </div>
              <div class="media-body tx-gray-800 mg-l-10 mg-r-auto">
                <p class="mg-b-0 tx-13">IMG_43420</p>
                <p class="mg-b-0 tx-12 op-5">JPG Image</p>
                <p class="mg-b-0 tx-12 op-5">2.2mb</p>
              </div><!-- media-body -->
              <a href="" class="more"><i class="icon ion-android-more-vertical tx-18"></i></a>
            </div><!-- media -->
            <div class="media mg-t-20">
              <div class="pd-10 bg-gray-500 bg-mojito wd-50 ht-60 tx-center d-flex align-items-center justify-content-center">
                <i class="far fa-file-image tx-28 tx-white"></i>
              </div>
              <div class="media-body tx-gray-800 mg-l-10 mg-r-auto">
                <p class="mg-b-0 tx-13">IMG_43447</p>
                <p class="mg-b-0 tx-12 op-5">JPG Image</p>
                <p class="mg-b-0 tx-12 op-5">3.2mb</p>
              </div><!-- media-body -->
              <a href="" class="more"><i class="icon ion-android-more-vertical tx-18"></i></a>
            </div><!-- media -->
            <div class="media mg-t-20">
              <div class="pd-10 bg-gray-500 bg-purple wd-50 ht-60 tx-center d-flex align-items-center justify-content-center">
                <i class="far fa-file-video tx-28 tx-white"></i>
              </div>
              <div class="media-body tx-gray-800 mg-l-10 mg-r-auto">
                <p class="mg-b-0 tx-13">VID_6545</p>
                <p class="mg-b-0 tx-12 op-5">AVI Video</p>
                <p class="mg-b-0 tx-12 op-5">14.8mb</p>
              </div><!-- media-body -->
              <a href="" class="more"><i class="icon ion-android-more-vertical tx-18"></i></a>
            </div><!-- media -->
            <div class="media mg-t-20">
              <div class="pd-10 bg-gray-500 bg-reef wd-50 ht-60 tx-center d-flex align-items-center justify-content-center">
                <i class="far fa-file-word tx-28 tx-white"></i>
              </div>
              <div class="media-body tx-gray-800 mg-l-10 mg-r-auto">
                <p class="mg-b-0 tx-13">Secret_Document</p>
                <p class="mg-b-0 tx-12 op-5">Word Document</p>
                <p class="mg-b-0 tx-12 op-5">4.5mb</p>
              </div><!-- media-body -->
              <a href="" class="more"><i class="icon ion-android-more-vertical tx-18"></i></a>
            </div><!-- media -->
          </div><!-- media-list -->
        </div><!-- #history -->
        <div class="tab-pane pos-absolute a-0 mg-t-60 schedule-scrollbar" id="calendar" role="tabpanel">
          <label class="sidebar-label pd-x-25 mg-t-25">Time &amp; Date</label>
          <div class="pd-x-25">
            <h2 id="brTime" class="br-time"></h2>
            <h6 id="brDate" class="br-date"></h6>
          </div>

          <label class="sidebar-label pd-x-25 mg-t-25">Events Calendar</label>
          <div class="datepicker sidebar-datepicker"></div>


          <label class="sidebar-label pd-x-25 mg-t-25">Event Today</label>
          <div class="pd-x-25">
            <div class="list-group sidebar-event-list mg-b-20">
              <div class="list-group-item">
                <div>
                  <h6 class="tx-inverse tx-13 mg-b-5 tx-normal">Roven's 32th Birthday</h6>
                  <p class="mg-b-0 tx-gray-600 tx-12">2:30PM</p>
                </div>
                <a href="" class="more"><i class="icon ion-android-more-vertical tx-18"></i></a>
              </div><!-- list-group-item -->
              <div class="list-group-item">
                <div>
                  <h6 class="tx-inverse tx-13 mg-b-5 tx-normal">Regular Workout Schedule</h6>
                  <p class="mg-b-0 tx-gray-600 tx-12">7:30PM</p>
                </div>
                <a href="" class="more"><i class="icon ion-android-more-vertical tx-18"></i></a>
              </div><!-- list-group-item -->
            </div><!-- list-group -->

            <a href="" class="btn btn-block btn-primary tx-uppercase tx-10 tx-mont tx-semibold">+ Add Event</a>
            <br>
          </div>

        </div>
        <div class="tab-pane pos-absolute a-0 mg-t-60 settings-scrollbar" id="settings" role="tabpanel">
          <label class="sidebar-label pd-x-25 mg-t-25">Quick Settings</label>

          <div class="sidebar-settings-item">
            <h6 class="tx-13 tx-normal">Sound Notification</h6>
            <p class="op-5 tx-13">Play an alert sound everytime there is a new notification.</p>
            <div class="br-switchbutton checked">
              <input type="hidden" name="switch1" value="true">
              <span></span>
            </div><!-- br-switchbutton -->
          </div>
          <div class="sidebar-settings-item">
            <h6 class="tx-13 tx-normal">2 Steps Verification</h6>
            <p class="op-5 tx-13">Sign in using a two step verification by sending a verification code to your phone.</p>
            <div class="br-switchbutton">
              <input type="hidden" name="switch2" value="false">
              <span></span>
            </div><!-- br-switchbutton -->
          </div>
          <div class="sidebar-settings-item">
            <h6 class="tx-13 tx-normal">Location Services</h6>
            <p class="op-5 tx-13">Allowing us to access your location</p>
            <div class="br-switchbutton">
              <input type="hidden" name="switch3" value="false">
              <span></span>
            </div><!-- br-switchbutton -->
          </div>
          <div class="sidebar-settings-item">
            <h6 class="tx-13 tx-normal">Newsletter Subscription</h6>
            <p class="op-5 tx-13">Enables you to send us news and updates send straight to your email.</p>
            <div class="br-switchbutton checked">
              <input type="hidden" name="switch4" value="true">
              <span></span>
            </div><!-- br-switchbutton -->
          </div>
          <div class="sidebar-settings-item">
            <h6 class="tx-13 tx-normal">Your email</h6>
            <div class="pos-relative">
              <input type="email" name="email" class="form-control" value="janedoe@domain.com">
            </div>
          </div>

          <div class="pd-y-20 pd-x-25">
            <h6 class="tx-13 tx-normal tx-white mg-b-20">More Settings</h6>
            <a href="" class="btn btn-block btn-outline-secondary tx-uppercase tx-11 tx-spacing-2">Account Settings</a>
            <a href="" class="btn btn-block btn-outline-secondary tx-uppercase tx-11 tx-spacing-2">Privacy Settings</a>
          </div>
        </div>
      </div><!-- tab-content -->
    </div><!-- br-sideright -->
    <!-- ########## END: RIGHT PANEL ########## --->

    @yield('maincontent')

    <script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('lib/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('lib/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('lib/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('lib/rickshaw/vendor/d3.min.js') }}"></script>
    <script src="{{ asset('lib/rickshaw/vendor/d3.layout.min.js') }}"></script>
    <script src="{{ asset('lib/rickshaw/rickshaw.min.js') }}"></script>
    <script src="{{ asset('lib/jquery.flot/jquery.flot.js')}}"></script>
    <script src="{{ asset('lib/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('lib/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
    <script src="{{ asset('lib/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('lib/echarts/echarts.min.js')}}"></script>
    <script src="{{ asset('lib/select2/js/select2.full.min.js') }}"></script>
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyAq8o5-8Y5pudbJMJtDFzb8aHiWJufa5fg"></script>
    <script src="{{ asset('lib/gmaps/gmaps.min.js')}}"></script>

    <script src="{{ asset('js/bracket.js') }}"></script>
    <script src="{{ asset('js/map.shiftworker.js') }}"></script>
    <script src="{{ asset('js/ResizeSensor.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>

    <script>
      $(function(){
        'use strict';

        $('#datatable1').DataTable({

        });
      });

      $(document).ready(function() {
        $('#select2forme,#frontsale,#projectmanager').select2();
        frontsale
      });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  </body>
</html>
