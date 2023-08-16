@extends('frontend.layouts.main')
@section('content')


 <section class="pricing-plans pt-100 pb-100" id="pricing">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="text-center section-title">
                    <h3 class="">{{str_replace('-'," ",$key)}}</h3>
                    <p class="">{{$description}}</p>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection