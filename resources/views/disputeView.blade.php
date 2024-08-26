@extends($theme == 1 ? 'layouts.darktheme' : 'layouts.app')

@section($theme == 1 ? 'maincontent1' : 'maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Client</a>
            <span class="breadcrumb-item active">Projects</span>
            <span class="breadcrumb-item active">Payments</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Dispute:</h4>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
            <button class="btn btn-outline-primary">Client Name: {{$dispute[0]->disputeclientName->name}}</button>
              <button class="btn btn-outline-primary">Project Name:  {{$dispute[0]->disputeprojectName->name}} </button>
              @if (isset($dispute[0]->disputeEmployeeName->name) and $dispute[0]->disputeEmployeeName->name !== null)
              <button class="btn btn-outline-primary">Project Manager: {{$dispute[0]->disputeEmployeeName->name}}</button>
              @else
              <button class="btn btn-outline-danger">Project Manager: User Deleted</button>
              @endif

              {{-- <button class="btn btn-outline-primary">Project Manager: {{$qa_data[0]->Project_ProjectManager->name}}</button> --}}
              <button class="btn btn-outline-primary">Brand: {{$dispute[0]->disputebrandName->name}}</button>
              <br><br>

            <table  id="datatable1"  style="width:100%"  class="table-dark-wrapper table-hover">
                <tr>
                  <th>Dispute Date:</th>
                  <td>{{$dispute[0]->dispute_Date}}</td>
                </tr>
                <tr>
                  <th>Disputed Amount:</th>
                  <td>${{$dispute[0]->disputedAmount}}</td>
                </tr>
                <tr>
                    <th>Dispute Reason:</th>
                    <td>{{$dispute[0]->disputeReason}}</td>
                </tr>
            </table>






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
