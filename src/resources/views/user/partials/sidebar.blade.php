

<div id="sideContent" class="side_content">
    <div class="logo_container">
        <div class="logo_name">
            @php
               $panel_logo =  $general->panel_logo ?  $general->panel_logo : "panel_logo.png"
            @endphp
            <div class="logo_img">
                <img src="{{showImage(filePath()['panel_logo']['path'].'/'.$panel_logo)}}" alt="{{ translate('Site Logo')}}">
            </div>
            <div onclick="showSideBar()" class="cross">
                <i class="lar la-times-circle fs--9 "></i>
            </div>
        </div>
    </div>
    <div class="side_bar_menu_container">
        <div class="mt-2 mx-2 p-2">
            <input class=" form-control menu-search" placeholder="{{translate('Search Here')}}" type="text" name="" id="searchMenu">
         </div>

        <div class="main-nav side_bar_menu_list">

            <ul class="menu-list">
                <li>
                    <a class="ms--1 d--flex align--center {{menuActive('user.dashboard')}}" href="{{route('user.dashboard')}}">
                        <span class=""><i class="fs-5 las la-tachometer-alt  "></i></span>{{ translate('Dashboard')}}
                    </a>
                </li>
                <li>
                    <a class="ms--1 d--flex align--center {{menuActive('user.plan.create')}}" href="{{route('user.plan.create')}}">
                        <span class=""><i class="fs-5 las la-money-bill-wave  "></i></span>{{ translate('Pricing Plan') }}
                    </a>
                </li>

                <li>
                    <a class="ms--1 d--flex align--center {{menuActive('user.plan.subscription')}}" href="{{route('user.plan.subscription')}}">
                        <span class=""><i class="fs-5 las la-calendar-day  "></i></span>{{ translate('Subscriptions')}}
                    </a>
                </li>
                <li class="sidebar-title">{{ translate('MESSAGING')}}</li>


                <li class="li-has-children">
                    <a class="ms--1 d--flex align--center {{request()->routeIs('user.sms.*') && !request()->routeIs('user.sms.gateway.index')  ? "active" :""}} " href="javascript:void(0)"><span class=""><i class="fs-5 las la-envelope "></i></span> {{ translate('SMS')}} </a>
                    <i class='bi bi-chevron-down dropdown-icon'></i>
                    <ul class="sub-menu {{request()->routeIs('user.sms.*') && !request()->routeIs('user.sms.gateway.index') ? "animate" :""}}">
                        <li>
                            <a class="{{menuActive('user.sms.send')}}" href="{{route('user.sms.send')}}"><i class="lab la-jira "></i> {{ translate('Send SMS')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('user.sms.index')}}" href="{{route('user.sms.index')}}"><i class="lab la-jira "></i> {{ translate('All SMS')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('user.sms.pending')}}" href="{{route('user.sms.pending')}}"><i class="lab la-jira "></i> {{ translate('Pending SMS')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('user.sms.schedule')}}" href="{{route('user.sms.schedule')}}"><i class="lab la-jira "></i> {{ translate('Schedule SMS')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('user.sms.processing')}}" href="{{route('user.sms.processing')}}"><i class="lab la-jira "></i> {{ translate('Processing SMS')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('user.sms.delivered')}}" href="{{route('user.sms.delivered')}}"><i class="lab la-jira "></i> {{ translate('Delivered SMS')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('user.sms.failed')}}" href="{{route('user.sms.failed')}}"><i class="lab la-jira "></i> {{ translate('Failed SMS')}}</a>
                        </li>

                    </ul>
                </li>

                <li class="li-has-children">
                    <a class="ms--1 d--flex align--center {{request()->routeIs('user.whatsapp.*') &&  !request()->routeIs('user.whatsapp.credit.*')  ? "active" :""}} " href="javascript:void(0)"><span class=""><i class="fs-5 lab la-whatsapp"></i></i></span> {{ translate('WhatsApp')}}</a>
                    <i class='bi bi-chevron-down dropdown-icon'></i>
                    <ul class="sub-menu {{request()->routeIs('user.whatsapp.*')  &&  !request()->routeIs('user.whatsapp.credit.*') ? "animate" :""}}">
                        <li>
                            <a class="{{menuActive('user.whatsapp.send')}}" href="{{route('user.whatsapp.send')}}"><i class="lab la-jira "></i> {{ translate('Send Message')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('user.whatsapp.index')}}" href="{{route('user.whatsapp.index')}}"><i class="lab la-jira "></i> {{ translate('All Message')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('user.whatsapp.pending')}}" href="{{route('user.whatsapp.pending')}}"><i class="lab la-jira "></i> {{ translate('Pending Message')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('user.whatsapp.schedule')}}" href="{{route('user.whatsapp.schedule')}}"><i class="lab la-jira "></i> {{ translate('Schedule Message')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('user.whatsapp.processing')}}" href="{{route('user.whatsapp.processing')}}"><i class="lab la-jira "></i> {{ translate('Processing Message')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('user.whatsapp.delivered')}}" href="{{route('user.whatsapp.delivered')}}"><i class="lab la-jira "></i> {{ translate('Delivered Message')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('user.whatsapp.failed')}}" href="{{route('user.whatsapp.failed')}}"><i class="lab la-jira "></i> {{ translate('Failed Message')}}</a>
                        </li>
                    </ul>
                </li>

                <li class="li-has-children">
                    <a class="ms--1 d--flex align--center {{request()->routeIs('user.manage.email.*')  ? "active" :""}} side_bar_ten_list" href="javascript:void(0)"><span class=""><i class="fs-5 las la-envelope-open-text "></i></span>{{ translate('Email')}}</a>
                    <i class='bi bi-chevron-down dropdown-icon'></i>
                    <ul class="sub-menu {{request()->routeIs('user.manage.email.*')  ? "animate" :""}}">
                        <li>
                            <a class="{{menuActive('user.manage.email.send')}}" href="{{route('user.manage.email.send')}}"><i class="lab la-jira"></i> {{ translate('Send Email')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive(['user.manage.email.index','user.manage.email.search', 'user.manage.email.date.search'])}}" href="{{route('user.manage.email.index')}}"><i class="lab la-jira "></i> {{ translate('All Email')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('user.manage.email.pending')}}" href="{{route('user.manage.email.pending')}}"><i class="lab la-jira "></i> {{ translate('Pending Email')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('user.manage.email.schedule')}}" href="{{route('user.manage.email.schedule')}}"><i class="lab la-jira "></i> {{ translate('Schedule Email')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('user.manage.email.delivered')}}" href="{{route('user.manage.email.delivered')}}"><i class="lab la-jira "></i> {{ translate('Delivered Email')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('user.manage.email.failed')}}" href="{{route('user.manage.email.failed')}}"><i class="lab la-jira "></i> {{ translate('Failed Email')}}</a>
                        </li>
                    </ul>
                </li>


                <li>
                    <a class="ms--1 d--flex align--center {{menuActive('user.phone.book.template.index')}}" href="{{route('user.phone.book.template.index')}}">
                        <span class=""><i class="las la-palette fs-5  "></i></span> {{ translate('SMS Template')}}
                    </a>
                </li>

                <li>
                    <a class="ms--1 d--flex align--center {{menuActive('user.template.email.list')}}" href="{{route('user.template.email.list')}}">
                        <span class=""><i class="las la-align-center fs-5  "></i></span> {{ translate('Email Template')}}
                    </a>
                </li>

                <li class="sidebar-title">{{ translate('CONTACTS')}}</li>

                <li class="li-has-children">
                    <a class="ms--1 d--flex align--center {{request()->routeIs('user.phone.book.*') && !request()->routeIs('user.phone.book.template.index*')   ? "active" :""}} side_bar_twenty_list" href="javascript:void(0)"><span class=""><i class="fs-5 las la-sms "></i></span>{{ translate('Phonebook')}}</a>
                    <i class='bi bi-chevron-down dropdown-icon'></i>
                    <ul class="sub-menu {{request()->routeIs('user.phone.book.*')  && !request()->routeIs('user.phone.book.template.index*')  ? "animate" :""}}">
                        <li>
                            <a class="{{menuActive(['user.phone.book.group.index','user.phone.book.group.sms.contact'])}}" href="{{route('user.phone.book.group.index')}}"><i class="lab la-jira "></i> {{ translate('Groups')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('user.phone.book.contact.index')}}" href="{{route('user.phone.book.contact.index')}}"><i class="lab la-jira "></i> {{ translate('All Numbers')}}</a>
                        </li>
                    </ul>
                </li>

                <li class="li-has-children">
                    <a class="ms--1 d--flex align--center {{request()->routeIs('user.email.group.*') || request()->routeIs('user.email.contact.*')   ? "active" :""}} " href="javascript:void(0)"><span class=""><i class="fs-5 las la-envelope "></i></span>{{ translate('Email')}}</a>
                    <i class='bi bi-chevron-down dropdown-icon'></i>
                    <ul class="sub-menu {{request()->routeIs('user.email.group.*') || request()->routeIs('user.email.contact.*')  ? "animate" :""}}">
                        <li>
                            <a class="{{menuActive(['user.email.group.index','user.email.group.contact'])}}" href="{{route('user.email.group.index')}}"><i class="lab la-jira "></i> {{ translate('Groups')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive('user.email.contact.index')}}" href="{{route('user.email.contact.index')}}"><i class="lab la-jira "></i> {{ translate('All Emails')}}</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-title">{{ translate('CAMPAIGNS')}}</li>

                <li>
                    <a class="ms--1 d--flex align--center {{ menuActive(['user.campaign.email']) }}"
                        href="{{ route('user.campaign.email') }}">
                        <span class=""><i class="fs-5 las la-envelope  "></i></span>{{ translate('Email Campaign') }}
                    </a>
                </li>

                <li>
                    <a class="ms--1 d--flex align--center {{ menuActive(['user.campaign.sms']) }}"
                        href="{{ route('user.campaign.sms') }}">
                        <span class=""><i class="fs-5 las la-sms  "></i></span>{{ translate('Sms Campaign') }}
                    </a>
                </li>
                <li>
                    <a class="ms--1 d--flex align--center {{ menuActive(['user.campaign.whatsapp']) }}"
                        href="{{route('user.campaign.whatsapp') }}">
                        <span class=""><i class="fs-5 lab la-whatsapp  "></i></span>{{ translate('Whatsapp Campaign') }}
                    </a>
                </li>

                <li class="sidebar-title">{{ translate('GATEWAY')}}</li>

                <li class="li-has-children">
                    <a class="ms--1 d--flex align--center {{request()->routeIs('user.gateway.sms.*') || request()->routeIs('user.sms.gateway.index')   ? "active" :""}} " href="javascript:void(0)"><span class=""><i class="fs-5 las la-sms "></i></span>{{ translate('SMS Settings')}}</a>
                    <i class='bi bi-chevron-down dropdown-icon'></i>
                    <ul class="sub-menu  {{request()->routeIs('user.gateway.sms.*') || request()->routeIs('user.sms.gateway.index')  ? "animate" :""}}">
                        <li>
                            <a class="{{menuActive(['user.gateway.sms.sendmethod'])}}" href="{{route('user.gateway.sms.sendmethod')}}"><i class="lab la-jira "></i> {{ translate('SMS Gateway Method')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive(['user.sms.gateway.index', 'user.sms.gateway.edit'])}}" href="{{route('user.sms.gateway.index')}}"><i class="lab la-jira "></i> {{ translate('SMS API Gateway')}}</a>
                        </li>
                        <li>
                            <a class="{{menuActive(['user.gateway.sms.android.index', 'user.gateway.sms.android.sim.index'])}}" href="{{route('user.gateway.sms.android.index')}}"><i class="lab la-jira "></i> {{ translate('Android Gateway')}}</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="ms--1 d--flex align--center {{menuActive(['user.mail.configuration', 'user.mail.edit'])}}" href="{{route('user.mail.configuration')}}">
                        <span class=""><i class="lab la-whatsapp fs-5  "></i></span>
                        {{translate('Email')}}
                    </a>
                </li>

                <li>
                    <a class="ms--1 d--flex align--center {{menuActive(['user.gateway.whatsapp.edit','user.gateway.whatsapp.create'])}}" href="{{route('user.gateway.whatsapp.create')}}"><span class=""><i class="las la-envelope-open  fs-5 "></i></span>{{ translate('WhatsApp Settings')}}
                    </a>
                </li>

                <li class="sidebar-title">
                    {{ translate('REPORTS')}}
                </li>

                <li>
                    <a class="ms--1 d--flex align--center {{menuActive(['user.transaction.history', 'user.transaction.search'])}}" href="{{route('user.transaction.history')}}">
                        <span class=""><i class="fs-5 las la-credit-card  "></i></span>{{ translate('Transaction Logs')}}
                    </a>
                </li>

                <li>
                    <a class="ms--1 d--flex align--center {{menuActive(['user.credit.history', 'user.credit.search'])}}" href="{{route('user.credit.history')}}">
                        <span class=""><i class="las la-bars fs-5  "></i></span>{{ translate('SMS Credit Logs')}}
                    </a>
                </li>

                <li>
                    <a class="ms--1 d--flex align--center {{menuActive(['user.whatsapp.credit.history', 'user.whatsapp.credit.search'])}}" href="{{route('user.whatsapp.credit.history')}}"><span class=""><i class="las la-bars fs-5  "></i></span>{{ translate('WhatsApp Credit Logs')}}
                    </a>
                </li>

                <li>
                    <a class="ms--1 d--flex align--center {{menuActive(['user.credit.email.history', 'user.credit.email.search'])}}" href="{{route('user.credit.email.history')}}">
                        <span class=""><i class="las la-tasks fs-5  "></i></span>{{ translate('Email Credit Logs')}}
                    </a>
                </li>

                <li class="sidebar-title">{{ translate('DEVELOPER OPTIONS')}}</li>

                <li>
                    <a class="ms--1 d--flex align--center {{menuActive('user.generate.api.key')}}" href="{{route('user.generate.api.key')}}">
                        <span class=""><i class="fs-5 las la-key  "></i></span> {{ translate('Generate Key')}}
                    </a>
                </li>
                <li>
                    <a class="ms--1 d--flex align--center {{menuActive('api.document')}}" href="{{route('api.document')}}">
                        <span class=""><i class="fs-5 las la-code  "></i></span> {{ translate('API Document')}}
                    </a>
                </li>

                <li class="sidebar-title">{{ translate('SUPPORT')}}</li>

                <li>
                    <a class="ms--1 d--flex align--center {{menuActive(['user.ticket.index', 'user.ticket.detail', 'user.ticket.create'])}}" href="{{route('user.ticket.index')}}">
                        <span class=""><i class="las la-ticket-alt fs-5  "></i></span>{{ translate('Support Tickets')}}
                    </a>
                </li>
            </ul>
            {{-- my code end --}}

        </div>
    </div>

    <div class="sidebar-copyright text-center p-1 text-uppercase version">
        <span class="text--primary">©{{ @$general->copyright }}</span>
        <span class="text--success">{{ config('requirements.core.appVersion')}}</span>
    </div>
</div>



@push('scriptpush')
<script>
	(function($){
       	"use strict";
		$('#searchMenu').keyup(function(){
            // alert(0)
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
