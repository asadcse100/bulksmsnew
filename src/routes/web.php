<?php

use App\Http\Controllers\AuthorizationProcessController;
use App\Http\Controllers\User\AndroidApiController;
use App\Http\Controllers\User\EmailApiGatewayController;
use App\Http\Controllers\User\SmsApiGatewayController;
use App\Http\Controllers\User\WhatsappDeviceController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\PhoneBookController;
use App\Http\Controllers\User\ManageSMSController;
use App\Http\Controllers\User\PlanController;
use App\Http\Controllers\User\EmailContactController;
use App\Http\Controllers\User\ManageEmailController;
use App\Http\Controllers\User\SupportTicketController;
use App\Http\Controllers\PaymentMethod\PaymentController;
use App\Http\Controllers\PaymentMethod\PaymentWithStripe;
use App\Http\Controllers\PaymentMethod\PaymentWithPaypal;
use App\Http\Controllers\PaymentMethod\PaymentWithPayStack;
use App\Http\Controllers\PaymentMethod\PaymentWithPaytm;
use App\Http\Controllers\PaymentMethod\PaymentWithFlutterwave;
use App\Http\Controllers\PaymentMethod\PaymentWithRazorpay;
use App\Http\Controllers\PaymentMethod\PaymentWithInstamojo;
use App\Http\Controllers\PaymentMethod\SslCommerzPaymentController;
use App\Http\Controllers\PaymentMethod\CoinbaseCommerce;
use App\Http\Controllers\User\CampaignController;
use App\Http\Controllers\User\EmailTemplateController;
use App\Http\Controllers\User\ManageWhatsappController;

Route::get('queue-work', function () {
    return Illuminate\Support\Facades\Artisan::call('queue:work', ['--stop-when-empty' => true]);
})->name('queue.work');

Route::get('cron/run', [CronController::class, 'run'])->name('cron.run');

Route::get('/select/search', [FrontendController::class, 'selectSearch'])->name('email.select2');


