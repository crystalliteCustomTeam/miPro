@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">Brand</a>
            <span class="breadcrumb-item active">Set Up Brand</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Set Up Brand</h4>
            <p class="mg-b-0">Brand</p>
          </div>
        </div><!-- d-flex -->
  
        <div class="br-pagebody">
          <div class="br-section-wrapper">
           <form action="#" method="POST">
            @csrf
            
            <div class="row">
            
                <div class="col-3">
                    <label for="">Basecamp Link</label>
                    <input type="url" name="Basecamp" class="form-control" required>
                </div>
                <div class="col-3">
                    <label for=""> Brand: </label>
                    <input type="text" name="brand" required class="form-control">
                </div>
                <div class="col-3">
                    <label for="">Email/Domain </label>
                    <input type="email" name="emailordomain" required class="form-control">
                </div>
                <div class="col-3">
                  <label for="">Last communication with client </label>
                  <input type="date" name="lastcommunication" required class="form-control">
                </div>
                <div class="col-3">
                    <label for="">Medium of communication </label><br>
                    <input type="checkbox" id="calls" name="calls" value="calls" required >
                    <label for="calls">calls</label><br>
                    <input type="checkbox" id="messages" name="messages" value="messages" required >
                    <label for="messages">messages</label><br>
                    <input type="checkbox" id="basecamp" name="basecamp" value="basecamp" required >
                    <label for="basecamp">basecamp</label><br>
                    <input type="checkbox" id="email" name="email" value="email" required >
                    <label for="email">email</label><br>
                    <input type="checkbox" id="Whatsapp" name="Whatsapp" value="Whatsapp" required >
                    <label for="Whatsapp">Whatsapp</label><br> 
                </div>
                <div class="col-3">
                    <label for="">Refund Requested</label><br>
                    <input type="radio" id="yes" name="Refund_Requested" value="yes">
                    <label for="yes">Yes</label><br>
                    <input type="radio" id="no" name="Refund_Requested" value="no">
                    <label for="no">No</label><br>
                  </div>
                <div class="col-3">
                  <label for="">Refund Request Attachment </label>
                  <input type="file" name="Refund_Request_Attachment" required class="form-control">
                </div>
                <div class="col-3">
                    <label for=""> Status </label><br>
                    <input type="radio" id="dispute" name="status" value="dispute">
                    <label for="dispute">Dispute</label><br>
                    <input type="radio" id="refund" name="status" value="refund">
                    <label for="refund">Refund</label><br>
                    <input type="radio" id="on_going" name="status" value="On Going">
                    <label for="on_going">On Going</label>
                </div>

            </div>
            {{-- <div class="row mt-3">
                <div class="col-3">
                    <label for="">Address </label>
                    <input type="text" name="address" required class="form-control">
                </div>
                <div class="col-4">
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
            </div> --}}
           </form>
  
       
            
          
            




