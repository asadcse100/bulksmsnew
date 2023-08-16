@extends('admin.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="row g-3">
        <div class="col-12 col-md-6 col-lg-6 col-xl-4">
            <div class="info-card style-purple">
                <div class="icon">
                    <i class="las la-comment"></i>
                </div>
                <div class="content">
                    <h4>{{$smslog['all']}}</h4>
                    <p>{{ translate('Total SMS')}}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6 col-xl-4">
            <div class="info-card style-purple">
                <div class="icon">
                    <i class="las la-comment-alt"></i>
                </div>
                <div class="content">
                    <h4>{{$smslog['success']}}</h4>
                    <p>{{ translate('Total Success SMS')}}</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-6 col-xl-4">
            <div class="info-card style-purple">
                <div class="icon">
                    <i class="las la-inbox"></i>
                </div>
                <div class="content">
                    <h4>{{$phonebook['contact']}}</h4>
                    <p>{{ translate('Total SMS Contact')}}</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-6 col-xl-4">
            <div class="info-card style-gold">
                <div class="icon">
                    <i class="las la-envelope"></i>
                </div>
                <div class="content">
                    <h4>{{$emailLog['all']}}</h4>
                    <p>{{ translate('Total Email')}}</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-6 col-xl-4">
            <div class="info-card style-gold">
                <div class="icon">
                    <i class="las la-envelope-open"></i>
                </div>
                <div class="content">
                    <h4>{{$emailLog['success']}}</h4>
                    <p>{{ translate('Total Success Email')}}</h6>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-6 col-xl-4">
            <div class="info-card style-gold">
                <div class="icon">
                    <i class="las la-envelope-open-text"></i>
                </div>
                <div class="content">
                    <h4>{{$phonebook['email_contact']}}</h4>
                    <p>{{ translate('Total Email Contact')}}</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-6 col-xl-4">
            <div class="info-card style-green">
                <div class="icon">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <div class="content">
                    <h4>{{$whatsappLog['all']}}</h4>
                    <p>{{ translate('Total Sent WhatsApp Message')}}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-6 col-xl-4">
            <div class="info-card style-green">
                <div class="icon">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <div class="content">
                    <h4 >{{$whatsappLog['success']}}</h4>
                    <p>{{ translate('Total Success WhatsApp Message')}}</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-6 col-xl-4">
            <div class="info-card style-green">
                <div class="icon">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <div class="content">
                    <h4>{{$whatsappLog['pending']}}</h4>
                    <p>{{ translate('Total Pending WhatsApp Message')}}</p>
                </div>
            </div>
        </div>

    </div>
</section>


<section class="mt-35">
    <div class="row g-3">
        <div class="col-lg-3">
            <a href="{{route('admin.user.index')}}" class="single_pinned_project">
                <div class="pinned_icon">
                    <i class="las la-user"></i>
                </div>
                <div class="pinned_text">
                    <div>
                        <h6>{{ translate('Total User')}}</h6>
                        <p>{{$phonebook['user']}} {{ translate('User')}}</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3">
            <a href="{{route('admin.plan.index')}}" class="single_pinned_project">
                <div class="pinned_icon">
                    <i class="lab la-telegram-plane"></i>
                </div>
                <div class="pinned_text">
                    <div>
                        <h6>{{ translate('Total Pricing Plan')}}</h6>
                        <p>{{$phonebook['plan']}} {{ translate('Plan')}}</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3">
            <a href="{{route('admin.report.subscription.index')}}" class="single_pinned_project">
                <div class="pinned_icon">
                    <i class="las la-credit-card"></i>
                </div>
                <div class="pinned_text">
                    <div>
                        <h6>{{ translate('Total Subscription User')}}</h6>
                        <p>{{$phonebook['subscription']}}</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3">
            <a href="{{route('admin.sms.gateway.index')}}" class="single_pinned_project">
                <div class="pinned_icon">
                    <i class="las la-angle-double-right"></i>
                </div>
                <div class="pinned_text">
                    <div>
                        <h6>{{ translate('Total SMS Api Gateway')}}</h6>
                        <p>{{$phonebook['sms_gateway']}}</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3">
            <a href="{{route('admin.sms.gateway.android.index')}}" class="single_pinned_project">
                <div class="pinned_icon">
                   <i class="lab la-android"></i>
                </div>
                <div class="pinned_text">
                    <div>
                        <h6>{{ translate('Total Android Gateway')}}</h6>
                        <p>{{$phonebook['android_api']}} {{ translate('Android Gateway')}}</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3">
            <a href="{{route('admin.report.credit.index')}}" class="single_pinned_project">
                <div class="pinned_icon">
                    <i class="las la-money-bill-wave-alt"></i>
                </div>
                <div class="pinned_text">
                    <div>
                        <h6>{{ translate('Total Credit Log')}}</h6>
                        <p>{{$phonebook['credit_log']}} {{ translate('Logs')}}</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3">
            <a href="{{route('admin.report.payment.index')}}" class="single_pinned_project">
                <div class="pinned_icon">
                   <i class="las la-credit-card"></i>
                </div>
                <div class="pinned_text">
                    <div>
                        <h6>{{ translate('Payment History')}}</h6>
                        <p>{{shortAmount($phonebook['payment_log'])}} {{ translate('Logs')}}</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3">
            <a href="{{route('admin.report.transaction.index')}}" class="single_pinned_project">
                <div class="pinned_icon">
                    <i class="las la-wallet"></i>
                </div>
                <div class="pinned_text">
                    <div>
                        <h6>{{ translate('Transaction History')}}</h6>
                        <p>{{$phonebook['transaction']}} {{ translate('Log')}}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>


 <section class="mt-35">
    <div class="rounded_box">
        <div class="row">
            <div class="col-md-6">
                <div class="new-card-container">
                    <div class="info-card-2 style-red">
                        <div class="icon d--flex align--center justify--between p-2">
                            <i class="fs-4 las la-credit-card"></i>
                            <i class="fs-4 las la-ellipsis-h"></i>
                        </div>
                        <h4 class="my-3">{{@$general->currency_symbol}} {{shortAmount($phonebook['payment_amount'])}}</h4>
                        <span class="mb-3 text-secondary">{{ translate('Total Payment')}}</span>
                    </div>

                    <div class="info-card-2 style-purple">
                        <div class="icon d--flex align--center justify--between p-2">
                            <i class="fs-4 las la-wallet"></i>
                            <i class="fs-4 las la-ellipsis-h"></i>
                        </div>
                        <h4 class="my-3">{{@$general->currency_symbol}} {{shortAmount($phonebook['payment_amount_charge'])}}</h4>
                        <span class="mb-3 text-secondary">{{ translate('Payment Charge')}}</span>
                    </div>

                    <div class="info-card-2 style-gold">
                        <div class="icon d--flex align--center justify--between p-2">
                            <i class="fs-4 las la-coins"></i>
                            <i class="fs-4 las la-ellipsis-h"></i>
                        </div>
                        <h4 class="my-3">{{@$general->currency_symbol}} {{shortAmount($phonebook['subscription_amount'])}}</h4>
                        <span class="mb-3 text-secondary">{{ translate('Subscription Amount')}}</span>
                    </div>

                    <div class="info-card-2 style-green">
                        <div class="icon d--flex align--center justify--between p-2">
                            <i class="fs-4 las la-user"></i>
                            <i class="fs-4 las la-ellipsis-h"></i>
                        </div>
                        <h4 class="my-3">{{$phonebook['subscription']}}</h4>
                        <span class="mb-3 text-secondary">{{ translate('Subscription User')}}</span>
                    </div>

                    <div class="info-card-2 style-sky">
                        <div class="icon d--flex align--center justify--between p-2">
                            <i class="fs-4 las la-sms"></i>
                            <i class="fs-4 las la-ellipsis-h"></i>
                        </div>
                        <h4 class="my-3">{{$smslog['pending']}}</h4>
                        <span class="mb-3 text-secondary">{{ translate('Pending SMS')}}</span>
                    </div>

                    <div class="info-card-2 style-yellow">
                        <div class="icon d--flex align--center justify--between p-2">
                            <i class="fs-4 las la-envelope"></i>
                            <i class="fs-4 las la-ellipsis-h"></i>
                        </div>
                        <h4 class="my-3">{{$emailLog['pending']}}</h4>
                        <span class="mb-3 text-secondary">{{ translate('Pending Email')}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box-wrapper">
                    <h6 class="header-title">{{ translate('SMS Details Report')}}</h6>
                    <div id="chart30"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mt-35">
    <div class="rounded_box">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 col-xl-6 p-1">
                <h6 class="header-title">{{ translate('New User')}}</h6>
                <div class="responsive-table">
                    <table class="m-0 text-center table--light">
                        <thead>
                            <tr>
                                <th>{{ translate('Customer')}}</th>
                                <th>{{ translate('Email - Phone')}}</th>
                                <th>{{ translate('Status')}}</th>
                                <th>{{ translate('Joined At')}}</th>
                            </tr>
                        </thead>
                        @forelse($customers as $customer)
                            <tr class="@if($loop->even)@endif">
                                <td data-label="{{ translate('Customer')}}">
                                    <a href="{{route('admin.user.details', $customer->id)}}" class="brand" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ translate('Click For Details')}}">
                                        {{$customer->name}}<br>
                                    </a>
                                </td>
                                <td data-label="{{ translate('Email')}}">
                                    {{$customer->email}}<br>
                                    {{$customer->phone}}
                                </td>

                                <td data-label="{{ translate('Status')}}">
                                    @if($customer->status == 1)
                                        <span class="badge badge--success">{{ translate('Active')}}</span>
                                    @else
                                        <span class="badge badge--danger">{{ translate('Banned')}}</span>
                                    @endif
                                </td>

                                <td data-label="{{ translate('Joined At')}}">
                                    {{diffForHumans($customer->created_at)}}<br>
                                    {{getDateTime($customer->created_at)}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ translate('No Data Found')}}</td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            </div>

            <div class="col-12 col-md-12 col-lg-12 col-xl-6 p-1">
                <h6 class="header-title">{{ translate('Latest Payment Log')}}</h6>
                <div class="responsive-table">
                    <table class="m-0 text-center table--light">
                        <thead>
                            <tr>
                                <th>{{ translate('Time')}}</th>
                                <th>{{ translate('User')}}</th>
                                <th>{{ translate('Amount')}}</th>
                                <th>{{ translate('Final Amount')}}</th>
                                <th>{{ translate('TrxID')}}</th>
                            </tr>
                        </thead>
                        @forelse($paymentLogs as $paymentLog)
                            <tr class="@if($loop->even)@endif">
                                <td data-label="{{ translate('Time')}}">
                                    <span>{{diffForHumans(@$paymentLog->created_at)}}</span><br>
                                    {{getDateTime(@$paymentLog->created_at)}}
                                </td>

                                <td data-label="{{ translate('User')}}">
                                    <a href="{{route('admin.user.details', $paymentLog->user_id)}}" class="fw-bold text-dark">{{@$paymentLog->user->name}}</a>
                                </td>

                                <td data-label="{{ translate('Amount')}}">
                                    {{shortAmount(@$paymentLog->amount)}} {{@$general->currency_name}}
                                    <br>
                                    {{@$paymentLog->paymentGateway->name}}
                                </td>

                                <td data-label="{{ translate('Final Amount')}}">
                                    <span class="text--success fw-bold">{{shortAmount($paymentLog->final_amount)}} {{@$paymentLog->paymentGateway->currency->name}}</span>
                                </td>

                                 <td data-label="{{ translate('TrxID')}}">
                                    {{$paymentLog->trx_number}} <br>
                                    @if($paymentLog->status == 1)
                                        <span class="badge badge--primary">{{ translate('Pending')}}</span>
                                    @elseif($paymentLog->status == 2)
                                        <span class="badge badge--success">{{ translate('Received')}}</span>
                                    @elseif($paymentLog->status == 3)
                                        <span class="badge badge--danger">{{ translate('Rejected')}}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ translate('No Data Found')}}</td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@if($general->cron_pop_up=='true')
<div class="modal fade" id="cronjob" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-md">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card">
                    <div class="card-header bg--lite--violet">
                        <div class="card-title text-center text--light">
                            <h6 class="text-light">{{translate('Basic Settings & Cron Job Setting Alert')}}</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <span class="badge badge--success mb-1">{{translate('Configure following area for SMS, EMAIL, WhatsApp')}}</span>
                        <p class="text-muted"> 
                            <i class="fas fa-hand-point-right"></i> {{translate('For SMS: Please setup SMS API From Those Provider or use SMS App.')}}<br>
                            <i class="fas fa-hand-point-right"></i> {{translate('For Email: Please setup SMTP Configuration for Sending Email and users notification.')}}<br>
                            <i class="fas fa-hand-point-right"></i> {{translate('For WhatsApp: Please setup node server, then scan your device for sending WhatsApp messages')}}
                        </p>
                        <div class="text-center mt-2 mb-2">
                            <a class="btn btn-info btn-sm" href="{{route('admin.sms.gateway.index')}}">
                                <i class="fas fa-sms"></i> {{translate('SMS')}}
                            </a>
                            <a class="btn btn-warning btn-sm" href="{{route('admin.mail.index')}}">
                                <i class="fas fa-envelope"></i> {{translate('Email')}}
                            </a>
                            <a class="btn btn-success btn-sm" href="{{route('admin.gateway.whatsapp.create')}}">
                                <i class="fab fa-whatsapp"></i> {{translate('WhatsApp')}}
                            </a>
                        </div>
                        <span class="badge badge--success mb-1">{{translate('To set cron job for the following tasks automation:')}}</span>
                        <p class="text-muted"> 
                            <i class="fas fa-hand-point-right"></i> {{translate('Bulk SMS, Email, and WhatsApp message sending.')}}<br>
                            <i class="fas fa-hand-point-right"></i> {{translate('Background process for contact import to reduce server usage.')}}<br>
                            <i class="fas fa-hand-point-right"></i> {{translate('Implementing delays and strategies to minimize blocking issues with WhatsApp.')}}
                        </p>
                        <hr>
                        <div class="mt-3 mb-3">
                            <label for="queue_url" class="form-label">{{translate('Cron Job i')}} <sup class="text--danger">* {{translate('Set time for 1 minute')}}</sup></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" value="curl -s {{route('queue.work')}}" id="queue_url" readonly="">
                                <span class="input-group-text btn btn--success" onclick="queue()">
                                    <i class="fas fa-copy"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="cron--run" class="form-label">{{translate('Cron Job ii')}} <sup class="text--danger">* {{translate('Set time for 2 minutes')}}</sup></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" value="curl -s {{route('cron.run')}}" id="cron--run" readonly="">
                                <span class="input-group-text btn btn--success" onclick="cronJobRun()">
                                    <i class="fas fa-copy"></i>
                                </span>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal_button2">
                <button type="button" class="w-100" data-bs-dismiss="modal">{{translate('Cancel')}}</button>
            </div>
            <div class="col-md-12 text-center">
                <p class="bg-dark text-white p-2">
                    {{translate('To disable the CronJob setup pop-up, simply')}}
                    <a href="{{route('admin.general.setting.index')}}" class="badge badge--info text--white">
                    {{translate('Click Here')}}</a>
                 </p>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
