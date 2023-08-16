<?php

namespace App\Providers;

use App\Models\FrontendSection;
use App\Models\PricingPlan;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class FrontendViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        try {
            //Frontend
            $frontendContents = FrontendSection::get();

            $userId = null;

            if(Auth::check()){
                $userId = Auth::user()->id;
            }

            View::composer('sections.pricing_plan', function ($view) use ($frontendContents, $userId) {
                $view->with([
                    'plan_content'=> $frontendContents->where('section_key', FrontendSection::PRICING_PLAN_CONTENT)->first(),
                    'plans'=> PricingPlan::where('status', 1)->get(),
                    'subscription' => Subscription::where('user_id', $userId)->where('status', '!=', 0)->first(),
                ]);
            });

            View::composer('sections.faq', function ($view) use ($frontendContents) {
                $view->with([
                    'faq_content'=> $frontendContents->where('section_key', FrontendSection::FAQ_CONTENT)->first(),
                    'faq_element'=> $frontendContents->where('section_key', FrontendSection::FAQ_ELEMENT),
                ]);
            });

            View::composer('sections.about', function ($view) use ($frontendContents) {
                $view->with([
                    'about_content'=> $frontendContents->where('section_key', FrontendSection::ABOUT_CONTENT)->first(),
                    'about_element'=> $frontendContents->where('section_key', FrontendSection::ABOUT_ELEMENT),
                ]);
            });


            View::composer('sections.banner', function ($view) use ($frontendContents) {
                $view->with([
                    'banner_content'=> $frontendContents->where('section_key', FrontendSection::BANNER_CONTENT)->first(),
                    'banner_element'=> $frontendContents->where('section_key', FrontendSection::BANNER_ELEMENT),
                ]);
            });


            View::composer('sections.feature', function ($view) use ($frontendContents) {
                $view->with([
                    'feature_content'=> $frontendContents->where('section_key', FrontendSection::FEATURE_CONTENT)->first(),
                    'feature_element'=> $frontendContents->where('section_key', FrontendSection::FEATURE_ELEMENT),
                ]);
            });

            View::composer('sections.cta', function ($view) use ($frontendContents) {
                $view->with([
                    'cta_content'=> $frontendContents->where('section_key', FrontendSection::CTA_CONTENT)->first(),
                    'cta_element'=> $frontendContents->where('section_key', FrontendSection::CTA_ELEMENT),
                ]);
            });


            View::composer('sections.cta', function ($view) use ($frontendContents) {
                $view->with([
                    'cta_content'=> $frontendContents->where('section_key', FrontendSection::CTA_CONTENT)->first(),
                    'cta_element'=> $frontendContents->where('section_key', FrontendSection::CTA_ELEMENT),
                ]);
            });


            View::composer('sections.overview', function ($view) use ($frontendContents) {
                $view->with([
                    'overview_content'=> $frontendContents->where('section_key', FrontendSection::OVERVIEW_CONTENT)->first(),
                    'overview_element'=> $frontendContents->where('section_key', FrontendSection::OVERVIEW_ELEMENT),
                ]);
            });

            View::composer('frontend.partials.footer', function ($view) use ($frontendContents) {
                $view->with([
                    'footer_content'=> $frontendContents->where('section_key', FrontendSection::FOOTER_CONTENT)->first(),
                    'socail_icons'=> $frontendContents->where('section_key', FrontendSection::SOCAIL_ICON),
                    'socail_icons'=> $frontendContents->where('section_key', FrontendSection::SOCAIL_ICON),
                    'pages'=> $frontendContents->where('section_key', FrontendSection::PAGES),
                ]);
            });
        }catch (\Exception $exception){

        }

    }
}