<!--Editing-->
  
          </div><!-- br-section-wrapper -->
        </div><!-- br-pagebody -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
           <form action="#" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-3">
                    <label for="">Status of Editting</label><br>
                    <input type="radio" id="in_process" name="Editting_Status_of_Editting" value="in process">
                    <label for="in_process">In Process</label><br>
                    <input type="radio" id="Completed" name="Editting_Status_of_Editting" value="Completed">
                    <label for="Completed">Completed</label><br>
                    <input type="radio" id="Not_Applicable" name="Editting_Status_of_Editting" value="Not Applicable">
                    <label for="Not_Applicable">Not Applicable</label><br>
                    <input type="radio" id="Not_Started_Yet" name="Editting_Status_of_Editting" value="Not Started Yet">
                    <label for="Not_Started_Yet">Not Started Yet</label><br>
                    <input type="radio" id="Waiting_for_Client_Response" name="Editting_Status_of_Editting" value="Waiting for Client Response">
                    <label for="Waiting_for_Client_Response">Waiting for Client Response</label><br>
                  </div>
                <div class="col-3">
                    <label for=""> Editing Issue </label><br>
                    <input type="checkbox" id="Question_Type" name="Question_Type" value="Question Type" required >
                    <label for="Question_Type">Question Type</label><br>
                    <input type="checkbox" id="Editing_Issue" name="Editing_Issue" value="Editing Issue" required >
                    <label for="Editing_Issue">Editing Issue</label><br>
                    <input type="checkbox" id="Typos" name="Editing_Typos" value="Typos" required >
                    <label for="Typos">Typos</label><br>
                    <input type="checkbox" id="Writing_Weaknesses" name="Editing_Writing_Weaknesses" value="Writing Weaknesses" required >
                    <label for="Writing_Weaknesses">Writing Weaknesses</label><br>
                    <input type="checkbox" id="Word_Omissions" name="Editing_Word_Omissions" value="Word Omissions" required >
                    <label for="Word_Omissions">Word Omissions</label><br>
                    <input type="checkbox" id="Grammatical" name="Editing_Grammatical" value="Grammatical" required >
                    <label for="Grammatical">Grammatical</label><br>
                    <input type="checkbox" id="Going_Good" name="Editing_Going_Good" value="Going_Good" required >
                    <label for="Going_Good">Going Good</label><br>
                    <input type="checkbox" id="Understanding_issue" name="Editing_Understanding_issue" value="Understanding issue" required >
                    <label for="Understanding_issue">Understanding issue</label><br>
                </div>
                <div class="col-3">
                    <label for="">Description of issue</label>
                    <input type="text" name="Editing_Description_of_issue" required class="form-control">
                </div>
                <div class="col-3">
                    <label for="">Timely Delivered</label><br>
                    <input type="radio" id="yes" name="Editing_Timely_Delivered" value="yes">
                    <label for="yes">Yes</label><br>
                    <input type="radio" id="no" name="Editing_Timely_Delivered" value="no">
                    <label for="no">No</label><br>
                </div>
                <div class="col-3">
                    <label for="">Work Assinged</label><br>
                    <input type="radio" id="yes" name="Editing_Work_Assinged" value="yes">
                    <label for="yes">Yes</label><br>
                    <input type="radio" id="no" name="Editing_Work_Assinged" value="no">
                    <label for="no">No</label><br>
                </div>
                <div class="col-3">
                  <label for="">Content Creator</label>
                  <input type="text" name="Editing_Content_Creator" required class="form-control">
                </div>
                <div class="col-3">
                    <label for="">Editing Evidence(if any issue) </label>
                    <input type="file" name="Editing_Evidence" required class="form-control">
                  </div>
            </div>
           </form>













<!-- Ghost Writing -->

</div><!-- br-section-wrapper -->
</div><!-- br-pagebody -->

<div class="br-pagebody">
  <div class="br-section-wrapper">
   <form action="#" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-3">
            <div class="col-3">
                <label for="">Status of Ghost Writing</label><br>
                <input type="radio" id="in_process" name="Ghost_Writing_Status value="in process">
                <label for="in_process">In Process</label><br>
                <input type="radio" id="Completed" name="Ghost_Writing_Status" value="Completed">
                <label for="Completed">Completed</label><br>
                <input type="radio" id="Not_Applicable" name="Ghost_Writing_Status" value="Not Applicable">
                <label for="Not_Applicable">Not Applicable</label><br>
                <input type="radio" id="Not_Started_Yet" name="Ghost_Writing_Status" value="Not Started Yet">
                <label for="Not_Started_Yet">Not Started Yet</label><br>
                <input type="radio" id="Waiting_for_Client_Response" name="Ghost_Writing_Status" value="Waiting for Client Response">
                <label for="Waiting_for_Client_Response">Waiting for Client Response</label><br>
              </div>
        <div class="col-3">
            <label for=""> Ghost Writing Issue </label><br>
            <input type="checkbox" id="Writing_issue" name="Writing_issue" value="Writing issue" required >
            <label for="Writing_issue">Writing issue</label><br>
            <input type="checkbox" id="Grammatical_Issue" name="Grammatical_Issue" value="Grammatical Issue" required >
            <label for="Grammatical_Issue">Grammatical Issue</label><br>
            <input type="checkbox" id="Typos" name="Typos" value="Typos" required >
            <label for="Typos">Typos</label><br>
            <input type="checkbox" id="Understanding_Issue" name="Understanding_Issue" value="Understanding Issue" required >
            <label for="Understanding_Issue">Understanding Issue</label><br>
            <input type="checkbox" id="Going_Good" name="Going_Good" value="Going Good" required >
            <label for="Going_Good">Going Good </label><br>
        </div>
        <div class="col-3">
            <label for="">Description of issue </label>
            <input type="text" name="ghost_writing_Description_of_issue" required class="form-control">
        </div>
        <div class="col-3">
            <label for="">Timely Delivered</label><br>
            <input type="radio" id="yes" name="Ghost_Writing_Timely_Delivered" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="Ghost_Writing_Timely_Delivered" value="no">
            <label for="no">No</label><br>
        </div>
        <div class="col-3">
            <label for="">Work Assinged</label><br>
            <input type="radio" id="yes" name="Ghost_Writing_Work_Assinged" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="Ghost_Writing_Work_Assinged" value="no">
            <label for="no">No</label><br>
        </div>
        <div class="col-3">
            <label for="">Number of Chapters </label>
            <input type="number" name="Number_of_Chapters" required class="form-control">
          </div>
          <div class="col-3">
            <label for="">Writer</label>
            <input type="text" name="Ghost_Writing_Writer" required class="form-control">
          </div>
          <div class="col-3">
              <label for="">Editing Evidence(if any issue) </label>
              <input type="file" name="Ghost_Writing_Evidence" required class="form-control">
            </div>
    </div>
   </form>







