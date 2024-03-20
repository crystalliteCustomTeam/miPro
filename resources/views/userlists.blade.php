@extends('layouts.app')

@section('maincontent')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">User Management</a>
            <span class="breadcrumb-item active">Create User</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>User Management</h4>
            <p class="mg-b-0">Create User</p>
          </div>
        </div><!-- d-flex  -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">


           <table id="datatable1" class="table-dark table-hover">
              <thead>
                <tr role="row">
                  <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="First name: activate to sort column descending">Name</th>
                  <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Email</th>
                  <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">Extension</th>
                  <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">Position</th>
                  <th class="wd-10p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Salary: activate to sort column ascending">Action</th>
                  <th class="wd-25p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 353px; display: none;" aria-label="E-mail: activate to sort column ascending">Status</th>
                </tr>
              </thead>
              <tbody>

                @foreach($Employees as $employees)
                <tr role="row" class="odd">
                  <td tabindex="0" class="sorting_1"><a href="/userprofile/{{ $employees->id }}">{{ $employees->name }}</a></td>
                  <td>{{ $employees->email }}</td>
                  <td>{{ $employees->extension }}</td>
                  <td>{{ $employees->position }}</td>
                  <td>
                      <div class="button-group">
                        <a href="/edituser/{{ $employees->id }}" class="btn btn-sm btn-info">Edit</a>
                        <a href="#"  onclick="myConfirm('{{ $employees->id }}')" class="btn btn-sm btn-danger">Delete</a>
                        <a href="/setupdepartments/{{ $employees->id }}" class="btn btn-sm btn-primary">Add Department</a>
                      </div>
                  </td>
                  <td style="display: none;">{{ $employees->status }}</td>
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
                        window.location.href = "/deleteuser/" + id;
                        Swal.fire({
                        title: "Deleted!",
                        text: "User has been deleted.",
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
