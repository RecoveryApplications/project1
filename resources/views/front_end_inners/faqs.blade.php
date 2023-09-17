@extends('front_end_inners.app_front_end', ['title' => 'الصفحة الرئيسية'])

@section('content')
  <!-- breadcrumb start -->
  <div class="breadcrumb-section">
    <div class="container">
        <div style="direction: ltr !important;" class="row">
            <div class="col-sm-6">
                <div class="page-title">
                    <h2>{{__('front_end.home_FAQ')}}</h2>
                </div>
            </div>
            <div class="col-sm-6">
                <nav aria-label="breadcrumb" class="theme-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('welcome')}}">{{__('front_end.home_home')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('front_end.home_FAQ')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb end -->


<!--section start-->
<section class="faq-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="accordion theme-accordion" id="accordionExample">
                    @if(isset($faqs) && $faqs->count() > 0)
                    @foreach ($faqs as $faq)
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h5 class="mb-0"><button class="btn btn-link" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{$faq->id}}" aria-expanded="true"
                                    aria-controls="collapseOne"> {!! $faq->title_en !!}</button></h5>
                        </div>
                        <div id="collapse{{$faq->id}}" class="collapse " aria-labelledby="headingOne"
                            data-bs-parent="#accordionExample">
                            <div class="card-body">
                                <p>{!! $faq->answer_en !!}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                            @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
