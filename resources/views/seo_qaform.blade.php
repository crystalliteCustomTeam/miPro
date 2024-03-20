@extends('layouts.app')

@section('maincontent')
        <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="index.html">Crystal Pro</a>
            <a class="breadcrumb-item" href="#">QA Form</a>
            <span class="breadcrumb-item active">Set Up QA Form</span>
          </nav>
        </div><!-- br-pageheader -->


        <div class="br-pagetitle">
          <i class="icon ion-ios-gear-outline"></i>
          <div>
            <h4>Set Up QA From</h4>
            <p class="mg-b-0">SEO QA Form</p>
          </div>
        </div><!-- d-flex -->

        <div class="br-pagebody">
          <div class="br-section-wrapper">
            <h4 style="font-weight:bold;">General Information:</h4>
           <form action="#" method="POST">
            @csrf

            <div class="row">

                <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Basecamp Link</label>
                    <input type="url" name="Basecamp" class="form-control" required>
                </div>
                <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;"> Brand: </label>
                    <input type="text" name="brand" required class="form-control">
                </div>
                <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Email/Domain </label>
                    <input type="email" name="emailordomain" required class="form-control">
                </div>
                <div class="col-3 mt-3" >
                  <label for="" style="font-weight:bold;">Last communication with client </label>
                  <input type="date" name="last_communication_with_client" required class="form-control">
                </div>
                <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Medium of communication </label><br>
                    <input type="checkbox" id="calls" name="Medium_of_communication[]" value="calls" required >
                    <label for="calls">calls</label><br>
                    <input type="checkbox" id="messages" name="Medium_of_communication[]" value="messages" required >
                    <label for="messages">messages</label><br>
                    <input type="checkbox" id="basecamp" name="Medium_of_communication[]" value="basecamp" required >
                    <label for="basecamp">basecamp</label><br>
                    <input type="checkbox" id="email" name="Medium_of_communication[]" value="email" required >
                    <label for="email">email</label><br>
                    <input type="checkbox" id="Whatsapp" name="Medium_of_communication[]" value="Whatsapp" required >
                    <label for="Whatsapp">Whatsapp</label><br>
                </div>
                <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Status </label><br>
                    <input type="radio" id="dispute" name="status" value="dispute">
                    <label for="dispute">Dispute</label><br>
                    <input type="radio" id="refund" name="status" value="refund">
                    <label for="refund">Refund</label><br>
                    <input type="radio" id="on_going" name="status" value="On Going">
                    <label for="on_going">On Going</label>
                </div>
                <div class="col-3 mt-3">
                    <label for="" style="font-weight:bold;">Refund Requested</label><br>
                    <input type="radio" id="yes" name="Refund_Requested" value="yes">
                    <label for="yes">Yes</label><br>
                    <input type="radio" id="no" name="Refund_Requested" value="no">
                    <label for="no">No</label><br>
                  </div>
                <div class="col-3 mt-3">
                  <label for="" style="font-weight:bold;">Refund Request Attachment </label>
                  <input type="file" name="Refund_Request_Attachment" required class="form-control">
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











<!-- Design -->


</div><!-- br-section-wrapper -->
</div><!-- br-pagebody -->

