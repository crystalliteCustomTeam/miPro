
<!-- ########## START: LEFT PANEL ########## -->
<div class="br-logo"><a href=""><span>[</span>Crystal <i>pro</i><span>]</span></a></div>
<div class="br-sideleft sideleft-scrollbar">
  <label class="sidebar-label">Navigation</label>
  <ul class="br-sideleft-menu">


    @if( $superUser == 0 || $departmentAccess[0]->access == 0 )
    <li class="br-menu-item">
      <a href="/dashboard" class="br-menu-link active">
        <i class="menu-item-icon icon ion-ios-home-outline tx-24"></i>
        <span class="menu-item-label">Dashboard</span>
      </a><!-- br-menu-link -->
    </li><!-- br-menu-item -->

    <li class="br-menu-item">
      <a href="#" class="br-menu-link with-sub">
        <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
        <span class="menu-item-label">Company</span>
      </a><!-- br-menu-link -->
      <ul class="br-menu-sub">
        <li class="sub-item"><a href="/companies" class="sub-link">Companies</a></li>
        <li class="sub-item"><a href="/setupcompany" class="sub-link">Set Up a Company</a></li>

      </ul>
    </li>
    <li class="br-menu-item">
      <a href="#" class="br-menu-link with-sub">
        <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
        <span class="menu-item-label">Brands</span>
      </a><!-- br-menu-link -->
      <ul class="br-menu-sub">
        <li class="sub-item"><a href="/brandlist" class="sub-link">Brands</a></li>
      </ul>
    </li>

    <li class="br-menu-item">
      <a href="#" class="br-menu-link with-sub">
        <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
        <span class="menu-item-label">Departments</span>
      </a><!-- br-menu-link -->
      <ul class="br-menu-sub">
        <li class="sub-item"><a href="/departmentlist" class="sub-link">Departments</a></li>
        <li class="sub-item"><a href="/setupdepartments" class="sub-link">Set Up a Department</a></li>

      </ul>
    </li>
    <li class="br-menu-item">
      <a href="#" class="br-menu-link with-sub">
        <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
        <span class="menu-item-label">Users</span>
      </a><!-- br-menu-link -->
      <ul class="br-menu-sub">
        <li class="sub-item"><a href="/userlist" class="sub-link">Lists</a></li>
        <li class="sub-item"><a href="/createuser" class="sub-link">Create Users</a></li>
        <li class="sub-item"><a href="/searchuser" class="sub-link">Search Users</a></li>
      </ul>
    </li>
    <li class="br-menu-item">
      <a href="#" class="br-menu-link with-sub">
        <i class="menu-item-icon icon ion-ios-filing-outline tx-24"></i>
        <span class="menu-item-label">Client Registration</span>
      </a><!-- br-menu-link -->
      <ul class="br-menu-sub">
        <li class="sub-item"><a href="/forms/kyc" class="sub-link">SEO Kyc</a></li>
        <li class="sub-item"><a href="/forms/book" class="sub-link">Book Kyc</a></li>
        <li class="sub-item"><a href="/forms/website" class="sub-link">Website Kyc</a></li>
        <li class="sub-item"><a href="/forms/cld" class="sub-link">CLD Kyc</a></li>
        <li class="sub-item"><a href="/forms/csv_uploads" class="sub-link">Client Registration(CSV)</a></li>
        <li class="sub-item"><a href="/client/emails" class="sub-link">push emails</a></li>
      </ul>
    </li><!-- br-menu-item -->
    <li class="br-menu-item">
        <a href="#" class="br-menu-link with-sub">
          <i class="menu-item-icon icon ion-ios-filing-outline tx-24"></i>
          <span class="menu-item-label">Client</span>
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub">
          <li class="sub-item"><a href="/all/clients" class="sub-link">Clients</a></li>
        </ul>
      </li><!-- br-menu-item -->
    <li class="br-menu-item">
      <a href="#" class="br-menu-link with-sub">
        <i class="menu-item-icon ion-ios-redo-outline tx-24"></i>
        <span class="menu-item-label">Projects</span>
      </a><!-- br-menu-link -->
      <ul class="br-menu-sub">
        <li class="sub-item"><a href="/client/project" class="sub-link">Create Project</a></li>
        <li class="sub-item"><a href="/forms/csv_uploads_projects" class="sub-link">Create Project(CSV)</a></li>
      </ul>
    </li><!-- br-menu-item -->
    <li class="br-menu-item">
        <a href="#" class="br-menu-link with-sub">
          <i class="menu-item-icon ion-ios-redo-outline tx-24"></i>
          <span class="menu-item-label">Payments</span>
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub">
          <li class="sub-item"><a href="/client/add/payment" class="sub-link">Add Payment</a></li>
          {{-- <li class="sub-item"><a href="/client/new/payment" class="sub-link">Stripe Payments</a></li> --}}
          <li class="sub-item"><a href="/forms/csv_uploads_stripePayments" class="sub-link">Stripe Payments(CSV)</a></li>
          <li class="sub-item"><a href="/client/project/payment/all" class="sub-link">All Payments</a></li>
          <li class="sub-item"><a href="/payments/unmatched" class="sub-link">Unmatched Payments</a></li>
          <li class="sub-item"><a href="/client/project/payment/disputes" class="sub-link">Disputes</a></li>
        </ul>
      </li><!-- br-menu-item -->
      <li class="br-menu-item">
        <a href="#" class="br-menu-link with-sub">
          <i class="menu-item-icon ion-ios-redo-outline tx-24"></i>
          <span class="menu-item-label">PPC</span>
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub">
          <li class="sub-item"><a href="/forms/csv_uploads_ppc" class="sub-link">PPC Payments(CSV)</a></li>
          <li class="sub-item"><a href="#" class="sub-link">PPC</a></li>
        </ul>
      </li><!-- br-menu-item -->
      <li class="br-menu-item">
        <a href="#" class="br-menu-link with-sub">
          <i class="menu-item-icon ion-ios-redo-outline tx-24"></i>
          <span class="menu-item-label">Set Targets</span>
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub">
            <li class="sub-item"><a href="/settarget" class="sub-link">Set Brand Target</a></li>
            <li class="sub-item"><a href="/brandtarget" class="sub-link">Targets</a></li>
            <li class="sub-item"><a href="#" class="sub-link">Set Agent Target</a></li>
            <li class="sub-item"><a href="#" class="sub-link">Agents</a></li>
        </ul>
      </li><!-- br-menu-item -->
    <li class="br-menu-item">
        <a href="#" class="br-menu-link with-sub">
          <i class="menu-item-icon icon ion-ios-gear-outline tx-24"></i>
          <span class="menu-item-label">QA Forms</span>
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub">
          <li class="sub-item"><a href="/forms/qaform_d" class="sub-link">QA FORM</a></li>
        </ul>
      </li><!-- br-menu-item -->
      <li class="br-menu-item">
        <a href="#" class="br-menu-link with-sub">
          <i class="menu-item-icon icon ion-ios-gear-outline tx-24"></i>
          <span class="menu-item-label">Report</span>
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub">
          {{-- <li class="sub-item"><a href="/allproject/report" class="sub-link">QA Report</a></li> --}}
          <li class="sub-item"><a href="/project/report" class="sub-link">Quality Assurance Report</a></li>
          {{-- <li class="sub-item"><a href="/client/revenue" class="sub-link">Report</a></li> --}}
          <li class="sub-item"><a href="/allclient/revenue" class="sub-link">Revenue Report</a></li>
          <li class="sub-item"><a href="/paymentdashboard" class="sub-link">Payment Dashboard</a></li>
        </ul>
      </li><!-- br-menu-item -->

      <li class="br-menu-item">
        <a href="#" class="br-menu-link with-sub">
          <i class="menu-item-icon icon ion-ios-gear-outline tx-24"></i>
          <span class="menu-item-label">Settings</span>
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub">
            <li class="sub-item"><a href="/settings/Production/services" class="sub-link">Production Services</a></li>
            <li class="sub-item"><a href="/settings/qa_issues" class="sub-link">QA Form Issues</a></li>
            <li class="sub-item"><a href="/settings/user/client" class="sub-link">Assign Clients</a></li>
        </ul>
    </li><!-- br-menu-item -->


    {{-- @elseif( isset($departmentAccess) ) --}}
    @elseif($departmentAccess[0]->access == 1)
    <h1>1</h1>
    @elseif($departmentAccess[0]->access == 2)
    <li class="br-menu-item">
        <a href="/dashboard" class="br-menu-link active">
          <i class="menu-item-icon icon ion-ios-home-outline tx-24"></i>
          <span class="menu-item-label">Dashboard</span>
        </a><!-- br-menu-link -->
      </li><!-- br-menu-item -->
      <li class="br-menu-item">
        <a href="#" class="br-menu-link with-sub">
          <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
          <span class="menu-item-label">Profile</span>
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub">
          <li class="sub-item"><a href="/userprofile/{{$LoginUser[0]->id}}" class="sub-link">Profile</a></li>
        </ul>
      </li>
      <li class="br-menu-item">
        <a href="#" class="br-menu-link with-sub">
          <i class="menu-item-icon icon ion-ios-filing-outline tx-24"></i>
          <span class="menu-item-label">Client Registration</span>
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub">
          <li class="sub-item"><a href="/forms/kyc" class="sub-link">SEO Kyc</a></li>
          <li class="sub-item"><a href="/forms/book" class="sub-link">Book Kyc</a></li>
          <li class="sub-item"><a href="/forms/website" class="sub-link">Website Kyc</a></li>
          <li class="sub-item"><a href="/forms/cld" class="sub-link">CLD Kyc</a></li>
          <li class="sub-item"><a href="/forms/csv_uploads" class="sub-link">Client Registration(CSV)</a></li>
        </ul>
      </li><!-- br-menu-item -->
      <li class="br-menu-item">
        <a href="#" class="br-menu-link with-sub">
          <i class="menu-item-icon icon ion-ios-filing-outline tx-24"></i>
          <span class="menu-item-label">Clients</span>
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub">
          <li class="sub-item"><a href="/assigned/clients" class="sub-link">Clients</a></li>
          <li class="sub-item"><a href="/all/newclients" class="sub-link">New Client</a></li>
        </ul>
      </li><!-- br-menu-item -->
      <li class="br-menu-item">
        <a href="#" class="br-menu-link with-sub">
          <i class="menu-item-icon ion-ios-redo-outline tx-24"></i>
          <span class="menu-item-label">Projects</span>
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub">
          <li class="sub-item"><a href="/assignedclient/project" class="sub-link">Create Project</a></li>
          <li class="sub-item"><a href="/forms/csv_uploads_projects" class="sub-link">Create Project(CSV)</a></li>
        </ul>
      </li><!-- br-menu-item -->
      <li class="br-menu-item">
          <a href="#" class="br-menu-link with-sub">
            <i class="menu-item-icon icon ion-ios-gear-outline tx-24"></i>
            <span class="menu-item-label">QA Forms</span>
          </a><!-- br-menu-link -->
          <ul class="br-menu-sub">
            <li class="sub-item"><a href="/forms/qaform_d" class="sub-link">QA FORM</a></li>
            <li class="sub-item"><a href="/allfilled/qaforms" class="sub-link">Filled QA FORM</a></li>
          </ul>
        </li><!-- br-menu-item -->

        <li class="br-menu-item">
          <a href="#" class="br-menu-link with-sub">
            <i class="menu-item-icon icon ion-ios-gear-outline tx-24"></i>
            <span class="menu-item-label">Settings</span>
          </a><!-- br-menu-link -->
          <ul class="br-menu-sub">
              <li class="sub-item"><a href="/settings/Production/services" class="sub-link">Production Services</a></li>
              <li class="sub-item"><a href="/settings/qa_issues" class="sub-link">QA Form Issues</a></li>
          </ul>
      </li><!-- br-menu-item -->
    @elseif($departmentAccess[0]->access == 3)
    <h1>3</h1>
    @endif








    </ul>

  <br>
</div>