<!-- Illustration -->

</div><!-- br-section-wrapper -->
</div><!-- br-pagebody -->

<div class="br-pagebody">
  <div class="br-section-wrapper">
   <form action="#" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-3">
            <label for="">Status of Illustration</label><br>
            <input type="radio" id="in_process" name="Illustration_Status" value="in process">
            <label for="in_process">In Process</label><br>
            <input type="radio" id="Completed" name="Illustration_Status value="Completed">
            <label for="Completed">Completed</label><br>
            <input type="radio" id="Not_Applicable" name="Illustration_Status" value="Not Applicable">
            <label for="Not_Applicable">Not Applicable</label><br>
            <input type="radio" id="Not_Started_Yet" name="Illustration_Status" value="Not Started Yet">
            <label for="Not_Started_Yet">Not Started Yet</label><br>
            <input type="radio" id="Waiting_for_Client_Response" name="Illustration_Status" value="Waiting for Client Response">
            <label for="Waiting_for_Client_Response">Waiting for Client Response</label><br>
          </div>
        <div class="col-3">
            <label for=""> Illustration Issue </label><br>
            <input type="checkbox" id="Global" name="global" value="global" required >
            <label for="Global">Illustration issue</label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">Character Issue</label><br>
            <input type="checkbox" id="Global" name="global" value="global" required >
            <label for="Global">Simple issue</label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">Timely Update</label><br>
            <input type="checkbox" id="Global" name="global" value="global" required >
            <label for="Global">Understanding Issue</label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">Going Good </label><br>
        </div>
        <div class="col-3">
            <label for="">Description of issue </label>
            <input type="text" name="leadplatform" required class="form-control">
        </div>
        <div class="col-3">
            <label for="">Timely Delivered</label>
            <input type="radio" id="yes" name="Refund_Requested" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="Refund_Requested" value="no">
            <label for="no">No</label><br>
        </div>
        <div class="col-3">
            <label for="">Work Assinged</label>
            <input type="radio" id="yes" name="Refund_Requested" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="Refund_Requested" value="no">
            <label for="no">No</label><br>
        </div>
        <div class="col-3">
          <label for="">Design Team</label>
          <input type="text" name="leadplatform" required class="form-control">
        </div>
        <div class="col-3">
            <label for="">Design Evidence(if any issue) </label>
            <input type="file" name="leadplatform" required class="form-control">
          </div>
    </div>
   </form>

  
       






<!-- Publishing --> 


</div><!-- br-section-wrapper -->
</div><!-- br-pagebody -->

<div class="br-pagebody">
  <div class="br-section-wrapper">
   <form action="#" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-3">
            <label for=""> Status Of Publishing </label>
            <input type="checkbox" id="SMM" name="SMM" value="SMM"  >
            <label for="SMM">In Process</label><br>
            <input type="checkbox" id="GMB" name="GMB" value="GMB"  >
            <label for="GMB">Completed</label><br>
            <input type="checkbox" id="adword" name="adword" value="adword"  >
            <label for="adword">Not Applicable</label>  
            <input type="checkbox" id="Facebook" name="Facebook" value="Facebook"  >
            <label for="Facebook">Not Started Yet</label>  
            <input type="checkbox" id="Website" name="Website" value="Website"  >
            <label for="Website">Waiting for Client Response</label>  
          </div>
          <div class="col-3">
            <label for="">Book Cover Status </label>
            <input type="checkbox" id="SMM" name="SMM" value="SMM"  >
            <label for="SMM">Approved</label><br>
            <input type="checkbox" id="GMB" name="GMB" value="GMB"  >
            <label for="GMB">Rejected</label><br>
            <input type="checkbox" id="adword" name="adword" value="adword"  >
            <label for="adword">In Progress</label>  
            <input type="checkbox" id="Facebook" name="Facebook" value="Facebook"  >
            <label for="Facebook">Not Started Yet</label>  
          </div>
        <div class="col-3">
            <label for=""> Publishing Issue </label><br>
            <input type="checkbox" id="Global" name="global" value="global" required >
            <label for="Global">Illustration issue</label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">Character Issue</label><br>
            <input type="checkbox" id="Global" name="global" value="global" required >
            <label for="Global">Simple issue</label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">Timely Update</label><br>
            <input type="checkbox" id="Global" name="global" value="global" required >
            <label for="Global">Understanding Issue</label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">Going Good </label><br>
        </div>
        <div class="col-3">
            <label for=""> Platform</label><br>
            <input type="checkbox" id="Global" name="global" value="global" required >
            <label for="Global">Amazon</label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">Barnes & Nobles</label><br>
            <input type="checkbox" id="Global" name="global" value="global" required >
            <label for="Global">Ingram Spark</label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">Lulu</label><br>
            <input type="checkbox" id="Global" name="global" value="global" required >
            <label for="Global">Kobo</label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">Walmart </label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">E-bay</label><br>
            <input type="checkbox" id="Global" name="global" value="global" required >
            <label for="Global">Google Book</label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">Apple Book </label><br>
        </div>
        <div class="col-3">
            <label for="">Description of issue </label>
            <input type="text" name="leadplatform" required class="form-control">
        </div>
        <div class="col-3">
            <label for="">Timely Delivered</label>
            <input type="radio" id="yes" name="Refund_Requested" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="Refund_Requested" value="no">
            <label for="no">No</label><br>
        </div>
        <div class="col-3">
            <label for="">Work Assinged</label>
            <input type="radio" id="yes" name="Refund_Requested" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="Refund_Requested" value="no">
            <label for="no">No</label><br>
        </div>
        <div class="col-3">
          <label for="">Designer</label>
          <input type="text" name="leadplatform" required class="form-control">
        </div>
        <div class="col-3">
            <label for="">Publisher</label>
            <input type="text" name="leadplatform" required class="form-control">
          </div>
        <div class="col-3">
            <label for="">Publishing Evidence(if any issue) </label>
            <input type="file" name="leadplatform" required class="form-control">
          </div>
    </div>
   </form>    
          
            















   <!-- Standard Marketing for 3 month --> 
</div><!-- br-section-wrapper -->
</div><!-- br-pagebody -->

<div class="br-pagebody">
  <div class="br-section-wrapper">
   <form action="#" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-3">
            <label for=""> Status  3 month</label>
            <input type="checkbox" id="SMM" name="SMM" value="SMM"  >
            <label for="SMM">In Process</label><br>
            <input type="checkbox" id="GMB" name="GMB" value="GMB"  >
            <label for="GMB">Completed</label><br>
            <input type="checkbox" id="adword" name="adword" value="adword"  >
            <label for="adword">Not Applicable</label>  
            <input type="checkbox" id="Facebook" name="Facebook" value="Facebook"  >
            <label for="Facebook">Not Started Yet</label>  
            <input type="checkbox" id="Website" name="Website" value="Website"  >
            <label for="Website">Waiting for Client Response</label>  
          </div>
          <div class="col-3">
            <label for="">Services </label>
            <input type="checkbox" id="SMM" name="SMM" value="SMM"  >
            <label for="SMM">Design</label><br>
            <input type="checkbox" id="GMB" name="GMB" value="GMB"  >
            <label for="GMB">Development</label><br>
            <input type="checkbox" id="adword" name="adword" value="adword"  >
            <label for="adword">SMM</label>  
            <input type="checkbox" id="Facebook" name="Facebook" value="Facebook"  >
            <label for="Facebook">SEO</label>  
          </div>
    </div>
   </form> 
   
   






   
   <!-- Standard Marketing for 6 month --> 
</div><!-- br-section-wrapper -->
</div><!-- br-pagebody -->

