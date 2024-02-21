
<!-- ########## START: LEFT PANEL ########## -->
<div class="br-logo"><a href=""><span>[</span>Crystal <i>pro</i><span>]</span></a></div>
<div class="br-sideleft sideleft-scrollbar">
  <label class="sidebar-label">Navigation</label>
  <ul class="br-sideleft-menu">
    <li class="br-menu-item">
      <a href="index.html" class="br-menu-link active">
        <i class="menu-item-icon icon ion-ios-home-outline tx-24"></i>
        <span class="menu-item-label">Dashboard</span>
      </a><!-- br-menu-link -->
    </li><!-- br-menu-item -->
    @if($departmentAccess[0]->access == 0)
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
        <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
        <span class="menu-item-label">Forms</span>
      </a><!-- br-menu-link -->
      <ul class="br-menu-sub">
        <li class="sub-item"><a href="/forms/kyc" class="sub-link">Client Registration Form</a></li>
        <li class="sub-item"><a href="/forms/qaform_d" class="sub-link">Qa Form</a></li>
        <li class="sub-item"><a href="/searchuser" class="sub-link">Renewal/Resurring Form</a></li>
        <li class="sub-item"><a href="/searchuser" class="sub-link">Revenue Loss</a></li>
        <li class="sub-item"><a href="/searchuser" class="sub-link">Payment Confirmation Form</a></li>
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
              <span class="menu-item-label">Settings</span>
            </a><!-- br-menu-link -->
            <ul class="br-menu-sub">
                <li class="sub-item"><a href="/settings/Production/services" class="sub-link">Production Services</a></li>
                <li class="sub-item"><a href="/settings/qa_issues" class="sub-link">QA Form Issues</a></li>
                <li class="sub-item"><a href="/settings/user/client" class="sub-link">Assign Clients</a></li>
            </ul>
          </li><!-- br-menu-item -->

    @elseif($departmentAccess[0]->access == 1)

    <li class="br-menu-item">
      <a href="#" class="br-menu-link with-sub">
        <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
        <span class="menu-item-label">Reporting</span>
      </a><!-- br-menu-link -->
      <ul class="br-menu-sub">
        <li class="sub-item"><a href="/userlist" class="sub-link">KYC REPORT</a></li>
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
          <li class="sub-item"><a href="/employee/forms/kyc" class="sub-link">SEO Kyc</a></li>
          <li class="sub-item"><a href="/forms/book" class="sub-link">Book Kyc</a></li>
          <li class="sub-item"><a href="/forms/website" class="sub-link">Website Kyc</a></li>
          <li class="sub-item"><a href="/forms/cld" class="sub-link">CLD Kyc</a></li>
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
              <span class="menu-item-label">Settings</span>
            </a><!-- br-menu-link -->
            <ul class="br-menu-sub">
                <li class="sub-item"><a href="/settings/Production/services" class="sub-link">Production Services</a></li>
                <li class="sub-item"><a href="/settings/qa_issues" class="sub-link">QA Form Issues</a></li>
                <li class="sub-item"><a href="/settings/user/client" class="sub-link">Assign Clients</a></li>
            </ul>
          </li><!-- br-menu-item -->

    @elseif($departmentAccess[0]->access == 2)
    <li class="br-menu-item">
      <a href="#" class="br-menu-link with-sub">
        <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
        <span class="menu-item-label">Forms</span>
      </a><!-- br-menu-link -->
      <ul class="br-menu-sub">
        <li class="sub-item"><a href="/forms/kyc" class="sub-link">Client Registration Form</a></li>
        <li class="sub-item"><a href="/forms/qaform_d" class="sub-link">Qa Form</a></li>
        <li class="sub-item"><a href="/searchuser" class="sub-link">Renewal/Resurring Form</a></li>
        <li class="sub-item"><a href="/searchuser" class="sub-link">Revenue Loss</a></li>
        <li class="sub-item"><a href="/searchuser" class="sub-link">Payment Confirmation Form</a></li>
      </ul>
    </li>


    <li class="br-menu-item">
        <a href="#" class="br-menu-link with-sub">
          <i class="menu-item-icon icon ion-ios-filing-outline tx-24"></i>
          <span class="menu-item-label">Client Registration</span>
        </a><!-- br-menu-link -->
        <ul class="br-menu-sub">
          <li class="sub-item"><a href="/employee/forms/kyc" class="sub-link">SEO Kyc</a></li>
          <li class="sub-item"><a href="/forms/book" class="sub-link">Book Kyc</a></li>
          <li class="sub-item"><a href="/forms/website" class="sub-link">Website Kyc</a></li>
          <li class="sub-item"><a href="/forms/cld" class="sub-link">CLD Kyc</a></li>
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
              <span class="menu-item-label">Settings</span>
            </a><!-- br-menu-link -->
            <ul class="br-menu-sub">
                <li class="sub-item"><a href="/settings/Production/services" class="sub-link">Production Services</a></li>
                <li class="sub-item"><a href="/settings/qa_issues" class="sub-link">QA Form Issues</a></li>
                <li class="sub-item"><a href="/settings/user/client" class="sub-link">Assign Clients</a></li>
            </ul>
          </li><!-- br-menu-item -->


          @elseif($departmentAccess[0]->access == 3)

          <li class="br-menu-item">
            <a href="#" class="br-menu-link with-sub">
              <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
              <span class="menu-item-label">Reporting</span>
            </a><!-- br-menu-link -->
            <ul class="br-menu-sub">
              <li class="sub-item"><a href="/userlist" class="sub-link">KYC REPORT</a></li>
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
                <li class="sub-item"><a href="/employee/forms/kyc" class="sub-link">SEO Kyc</a></li>
                <li class="sub-item"><a href="/forms/book" class="sub-link">Book Kyc</a></li>
                <li class="sub-item"><a href="/forms/website" class="sub-link">Website Kyc</a></li>
                <li class="sub-item"><a href="/forms/cld" class="sub-link">CLD Kyc</a></li>
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
                    <span class="menu-item-label">Settings</span>
                  </a><!-- br-menu-link -->
                  <ul class="br-menu-sub">
                      <li class="sub-item"><a href="/settings/Production/services" class="sub-link">Production Services</a></li>
                      <li class="sub-item"><a href="/settings/qa_issues" class="sub-link">QA Form Issues</a></li>
                      <li class="sub-item"><a href="/settings/user/client" class="sub-link">Assign Clients</a></li>
                  </ul>
                </li><!-- br-menu-item -->

    @endif


  </ul><!-- br-sideleft-menu -->
  <br>
</div><!-- br-sideleft -->
<!-- ########## END: LEFT PANEL ########## -->
