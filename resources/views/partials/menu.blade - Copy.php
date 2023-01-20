<div class="sidebar sidebar-lg-show">
    <nav class="sidebar-nav">

        <ul class="nav">
            @can('dashboard_access')
            <li class="nav-item">
                <a href="{{ route("admin.dashboard") }}" class="nav-link {{ request()->is('admin/dashboard') || request()->is('admin/dashboard/*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt">

                    </i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>
            @endcan
            @can('user_management_access')
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle">
                    <i class="fas fa-users nav-icon">

                    </i>
                    {{ trans('global.userManagement.title') }}
                </a>
                <ul class="nav-dropdown-items ml-4">
                    <li class="nav-item">
                        <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                            <i class="fas fa-unlock-alt nav-icon">

                            </i>
                            {{ trans('global.permission.title') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                            <i class="fas fa-briefcase nav-icon">

                            </i>
                            {{ trans('global.role.title') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                            <i class="fas fa-user nav-icon">

                            </i>
                            {{ trans('global.user.title') }}
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
            @can('employer_access')
            <li class="nav-item">
                <a href="{{ route("admin.employer.index") }}" class="nav-link {{ request()->is('admin/employer') || request()->is('admin/employer/*') ? 'active' : '' }}">
                    <i class="fa fa-product-hunt nav-icon">

                    </i>
                     Employer Management
                </a>
            </li>
            @endcan
            <!-- <li class="nav-item">
                <a href="{{ route("admin.products.index") }}" class="nav-link {{ request()->is('admin/products') || request()->is('admin/products/*') ? 'active' : '' }}">
                    <i class="fas fa-cogs nav-icon">

                    </i>
                    {{ trans('global.product.title') }}
                </a>
            </li> -->
            @can('agencies_access')
            <li class="nav-item">
                <a href="{{ route("admin.agencies.index") }}" class="nav-link {{ request()->is('admin/agencies') || request()->is('admin/agencies/*') ? 'active' : '' }}">
                    <i class="fas fa-users nav-icon">

                    </i>
                    Provider Management
                </a>
            </li>
            @endcan
            <!-- Agency Profile -->
            @can('agencyprofile_access')
            <li class="nav-item">
                <a href="{{ route("admin.agencies.index") }}" class="nav-link {{ request()->is('admin/agencies') || request()->is('admin/agencies/*') ? 'active' : '' }}">
                    <i class="fas fa-users nav-icon">

                    </i>
                    Profile
                </a>
            </li>
            @endcan
            <!-- Agent Profile -->
            @can('agentprofile_access')
            <li class="nav-item">
                <a href="{{ route("admin.agencies.index") }}" class="nav-link {{ request()->is('admin/agencies') || request()->is('admin/agencies/*') ? 'active' : '' }}">
                    <i class="fas fa-users nav-icon">

                    </i>
                    Profile
                </a>
            </li>
            @endcan
            @can('agent_access')
            <li class="nav-item">
                <a href="{{ route("admin.agent.index") }}" class="nav-link {{ request()->is('admin/agent') || request()->is('admin/agent/*') ? 'active' : '' }}">
                    <i class="fas fa-user nav-icon">

                    </i>
                    Agents List
                </a>
            </li>
            @endcan
            @can('agency_access')
            <li class="nav-item">
                <a href="{{ route("admin.agency.index") }}" class="nav-link {{ request()->is('admin/agency') || request()->is('admin/agency/*') ? 'active' : '' }}">
                    <i class="fas fa-user nav-icon">

                    </i>
                    Agency List
                </a>
            </li>
            @endcan
            @can('agencyrequest_access')
            <li class="nav-item">
                <a href="{{ route("admin.agencyrequest.index") }}" class="nav-link {{ request()->is('admin/agencyrequest') || request()->is('admin/agencyrequest/*') ? 'active' : '' }}">
                    <i class="fas fa-users nav-icon">

                    </i>
                    Request From Agency 
                </a>
            </li>
            @endcan
            @can('agentrequest_access')
            <li class="nav-item">
                <a href="{{ route("admin.agentrequest.index") }}" class="nav-link {{ request()->is('admin/agentrequest') || request()->is('admin/agentrequest/*') ? 'active' : '' }}">
                    <i class="fas fa-users nav-icon">

                    </i>
                    Request From Agent
                </a>
            </li>
            @endcan
            <!-- @can('agencies_edit')
            <li class="nav-item">
                <a href="{{ route("admin.agencies.index") }}" class="nav-link {{ request()->is('admin/agencies') || request()->is('admin/agencies/*') ? 'active' : '' }}">
                    <i class="fas fa-users nav-icon">

                    </i>
                     Agency Profile
                </a>
            </li>
            @endcan -->
            @can('product_access')
            <li class="nav-item">
                <a href="{{ route("admin.products.index") }}" class="nav-link {{ request()->is('admin/products') || request()->is('admin/products/*') ? 'active' : '' }}">
                    <i class="fa fa-product-hunt nav-icon">

                    </i>
                     Maid Management
                </a>
            </li>
            @endcan
            <!-- <li class="nav-item">
                <a href="{{ route("admin.wallet.index") }}" class="nav-link {{ request()->is('admin/products') || request()->is('admin/products/*') ? 'active' : '' }}">
                    <i class="fa fa-product-hunt nav-icon">

                    </i>
                     Wallet Management
                </a>
            </li> -->
            <!-- <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle">
                    <i class="fas fa-users nav-icon">

                    </i>
                    Wallet Management
                </a>
                <ul class="nav-dropdown-items">
                    @can('wallet_agency_menu')
                    <li class="nav-item">
                        <a href="{{ route("admin.wallet.index") }}" class="nav-link {{ request()->is('admin/wallet') || request()->is('admin/wallet/*') ? 'active' : '' }}">
                            <i class="fas fa-users nav-icon">

                            </i>
                            Agencies
                        </a>
                    </li>
                    @endcan
                    @can('wallet_customer_menu')
                    <li class="nav-item">
                        <a href="{{ route("admin.wallet.customer") }}" class="nav-link {{ request()->is('admin/wallet') || request()->is('admin/wallet/*') ? 'active' : '' }}">
                            <i class="fas fa-user nav-icon">

                            </i>
                            Customers
                        </a>
                    </li>  
                    @endcan                 
                </ul>
            </li> -->
            @can('servicerequest_access')
            <li class="nav-item">
                <a href="{{ route("admin.service-request.index") }}" class="nav-link {{ request()->is('admin/service-request') || request()->is('admin/service-request/*') ? 'active' : '' }}">
                    <i class="fa fa-list nav-icon">

                    </i>
                     Maid Requests from Emp
                </a>
            </li>
            @endcan 
            @can('agentmaidrequest_access')
            <li class="nav-item">
                <a href="{{ route("admin.agent-product-request.index") }}" class="nav-link {{ request()->is('admin/agent-product-request') || request()->is('admin/agent-product-request/*') ? 'active' : '' }}">
                    <i class="fa fa-list nav-icon">

                    </i>
                    Maid Request from Agency
                </a>
            </li>
            @endcan
            @can('agencymaidrequest_access')
            <li class="nav-item">
                <a href="{{ route("admin.agency-product-request.index") }}" class="nav-link {{ request()->is('admin/agent-product-request') || request()->is('admin/agent-product-request/*') ? 'active' : '' }}">
                    <i class="fa fa-list nav-icon">

                    </i>
                     Maid Requests to Agent
                </a>
            </li>
            @endcan
            @can('package_access')
            <li class="nav-item">
                <a href="{{ route("admin.packages.index") }}" class="nav-link {{ request()->is('admin/packages') || request()->is('admin/packages/*') ? 'active' : '' }}">
                    <i class="fa fa-list nav-icon">

                    </i>
                    Subscription Packages
                </a>
            </li>
            @endcan            
            @can('report_access')
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle">
                    <i class="fas fa-file nav-icon">

                    </i>
                    Reports
                </a>
                <ul class="nav-dropdown-items ml-4">
                    <li class="nav-item">
                        <a href="{{ route("admin.reports.employers") }}" class="nav-link {{ request()->is('admin/reports/employers') || request()->is('admin/reports/employers/employers*') ? 'active' : '' }}">
                            <i class="fas fa-users nav-icon">

                            </i>
                            Employer
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route("admin.reports.products") }}" class="nav-link {{ request()->is('admin/reports/products') || request()->is('admin/reports/products/*') ? 'active' : '' }}">
                            <i class="fa fa-product-hunt nav-icon">

                            </i>
                            Maids(Products)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route("admin.reports.providers") }}" class="nav-link {{ request()->is('admin/reports/providers') || request()->is('admin/reports/providers/*') ? 'active' : '' }}">
                            <i class="fas fa-users nav-icon">

                            </i>
                            Providers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route("admin.reports.subscription") }}" class="nav-link {{ request()->is('admin/reports/subscription') || request()->is('admin/reports/subscription/*') ? 'active' : '' }}">
                            <i class="fas fa-money nav-icon">

                            </i>
                            Subscriptions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route("admin.reports.maidrequest") }}" class="nav-link {{ request()->is('admin/reports/maidrequest') || request()->is('admin/reports/maidrequest/*') ? 'active' : '' }}">
                            <i class="fas fa-users nav-icon">

                            </i>
                            Maid Requests
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
            @can('settings_access')
            <li class="nav-item">
                <a href="{{ route("admin.settings.index") }}" class="nav-link {{ request()->is('admin/settings') || request()->is('admin/settings/*') ? 'active' : '' }}">
                    <i class="fa fa-cog nav-icon">

                    </i>
                    Settings
                </a>
            </li>
            @endcan 
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>

        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; height: 869px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 415px;"></div>
        </div>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>