<div class="br-pagebody">
  <div class="br-section-wrapper">
    <h4 style="font-weight:bold;">Design Information:</h4>
   <form action="#" method="POST">
    @csrf

    <div class="row">
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Status of Design</label><br>
            <input type="radio" id="in_process" name="Design_Status" value="in process">
            <label for="in_process">In Process</label><br>
            <input type="radio" id="Completed" name="Design_Status" value="Completed">
            <label for="Completed">Completed</label><br>
            <input type="radio" id="Not_Applicable" name="Design_Status" value="Not Applicable">
            <label for="Not_Applicable">Not Applicable</label><br>
            <input type="radio" id="Not_Started_Yet" name="Design_Status" value="Not Started Yet">
            <label for="Not_Started_Yet">Not Started Yet</label><br>
            <input type="radio" id="Waiting_for_Client_Response" name="Design_Status" value="Waiting for Client Response">
            <label for="Waiting_for_Client_Response">Waiting for Client Response</label><br>
        </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;"> Desing Issue </label><br>
            <input type="checkbox" id="SMM_Post_Desing" name="Desing_Issue[]" value="SMM Post Desing" required >
            <label for="SMM_Post_Desing">SMM Post Desing</label><br>
            <input type="checkbox" id="Video_Trailer" name="Desing_Issue[]" value="Video Trailer" required >
            <label for="Video_Trailer">Video Trailer</label><br>
            <input type="checkbox" id="Website_Mockup" name="Desing_Issue[]" value="Website Mockup" required >
            <label for="Website_Mockup">Website Mockup</label><br>
            <input type="checkbox" id="News_Letter_Desing" name="Desing_Issue[]" value="News Letter Desing" required >
            <label for="News_Letter_Desing">News Letter Desing</label><br>
            <input type="checkbox" id="Mockup_design" name="Desing_Issue[]" value="Mockup Design" required >
            <label for="Mockup_design">Mockup Design</label><br>
            <input type="checkbox" id="NFT_Desing_Issue" name="Desing_Issue[]" value="NFT Desing Issue" required >
            <label for="NFT_Desing_Issue">NFT Desing Issue</label><br>
        </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Timely Delivered</label><br>
            <input type="radio" id="yes" name="Design_Timely_Delivered" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="Design_Timely_Delivered" value="no">
            <label for="no">No</label><br>
        </div>
        <div class="col-4 mt-3">
                <label for="" style="font-weight:bold;">Work Assinged</label><br>
                <input type="radio" id="yes" name="Design_Work_Assinged" value="yes">
                <label for="yes">Yes</label><br>
                <input type="radio" id="no" name="Design_Work_Assinged" value="no">
                <label for="no">No</label><br>
        </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Designer</label>
            <input type="text" name="Designer" required class="form-control">
         </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Design Evidence(if any issue) </label>
            <input type="file" name="Design_Evidence" required class="form-control">
        </div>
        <div class="col-12 mt-3">
            <label for="" style="font-weight:bold;">Description of issue</label>
           <textarea required name="Design_Description_of_issue" class="form-control" id="" cols="30" rows="5"></textarea>
        </div>
    </div>
   </form>










<!-- Development -->


</div><!-- br-section-wrapper -->
</div><!-- br-pagebody -->

<div class="br-pagebody">
  <div class="br-section-wrapper">
    <h4 style="font-weight:bold;">Development Information:</h4>
   <form action="#" method="POST">
    @csrf

    <div class="row">
        <div class="col-3 mt-3">
            <label for="" style="font-weight:bold;">Status of Development</label><br>
            <input type="radio" id="in_process" name="Development_Status" value="in process">
            <label for="in_process">In Process</label><br>
            <input type="radio" id="Completed" name="Development_Status" value="Completed">
            <label for="Completed">Completed</label><br>
            <input type="radio" id="Not_Applicable" name="Development_Status" value="Not Applicable">
            <label for="Not_Applicable">Not Applicable</label><br>
            <input type="radio" id="Not_Started_Yet" name="Development_Status" value="Not Started Yet">
            <label for="Not_Started_Yet">Not Started Yet</label><br>
            <input type="radio" id="Waiting_for_Client_Response" name="Development_Status" value="Waiting for Client Response">
            <label for="Waiting_for_Client_Response">Waiting for Client Response</label><br>
          </div>
          <div class="col-3 mt-3">
            <label for="" style="font-weight:bold;"> Web Development </label><br>
            <input type="checkbox" id="Word_Press" name="Web_Development[]" value="Word Press"  >
            <label for="Word_Press">Word Press</label><br>
            <input type="checkbox" id="Shopify" name="Web_Development[]" value="Shopify"  >
            <label for="Shopify">Shopify</label><br>
            <input type="checkbox" id="Custom" name="Web_Development[]" value="Custom"  >
            <label for="Custom">Custom</label><br>
            <input type="checkbox" id="Magento" name="Web_Development[]" value="Magento"  >
            <label for="Magento">Magento</label><br>
            <input type="checkbox" id="Go_daddy" name="Web_Development[]" value="Go daddy"  >
            <label for="Go_daddy">Go daddy</label>
          </div>
        <div class="col-3 mt-3">
            <label for="" style="font-weight:bold;"> Development Issue </label><br>
            <input type="checkbox" id="Content_Alignment" name="Development_Issue[]" value="Content Alignment" required >
            <label for="Content_Alignment">Content Alignment</label><br>
            <input type="checkbox" id="Logo_Alignment" name="Development_Issue[]" value="Logo Alignment" required >
            <label for="Logo_Alignment">Logo Alignment</label><br>
            <input type="checkbox" id="Theme_issue" name="Development_Issue[]" value="Theme issue'optimisation issue" required >
            <label for="Theme_issue">Theme issue'optimisation issue</label><br>
            <input type="checkbox" id="Mobile_responseviness" name="Development_Issue[]" value="Mobile responseviness" required >
            <label for="Mobile_responseviness">Mobile responseviness</label><br>
            <input type="checkbox" id="General_issue" name="Development_Issue[]" value="General issue" required >
            <label for="General_issue">General issue</label><br>
            <input type="checkbox" id="Going_Good" name="Development_Issue[]" value="Going Good" required >
            <label for="Going_Good">Going Good</label><br>
        </div>
        <div class="col-3 mt-3">
            <label for="" style="font-weight:bold;">Timely Delivered</label><br>
            <input type="radio" id="yes" name="Development_Timely_Delivered" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="Development_Timely_Delivered" value="no">
            <label for="no">No</label><br>
        </div>
        <div class="col-3 mt-3">
            <label for="" style="font-weight:bold;">Work Assinged</label><br>
            <input type="radio" id="yes" name="Development_Work_Assinged" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="Development_Work_Assinged" value="no">
            <label for="no">No</label><br>
        </div>
        <div class="col-3 mt-3">
          <label for="" style="font-weight:bold;">Developmenter</label>
          <input type="text" name="Development" required class="form-control">
        </div>
        <div class="col-3 mt-3">
            <label for="" style="font-weight:bold;">Development Evidence(if any issue) </label>
            <input type="file" name="Development_Evidence" required class="form-control">
        </div>
        <div class="col-12 mt-3">
            <label for="" style="font-weight:bold;">Description of issue</label>
           <textarea required name="Development_Description_of_issue" class="form-control" id="" cols="30" rows="5"></textarea>
        </div>
    </div>
   </form>











<!-- SEO -->


</div><!-- br-section-wrapper -->
</div><!-- br-pagebody -->

<div class="br-pagebody">
  <div class="br-section-wrapper">
    <h4 style="font-weight:bold;">SEO Information:</h4>
   <form action="#" method="POST">
    @csrf

    <div class="row">
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Status of SEO</label><br>
            <input type="radio" id="in_process" name="SEO_Status" value="in process">
            <label for="in_process">In Process</label><br>
            <input type="radio" id="Completed" name="SEO_Status" value="Completed">
            <label for="Completed">Completed</label><br>
            <input type="radio" id="Not_Applicable" name="SEO_Status" value="Not Applicable">
            <label for="Not_Applicable">Not Applicable</label><br>
            <input type="radio" id="Not_Started_Yet" name="SEO_Status" value="Not Started Yet">
            <label for="Not_Started_Yet">Not Started Yet</label><br>
            <input type="radio" id="Waiting_for_Client_Response" name="SEO_Status" value="Waiting for Client Response">
            <label for="Waiting_for_Client_Response">Waiting for Client Response</label><br>
          </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;"> SEO Issue </label><br>
            <input type="checkbox" id="Article" name="SEO_Issue[]" value="Article" required >
            <label for="Article">Article</label><br>
            <input type="checkbox" id="Blogs" name="SEO_Issue[]" value="Blogs" required >
            <label for="Blogs">Blogs</label><br>
            <input type="checkbox" id="PR_Release" name="SEO_Issue[]" value="PR Release" required >
            <label for="PR_Release">PR Release</label><br>
            <input type="checkbox" id="Author_Center" name="SEO_Issue[]" value="Author Center" required >
            <label for="Author_Center">Author Center</label><br>
            <input type="checkbox" id="Creating_Media_Account" name="SEO_Issue[]" value="Creating Media Account" required >
            <label for="Creating_Media_Account">Creating Media Account</label><br>
            <input type="checkbox" id="QA_Session" name="SEO_Issue[]" value="Q&A Session" required >
            <label for="QA_Session">Q&A Session </label><br>
            <input type="checkbox" id="News_Letter" name="SEO_Issue[]" value="News Letter" required >
            <label for="News_Letter">News Letter</label><br>
            <input type="checkbox" id="Reach_BookClub" name="SEO_Issue[]" value="Reach BookClub" required >
            <label for="Reach_BookClub">Reach BookClub</label><br>
            <input type="checkbox" id="Influencer_Outreach" name="SEO_Issue[]" value="Influencer Outreach" required >
            <label for="Influencer_Outreach">Influencer Outreach</label><br>
            <input type="checkbox" id="Amazon_Ads_Campaign" name="SEO_Issue[]" value="Amazon Ads Campaign" required >
            <label for="Amazon_Ads_Campaign">Amazon Ads Campaign</label><br>
        </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Timely Delivered</label><br>
            <input type="radio" id="yes" name="SEO_Timely_Delivered" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="SEO_Timely_Delivered" value="no">
            <label for="no">No</label><br>
        </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Work Assinged</label><br>
            <input type="radio" id="yes" name="SEO_Work_Assinged" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="SEO_Work_Assinged" value="no">
            <label for="no">No</label><br>
        </div>
        <div class="col-4 mt-3">
          <label for="" style="font-weight:bold;">SEO Person</label>
          <input type="text" name="SEO" required class="form-control">
        </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">SEO Evidence(if any issue) </label>
            <input type="file" name="SEO_Evidence" required class="form-control">
        </div>
        <div class="col-12 mt-3">
            <label for="" style="font-weight:bold;">Description of issue</label>
           <textarea required name="SEO_Description_of_issue" class="form-control" id="" cols="30" rows="5"></textarea>
        </div>
    </div>
   </form>

















