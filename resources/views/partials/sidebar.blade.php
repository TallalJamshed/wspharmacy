<style>
    .submenu{
	color:black !important;
}
}
</style>
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            {{-- <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
                </div>
                <!-- /input-group -->
            </li> --}}
            {{-- <li> --}}
                {{-- <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Dashboard<span class="fa arrow"></span></a> --}}
                {{-- <ul class="nav nav-second-level"> --}}
                    <li style="font-size:16px; font-weight:bold">
                        <a href="{{ route('dashboard')}}"><i class="fa fa-tachometer fa-fw"></i>Dashboard</a>
                    </li>

                    <li style="font-size:16px; font-weight:bold">
                        <a href="{{ route('showstocks')}}"><i class="fa fa-line-chart fa-fw"></i>Stocks</a>
                    </li>

                    {{-- @if(Auth::user()->fk_role_id == 1) --}}
                    @if ((Auth::user()->name != "beta"))

                        <li>
                            <a href="#" style="font-size:16px; font-weight:bold;"><i class="fa fa-plus fa-fw"></i> Create Items<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li >
                                    <a href="{{ route('addcompanyform')}}" class="submenu"><i class="fa fa-plus-circle fa-fw"></i>Add Company</a>
                                </li>
                                {{-- <li>
                                    <a href="{{ route('addcategoryform')}}"><i class="fa fa-plus-circle fa-fw"></i>Add Category</a>
                                </li> --}}
                                {{-- <li>
                                    <a href="{{ route('addformulaform')}}" class="submenu"><i class="fa fa-plus-circle fa-fw"></i>Add Formulas</a>
                                </li> --}}
                                <li>
                                    <a href="{{ route('addmedicineform')}}" class="submenu"><i class="fa fa-plus-circle fa-fw"></i>Add Medicine</a>
                                </li>
                                
                            </ul>
                        </li>
                        @endif
                    {{-- @endif --}}

                    {{-- @if(Auth::user()->fk_role_id == 1) --}}
                    @if ((Auth::user()->name != "beta"))

                        <li>
                            <a href="#" style="font-size:16px; font-weight:bold"><i class="fa fa-cart-plus fa-fw"></i> Purchase<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                {{-- <li>
                                    <a href="{{ route('addvendorform')}}"><i class="fa fa-plus-circle fa-fw"></i>Add Vendor</a>
                                </li> --}}
                                <li>
                                    <a href="{{ route('addpurchaseform')}}" class="submenu"><i class="fa fa-plus-circle fa-fw"></i>Add New Purchases</a>
                                </li>
                                <li>
                                    <a href="{{ route('showpurchaseform')}}" class="submenu"><i class="fa fa-eye fa-fw"></i>Show Purchases</a>
                                </li>
                                {{-- <li>
                                    <a href="{{ route('purchasereturn')}}" class="submenu"><i class="fa fa-mail-reply fa-fw"></i>Purchase Returns</a>
                                </li> --}}
                            </ul>
                        </li>
                        @endif
                    {{-- @endif --}}
                    {{-- <li>
                        <a href="{{ route('addpricingform')}}"><i class="fa fa-plus-circle fa-fw"></i>Add Sale Pricing</a>
                    </li> --}}
                    
                    
                    {{-- @if(Auth::user()->fk_role_id == 1) --}}
                        <li>
                            <a href="#" style="font-size:16px; font-weight:bold"><i class="fa fa-dollar fa-fw"></i> Sales<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                                              
                                <li>
                                    <a href="{{ route('addsalesform')}}" class="submenu"><i class="fa fa-plus-circle fa-fw"></i>Add New Sales</a>
                                </li>
                                <li>
                                    <a href="{{ route('showsalesform')}}" class="submenu"><i class="fa fa-eye fa-fw"></i>Show Sales</a>
                                </li>
                                @if ((Auth::user()->name != "beta"))
                                    <li>
                                        <a href="{{ route('salesreturn')}}" class="submenu"><i class="fa fa-mail-reply fa-fw"></i>Sales Return</a>
                                    </li>
                                @endif
                                
                            </ul>
                        </li>
                    {{-- @endif --}}
                    @if ((Auth::user()->name != "beta"))

                        <li>
                            <a href="#" style="font-size:16px; font-weight:bold"><i class="fa fa-money fa-fw"></i>Vendor Payment<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('addvendorpaymentform')}}" class="submenu"><i class="fa fa-plus-circle fa-fw"></i>Add Payment</a>
                                </li>
                                
                            </ul>
                        </li>
                    @endif
                        {{-- <li style="height:2px;background-color:red" ></li> --}}
                        @if ((Auth::user()->name != "beta"))

                        <li>
                            <a href="#" style="font-size:16px; font-weight:bold"><i class="fa fa-money fa-fw"></i>Customer Payment<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('addcustpaymentform')}}" class="submenu"><i class="fa fa-plus-circle fa-fw"></i>Add Payment</a>
                                </li>
                            </ul>
                        </li>
                        @endif
                    {{-- @if(Auth::user()->fk_role_id == 1) --}}
                        <li>
                            <a href="#" style="font-size:16px; font-weight:bold"><i class="fa fa-bar-chart-o fa-fw"></i> Reports<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{route('dailysalesreport')}}" class="submenu"><i class="fa fa-line-chart fa-fw"></i>Daily Sales Summary</a>
                                </li>
                                <li>
                                    <a href="{{route('topsalesreport')}}" class="submenu"><i class="fa fa-line-chart fa-fw"></i>Top Sales Items</a>
                                </li>
                                <li>
                                    <a href="{{route('expiredmeds')}}" class="submenu"><i class="fa fa-line-chart fa-fw"></i>Expired Medicines</a>
                                </li>
                                <li>
                                    <a href="{{route('genreport')}}" class="submenu"><i class="fa fa-line-chart fa-fw"></i>Sale/Purchase Reports</a>
                                </li>
                                <li>
                                    <a href="{{route('plreport')}}" class="submenu"><i class="fa fa-line-chart fa-fw"></i>Profit/loss Reports</a>
                                </li>
                                <li>
                                    <a href="{{route('recoveryreport')}}" class="submenu"><i class="fa fa-line-chart fa-fw"></i>Payment Recovery Reports</a>
                                </li>
                            </ul>
                        </li>
                    {{-- @endif --}}

                    {{-- @if(Auth::user()->fk_role_id == 1)
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Admin Tasks<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level"> --}}
                                
                        
                    {{-- @endif --}}
                {{-- </ul> --}}
            {{-- </li> --}}
            {{-- <li>
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Purchase<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level"> --}}
                    {{-- @if(Auth::user()->fk_role_id == 1) --}}

                                
                                
                                
                            {{-- </ul>
                        
                    @endif --}}
                        {{-- <li>
                            <a href="{{ route('addsalesform')}}"><i class="fa fa-list-ul fa-fw"></i>Add New Sales</a>
                        </li> --}}
                        
                    
                {{-- </ul> --}}
                <!-- /.nav-second-level -->
            {{-- </li> --}}
            {{-- <li>
                <a href="tables.html"><i class="fa fa-table fa-fw"></i> Tables</a>
            </li>
            <li>
                <a href="forms.html"><i class="fa fa-edit fa-fw"></i> Forms</a>
            </li> --}}
            {{-- <li>
                <a href="#"><i class="fa fa-wrench fa-fw"></i>Sales<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level"> --}}
                    
                    {{-- <li>
                        <a href="buttons.html">Buttons</a>
                    </li>
                    <li>
                        <a href="notifications.html">Notifications</a>
                    </li>
                    <li>
                        <a href="typography.html">Typography</a>
                    </li>
                    <li>
                        <a href="icons.html"> Icons</a>
                    </li>
                    <li>
                        <a href="grid.html">Grid</a>
                    </li> --}}
                {{-- </ul>
                <!-- /.nav-second-level -->
            </li> --}}
            {{-- <li>
                <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="#">Second Level Item</a>
                    </li>
                    <li>
                        <a href="#">Second Level Item</a>
                    </li>
                    <li>
                        <a href="#">Third Level <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level">
                            <li>
                                <a href="#">Third Level Item</a>
                            </li>
                            <li>
                                <a href="#">Third Level Item</a>
                            </li>
                            <li>
                                <a href="#">Third Level Item</a>
                            </li>
                            <li>
                                <a href="#">Third Level Item</a>
                            </li>
                        </ul>
                        <!-- /.nav-third-level -->
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li> --}}
            {{-- <li>
                <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="blank.html">Blank Page</a>
                    </li>
                    <li>
                        <a href="login.html">Login Page</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li> --}}
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
