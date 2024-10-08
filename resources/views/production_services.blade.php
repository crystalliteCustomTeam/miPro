@extends($theme == 1 ? 'layouts.darktheme' : 'layouts.app')

@section($theme == 1 ? 'maincontent1' : 'maincontent')


        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Settings</a>
            <span class="breadcrumb-item active">Production Services</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Production Services</h4>
            <p class="mg-b-0">Settings</p>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
           <form action="/settings/Production/services/Process" method="POST">
            @csrf
            <div class="row">

                <div class="col-6 mt-3">
                    <label for="" style="font-weight:bold;">Department: </label>
                    <select class="form-control select2" name="department">
                        @if ($statusDepartment > 0)
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                        @else
                        <option value="">Create Department First</option>
                        @endif
                    </select>
                </div>
                <div class="col-6 mt-3">
                    <label for="">Add Services</label><br>
                    @if ($theme == 1)
                    <input type="text" name="services"  class="form-control-dark wd-600" style="height: 50px;" placeholder="  Enter Services"  required>
                    @else
                    <input type="text" name="services" class="form-control" required>
                    @endif

                </div>
                <div class="col-12">
                    <br>
                    <input type="submit" value="Create" name="" class="btn btn-success mt-2">
                </div>
                <div class="col-4">
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

    <div class="br-pagebody">
        <div class="br-section-wrapper">
           <h2>Production Services:</h2>

           <table class="table" id="datatable1" class="table-dark table-hover">
            <thead>
                <tr role="row">
                    <td style="font-weight:bold;">ID</td>
                    <td style="font-weight:bold;">Department</td>
                    <td style="font-weight:bold;">Servicess</td>
                    <td style="font-weight:bold;">Action</td>
                  </tr>
            </thead>
            <tbody>
                @foreach ($ProductionServices as $ProductionService)
                  <tr  role="row" class="odd">
                    <td>{{ $ProductionService->id }}</td>
                    <td>{{ $ProductionService->Prod_Depart->name  }}</td>
                    <td>{{ $ProductionService->services  }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="/settings/delete_kycservices/{{$ProductionService->id}}"><button class="btn btn-danger btn-sm"> <img src="https://cdn-icons-png.flaticon.com/16/8745/8745912.png" alt="" style="filter: invert(1);"> Delete</button></a>
                        </div>
                      </td>
                  </tr>
                @endforeach
              </tbody>
           </table>
        </div>
      </div>









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
