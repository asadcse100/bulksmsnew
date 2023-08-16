<div id="sideContent" class="side_content">
    <div class="logo_container">
        <div class="logo_name">

            @php
               $panel_logo =  $general->panel_logo ?  $general->panel_logo : "panel_logo.png"
            @endphp

            <div class="logo_img">
                <img src="{{showImage(filePath()['panel_logo']['path'].'/'.$panel_logo)}}" class="mx-auto" alt="">
            </div>
            <div onclick="showSideBar()" class="cross">
                <i class="lar la-times-circle fs--9 text--light"></i>
            </div>
        </div>
    </div>
    <div class="side_bar_menu_container">
         <div class="mt-2 mx-2 p-2">
            <input class=" form-control menu-search" placeholder="{{translate('Search Here')}}" type="text" name="" id="searchMenu">
         </div>
        <div class="main-nav side_bar_menu_list mt-2">
            <ul class="menu-list">
                <li class="sidebar-title">{{ translate('MENU')}}</li>
                <li class="">
                    <a class="{{request()->routeIs('admin.dashboard') ? "active" :""}}" href="{{route('admin.dashboard')}}"><span class=""><i class="fs-5 las la-tachometer-alt "></i></span> {{ translate('Dashboard')}}</a>
                </li>

                <li class="sidebar-title">{{ translate('MESSAGING')}}</li>
                {{-- sms --}}
                <li class="li-has-children">
                    <a href="javascript:void(0)" class="drop-down  {{request()->routeIs('admin.sms.*') && !request()->routeIs('admin.sms.gateway.*') ? "active" :""}}"><span class=""><i class="fs-5 las las la-envelope"></i></span> {{ translate('SMS')}}</a>

                    @if($pending_sms_count > 0)
                        <i class="las la-exclamation sidebar-batch-icon"></i>
                    @endif
                    <i class='bi bi-chevron-down dropdown-icon'></i>

                    <ul class="sub-menu {{request()->routeIs('admin.sms.*') && !request()->routeIs('admin.sms.gateway.*') ? "animate" :"" }}">
                        <li>
                            <a class="{{menuActive('admin.sms.create')}}" href="{{route('admin.sms.create')}}"><i       class="lab la-jira "></i> {{ translate('Send SMS')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.sms.index')}}" href="{{route('admin.sms.index')}}"><i class="lab la-jira "></i> {{ translate('All SMS')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.sms.pending')}}" href="{{route('admin.sms.pending')}}"><i class="lab la-jira "></i> {{ translate('Pending Message')}}
                                @if($pending_whatsapp_count > 0)
                                    <span class="badge bg-danger"> {{$pending_whatsapp_count}}</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.sms.success')}}" href="{{route('admin.sms.success')}}"><i class="lab la-jira "></i> {{ translate('Delivered SMS')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.sms.schedule')}}" href="{{route('admin.sms.schedule')}}"><i class="lab la-jira "></i> {{ translate('Schedule SMS')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.sms.processing')}}" href="{{route('admin.sms.processing')}}"><i class="lab la-jira "></i> {{ translate('Processing SMS')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.sms.failed')}}" href="{{route('admin.sms.failed')}}"><i class="lab la-jira "></i> {{ translate('Failed SMS')}}</a>
                        </li>
                    </ul>
                </li>
                {{-- whatsapp --}}
                <li class="li-has-children">
                    <a href="javascript:void(0)" class="drop-down  {{request()->routeIs('admin.whatsapp*') ? "active" :""}}"><span class=""><i class="fs-5 fab fa-whatsapp"></i></span> {{ translate('WhatsApp')}}</a>
                    @if($pending_whatsapp_count > 0)
                        <i class="las la-exclamation sidebar-batch-icon"></i>
                    @endif
                    <i class='bi bi-chevron-down dropdown-icon'></i>

                    <ul class="sub-menu {{request()->routeIs('admin.whatsapp*') ? "animate" :"" }}">
                        <li>
                            <a class="{{menuActive('admin.whatsapp.create')}}" href="{{route('admin.whatsapp.create')}}"><i class="lab la-jira "></i> {{ translate('Send Message')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.whatsapp.index')}}" href="{{route('admin.whatsapp.index')}}"><i class="lab la-jira "></i> {{ translate('All Message')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.whatsapp.pending')}}" href="{{route('admin.whatsapp.pending')}}"><i class="lab la-jira "></i> {{ translate('Pending Message')}}
                                @if($pending_whatsapp_count > 0)
                                    <span class="badge bg-danger"> {{$pending_whatsapp_count}}</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.whatsapp.success')}}" href="{{route('admin.whatsapp.success')}}"><i class="lab la-jira "></i> {{ translate('Delivered Message')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.whatsapp.schedule')}}" href="{{route('admin.whatsapp.schedule')}}"><i class="lab la-jira "></i> {{ translate('Schedule Message')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.whatsapp.processing')}}" href="{{route('admin.whatsapp.processing')}}"><i class="lab la-jira "></i> {{ translate('Processing Message')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.whatsapp.failed')}}" href="{{route('admin.whatsapp.failed')}}"><i class="lab la-jira "></i> {{ translate('Failed Message')}}</a>
                        </li>
                    </ul>
                </li>
         
                <li class="li-has-children">
                    <a class="ms--1 d--flex align--center {{request()->routeIs('admin.email*') ? "active" :""}}" href="javascript:void(0)"><span class=""><i class="fs-5 las las la-envelope-open-text"></i></span> {{ translate('Email')}}</a>
                    @if($pending_email_count > 0)
                        <i class="las la-exclamation sidebar-batch-icon"></i>
                    @endif
                    <i class='bi bi-chevron-down dropdown-icon'></i>

                    <ul class="sub-menu {{request()->routeIs('admin.email*') ? "animate" :"" }}">
                        <li>
                            <a class="{{menuActive('admin.email.send')}}" href="{{route('admin.email.send')}}"><i class="lab la-jira "></i> {{ translate('Send Email')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.email.index')}}" href="{{route('admin.email.index')}}"><i class="lab la-jira"></i> {{ translate('All Email')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.email.pending')}}" href="{{route('admin.email.pending')}}"><i class="lab la-jira "></i> {{ translate('Pending Email')}}
                                @if($pending_email_count > 0)
                                    <span class="badge bg-danger"> {{$pending_email_count}}</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.email.success')}}" href="{{route('admin.email.success')}}"><i class="lab la-jira "></i> {{ translate('Delivered Email')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.email.schedule')}}" href="{{route('admin.email.schedule')}}"><i class="lab la-jira "></i> {{ translate('Schedule Email')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.email.failed')}}" href="{{route('admin.email.failed')}}"><i class="lab la-jira "></i> {{ translate('Failed Email')}}</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-title">{{ translate('CONTACTS')}}</li>
                 {{-- groups --}}
                 <li class="li-has-children">
                    <a class="ms--1 d--flex align--center {{request()->routeIs('admin.group.*') ? "active" :""}} " href="javascript:void(0)">
                        <span class=""><i class="fs-5 las la-layer-group"></i></span> {{ translate('Groups')}}
                    </a>
                    <i class='bi bi-chevron-down dropdown-icon'></i>

                    <ul class="sub-menu {{request()->routeIs('admin.group.*') ? "animate" :"" }}">
                        <li>
                            <a class="{{menuActive(['admin.group.own.sms.index', 'admin.group.sms.groupby'])}}" href="{{route('admin.group.own.sms.index')}}"><i class="lab la-jira"></i> {{ translate('Own SMS Group')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive(['admin.group.own.email.index','admin.group.email.groupby'])}}" href="{{route('admin.group.own.email.index')}}"><i class="lab la-jira "></i> {{ translate('Own Email Group')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive(['admin.group.sms.index', 'admin.group.sms.groupby'])}}" href="{{route('admin.group.sms.index')}}"><i class="lab la-jira "></i> {{ translate('User SMS Group')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive(['admin.group.email.index', 'admin.group.email.groupby'])}}" href="{{route('admin.group.email.index')}}"><i class="lab la-jira "></i> {{ translate('User Email Group')}}</a>
                        </li>
                    </ul>
                </li>
                {{-- contacts --}}
                <li class="li-has-children">
                    <a class="ms--1 d--flex align--center {{request()->routeIs('admin.contact.*') ? "active" :""}} " href="javascript:void(0)"><span class=""><i class="fs-5 las la-comments-dollar"></i></span> {{ translate('Contact')}}</a>

                    <i class='bi bi-chevron-down dropdown-icon'></i>

                    <ul class="sub-menu {{request()->routeIs('admin.contact.*') ? "animate" :"" }} ">
                        <li>
                            <a class="{{menuActive('admin.contact.email.own.index')}}" href="{{route('admin.contact.email.own.index')}}"><i class="lab la-jira "></i> {{ translate('Own Email Contact')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.contact.sms.own.index')}}" href="{{route('admin.contact.sms.own.index')}}"><i class="lab la-jira "></i> {{ translate('Own SMS Contact')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.contact.email.index')}}" href="{{route('admin.contact.email.index')}}"><i class="lab la-jira "></i> {{ translate('User Email Contact')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.contact.sms.index')}}" href="{{route('admin.contact.sms.index')}}"><i class="lab la-jira "></i> {{ translate('User SMS Contact')}}</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-title">{{ translate('USERS')}}</li>
                 {{-- manag users --}}
                 <li class="li-has-children">
                    <a class="d--flex align--center {{request()->routeIs('admin.user.*') ? "active" :"" }} " href="javascript:void(0)"><span class=""><i class="fs-5 las la-user-plus"></i></span> {{ translate('Manage Users')}}</a>
                    <i class='bi bi-chevron-down dropdown-icon'></i>

                    <ul class="sub-menu {{request()->routeIs('admin.user.*') ? "animate" :"" }}">
                        <li>
                            <a class="{{menuActive(['admin.user.index', 'admin.user.details', 'admin.user.search', 'admin.user.contact', 'admin.user.sms', 'admin.user.subscription'])}}" href="{{route('admin.user.index')}}"><i class="lab la-jira "></i> {{ translate('All Users')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.user.active')}}" href="{{route('admin.user.active')}}"><i class="lab la-jira "></i> {{ translate('Active Users')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.user.banned')}}" href="{{route('admin.user.banned')}}"><i class="lab la-jira "></i> {{ translate('Banned Users')}}</a>
                        </li>
                    </ul>
                </li>
                {{-- pricing plan --}}
                <li>
                    <a class="d--flex align--center {{menuActive('admin.plan.index')}}" href="{{route('admin.plan.index')}}">
                        <span class=""><i class="fs-5 las la-paper-plane "></i></span> {{ translate('Pricing Plan')}}
                    </a>
                </li>

                <li class="sidebar-title">{{ translate('CAMPAIGNS')}}</li>
                {{-- email campaigns --}}
                <li>
                    <a class="ms--1 d--flex align--center {{ menuActive(['admin.campaign.email']) }}"href="{{ route('admin.campaign.email') }}">
                        <span class=""><i class="fs-5 las la-envelope "></i></span>{{ translate('Email Campaign') }}
                    </a>
                </li>
                {{-- sms campaigns --}}
                <li>
                    <a class="ms--1 d--flex align--center {{ menuActive(['admin.campaign.sms']) }}"
                        href="{{ route('admin.campaign.sms') }}">
                        <span class=""><i class="fs-5 las la-sms "></i></span>{{ translate('Sms Campaign') }}
                    </a>
                </li>
                {{-- whatsapp campaigns --}}
                <li>
                    <a class="ms--1 d--flex align--center {{ menuActive(['admin.campaign.whatsapp']) }}"
                         href="{{route('admin.campaign.whatsapp') }}">
                        <span class=""><i class="fs-5 lab la-whatsapp "></i></span>{{ translate('Whatsapp Campaign') }}
                    </a>
                </li>

                <li class="sidebar-title">{{ translate('SETTINGS')}}</li>
                {{-- sms settings --}}
                <li class="li-has-children">
                    <a class="ms--1 d--flex align--center {{request()->routeIs('admin.sms.gateway.*') ? "active" :"" }}  " href="javascript:void(0)">
                        <span class=""><i class="fs-5 las la-sms"></i></span> {{ translate('SMS Settings')}}
                    </a>
                    <i class='bi bi-chevron-down dropdown-icon'></i>

                    <ul class="sub-menu {{request()->routeIs('admin.sms.gateway.*') ? "animate" :"" }}">
                        <li>
                            <a class="{{menuActive(['admin.sms.gateway.index','admin.gateway.sms.edit'])}}" href="{{route('admin.sms.gateway.index')}}"><i class="lab la-jira "></i> {{ translate('SMS Api Gateway')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive(['admin.sms.gateway.android.index', 'admin.sms.gateway.android.sim.index'])}}" href="{{route('admin.sms.gateway.android.index')}}"><i class="lab la-jira"></i> {{ translate('Android Gateway')}}</a>
                        </li>
                    </ul>
                </li>
                 {{-- whatsapp settings --}}
                 <li class="li-has-children">
                    <a class="ms--1 d--flex align--center {{request()->routeIs('admin.gateway.whatsapp.*') ? "active" :"" }}  " href="javascript:void(0)"><span class=""><i class="fs-5 fab fa-whatsapp"></i></span> {{ translate('WhatsApp Settings')}}</a>
                    <i class='bi bi-chevron-down dropdown-icon'></i>

                    <ul class="sub-menu {{request()->routeIs('admin.gateway.whatsapp.*') ? "animate" :"" }}">
                        <li>
                            <a class="{{menuActive(['admin.gateway.whatsapp.edit','admin.gateway.whatsapp.create'])}}" href="{{route('admin.gateway.whatsapp.create')}}"><i class="lab la-jira "></i> {{ translate('Add/View Device')}}</a>
                        </li>
                    </ul>
                </li>
                {{-- email settings --}}
                <li class="li-has-children">
                    <a class="ms--1 d--flex align--center {{request()->routeIs('admin.mail.*') ? "active" :"" }} " href="javascript:void(0)"><span class=""><i class="fs-5 las las la-envelope"></i></span> {{ translate('Email Settings')}}</a>
                    <i class='bi bi-chevron-down dropdown-icon'></i>

                    <ul class="sub-menu  {{request()->routeIs('admin.mail.*') ? "animate" :"" }}">
                        <li>
                            <a class="{{menuActive(['admin.mail.index', 'admin.mail.edit'])}}" href="{{route('admin.mail.index')}}"><i class="lab la-jira "></i> {{ translate('Mail Configuration')}}</a>
                        </li>
                        <li>
                            <a class=" {{menuActive(['admin.mail.global.template'])}}" href="{{route('admin.mail.global.template')}}"><i class="lab la-jira"></i> {{ translate('Global Template')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive(['admin.mail.templates.index', 'admin.mail.templates.edit'])}}" href="{{route('admin.mail.templates.index')}}"><i class="lab la-jira "></i> {{ translate('Mail Templates')}}</a>
                        </li>
                    </ul>
                </li>
                {{-- messaging template --}}
                <li class="li-has-children">
                    <a class="ms--1 d--flex align--center {{request()->routeIs('admin.template.*') ? "active" :"" }}" href="javascript:void(0)">
                        <span class=""><i class="fs-5 las la-palette "></i></span>{{ translate('Messaging Template')}}
                    </a>
                    <i class='bi bi-chevron-down dropdown-icon'></i>

                    <ul class="sub-menu {{request()->routeIs('admin.template.*') ? "animate" :"" }}">
                        <li>
                            <a class="{{ menuActive(['admin.template.index']) }}"
                                href="{{ route('admin.template.index') }}"> <i class="lab la-jira"></i> {{translate('Admin SMS Template')}}</a>
                        </li>
                        <li>
                            <a class="{{ menuActive(['admin.template.user.index']) }}" href="{{ route('admin.template.user.index') }}"> <i class="lab la-jira"></i> {{translate('User SMS Template')}}</a>
                        </li>

                        <li>
                            <a class="{{ menuActive(['admin.template.email.list','admin.template.email.edit']) }}"
                                href="{{ route('admin.template.email.list') }}"> <i class="lab la-jira"></i> {{translate('Admin Email Template')}}</a>
                        </li>
                        <li>
                            <a class="{{ menuActive(['admin.template.email.user.list']) }}" href="{{ route('admin.template.email.user.list') }}"> <i class="lab la-jira "></i> {{ translate('User Email Template')}}</a>
                        </li>
                    </ul>
                </li>
                <!-- Language Settings -->
                <li>
                    <a class="ms--1 d--flex align--center {{menuActive(['admin.language.index', 'admin.language.edit'])}}" href="{{route('admin.language.index')}}">
                        <span class=""><i class="fs-5 las la-language "></i></span> {{ translate('Manage Language') }}
                    </a>
                </li>
                <!-- spam words -->
                <li>
                    <a class="ms--1 d--flex align--center {{ menuActive(['admin.spam.word.index']) }}"
                        href="{{ route('admin.spam.word.index') }}">
                        <span class=""><i class="fs-5 las la-pastafarianism "></i></span>{{ translate('Spam Words') }}
                    </a>
                </li>
                 {{-- payment-gateway settings --}}
                 <li class="li-has-children">
                    <a class="ms--1 d--flex align--center {{request()->routeIs('admin.payment.method.*') ||  request()->routeIs('admin.manual.payment.*') ? "active" :"" }} " href="javascript:void(0)"><span class=""><i class="fs-5 las la-credit-card"></i></span> {{ translate('Payment Gateway')}}</a>
                    <i class='bi bi-chevron-down dropdown-icon'></i>

                    <ul class="sub-menu {{request()->routeIs('admin.payment.method.*') || request()->routeIs('admin.manual.payment.*')  ? "animate" :"" }}">
                        <li>
                            <a class="{{menuActive(['admin.payment.method.index', 'admin.payment.method.edit'])}}" href="{{route('admin.payment.method.index')}}"><i class="lab la-jira "></i> {{ translate('Automatic Gateway')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive(['admin.manual.payment.index', 'admin.manual.payment.edit'])}}" href="{{route('admin.manual.payment.index')}}"><i class="lab la-jira"></i> {{ translate('Manual Gateway') }}</a>
                        </li>
                    </ul>
                </li>
                {{-- system settings --}}
                <li class="li-has-children">
                    <a class="ms--1 d--flex align--center {{request()->routeIs('admin.general.setting.*') && !request()->routeIs('admin.general.setting.system.info')  ? "active" :"" }} " href="javascript:void(0)"><span class=""><i class="fs-5 las las la-cog"></i></span> {{ translate('System Settings')}}</a>
                    <i class='bi bi-chevron-down dropdown-icon'></i>

                    <ul class="sub-menu {{request()->routeIs('admin.general.setting.*') && !request()->routeIs('admin.general.setting.system.info') ? "animate" :"" }}">
                        <li>
                            <a class="{{menuActive('admin.general.setting.index')}}" href="{{route('admin.general.setting.index')}}"><i class="lab la-jira"></i> {{ translate('Setting')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.general.setting.social.login')}}" href="{{route('admin.general.setting.social.login')}}"><i class="lab la-jira "></i> {{ translate('Google Login')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.general.setting.beefree.plugin')}}" href="{{route('admin.general.setting.beefree.plugin')}}"><i class="lab la-jira"></i> {{ translate('Bee Plugin')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.general.setting.currency.index')}}" href="{{route('admin.general.setting.currency.index')}}"><i class="lab la-jira "></i> {{ translate('Currencies')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.general.setting.frontend.section')}}" href="{{route('admin.general.setting.frontend.section')}}"><i class="lab la-jira "></i> {{ translate('User Login Section')}}</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-title">{{ translate('REPORTS')}}</li>
                 {{-- transaction-log --}}
                 <li class="li-has-children">
                    <a class="ms--1 d--flex align--center {{request()->routeIs('admin.report.*') ? "active" :"" }} " href="javascript:void(0)"><span class=""><i class="fs-5 las la-bars"></i></span> {{ translate('Transaction Logs')}}</a>
                    @if($pending_manual_payment_count > 0)
                        <i class="las la-exclamation sidebar-batch-icon"></i>
                    @endif
                    <i class='bi bi-chevron-down dropdown-icon'></i>

                    <ul class="sub-menu  {{request()->routeIs('admin.report.*') ? "animate" :"" }}">
                        <li>
                            <a class="{{menuActive(['admin.report.transaction.index','admin.report.transaction.search'])}}" href="{{route('admin.report.transaction.index')}}"><i class="lab la-jira"></i> {{ translate('Transaction History')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive(['admin.report.subscription.index','admin.report.subscription.search','admin.report.subscription.search.date'])}}" href="{{route('admin.report.subscription.index')}}"><i class="lab la-jira"></i> {{ translate('Subscription History')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive(['admin.report.payment.index', 'admin.report.payment.detail'])}}" href="{{route('admin.report.payment.index')}}"><i class="lab la-jira "></i> {{ translate('Payment History')}}
                                @if($pending_manual_payment_count > 0)
                                    <span class="badge bg-danger"> {{$pending_manual_payment_count}}</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a class="{{menuActive(['admin.report.credit.index','admin.report.credit.search'])}}" href="{{route('admin.report.credit.index')}}"><i class="lab la-jira "></i> {{ translate('SMS Credit Log')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive(['admin.report.whatsapp.index','admin.report.whatsapp.search'])}}" href="{{route('admin.report.whatsapp.index')}}"><i class="lab la-jira"></i> {{ translate('WhatsApp Credit Log')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive(['admin.report.email.credit.index','admin.report.email.credit.search'])}}" href="{{route('admin.report.email.credit.index')}}"><i class="lab la-jira "></i> {{ translate('Email Credit Log')}}</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-title">{{ translate('FRONTEND MANAGE')}}</li>
                {{-- transaction-log --}}
                <li class="li-has-children">
                    <a class="ms--1 d--flex align--center  {{request()->routeIs('admin.frontend.sections.*') ?"active" :""}} " href="javascript:void(0)">
                        <span class="">
                            <i class=" fs-5 las la-globe-americas"></i>
                        </span> {{ translate('Frontend Section')}}
                    </a>
                    <i class='bi bi-chevron-down dropdown-icon'></i>

                   <ul class="sub-menu {{request()->routeIs('admin.frontend.sections.*') ? "animate" :""}}">
                        @php
                            $lastElement =  collect(request()->segments())->last();
                        @endphp
                            @foreach(getFrontendSection(true) as $key => $section)
                            <li>
                            
                                <a class="@if($lastElement == $key) active @endif" href="{{ route('admin.frontend.sections.index',$key) }}">
                                    <i class="lab la-jira "></i> {{__(\Illuminate\Support\Arr::get($section, 'name',''))}}
                                </a>
                            
                            </li>
                        @endforeach
                    </ul>
                </li>

                <li class="sidebar-title">{{ translate('SUPPORT')}}</li>
                <li class="li-has-children">
                    <a class="ms--1 d--flex align--center {{request()->routeIs('admin.support.ticket.*') ? "active" :""}} " href="javascript:void(0)"><span class=""><i class="fs-5 las la-ticket-alt"></i></span> {{ translate('Support Tickets')}}
                    </a>
                    @if($running_support_ticket_count > 0)
                        <i class="las la-exclamation sidebar-batch-icon"></i>
                    @endif
                    <i class='bi bi-chevron-down dropdown-icon'></i>

                    <ul class="sub-menu {{request()->routeIs('admin.support.ticket.*') ? "animate" :""}}">
                        <li>
                            <a class="{{menuActive(['admin.support.ticket.index', 'admin.support.ticket.search'])}}" href="{{route('admin.support.ticket.index')}}"><i class="lab la-jira "></i> {{ translate('All Tickets')}}
                            </a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.support.ticket.running')}}" href="{{route('admin.support.ticket.running')}}"><i class="lab la-jira"></i> {{ translate('Running Tickets')}}
                                @if($running_support_ticket_count > 0)
                                    <span class="badge bg-danger"> {{$running_support_ticket_count}}</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.support.ticket.answered')}}" href="{{route('admin.support.ticket.answered')}}"><i class="lab la-jira "></i> {{ translate('Answered Tickets')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.support.ticket.replied')}}" href="{{route('admin.support.ticket.replied')}}"><i class="lab la-jira "></i> {{ translate('Replied Tickets')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('admin.support.ticket.closed')}}" href="{{route('admin.support.ticket.closed')}}"><i class="lab la-jira"></i> {{ translate('Closed Tickets')}}</a>
                        </li>
                    </ul>

                </li>
                <li>
                    <a class="ms--1 d--flex align--center {{menuActive(['admin.general.setting.system.info'])}}" href="{{route('admin.general.setting.system.info')}}">
                    <span class=""><i class="fs-5 las la-info-circle "></i></span> {{ translate('Server Information')}}
                    </a>
                </li>

                <li class="sidebar-title">{{ translate('DEVELOPER OPTION')}}</li>
                <li>
                    <a class="ms--1 d--flex align--center {{menuActive('admin.generate.api.key')}}" href="{{route('admin.generate.api.key')}}">
                        <span class=""><i class="fs-5 las la-key 
                            "></i></span> {{ translate('Generate Key')}}
                    </a>
                </li>
                <li>
                    <a class="ms--1 d--flex align--center {{menuActive('api.document')}}" href="{{route('api.document')}}">
                        <span class=""><i class="fs-5 las la-code 
                            "></i></span> {{ translate('API Document')}}
                    </a>
                </li>
            </ul>
        </div>

    </div>
    <div class="sidebar-copyright text-center p-1 text-uppercase version">
        <span>©{{ @$general->copyright }}</span>
        <span class="version"> {{ config('requirements.core.appVersion')}}</span>
    </div>
</div>



@push('scriptpush')
<script>
	(function($){
       	"use strict";
		$('#searchMenu').keyup(function(){

			var value = $(this).val().toLowerCase();
            if (value === '') {
               $('.side_bar_menu_list h1').show();
            } else {
                $('.side_bar_menu_list h1').hide();
            }
			$('.side_bar_menu_list ul li').each(function(){
				var lcval = $(this).text().toLowerCase();
                if(lcval.indexOf(value)>-1){
                    $(this).show();
                } else {
                    $(this).hide();
                }

			});


		});
	})(jQuery);
</script>
@endpush
