
@extends('front_end_inners.app_front_end', ['title' => 'الصفحة الرئيسية'])

@section('content')
    <!-- catg header banner section -->

    <div class="d-flex justify-content-center m-5">
        <section id="aa-catg-head-banner ">

            <div class="aa-catg-head-banner-area">
                <div class="container">
                    <div class="aa-catg-head-banner-content">
                        <h2>{{__('front_end.home_Policy_Policy')}}</h2>


                    </div>
                </div>
            </div>
        </section>

    </div>
    {{-- w-50 d-flex justify-content-center m-5 --}}
    <section style="width: 75%;
    margin: auto;" class="ec-page-content section-space-p shadow-lg p-3 mb-5 bg-white rounded ">
        <div class="container">
            <div class="pt-4 bg-gray-100">
                <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                    <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white shadow-md overflow-hidden sm:rounded-lg prose">
                        {!! isset($policy->privacy_policy_des_en) ? $policy->privacy_policy_des_en : '-----------' !!}
                    </div>
                </div>
            </div>
        </div>
    </section>


    @endsection
