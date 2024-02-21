@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Client</a>
            <span class="breadcrumb-item active">Projects</span>
            <span class="breadcrumb-item active">QA</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Quality Assautance</h4>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
            <button class="btn btn-outline-primary">Client Name: {{$qa_data[0]->Client_Name->name}}</button>
              <button class="btn btn-outline-primary">Project Name:  {{$qa_data[0]->Project_Name->name}} </button>
              <button class="btn btn-outline-primary">Project Manager: {{$qa_data[0]->Project_ProjectManager->name}}</button>
              <button class="btn btn-outline-primary">Brand: {{$qa_data[0]->Brand_Name->name}}</button>
              <br><br>

            @if ( $qa_data[0]->status != "Not Started Yet")

            <table  id="datatable1"  style="width:70%"  class="table-dark table-hover">
                <tr>
                  <th>Department:</th>
                  <td>{{$Proj_Prod[0]->DepartNameinProjectProduction->name}}</td>
                </tr>
                <tr>
                  <th>Assignee:</th>
                  <td>{{$Proj_Prod[0]->EmployeeNameinProjectProduction->name}}</td>
                </tr>
                <tr>
                    <th>Issue:</th>
                    @php
                    $qa_issues = json_decode($qa_meta[0]->issues)
                    @endphp
                    <td>
                        @foreach ($qa_issues as $issue)
                            <ul>
                                <li>{{$issue}}</li>
                            </ul>
                        @endforeach
                    </td>
                  </tr>
                  <tr>
                    <th>Description:</th>
                    <td>{{$qa_meta[0]->Description_of_issue}}</td>
                  </tr>
                <tr>
                  <th>Status:</th>
                  <td>{{$qa_data[0]->status}}</td>
                </tr>
                <tr>
                    <th>Last Communication:</th>
                    <td>{{$qa_data[0]->last_communication}}</td>
                </tr>
                <tr>
                    <th>Medium of Communication:</th>
                    @php
                    $medium = json_decode($qa_data[0]->medium_of_communication)
                    @endphp
                    <td>
                    @foreach ($medium as $item)
                            <ul>
                                <li>{{$item}}</li>
                            </ul>
                    @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Client Satisfaction:</th>
                    <td>{{$qa_data[0]->client_satisfaction}}</td>
                </tr>
                <tr>
                    <th>Summery:</th>
                    <td>{{$qa_data[0]->Refund_Request_summery}}</td>
                </tr>
                <tr>
                    <th>QA Person:</th>
                    <td>{{$qa_data[0]->QA_Person->name}}</td>
                </tr>

                @if ($qa_data[0]->Refund_Request_Attachment != null)

                <tr>
                    <th>Refund Attachment:</th>
                    {{-- <td>{{$qa_data[0]->Refund_Request_Attachment}}</td> --}}
                    <td><a target="_blank" href="{{  Storage::url( $qa_data[0]->Refund_Request_Attachment ) }}">DOWNLOAD</a></td>
                </tr>

                @endif

                @if ( $qa_meta[0]->evidence != null)

                <tr>
                    <th>Issue Evidence:</th>
                    {{-- <td>{{$qa_meta[0]->evidence}}</td> --}}
                    <td><a target="_blank" href="{{  Storage::url( $qa_meta[0]->evidence ) }}">DOWNLOAD</a></td>

                </tr>

                @endif
              </table>

            @else
            <table  id="datatable1"  style="width:70%" class="table-dark table-hover" >
                <tr>
                  <th>Department:</th>
                  <td>--</td>
                </tr>
                <tr>
                  <th>Assignee:</th>
                  <td>--</td>
                </tr>
                <tr>
                    <th>Issue:</th>
                    <td>--</td>
                  </tr>
                  <tr>
                    <th>Description:</th>
                    <td>--</td>
                  </tr>
                <tr>
                  <th>Status:</th>
                  <td>{{$qa_data[0]->status}}</td>
                </tr>
                <tr>
                    <th>Last Communication:</th>
                    <td>{{$qa_data[0]->last_communication}}</td>
                </tr>
                <tr>
                    <th>Medium of Communication:</th>
                    @php
                    $medium = json_decode($qa_data[0]->medium_of_communication)
                    @endphp
                    <td>
                    @foreach ($medium as $item)
                            <ul>
                                <li>{{$item}}</li>
                            </ul>
                    @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Client Satisfaction:</th>
                    <td>--</td>
                </tr>
                <tr>
                    <th>Summery:</th>
                    <td>--</td>
                </tr>
                <tr>
                    <th>QA Person:</th>
                    <td>{{$qa_data[0]->QA_Person->name}}</td>
                </tr>
              </table>

              @endif
              <a href="/client/project/qareport/{{$qa_data[0]->Project_Name->id}}"><button class="btn btn-outline-primary">BACK</button></a>






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