Route::middleware(['auth','checkUserStatus','maintenance','demo.mode'])->prefix('user')->name('user.')->group(function () {
    Route::get('authorization', [AuthorizationProcessController::class, 'process'])->name('authorization.process');
    Route::get('email/verification', [AuthorizationProcessController::class, 'processEmailVerification'])->name('email.verification');
    Route::post('email/verification', [AuthorizationProcessController::class, 'emailVerification'])->name('email.verification');

    Route::middleware(['authorization'])->group(function(){
    	Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    	Route::get('profile', [HomeController::class, 'profile'])->name('profile');
    	Route::post('profile/update', [HomeController::class, 'profileUpdate'])->name('profile.update');
        Route::get('gateway/sms/send-method', [HomeController::class, 'defaultSmsMethod'])->name('gateway.sms.sendmethod');
        Route::post('default/sms/gateway', [HomeController::class, 'defaultSmsGateway'])->name('default.sms.gateway');
    	Route::get('password', [HomeController::class, 'password'])->name('password');
    	Route::post('password/update', [HomeController::class, 'passwordUpdate'])->name('password.update');
        Route::get('generate/api-key', [HomeController::class, 'generateApiKey'])->name('generate.api.key');
        Route::post('save/generate/api-key', [HomeController::class, 'saveGenerateApiKey'])->name('save.generate.api.key');

        //SMS Gateway
        Route::prefix('sms/gateways/')->name('sms.gateway.')->group(function () {
            Route::get('', [SmsApiGatewayController::class, 'index'])->name('index');
            Route::get('edit/{id}', [SmsApiGatewayController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [SmsApiGatewayController::class, 'update'])->name('update');
            Route::post('default', [SmsApiGatewayController::class, 'defaultGateway'])->name('default');
        });

        //Email Gateway
        Route::prefix('mail/gateways/')->name('mail.')->group(function () {
            Route::get('', [EmailApiGatewayController::class, 'index'])->name('configuration');
            Route::post('update/{id}', [EmailApiGatewayController::class, 'update'])->name('update');
            Route::get('edit/{id}', [EmailApiGatewayController::class, 'edit'])->name('edit');
            Route::post('default', [EmailApiGatewayController::class, 'defaultGateway'])->name('default.method');
        });

        //credit Log
        Route::get('transaction/log', [HomeController::class, 'transaction'])->name('transaction.history');
        Route::get('transaction/search', [HomeController::class, 'transactionSearch'])->name('transaction.search');

        //credit Log
        Route::get('credit/log', [HomeController::class, 'credit'])->name('credit.history');
        Route::get('credit/search', [HomeController::class, 'creditSearch'])->name('credit.search');

        //whatsapp credit Log
        Route::get('whatsapp/credit/log', [HomeController::class, 'whatsappCredit'])->name('whatsapp.credit.history');
        Route::get('whatsapp/credit/search', [HomeController::class, 'whatsappCreditSearch'])->name('whatsapp.credit.search');

        //Email credit Log
        Route::get('email/credit/log', [HomeController::class, 'emailCredit'])->name('credit.email.history');
        Route::get('email/credit/search', [HomeController::class, 'emailCreditSearch'])->name('credit.email.search');


        //CAMPAIGN ROUTE START
		Route::controller(CampaignController::class)->prefix('campaigns')->name('campaign.')->group(function(){
			Route::get('/sms','index')->name('sms');
			Route::get('/email','index')->name('email');
			Route::get('/whatsapp','index')->name('whatsapp');
			Route::get('/{type}/create','create')->name('create');
			Route::post('/store','store')->name('store');
			Route::post('/search','search')->name('search');
			Route::post('/delete','delete')->name('delete');
			Route::get('/contacts/{id}','contacts')->name('contacts');
			Route::get('/edit/{id}','edit')->name('edit');
			Route::post('/update','update')->name('update');
			Route::post('/contact/delete','contactDelete')->name('contact.delete');
        });


           //EMAIL TEAMPLATE ROUTE START
		Route::controller(EmailTemplateController::class)->prefix('email/templates')->name('template.email.')->group(function (){
			Route::any('/list','templates')->name('list');
			Route::get('/create','create')->name('create');
			Route::post('/store','store')->name('store');
			Route::post('/update/templates','updateTemplates')->name('update');
			Route::get('/user/list','userTemplates')->name('user.list');

			Route::get('/get/{id}','templateJson')->name('select');
			Route::get('/edit/{id}','editTemplate')->name('edit');
			Route::get('/edit/json/{id}','templateJsonEdit')->name('edit.json');
			Route::post('/delete','delete')->name('delete');
		});



    	//Phone book
    	Route::get('sms/groups', [PhoneBookController::class, 'groupIndex'])->name('phone.book.group.index');
        Route::get('sms/contact/group/{id}', [PhoneBookController::class, 'smsContactByGroup'])->name('phone.book.sms.contact.group');
    	Route::post('sms/group/store', [PhoneBookController::class, 'groupStore'])->name('phone.book.group.store');
    	Route::post('sms/group/update', [PhoneBookController::class, 'groupUpdate'])->name('phone.book.group.update');
    	Route::post('sms/group/delete', [PhoneBookController::class, 'groupdelete'])->name('phone.book.group.delete');

    	Route::get('sms/contacts', [PhoneBookController::class, 'contactIndex'])->name('phone.book.contact.index');
    	Route::post('sms/contact/store', [PhoneBookController::class, 'contactStore'])->name('phone.book.contact.store');
    	Route::post('sms/contact/update', [PhoneBookController::class, 'contactUpdate'])->name('phone.book.contact.update');
    	Route::post('sms/contact/delete', [PhoneBookController::class, 'contactDelete'])->name('phone.book.contact.delete');
        Route::post('sms/contact/import', [PhoneBookController::class, 'contactImport'])->name('phone.book.contact.import');
        Route::get('sms/contact/export', [PhoneBookController::class, 'contactExport'])->name('phone.book.contact.export');
        Route::get('sms/contact/group/export/{id}', [PhoneBookController::class, 'contactGroupExport'])->name('phone.book.contact.group.export');

        Route::get('sms/templates', [PhoneBookController::class, 'templateIndex'])->name('template.index');
        Route::post('sms/template/store', [PhoneBookController::class, 'templateStore'])->name('phone.book.template.store');
        Route::post('sms/template/update', [PhoneBookController::class, 'templateUpdate'])->name('phone.book.template.update');
        Route::post('sms/template/delete', [PhoneBookController::class, 'templateDelete'])->name('phone.book.template.delete');

        //Email
        Route::get('email/groups', [EmailContactController::class, 'emailGroupIndex'])->name('email.group.index');
        Route::get('email/contact/group/{id}', [EmailContactController::class, 'emailContactByGroup'])->name('email.contact.group');
        Route::post('email/group/store', [EmailContactController::class, 'emailGroupStore'])->name('email.group.store');
        Route::post('email/group/update', [EmailContactController::class, 'emailGroupUpdate'])->name('email.group.update');
        Route::post('email/group/delete', [EmailContactController::class, 'emailGroupdelete'])->name('email.group.delete');

        Route::get('email/contacts', [EmailContactController::class, 'emailContactIndex'])->name('email.contact.index');
        Route::post('email/contact/store', [EmailContactController::class, 'emailContactStore'])->name('email.contact.store');
        Route::post('email/contact/update', [EmailContactController::class, 'emailContactUpdate'])->name('email.contact.update');
        Route::post('email/contact/import', [EmailContactController::class, 'emailContactImport'])->name('email.contact.import');
        Route::get('email/contact/export', [EmailContactController::class, 'emailContactExport'])->name('email.contact.export');
        Route::get('email/contact/group/export/{id}', [EmailContactController::class, 'emailContactGroupExport'])->name('email.contact.group.export');
        Route::post('email/contact/delete', [EmailContactController::class, 'emailContactDelete'])->name('email.contact.delete');


        Route::prefix('email/')->name('manage.email.')->group(function () {
            Route::get('send', [ManageEmailController::class, 'create'])->name('send');
            Route::get('log/history', [ManageEmailController::class, 'index'])->name('index');
            Route::get('log/pending', [ManageEmailController::class, 'pending'])->name('pending');
            Route::get('log/delivered', [ManageEmailController::class, 'delivered'])->name('delivered');
            Route::get('log/failed', [ManageEmailController::class, 'failed'])->name('failed');
            Route::get('log/schedule', [ManageEmailController::class, 'scheduled'])->name('schedule');
            Route::post('status/update', [ManageEmailController::class, 'emailStatusUpdate'])->name('status.update');
            Route::get('log/search/{scope}', [ManageEmailController::class, 'search'])->name('search');
            Route::post('store', [ManageEmailController::class, 'store'])->name('store');
        });

        //Sms Contacts
        Route::prefix('sms/contacts/')->name('phone.book.contact.')->group(function () {
            Route::get('', [PhoneBookController::class, 'contactIndex'])->name('index');
            Route::post('store', [PhoneBookController::class, 'contactStore'])->name('store');
            Route::post('update', [PhoneBookController::class, 'contactUpdate'])->name('update');
            Route::post('delete', [PhoneBookController::class, 'contactDelete'])->name('delete');
            Route::post('import', [PhoneBookController::class, 'contactImport'])->name('import');
            Route::get('export', [PhoneBookController::class, 'contactExport'])->name('export');
            Route::get('group/export/{id}', [PhoneBookController::class, 'contactGroupExport'])->name('group.export');
        });

        //SMS templates
        Route::prefix('sms/templates/')->name('phone.book.template.')->group(function () {
            Route::get('', [PhoneBookController::class, 'templateIndex'])->name('index');
            Route::post('store', [PhoneBookController::class, 'templateStore'])->name('store');
            Route::post('update', [PhoneBookController::class, 'templateUpdate'])->name('update');
            Route::post('delete', [PhoneBookController::class, 'templateDelete'])->name('delete');
        });

        //Email Groups
        Route::prefix('email/groups/')->name('email.group.')->group(function () {
            Route::get('', [EmailContactController::class, 'emailGroupIndex'])->name('index');
            Route::get('contact/{id}', [EmailContactController::class, 'emailContactByGroup'])->name('contact');
            Route::post('store', [EmailContactController::class, 'emailGroupStore'])->name('store');
            Route::post('update', [EmailContactController::class, 'emailGroupUpdate'])->name('update');
            Route::post('delete', [EmailContactController::class, 'emailGroupdelete'])->name('delete');
        });

        //Email Contacts
        Route::prefix('email/contacts')->name('email.contact.')->group(function () {
            Route::get('', [EmailContactController::class, 'emailContactIndex'])->name('index');
            Route::post('store', [EmailContactController::class, 'emailContactStore'])->name('store');
            Route::post('update', [EmailContactController::class, 'emailContactUpdate'])->name('update');
            Route::post('import', [EmailContactController::class, 'emailContactImport'])->name('import');
            Route::get('export', [EmailContactController::class, 'emailContactExport'])->name('export');
            Route::get('group/export/{id}', [EmailContactController::class, 'emailContactGroupExport'])->name('group.export');
            Route::post('delete', [EmailContactController::class, 'emailContactDelete'])->name('delete');
        });

        //Emails
        Route::prefix('emails/')->name('manage.email.')->group(function () {
            Route::get('', [ManageEmailController::class, 'index'])->name('index');
            Route::post('store', [ManageEmailController::class, 'store'])->name('store');
            Route::get('send', [ManageEmailController::class, 'create'])->name('send');
            Route::get('pending', [ManageEmailController::class, 'pending'])->name('pending');
            Route::get('delivered', [ManageEmailController::class, 'delivered'])->name('delivered');
            Route::get('failed', [ManageEmailController::class, 'failed'])->name('failed');
            Route::get('schedule', [ManageEmailController::class, 'scheduled'])->name('schedule');
            Route::post('status/update', [ManageEmailController::class, 'emailStatusUpdate'])->name('status.update');
            Route::get('search/{scope}', [ManageEmailController::class, 'search'])->name('search');
            Route::get('view/{id}', [ManageEmailController::class, 'viewEmailBody'])->name('view');
        });

        //Sms log
        Route::prefix('sms/')->name('sms.')->group(function () {
            Route::get('', [ManageSMSController::class, 'index'])->name('index');
            Route::post('store', [ManageSMSController::class, 'store'])->name('store');
            Route::get('send', [ManageSMSController::class, 'create'])->name('send');
            Route::get('pending', [ManageSMSController::class, 'pending'])->name('pending');
            Route::get('delivered', [ManageSMSController::class, 'delivered'])->name('delivered');
            Route::get('failed', [ManageSMSController::class, 'failed'])->name('failed');
            Route::get('schedule', [ManageSMSController::class, 'scheduled'])->name('schedule');
            Route::get('processing', [ManageSMSController::class, 'processing'])->name('processing');
            Route::get('search/{scope}', [ManageSMSController::class, 'search'])->name('search');
            Route::post('status/update', [ManageSMSController::class, 'smsStatusUpdate'])->name('status.update');
        });

         //whatsapp log
        Route::prefix('whatsapp/')->name('whatsapp.')->group(function () {
            Route::get('', [ManageWhatsappController::class, 'index'])->name('index');
            Route::get('send', [ManageWhatsappController::class, 'create'])->name('send');
            Route::get('pending', [ManageWhatsappController::class, 'pending'])->name('pending');
            Route::get('delivered', [ManageWhatsappController::class, 'delivered'])->name('delivered');
            Route::get('failed', [ManageWhatsappController::class, 'failed'])->name('failed');
            Route::get('schedule', [ManageWhatsappController::class, 'scheduled'])->name('schedule');
            Route::get('processing', [ManageWhatsappController::class, 'processing'])->name('processing');
            Route::get('search/{scope}', [ManageWhatsappController::class, 'search'])->name('search');
            Route::post('status/update', [ManageWhatsappController::class, 'statusUpdate'])->name('status.update');
            Route::post('store', [ManageWhatsappController::class, 'store'])->name('store');
        });

        //Plan
        Route::prefix('plans/')->name('plan.')->group(function () {
            Route::get('', [PlanController::class, 'create'])->name('create');
            Route::post('store', [PlanController::class, 'store'])->name('store');
            Route::get('subscriptions', [PlanController::class, 'subscription'])->name('subscription');
            Route::post('renew', [PlanController::class, 'subscriptionRenew'])->name('renew');
        });


        //Payment
        Route::get('payment/preview', [PaymentController::class, 'preview'])->name('payment.preview');
        Route::get('payment/confirm', [PaymentController::class, 'paymentConfirm'])->name('payment.confirm');
        Route::get('manual/payment/confirm', [PaymentController::class, 'manualPayment'])->name('manual.payment.confirm');
        Route::post('manual/payment/update', [PaymentController::class, 'manualPaymentUpdate'])->name('manual.payment.update');

        //Payment Action
        Route::post('ipn/strip', [PaymentWithStripe::class, 'stripePost'])->name('payment.with.strip');
        Route::get('/strip/success', [PaymentWithStripe::class, 'success'])->name('payment.with.strip.success');
        Route::post('ipn/paypal', [PaymentWithPaypal::class, 'postPaymentWithpaypal'])->name('payment.with.paypal');
        Route::get('ipn/paypal/status', [PaymentWithPaypal::class, 'getPaymentStatus'])->name('payment.paypal.status');
        Route::get('ipn/paystack', [PaymentWithPayStack::class, 'store'])->name('payment.with.paystack');
        Route::post('ipn/pay/with/sslcommerz', [SslCommerzPaymentController::class, 'index'])->name('payment.with.ssl');
        Route::post('success', [SslCommerzPaymentController::class, 'success']);
        Route::post('fail', [SslCommerzPaymentController::class, 'fail']);
        Route::post('cancel', [SslCommerzPaymentController::class, 'cancel']);
        Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);

        Route::post('ipn/paytm/process', [PaymentWithPaytm::class,'getTransactionToken'])->name('paytm.process');
        Route::post('ipn/paytm/callback', [PaymentWithPaytm::class,'ipn'])->name('paytm.ipn');

        Route::get('flutter-wave/{trx}/{type}', [PaymentWithFlutterwave::class,'callback'])->name('flutterwave.callback');
        Route::post('ipn/razorpay', [PaymentWithRazorpay::class,'ipn'])->name('razorpay');

        Route::get('instamojo', [PaymentWithInstamojo::class,'process'])->name('instamojo');
        Route::post('ipn/instamojo', [PaymentWithInstamojo::class,'ipn'])->name('ipn.instamojo');

        Route::get('ipn/coinbase', [CoinbaseCommerce::class, 'store'])->name('coinbase');
        Route::any('ipn/callback/coinbase', [CoinbaseCommerce::class, 'confirmPayment'])->name('callback.coinbase');

        //Support Ticket
        Route::prefix('support/tickets/')->name('ticket.')->group(function () {
            Route::get('', [SupportTicketController::class, 'index'])->name('index');
            Route::get('create', [SupportTicketController::class, 'create'])->name('create');
            Route::post('store', [SupportTicketController::class, 'store'])->name('store');
            Route::get('reply/{id}', [SupportTicketController::class, 'detail'])->name('detail');
            Route::post('reply/{id}', [SupportTicketController::class, 'ticketReply'])->name('reply');
            Route::post('closed/{id}', [SupportTicketController::class, 'closedTicket'])->name('closed');
            Route::get('file/download/{id}', [SupportTicketController::class, 'supportTicketDownloader'])->name('file.download');
        });

        //whatsapp Gateway
        Route::prefix('whatsapp/gateways/')->name('gateway.whatsapp.')->group(function () {
            Route::get('create', [WhatsappDeviceController::class, 'create'])->name('create');
            Route::post('store', [WhatsappDeviceController::class, 'store'])->name('store');;
            Route::get('edit/{id}', [WhatsappDeviceController::class, 'edit'])->name('edit');
            Route::post('update', [WhatsappDeviceController::class, 'update'])->name('update');
            Route::post('status-update', [WhatsappDeviceController::class, 'statusUpdate'])->name('status-update');
            Route::post('delete', [WhatsappDeviceController::class, 'delete'])->name('delete');
            Route::post('qr-code', [WhatsappDeviceController::class, 'getWaqr'])->name('qrcode');
            Route::post('device/status', [WhatsappDeviceController::class, 'getDeviceStatus'])->name('device.status');
        });

        //android gateway
        Route::prefix('android/gateways/')->name('gateway.sms.android.')->group(function () {
            Route::get('', [AndroidApiController::class, 'index'])->name('index');
            Route::post('store', [AndroidApiController::class, 'store'])->name('store');
            Route::post('update', [AndroidApiController::class, 'update'])->name('update');
            Route::get('sim/list/{id}', [AndroidApiController::class, 'simList'])->name('sim.index');
            Route::post('delete/', [AndroidApiController::class, 'delete'])->name('delete');
            Route::post('sim/delete/', [AndroidApiController::class, 'simNumberDelete'])->name('sim.delete');
        });
    });
});

Route::get('/', [WebController::class, 'index'])->name('home');

Route::get('/pages/{key}/{id}', [WebController::class, 'pages'])->name('page');
Route::get('/language/change/{lang?}', [FrontendController::class, 'languageChange'])->name('language.change');
Route::get('/default/image/{size}', [FrontendController::class, 'defaultImageCreate'])->name('default.image');
Route::get('email/contact/demo/file', [FrontendController::class, 'demoImportFile'])->name('email.contact.demo.import');
Route::get('sms/demo/import/file', [FrontendController::class, 'demoImportFilesms'])->name('phone.book.demo.import.file');
Route::get('demo/file/download/{extension}', [FrontendController::class, 'demoFileDownloader'])->name('demo.file.downlode');
Route::get('demo/email/file/download/{extension}', [FrontendController::class, 'demoEmailFileDownloader'])->name('demo.email.file.downlode');
Route::get('demo/whatsapp/file/download/{extension}', [FrontendController::class, 'demoWhatsAppFileDownloader'])->name('demo.whatsapp.file.downlode');
Route::get('api/document', [FrontendController::class, 'apiDocumentation'])->name('api.document');
