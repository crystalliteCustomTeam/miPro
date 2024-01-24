@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Company</a>
            <span class="breadcrumb-item active">Manage Companies</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Companies List</h4>
          </div>
        </div><!-- d-flex -->
  
        <div class="br-pagebody">
          <div class="br-section-wrapper">
          
            
           <table id="datatable1" class="table-dark table-hover">
              <thead>
                <tr role="row">
                  <th class="wd-15p sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="First name: activate to sort column descending">Name</th>
                  <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Last name: activate to sort column ascending">Email</th>
                  <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">Tel</th>
                  <th class="wd-20p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 278px;" aria-label="Position: activate to sort column ascending">Owner</th>
                  <th class="wd-15p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Start date: activate to sort column ascending">Website</th>
                  <th class="wd-10p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 203px;" aria-label="Salary: activate to sort column ascending">Action</th>
                  <th class="wd-25p sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" style="width: 353px; display: none;" aria-label="E-mail: activate to sort column ascending">Address</th>
                </tr>
              </thead>
              <tbody>
              
                @foreach($companies as $company)
                <tr role="row" class="odd">
                  <td tabindex="0" class="sorting_1">{{ $company->name }}</td>
                  <td>{{ $company->email }}</td>
                  <td>{{ $company->tel }}</td>
                  <td>{{ $company->brandOwnerName->name }}</td>
                  <td>{{ $company->website }}</td>
                  <td>
                      <div class="button-group">
                        <button class="btn btn-sm btn-info">Edit</button>
                        <button class="btn btn-sm btn-danger">Delete</button>
                        <a href="/setupdepartments/{{ $company->id }}" class="btn btn-sm btn-primary">Add Department</a>
                      </div>
                  </td>
                  <td style="display: none;">{{ $company->address }}</td>
                </tr>
                @endforeach
                
              </tbody>
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