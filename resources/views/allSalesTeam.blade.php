@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Company Sales</a>
            <span class="breadcrumb-item active">Revenue Management</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Sales Teams:</h4>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">




            <table id="datatable1" class="table-dark table-hover">
                <thead>
                  <tr role="row">
                    <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-sort="ascending" aria-label="First name: activate to sort column descending">Team Lead</th>
                    {{-- <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Brand</th> --}}
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Members</th>
                    <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Action</th>
                  </tr>
                </thead>
                <tbody>

                  @foreach($salesteams as $department)
                  <tr role="row" class="odd">
                    @if (isset($department->Salesteamleadname->name) and $department->Salesteamleadname->name !== null)
                    <td tabindex="0" class="sorting_1">{{ $department->Salesteamleadname->name }}</td>
                    @else
                        <td tabindex="0" class="sorting_1"><p style="color: red">User Deleted</p></td>
                    @endif
                    {{-- <td>{{ $department->Salesbrandname->name }}</td> --}}
                    <td>
                        <ul>
                            @foreach($department->salesmembers($department->members)  as $dm)
                            <li><strong>{{ $dm->name }}</strong></li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                      <div class="btn-group">
                          <a href="#" onclick="myConfirm('{{ $department->id }}')"><button class="btn btn-danger btn-sm"> <img src="https://cdn-icons-png.flaticon.com/16/8745/8745912.png" alt="" style="filter: invert(1);"> Delete</button></a>
                          <a href="/#/{{ $department->id }}"><button class="btn btn-success btn-sm"><img src="https://cdn-icons-png.flaticon.com/16/10140/10140139.png" alt="" style="filter: invert(1);" > Edit </button></a>
                          <a href="/#/{{ $department->id }}"><button class="btn btn-primary btn-sm"><img src="https://cdn-icons-png.flaticon.com/16/5397/5397601.png" alt="" style="filter: invert(1);"> {{ count($department->salesmembers($department->members)) }} Employees </button></a>

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
                        window.location.href = "/#/" + id;
                        Swal.fire({
                        title: "Deleted!",
                        text: "Sales Team has been deleted.",
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
