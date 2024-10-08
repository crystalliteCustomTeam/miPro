@extends($theme == 1 ? 'layouts.darktheme' : 'layouts.app')

@section($theme == 1 ? 'maincontent1' : 'maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Client</a>
            <span class="breadcrumb-item active">Project</span>
            <span class="breadcrumb-item active">QA</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>QAFORMS</h4>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">

            <div class="row">
              <div class="col-12 mt-4">
                <table id="datatable1"  class="table-dark-wrapper table-hover">
                    <thead>
                        <th>Client</th>
                        <th>Brand</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Summery</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                      @foreach($qa_forms as $qafrom)
                      <tr>
                        <td>{{ $qafrom->Client_Name->name }}</td>
                        <td>{{ $qafrom->Brand_Name->name }}</td>
                        <td>{{ $qafrom->status }}</td>
                        <td>{{ $qafrom->created_at }}</td>
                        <td>{{ $qafrom->Refund_Request_summery }}</td>
                        <td>
                        <div class="btn-group">
                            <a href="/forms/editnewqaform/{{$qafrom->id}}"><button class="btn btn-info btn-sm"><img src="https://cdn-icons-png.flaticon.com/16/10140/10140139.png" alt="" style="filter: invert(1);" > Edit </button></a>
                            <a href="/client/project/qaform/view/{{$qafrom->id}}"><button class="btn btn-success btn-sm"><img src="https://cdn-icons-png.flaticon.com/16/3094/3094851.png" alt="" style="filter: invert(1);" > View </button></a>
                            {{-- <a href="/forms/deletenewqaform/{{$qafrom->id}}"><button class="btn btn-danger btn-sm"><img src="https://cdn-icons-png.flaticon.com/16/10140/10140139.png" alt="" style="filter: invert(1);" > Delete </button></a> --}}
                            <a href="#"  onclick="myConfirm('{{ $qafrom->id }}')"><button class="btn btn-danger btn-sm"><img src="https://cdn-icons-png.flaticon.com/16/1214/1214428.png" alt="" style="filter: invert(1);" > Delete </button></a>
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
                                window.location.href = "/forms/deletenewqaform/" + id;
                                Swal.fire({
                                title: "Deleted!",
                                text: "QAFORM has been deleted.",
                                icon: "success"
                                });
                            }});

                        }
                    </script>
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