<!-- SMM -->


</div><!-- br-section-wrapper -->
</div><!-- br-pagebody -->

<div class="br-pagebody">
  <div class="br-section-wrapper">
    <h4 style="font-weight:bold;">SMM Information:</h4>
   <form action="#" method="POST">
    @csrf

    <div class="row">
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Status of SMM</label><br>
            <input type="radio" id="in_process" name="SMM_Status" value="in process">
            <label for="in_process">In Process</label><br>
            <input type="radio" id="Completed" name="SMM_Status" value="Completed">
            <label for="Completed">Completed</label><br>
            <input type="radio" id="Not_Applicable" name="SMM_Status" value="Not Applicable">
            <label for="Not_Applicable">Not Applicable</label><br>
            <input type="radio" id="Not_Started_Yet" name="SMM_Status" value="Not Started Yet">
            <label for="Not_Started_Yet">Not Started Yet</label><br>
            <input type="radio" id="Waiting_for_Client_Response" name="SMM_Status" value="Waiting for Client Response">
            <label for="Waiting_for_Client_Response">Waiting for Client Response</label><br>
          </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;"> SMM Issue </label><br>
            <input type="checkbox" id="Posting" name="SMM_Issue[]" value="Posting" required >
            <label for="Posting">Posting</label><br>
            <input type="checkbox" id="SMM_Post_Content" name="SMM_Issue[]" value="SMM Post Content" required >
            <label for="SMM_Post_Content">SMM Post Content</label><br>
            <input type="checkbox" id="Good_Read_Account" name="SMM_Issue[]" value="Good Read Account" required >
            <label for="Good_Read_Account">Good Read Account</label><br>
            <input type="checkbox" id="Amazon_Campaign" name="SMM_Issue[]" value="Amazon Campaign" required >
            <label for="Amazon_Campaign">Amazon Campaign</label><br>
            <input type="checkbox" id="Creating_Social_Media_Account" name="SMM_Issue[]" value="Creating Social Media Account" required >
            <label for="Creating_Social_Media_Account">Creating Social Media Account</label><br>
            <input type="checkbox" id="QA_sessions" name="SMM_Issue[]" value="Q&A sessions" required >
            <label for="QA_sessions">Q&A sessions</label><br>
        </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Timely Delivered</label><br>
            <input type="radio" id="yes" name="SMM_Timely_Delivered" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="SMM_Timely_Delivered" value="no">
            <label for="no">No</label><br>
        </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Work Assinged</label><br>
            <input type="radio" id="yes" name="SMM_Work_Assinged" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="SMM_Work_Assinged" value="no">
            <label for="no">No</label><br>
        </div>
        <div class="col-4 mt-3">
          <label for="" style="font-weight:bold;">SMM Person</label>
          <input type="text" name="SMM" required class="form-control">
        </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">SMM Evidence(if any issue) </label>
            <input type="file" name="SMM_Evidence" required class="form-control">
        </div>
        <div class="col-12 mt-3">
            <label for="" style="font-weight:bold;">Description of issue </label>
            <textarea required name="SMM_Description_of_issue" class="form-control" id="" cols="30" rows="5"></textarea>
        </div>
    </div>
   </form>












   <!-- SEO Content Writer -->


</div><!-- br-section-wrapper -->
</div><!-- br-pagebody -->

