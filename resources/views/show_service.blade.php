@extends($active_theme)
@section('title')
    <title>{{ $service->name }}</title>
    <title>{{ $service->seo_title }}</title>
@endsection
@section('meta')
    <meta name="description" content="{{ $service->seo_description }}">
@endsection

@section('frontend-content')
    <!--=========================
        BREADCRUMB START
    ==========================-->
    <div class="wsus__breadcrumb" style="background: url({{ asset($breadcrumb->image) }});">
        <div class="wsus__breadcrumb_overlay pt_90 xs_pt_60 pb_95 xs_pb_65">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <nav aria-label="breadcrumb">
                            <h1>{{__('user.Service')}}</h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('user.Home')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{__('user.Service')}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--=========================
        BREADCRUMB END
    ==========================-->

        <!--=========================
        SERVICE DETAILS START
    ==========================-->
    <section class="wsus__service_details mt_100 xs_mt_70 mb_90 xs_mb_60">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-8">
                    <div class="wsus__service_details_content">
                        <div class="wsus__service_details_img">
                            <img src="{{ asset($service->image) }}" alt="service setails" class="imf-fluid w-100">
                        </div>
                        <div class="wsus__service_details_text">
                            <h2>{{ $service->name }} </h2>
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                        aria-selected="true">{{__('user.Description')}}</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-profile" type="button" role="tab"
                                        aria-controls="pills-profile" aria-selected="false">{{__('user.Availability')}}</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-contact" type="button" role="tab"
                                        aria-controls="pills-contact" aria-selected="false">{{__('user.Client Reviews')}}</button>
                                </li>
                            </ul>
                            <div class="tab-content tab_details" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab">
                                    {!! clean($service->details) !!}

                                    <div class="row">
                                        @if (count($what_you_will_get) > 0)
                                        <div class="col-xl-7 col-md-7">
                                            <div class="wsus_details_list_item">
                                                <h4>{{__('user.What you will get')}}:</h4>
                                                <ul class="list">
                                                    @foreach ($what_you_will_get as $get_item)
                                                    <li>{{ $get_item }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        @endif

                                        @if (count($benifits) > 0)
                                        <div class="col-xl-7 col-md-7">
                                            <div class="wsus_details_list_item">
                                                <h4>{{__('user.Benifits of the Package')}}:</h4>
                                                <ul class="list">
                                                    @foreach ($benifits as $benifit)
                                                    <li>{{ $benifit }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        @endif

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                    aria-labelledby="pills-profile-tab">

                                    <h4>{{__('user.Service Availability')}}  </h4>
                                    <ul class="details_time">
                                        @foreach ($schedule_list as $schedule)
                                            <li><span>{{ $schedule['day'] }}</span> {{ $schedule['start_time'] }} - {{ $schedule['end_time'] }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                    aria-labelledby="pills-contact-tab">

                                    @foreach ($reviews as $review)
                                        <div class="wsus__single_review">
                                            <div class="wsus__single_review_top">
                                                <img src="{{ $review->user->image ? asset($review->user->image) : asset($default_avatar->image) }}" alt="review" class="img-fluid">
                                                <div class="text">
                                                    <h3>{{ $review->user->name }}
                                                        <span>
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= $review->rating)
                                                                    <i class="fas fa-star"></i>
                                                                @else
                                                                    <i class="fal fa-star"></i>
                                                                @endif
                                                            @endfor
                                                        </span>
                                                    </h3>
                                                    <p>{{ $review->created_at->format('d M Y') }}</p>
                                                </div>
                                            </div>
                                            <p class="review_text">{{ html_decode($review->review) }}</p>
                                        </div>
                                    @endforeach


                                    {{ $reviews->links('custom_pagination') }}
                                    <div class="wsus__review_input mt_65 xs_mt_35">
                                        <form id="serviceReviewForm">
                                            @csrf
                                            <h4>{{__('user.Write Your Reviews')}}</h4>
                                            <p>
                                                <span>{{__('user.Rating')}} : </span>
                                                <i class="fas fa-star service_rat" data-rating="1" onclick="productReview(1)"></i>
                                                <i class="fas fa-star service_rat" data-rating="2" onclick="productReview(2)"></i>
                                                <i class="fas fa-star service_rat" data-rating="3" onclick="productReview(3)"></i>
                                                <i class="fas fa-star service_rat" data-rating="4" onclick="productReview(4)"></i>
                                                <i class="fas fa-star service_rat" data-rating="5" onclick="productReview(5)"></i>
                                                <span id="show_rating">(5.0)</span>
                                            </p>
                                            <div class="row">

                                                <input type="hidden" id="service_id" name="service_id" value="{{ $service->id }}">
                                                <input type="hidden" id="service_id" name="provider_id" value="{{ $service->provider_id }}">
                                                <input type="hidden" name="rating" value="5" id="service_rating">

                                                <div class="col-xl-12">
                                                    <fieldset>
                                                        <legend>{{__('user.Comment')}}*</legend>
                                                        <textarea rows="5" name="comment" placeholder="{{__('user.Write a Comment')}}"></textarea>
                                                    </fieldset>
                                                </div>

                                                @if($recaptchaSetting->status==1)
                                                    <div class="col-xl-12">
                                                        <div class="wsus__single_com mt_20">
                                                            <div class="g-recaptcha" data-sitekey="{{ $recaptchaSetting->site_key }}"></div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="col-xl-12">
                                                    @auth
                                                    <button type="submit" class="common_btn mt_20">
                                                {{__('user.Submit Review')}}</button>
                                                    @else
                                                    <button type="button" id="after_login" class="common_btn mt_20">

                                                        {{__('user.Submit Review')}}</button>
                                                    @endauth
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4">
                    <div class="wsus__sidebar" id="sticky_sidebar">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-12">
                                <div class="wsus__package">
                                    <p>{{__('user.My Package')}}</p>
                                    <h2>{{ $currency_icon->icon }}{{ $service->price }}</h2>
                                    <ul>
                                        @foreach ($package_features as $package_feature)
                                            <li>{{ $package_feature }}</li>
                                        @endforeach
                                    </ul>
                                    <a href="{{ route('ready-to-booking', $service->slug) }}">{{__('user.Book Now')}}</a>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-12">
                                <div class="wsus__service_provider mt_25">
                                    <img src="{{ $provider->image ? asset($provider->image) : asset($default_avatar->image) }}" alt="service provider"
                                        class="img-fluid w-100">
                                    <h3><a href="{{ route('providers', $provider->user_name) }}">{{ $provider->name }}</a></h3>
                                    <h6>{{__('user.Member Since')}} {{ $provider->created_at->format('M Y') }}</h6>
                                    <div class="info">
                                        <p>{{__('user.Order Complete')}}
                                            <span>{{ $complete_order }}</span>
                                        </p>
                                        <p>{{__('user.Provider Rating')}}
                                            @if ($total_review > 0)
                                            <b>
                                                @for ($i = 1; $i <=5; $i++)
                                                    @if ($i <= $review_point)
                                                        <i class="fas fa-star"></i>
                                                    @elseif ($i> $review_point )
                                                        @if ($half_rating == true)
                                                        <i class="fas fa-star-half-alt"></i>
                                                            @php
                                                                $half_rating = false
                                                            @endphp
                                                        @else
                                                        <i class="far fa-star"></i>
                                                        @endif
                                                    @endif
                                                @endfor
                                                <span>({{ $total_review }})</span>
                                            </b>
                                            @else
                                                <b>
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                </b>
                                                @endif
                                        </p>
                                        <hr>

                                        @if ($show_provider_contact_info->status == 1)
                                        <a href="callto:{{ $provider->phone }}"><i class="fas fa-phone-alt"></i> {{ $provider->phone }}</a>
                                        <a href="mailto:{{ $provider->email }}"><i class="fas fa-envelope"></i>
                                            {{ $provider->email }}</a>
                                        @endif

                                        @auth('web')
                                            <a href="javascript:;" class="contact_provider_btn" onclick="sendNewMessage('{{ $provider->name }}','{{ $provider->id }}', '{{ $provider->designation }}', '{{ $provider->image }}', '{{ $service->id }}', '{{ $service->name }}', '{{ $service->image }}')">{{__('user.Contact Here')}}</a>
                                        @else
                                            <a href="javascript:;" class="contact_provider_btn" onclick="sendNewMessagePrevLogin()">{{__('user.Contact Here')}}</a>
                                        @endauth

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=========================
        SERVICE DETAILS END
    ==========================-->



    <!--=========================
        RELATEDE SERVICES START
    ==========================-->

    @if ($related_services->count() > 0)
    <section class="wsus__features_services mb_60 xs_mb_30">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="related_services_heading">
                        <h2>{{__('user.Related Service')}}</h2>
                    </div>
                </div>
            </div>
            <div class="row related_services_slider">
                @foreach ($related_services as $related_service)
                <div class="col-xl-4">
                    <div class="wsus__single_services">
                        <div class="wsus__services_img">
                            <img src="{{ asset($related_service->image) }}" alt="service" class="img-fluid w-100">
                        </div>
                        <div class="wsus__services_text">
                            <ul class="d-flex justify-content-between">
                                <li><a href="{{ route('services',['category'=> $related_service->category->slug]) }}">{{ $related_service->category->name }}</a></li>
                                <li>{{ $currency_icon->icon }}{{ $related_service->price }}</li>
                            </ul>
                            <a class="title" href="{{ route('service', $related_service->slug) }}">{{ $related_service->name }}</a>
                            <div
                                class="single_service_footer d-flex flex-wrap justify-content-between align-items-center">
                                <div class="img_area">
                                    <img src="{{ $related_service->provider ? asset($related_service->provider->image) : '' }}" alt="user" class="img-fluid">
                                    <span>{{ $related_service->provider->name }}</span>
                                </div>

                                @php
                                    $reviewQty = $related_service->totalReview;
                                    $totalReview = $related_service->averageRating;
                                    if ($reviewQty > 0) {
                                        $average = $totalReview;
                                        $intAverage = intval($average);
                                        $nextValue = $intAverage + 1;
                                        $reviewPoint = $intAverage;
                                        $halfReview=false;
                                        if($intAverage < $average && $average < $nextValue){
                                            $reviewPoint= $intAverage + 0.5;
                                            $halfReview=true;
                                        }
                                    }
                                @endphp

                                @if ($reviewQty > 0)
                                    <p>
                                        @for ($i = 1; $i <=5; $i++)
                                            @if ($i <= $reviewPoint)
                                                <i class="fas fa-star"></i>
                                            @elseif ($i> $reviewPoint )
                                                @if ($halfReview==true)
                                                <i class="fas fa-star-half-alt"></i>
                                                    @php
                                                        $halfReview=false
                                                    @endphp
                                                @else
                                                <i class="far fa-star"></i>
                                                @endif
                                            @endif
                                        @endfor
                                        <span>({{ $related_service->totalReview }})</span>
                                    </p>
                                @else
                                    <p>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <span>({{ $related_service->totalReview }})</span>
                                    </p>
                                @endif
                            </div>
                            <a class="common_btn" href="{{ route('ready-to-booking', $related_service->slug) }}">{{__('user.Book now')}}</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    <!--=========================
        RELATEDE SERVICES END
    ==========================-->


<script>
    (function($) {
        "use strict";
        $(document).ready(function () {
            $("#after_login").on("click",function(){
                toastr.error('Please Login First');
            })


            $("#serviceReviewForm").on('submit', function(e){
                e.preventDefault();
                var isDemo = "{{ env('APP_MODE') }}"
                if(isDemo == 'DEMO'){
                    toastr.error('This Is Demo Version. You Can Not Change Anything');
                    return;
                }
                $.ajax({
                    type: 'POST',
                    data: $('#serviceReviewForm').serialize(),
                    url: "{{ route('store-service-review') }}",
                    success: function (response) {
                        if(response.status == 1){
                            toastr.success(response.message)
                            $("#serviceReviewForm").trigger("reset");
                        }

                        if(response.status == 0){
                            toastr.error(response.message)
                            $("#serviceReviewForm").trigger("reset");
                        }
                    },
                    error: function(response) {

                        if(response.responseJSON.errors.comment)toastr.error(response.responseJSON.errors.comment[0])

                        if(!response.responseJSON.errors.comment){
                            toastr.error("{{__('user.Please complete the recaptcha to submit the form')}}")
                        }
                    }
                });
            })

        });
    })(jQuery);


    function productReview(rating){
        $(".service_rat").each(function(){
            var service_rat = $(this).data('rating')
            if(service_rat > rating){
                $(this).removeClass('fas fa-star').addClass('fal fa-star');
            }else{
                $(this).removeClass('fal fa-star').addClass('fas fa-star');
            }
        })
        $("#service_rating").val(rating);
        let html = `(${rating}.0)`
        $("#show_rating").html(html);
    }

</script>
@endsection
