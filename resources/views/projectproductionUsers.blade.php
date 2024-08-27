@extends($theme == 1 ? 'layouts.darktheme' : 'layouts.app')

@section($theme == 1 ? 'maincontent1' : 'maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Project</a>
            <span class="breadcrumb-item active">Production</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Client Project</h4>
            <p class="mg-b-0">Production</p>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
            <h2>Project Production:</h2>
            <br><br>
              <button class="btn btn-outline-primary">Client Name: {{$projects[0]->ClientName->name }}</button>
              <button class="btn btn-outline-primary">Project Name: {{$projects[0]->name }}</button>
              @if (isset( $projects[0]->EmployeeName->name) and $projects[0]->EmployeeName->name !== null)
              <button class="btn btn-outline-primary">Project Manager: {{ $projects[0]->EmployeeName->name }}</button>
              @else
              <button class="btn btn-outline-danger">Project Manager: User Deleted</button>
              @endif
              {{-- <button class="btn btn-outline-primary">Project Manager: {{$projects[0]->EmployeeName->name }}</button> --}}
              <a href="/client/project/productions/{{$prjectid}}"><button class="btn btn-outline-success">Add Production</button></a>
              <br><br>
            <div class="row">
              <div class="col-12 mt-4">
                <table id="datatable1"  class="table-dark-wrapper table-hover">
                  <thead>
                    <th>Department</th>
                    <th>Assignee</th>
                    <th>Services</th>
                    <th>Description</th>
                    <th>Actions</th>
                  </thead>
                  <tbody>
                    @foreach($productions as $production)
                    <tr>
                      <td>{{ $production->DepartNameinProjectProduction->name }}</td>
                      @if (isset( $production->EmployeeNameinProjectProduction->name) and $production->EmployeeNameinProjectProduction->name !== null)
                      <td><a href="/userprofile/{{ $production->responsible_person }}">{{ $production->EmployeeNameinProjectProduction->name }}</a></td>
                      @else
                      <td><p style="color: red">User Deleted</p></td>
                      @endif
                      {{-- <td><a href="/userprofile/{{ $production->responsible_person }}">{{ $production->EmployeeNameinProjectProduction->name }}</a></td> --}}
                      <td>{{ $production->services }}</td>
                      <td>{{ $production->anycomment}}</td>
                      <td>
                        <div class="btn-group">
                            <a href="/client/project/editproductions/{{$production->id}}"><button class="btn btn-success btn-sm"><img src="https://cdn-icons-png.flaticon.com/16/10140/10140139.png" alt="" style="filter: invert(1);" > Edit </button></a>
                            {{-- <a href="/client/project/deleteproductions/{{$production->id}}"><button class="btn btn-danger btn-sm"> <img src="https://cdn-icons-png.flaticon.com/16/8745/8745912.png" alt="" style="filter: invert(1);"> Delete</button></a> --}}
                            <a href="#"  onclick="myConfirm('{{ $production->id }}')"><button class="btn btn-danger btn-sm"><img src="https://cdn-icons-png.flaticon.com/16/10140/10140139.png" alt="" style="filter: invert(1);" > Delete </button></a>
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
                            window.location.href = "/client/project/deleteproductions/" + id;
                            Swal.fire({
                            title: "Deleted!",
                            text: "Production has been deleted.",
                            icon: "success"
                            });
                        }});

                    }
                </script>
                <a href="/client/details/{{$projects[0]->ClientName->id}}"><button class="btn btn-outline-primary">BACK</button></a>
            </div>
            </div>





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

