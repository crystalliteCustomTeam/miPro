
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
        <li class="sub-item"><a href="/createuser" class="sub-link">Employee Registration form</a></li>
        <li class="sub-item"><a href="/createuser" class="sub-link">Book KYC Form</a></li>
        <li class="sub-item"><a href="/createuser" class="sub-link">SEO KYC Form</a></li>
        <li class="sub-item"><a href="/createuser" class="sub-link">Website KYC Form</a></li>
        <li class="sub-item"><a href="/createuser" class="sub-link">CLD KYC Form</a></li>
        <li class="sub-item"><a href="/searchuser" class="sub-link">Qa Form</a></li>
        <li class="sub-item"><a href="/searchuser" class="sub-link">Renewal/Resurring Form</a></li>
        <li class="sub-item"><a href="/searchuser" class="sub-link">Revenue Loss</a></li>
        <li class="sub-item"><a href="/searchuser" class="sub-link">Payment Confirmation Form</a></li>
      </ul>
    </li>

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
    
    @elseif($departmentAccess[0]->access == 2)
    <li class="br-menu-item">
      <a href="#" class="br-menu-link with-sub">
        <i class="menu-item-icon icon ion-ios-photos-outline tx-20"></i>
        <span class="menu-item-label">Forms</span>
      </a><!-- br-menu-link -->
      <ul class="br-menu-sub">
        <li class="sub-item"><a href="/createuser" class="sub-link">Employee Registration form</a></li>
        <li class="sub-item"><a href="/createuser" class="sub-link">Book KYC Form</a></li>
        <li class="sub-item"><a href="/createuser" class="sub-link">SEO KYC Form</a></li>
        <li class="sub-item"><a href="/createuser" class="sub-link">Website KYC Form</a></li>
        <li class="sub-item"><a href="/createuser" class="sub-link">CLD KYC Form</a></li>
        <li class="sub-item"><a href="/searchuser" class="sub-link">Qa Form</a></li>
        <li class="sub-item"><a href="/searchuser" class="sub-link">Renewal/Resurring Form</a></li>
        <li class="sub-item"><a href="/searchuser" class="sub-link">Revenue Loss</a></li>
        <li class="sub-item"><a href="/searchuser" class="sub-link">Payment Confirmation Form</a></li>
      </ul>
    </li>
    @endif
    
    
  </ul><!-- br-sideleft-menu -->

  <label class="sidebar-label pd-x-10 mg-t-25 mg-b-20 tx-primary">Information Summary</label>

  <div class="info-list">
    <div class="info-list-item">
      <div>
        <p class="info-list-label">Memory Usage</p>
        <h5 class="info-list-amount">32.3%</h5>
      </div>
      <span class="peity-bar" data-peity='{ "fill": ["#336490"], "height": 35, "width": 60 }'>8,6,5,9,8,4,9,3,5,9</span>
    </div><!-- info-list-item -->

    <div class="info-list-item">
      <div>
        <p class="info-list-label">CPU Usage</p>
        <h5 class="info-list-amount">140.05</h5>
      </div>
      <span class="peity-bar" data-peity='{ "fill": ["#1C7973"], "height": 35, "width": 60 }'>4,3,5,7,12,10,4,5,11,7</span>
    </div><!-- info-list-item -->

    <div class="info-list-item">
      <div>
        <p class="info-list-label">Disk Usage</p>
        <h5 class="info-list-amount">82.02%</h5>
      </div>
      <span class="peity-bar" data-peity='{ "fill": ["#8E4246"], "height": 35, "width": 60 }'>1,2,1,3,2,10,4,12,7</span>
    </div><!-- info-list-item -->

    <div class="info-list-item">
      <div>
        <p class="info-list-label">Daily Traffic</p>
        <h5 class="info-list-amount">62,201</h5>
      </div>
      <span class="peity-bar" data-peity='{ "fill": ["#9C7846"], "height": 35, "width": 60 }'>3,12,7,9,2,3,4,5,2</span>
    </div><!-- info-list-item -->
  </div><!-- info-list -->

  <br>
</div><!-- br-sideleft -->
<!-- ########## END: LEFT PANEL ########## -->