<div class="br-pagebody">
  <div class="br-section-wrapper">
   <form action="#" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-3">
            <label for=""> Status of 6 month</label>
            <input type="checkbox" id="SMM" name="SMM" value="SMM"  >
            <label for="SMM">In Process</label><br>
            <input type="checkbox" id="GMB" name="GMB" value="GMB"  >
            <label for="GMB">Completed</label><br>
            <input type="checkbox" id="adword" name="adword" value="adword"  >
            <label for="adword">Not Applicable</label>  
            <input type="checkbox" id="Facebook" name="Facebook" value="Facebook"  >
            <label for="Facebook">Not Started Yet</label>  
            <input type="checkbox" id="Website" name="Website" value="Website"  >
            <label for="Website">Waiting for Client Response</label>  
          </div>
          <div class="col-3">
            <label for="">Services </label>
            <input type="checkbox" id="SMM" name="SMM" value="SMM"  >
            <label for="SMM">Design</label><br>
            <input type="checkbox" id="GMB" name="GMB" value="GMB"  >
            <label for="GMB">Development</label><br>
            <input type="checkbox" id="adword" name="adword" value="adword"  >
            <label for="adword">SMM</label>  
            <input type="checkbox" id="Facebook" name="Facebook" value="Facebook"  >
            <label for="Facebook">SEO</label>  
          </div>
    </div>
   </form> 
  
















   
<!-- Design --> 


</div><!-- br-section-wrapper -->
</div><!-- br-pagebody -->

<div class="br-pagebody">
  <div class="br-section-wrapper">
   <form action="#" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-3">
            <label for=""> Status Of Desing </label>
            <input type="checkbox" id="SMM" name="SMM" value="SMM"  >
            <label for="SMM">In Process</label><br>
            <input type="checkbox" id="GMB" name="GMB" value="GMB"  >
            <label for="GMB">Completed</label><br>
            <input type="checkbox" id="adword" name="adword" value="adword"  >
            <label for="adword">Not Applicable</label>  
            <input type="checkbox" id="Facebook" name="Facebook" value="Facebook"  >
            <label for="Facebook">Not Started Yet</label>  
            <input type="checkbox" id="Website" name="Website" value="Website"  >
            <label for="Website">Waiting for Client Response</label>  
          </div>
        <div class="col-3">
            <label for=""> Desing Issue </label><br>
            <input type="checkbox" id="Global" name="global" value="global" required >
            <label for="Global">SMM Post Desing</label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">Video Trailer</label><br>
            <input type="checkbox" id="Global" name="global" value="global" required >
            <label for="Global">Website Mockup</label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">News Letter Desing</label><br>
        </div>
        <div class="col-3">
            <label for="">Description of issue </label>
            <input type="text" name="leadplatform" required class="form-control">
        </div>
        <div class="col-3">
            <label for="">Timely Delivered</label>
            <input type="radio" id="yes" name="Refund_Requested" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="Refund_Requested" value="no">
            <label for="no">No</label><br>
        </div>
        <div class="col-3">
            <label for="">Work Assinged</label>
            <input type="radio" id="yes" name="Refund_Requested" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="Refund_Requested" value="no">
            <label for="no">No</label><br>
        </div>
        <div class="col-3">
          <label for="">Designer</label>
          <input type="text" name="leadplatform" required class="form-control">
        </div>
        <div class="col-3">
            <label for="">Designer</label>
            <input type="text" name="leadplatform" required class="form-control">
          </div>
        <div class="col-3">
            <label for="">Design Evidence(if any issue) </label>
            <input type="file" name="leadplatform" required class="form-control">
          </div>
    </div>
   </form>    










<!-- Development --> 


</div><!-- br-section-wrapper -->
</div><!-- br-pagebody -->

<div class="br-pagebody">
  <div class="br-section-wrapper">
   <form action="#" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-3">
            <label for=""> Status Of Development </label>
            <input type="checkbox" id="SMM" name="SMM" value="SMM"  >
            <label for="SMM">In Process</label><br>
            <input type="checkbox" id="GMB" name="GMB" value="GMB"  >
            <label for="GMB">Completed</label><br>
            <input type="checkbox" id="adword" name="adword" value="adword"  >
            <label for="adword">Not Applicable</label>  
            <input type="checkbox" id="Facebook" name="Facebook" value="Facebook"  >
            <label for="Facebook">Not Started Yet</label>  
            <input type="checkbox" id="Website" name="Website" value="Website"  >
            <label for="Website">Waiting for Client Response</label>  
          </div>
          <div class="col-3">
            <label for=""> Web Development </label>
            <input type="checkbox" id="SMM" name="SMM" value="SMM"  >
            <label for="SMM">Word Press</label><br>
            <input type="checkbox" id="GMB" name="GMB" value="GMB"  >
            <label for="GMB">Shopify</label><br>
            <input type="checkbox" id="adword" name="adword" value="adword"  >
            <label for="adword">Custom</label>  
            <input type="checkbox" id="Facebook" name="Facebook" value="Facebook"  >
            <label for="Facebook">Magento</label>  
            <input type="checkbox" id="Website" name="Website" value="Website"  >
            <label for="Website">Go daddy</label>  
          </div>
        <div class="col-3">
            <label for=""> Development Issue </label><br>
            <input type="checkbox" id="Global" name="global" value="global" required >
            <label for="Global">Content Alignment</label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">Logo Alignment</label><br>
            <input type="checkbox" id="Global" name="global" value="global" required >
            <label for="Global">Theme issue'optimisation issue</label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">Mobile responseviness</label><br>
            <input type="checkbox" id="Global" name="global" value="global" required >
            <label for="Global">General issue</label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">Going Good </label><br>
        </div>
        <div class="col-3">
            <label for="">Description of issue </label>
            <input type="text" name="leadplatform" required class="form-control">
        </div>
        <div class="col-3">
            <label for="">Timely Delivered</label>
            <input type="radio" id="yes" name="Refund_Requested" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="Refund_Requested" value="no">
            <label for="no">No</label><br>
        </div>
        <div class="col-3">
            <label for="">Work Assinged</label>
            <input type="radio" id="yes" name="Refund_Requested" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="Refund_Requested" value="no">
            <label for="no">No</label><br>
        </div>
        <div class="col-3">
          <label for="">Developer</label>
          <input type="text" name="leadplatform" required class="form-control">
        </div>
        <div class="col-3">
            <label for="">Development Evidence(if any issue) </label>
            <input type="file" name="leadplatform" required class="form-control">
          </div>
    </div>
   </form>    











<!-- SEO --> 


</div><!-- br-section-wrapper -->
</div><!-- br-pagebody -->

<div class="br-pagebody">
  <div class="br-section-wrapper">
   <form action="#" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-3">
            <label for=""> Status Of SEO </label>
            <input type="checkbox" id="SMM" name="SMM" value="SMM"  >
            <label for="SMM">In Process</label><br>
            <input type="checkbox" id="GMB" name="GMB" value="GMB"  >
            <label for="GMB">Completed</label><br>
            <input type="checkbox" id="adword" name="adword" value="adword"  >
            <label for="adword">Not Applicable</label>  
            <input type="checkbox" id="Facebook" name="Facebook" value="Facebook"  >
            <label for="Facebook">Not Started Yet</label>  
            <input type="checkbox" id="Website" name="Website" value="Website"  >
            <label for="Website">Waiting for Client Response</label>  
          </div>
        <div class="col-3">
            <label for=""> Publishing Issue </label><br>
            <input type="checkbox" id="Global" name="global" value="global" required >
            <label for="Global">Article</label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">Blogs</label><br>
            <input type="checkbox" id="Global" name="global" value="global" required >
            <label for="Global">PR Release</label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">Author Center</label><br>
            <input type="checkbox" id="Global" name="global" value="global" required >
            <label for="Global">Creating Media Account</label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">Q&A Session </label><br>
            <input type="checkbox" id="Global" name="global" value="global" required >
            <label for="Global">News Letter</label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">Reach BookClub</label><br>
            <input type="checkbox" id="Global" name="global" value="global" required >
            <label for="Global">Influencer Outreach</label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">Amazon Ads Campaign </label><br>
        </div>
        <div class="col-3">
            <label for="">Description of issue </label>
            <input type="text" name="leadplatform" required class="form-control">
        </div>
        <div class="col-3">
            <label for="">Timely Delivered</label>
            <input type="radio" id="yes" name="Refund_Requested" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="Refund_Requested" value="no">
            <label for="no">No</label><br>
        </div>
        <div class="col-3">
            <label for="">Work Assinged</label>
            <input type="radio" id="yes" name="Refund_Requested" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="Refund_Requested" value="no">
            <label for="no">No</label><br>
        </div>
        <div class="col-3">
          <label for="">SEO Person</label>
          <input type="text" name="leadplatform" required class="form-control">
        </div>
        <div class="col-3">
            <label for="">SEO Team Lead</label>
            <input type="text" name="leadplatform" required class="form-control">
          </div>
        <div class="col-3">
            <label for="">SEO Evidence(if any issue) </label>
            <input type="file" name="leadplatform" required class="form-control">
          </div>
    </div>
   </form>    
















   