@push('scriptpush')
<script>
     window.addEventListener('DOMContentLoaded', function() {
        var cronjob = new bootstrap.Modal(document.getElementById('cronjob'));
        if (cronjob) {cronjob.show()}
     });
     var options = {
        series: [{
            name: 'Total SMS',
            type: 'column',
            data: [{{implode(",",$smsReport['month_sms']->toArray())}}]
        }],
        chart: {
            height: 400,
            type: 'line',
            stacked: false,
        },
        stroke:{
            width: [0, 2, 5],
            colors: ['#ffb800', '#cecece'],
            curve: 'smooth'
        },
        plotOptions:{
            bar:{
                columnWidth: '50%'
            }
        },
        fill:{
            opacity: [0.85, 0.25, 1],
            colors: ['#8b0dfd', '#c9b6ff'],
            gradient:{
                inverseColors: false,
                shade: 'light',
                type: "vertical",
                opacityFrom: 0.85,
                opacityTo: 1,
                stops: [0, 100, 100, 100]
            }
        },
        labels: @json($smsReport['month']->toArray()),
        markers: {
            size: 0
        },
        xaxis: {
            type: 'month'
        },
        yaxis: {
            title: {
                text: 'SMS',
            },
            min: 0
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function (y) {
                    if(typeof y !== "undefined") {
                        return y.toFixed(0) + " sms";
                    }
                    return y;

                }
            }
        }
    };
    var chart = new ApexCharts(document.querySelector("#chart30"), options);
    chart.render();

    function cronJobRun() {
        var copyText = document.getElementById("cron--run");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        notify('success', 'Copied the text : ' + copyText.value);
    }

    function queue() {
        var copyText = document.getElementById("queue_url");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        notify('success', 'Copied the text : ' + copyText.value);
    }
</script>
@endpush