<div class="br-pagebody">
  <div class="br-section-wrapper">
    <h4 style="font-weight:bold;">SEO Web Content Information:</h4>
   <form action="#" method="POST">
    @csrf

    <div class="row">
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Status of SEO Writing</label><br>
            <input type="radio" id="in_process" name="SEO_Writing_Status" value="in process">
            <label for="in_process">In Process</label><br>
            <input type="radio" id="Completed" name="SEO_Writing_Status" value="Completed">
            <label for="Completed">Completed</label><br>
            <input type="radio" id="Not_Applicable" name="SEO_Writing_Status" value="Not Applicable">
            <label for="Not_Applicable">Not Applicable</label><br>
            <input type="radio" id="Not_Started_Yet" name="SEO_Writing_Status" value="Not Started Yet">
            <label for="Not_Started_Yet">Not Started Yet</label><br>
            <input type="radio" id="Waiting_for_Client_Response" name="SEO_Writing_Status" value="Waiting for Client Response">
            <label for="Waiting_for_Client_Response">Waiting for Client Response</label><br>
          </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Issue in SEO Content </label><br>
            <input type="checkbox" id="Writing_issue" name="Issue_in_SEO_Content[]" value="Writing issue" required >
            <label for="Writing_issue">Writing issue</label><br>
            <input type="checkbox" id="Grammatical_Issue" name="Issue_in_SEO_Content[]" value="Grammatical Issue" required >
            <label for="Grammatical_Issue">Grammatical Issue</label><br>
            <input type="checkbox" id="Typos" name="Issue_in_SEO_Content[]" value="Typos" required >
            <label for="Typos">Typos</label><br>
            <input type="checkbox" id="Understanding_Issue" name="Issue_in_SEO_Content" value="Understanding Issue" required >
            <label for="Understanding_Issue">Understanding Issue</label><br>
            <input type="checkbox" id="Going_Good" name="Issue_in_SEO_Content[]" value="Going Good" required >
            <label for="Going_Good">Going Good </label><br>
        </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Timely Delivered</label><br>
            <input type="radio" id="yes" name="SEO_Content_Timely_Delivered" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="SEO_Content_Timely_Delivered" value="no">
            <label for="no">No</label><br>
        </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">Work Assinged</label><br>
            <input type="radio" id="yes" name="SEO_Content_Work_Assinged" value="yes">
            <label for="yes">Yes</label><br>
            <input type="radio" id="no" name="SEO_Content_Work_Assinged" value="no">
            <label for="no">No</label><br>
        </div>
        <div class="col-4 mt-3">
          <label for="" style="font-weight:bold;">SEO Content Writer</label>
          <input type="text" name="SEO" required class="form-control">
        </div>
        <div class="col-4 mt-3">
            <label for="" style="font-weight:bold;">SEO Content  Evidence(if any issue) </label>
            <input type="file" name="SEO_Content_Evidence" required class="form-control">
        </div>
        <div class="col-12 mt-3">
            <label for="" style="font-weight:bold;">Description of issue </label>
            <textarea required name="SEO_Content_Description_of_issue" class="form-control" id="" cols="30" rows="5"></textarea>
        </div>
    </div>
   </form>




   <!--Remarks-->

</div><!-- br-section-wrapper -->
</div><!-- br-pagebody -->

<div class="br-pagebody">
  <div class="br-section-wrapper">
    <h4 style="font-weight:bold;">Remarks:</h4>
   <form action="#" method="POST">
    @csrf

    <div class="row">
        <div class="col-6 mt-3">
            <label for="" style="font-weight:bold;"> Client Satisfaction Level </label><br>
            <input type="radio" id="dispute" name="status" value="dispute">
            <label for="dispute">Extremely Satisfied</label><br>
            <input type="radio" id="refund" name="status" value="refund">
            <label for="refund">Somewhat Satisfied</label><br>
            <input type="radio" id="on_going" name="status" value="On Going">
            <label for="on_going">Neither Satisfied nor Dissatisfied</label><br>
            <input type="radio" id="refund" name="status" value="refund">
            <label for="refund">Somewhat Dissatisfied</label><br>
            <input type="radio" id="on_going" name="status" value="On Going">
            <label for="on_going">Extremely Dissatisfied</label><br>
        </div>
        <div class="col-6 mt-3">
            <label for="" style="font-weight:bold;"> Refund & Dispute Expected </label><br>
            <input type="radio" id="dispute" name="status" value="dispute">
            <label for="dispute">Going Good</label><br>
            <input type="radio" id="refund" name="status" value="refund">
            <label for="refund">Low</label><br>
            <input type="radio" id="on_going" name="status" value="On Going">
            <label for="on_going">Moderate</label><br>
            <input type="radio" id="refund" name="status" value="refund">
            <label for="refund">High</label><br>
        </div>
        <div class="col-12 mt-3">
            <label for="" style="font-weight:bold;">Summery </label>
            <textarea required name="Refund_Request_Attachment" class="form-control" id="" cols="30" rows="5"></textarea>
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