<!-- SMM --> 


</div><!-- br-section-wrapper -->
</div><!-- br-pagebody -->

<div class="br-pagebody">
  <div class="br-section-wrapper">
   <form action="#" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-3">
            <label for=""> Status Of SMM </label>
            <input type="checkbox" id="SMM" name="SMM" value="SMM"  >
            <label for="SMM">In Process</label><br>
            <input type="checkbox" id="GMB" name="GMB" value="GMB"  >
            <label for="GMB">Completed</label><br>
            <input type="checkbox" id="adword" name="adword" value="adword"  >
            <label for="adword">Not Applicable</label>  
            <input type="checkbox" id="Facebook" name="Facebook" value="Facebook"  >
            <label for="Facebook">Not Started Yet</label>  
            <input type="checkbox" id="Website" name="Website" value="Website"  >
            <label for="Website">Waiting for Client Response</label>  
          </div>
        <div class="col-3">
            <label for=""> SMM Issue </label><br>
            <input type="checkbox" id="Global" name="global" value="global" required >
            <label for="Global">Posting</label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">SMM Post Content</label><br>
            <input type="checkbox" id="Global" name="global" value="global" required >
            <label for="Global">Good Read Account</label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">Amazon Campaign</label><br>
            <input type="checkbox" id="Global" name="global" value="global" required >
            <label for="Global">Creating Social Media Account</label><br>
            <input type="checkbox" id="Nationwide" name="nationwide" value="nationwide" required >
            <label for="Nationwide">Q & A sessions</label><br>
        </div>
        <div class="col-3">
            <label for="">Description of issue </label>
            <input type="text" name="leadplatform" required class="form-control">
        </div>
        <div class="col-3">
            <label for="">Timely Delivered</label>
            <input type="radio" id="yes" name="Refund_Requested" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="Refund_Requested" value="no">
            <label for="no">No</label><br>
        </div>
        <div class="col-3">
            <label for="">Work Assinged</label>
            <input type="radio" id="yes" name="Refund_Requested" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="Refund_Requested" value="no">
            <label for="no">No</label><br>
        </div>
        <div class="col-3">
            <label for="">SMM person</label>
            <input type="text" name="leadplatform" required class="form-control">
          </div>
        <div class="col-3">
            <label for="">SMM Evidence(if any issue) </label>
            <input type="file" name="leadplatform" required class="form-control">
          </div>
    </div>
   </form>    









   <!--Remarks-->
  
</div><!-- br-section-wrapper -->
</div><!-- br-pagebody -->

<div class="br-pagebody">
  <div class="br-section-wrapper">
   <form action="#" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-3">
            <label for=""> Client Satisfaction Level </label>
            <input type="radio" id="dispute" name="status" value="dispute">
            <label for="dispute">Extremely Satisfied</label><br>
            <input type="radio" id="refund" name="status" value="refund">
            <label for="refund">Somewhat Satisfied</label><br>
            <input type="radio" id="on_going" name="status" value="On Going">
            <label for="on_going">Neither Satisfied nor Dissatisfied</label>
            <input type="radio" id="refund" name="status" value="refund">
            <label for="refund">Somewhat Dissatisfied</label><br>
            <input type="radio" id="on_going" name="status" value="On Going">
            <label for="on_going">Extremely Dissatisfied</label>
        </div>
        <div class="col-3">
            <label for="">Summery </label>
            <input type="text" name="Refund_Request_Attachment" required class="form-control">
          </div>
          <div class="col-3">
            <label for=""> Refund & Dispute Expected </label>
            <input type="radio" id="dispute" name="status" value="dispute">
            <label for="dispute">Going Good</label><br>
            <input type="radio" id="refund" name="status" value="refund">
            <label for="refund">Low</label><br>
            <input type="radio" id="on_going" name="status" value="On Going">
            <label for="on_going">Moderate</label>
            <input type="radio" id="refund" name="status" value="refund">
            <label for="refund">High</label><br>
        </div>
    </div>
   </form>






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