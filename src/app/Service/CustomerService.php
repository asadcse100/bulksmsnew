<?php

namespace App\Service;

use App\Http\Requests\UserCreditRequest;
use App\Http\Utility\SendMail;
use App\Jobs\RegisterMailJob;
use App\Models\Contact;
use App\Models\EmailContact;
use App\Models\EmailLog;
use App\Models\GeneralSetting;
use App\Models\PricingPlan;
use App\Models\SMSlog;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\AbstractPaginator;

class CustomerService
{
    /**
     * @param $userId
     * @return mixed
     */
    public function findById($userId):mixed
    {
        return User::findOrFail($userId);
    }

    /**
     * @return AbstractPaginator
     */
    public function getPaginateUsers(): AbstractPaginator
    {
        return User::latest()->paginate(paginateNumber());
    }


    /**
     * @return AbstractPaginator
     */
    public function getPaginateActiveUsers(): AbstractPaginator
    {
        return User::active()->paginate(paginateNumber());
    }


    /**
     * @return AbstractPaginator
     */
    public function getPaginateBannedUsers(): AbstractPaginator
    {
        return User::banned()->paginate(paginateNumber());
    }


    /**
     * @param User $user
     * @return void
     */
    public function applySignUpBonus(User $user): void
    {
        $general = GeneralSetting::first();
        $plan = PricingPlan::find($general->plan_id);

        if($general->sign_up_bonus != 1 || !$plan){
            return;
        }

        $user->credit = $plan->credit;
        $user->email_credit = $plan->email_credit;
        $user->whatsapp_credit = $plan->whatsapp_credit;
        $user->save();

        Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'expired_date' => Carbon::now()->addDays($plan->duration),
            'amount' =>$plan->amount,
            'trx_number' =>trxNumber(),
            'status' => Subscription::RUNNING,
        ]);
    }


    /**
     * @param User $user
     * @return void
     */
    public function handleEmailVerification(User $user): void
    {
        $general = GeneralSetting::first();

        if($general->email_verification_status == 2){
            $user->email_verified_status = User::YES;
            $user->email_verified_code = null;
            $user->email_verified_at = carbon();
        }else{

            $mailCode = [
                'name' => $user->name,
                'code' => $user->email_verified_code,
                'time' => carbon(),
            ];

            RegisterMailJob::dispatch($user, 'REGISTRATION_VERIFY', $mailCode);
        }

        $user->save();
    }


    public function searchCustomers($search, $searchDate)
    {
        try{
            $customers = User::query();

            if (!empty($search)) {
                $customers->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                });
            }

            if (!empty($searchDate)) {
                $dateRange = explode('-', $searchDate);
                $firstDate =  Carbon::createFromFormat('m/d/Y', trim($dateRange[0]))->startOfDay() ?? null;
                $lastDate = Carbon::createFromFormat('m/d/Y', trim($dateRange[1]))->endOfDay() ?? null;

                if ($firstDate) {
                    $customers->whereDate('created_at', '>=', $firstDate);
                }

                if ($lastDate) {
                    $customers->whereDate('created_at', '<=', $lastDate);
                }

                return $customers;
            }
        }catch (\Exception $exception){

        }


    }


    /**
     * @param $customers
     * @param $scope
     * @return array
     */
    public function applyCustomerStatusFilter($customers, $scope): array
    {
        if ($scope == 'active') {
            $title = "Active";
            $customers = $customers->active();
        } elseif ($scope == 'banned') {
            $title = "Banned";
            $customers = $customers->banned();
        }else{
            $title = 'All';
        }

        return [$title,$customers];
    }


    /**
     * @param $userId
     * @return array
     */
    public function logs($userId): array
    {
        return [
            'contact' => Contact::where('user_id', $userId)->count(),
            'sms' => SMSlog::where('user_id', $userId)->count(),
            'email_contact' => EmailContact::where('user_id', $userId)->count(),
            'email' =>  EmailLog::where('user_id', $userId)->count()
        ];
    }



    public function getCustomerForContacts()
    {
        return User::select('id', 'name')->get();
    }


    /**
     * @param $userId
     * @return mixed
     */
    public function contactListForUser($userId)
    {
        return Contact::where('user_id', $userId)->latest()->with('user', 'group')->paginate(paginateNumber());
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function smsLogsForUser($userId)
    {
        return SMSlog::where('user_id', $userId)->latest()->with('user', 'androidGateway', 'smsGateway')->paginate(paginateNumber());
    }


    /**
     * @param $userId
     * @return mixed
     */
    public function emailContactsForUser($userId)
    {
        return EmailContact::where('user_id', $userId)->latest()->with('user', 'emailGroup')->paginate(paginateNumber());
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function emailLogsForUser($userId)
    {
        return EmailLog::where('user_id', $userId)->latest()->with('user','sender')->paginate(paginateNumber());
    }


    /**
     * @param UserCreditRequest $request
     * @return array
     */
    public function buildCreditArray(UserCreditRequest $request): array
    {
        return [
            'sms' => $request->input('sms_credit', 0),
            'email' => $request->input('email_credit', 0),
            'whatsapp' => $request->input('whatsapp_credit', 0),
        ];
    }


}
