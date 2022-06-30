@extends('web.layouts.main')
@section('content')

<main>
    <section class="section-reviews">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 col-xxl-9">
                    <div class="review">
                        <div class="container pe-xxl-5 ps-xxl-5 pe-xl-5 ps-xl-5 pe-lg-5 ps-lg-5">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-5 col-lg-5 col-xl-5 col-xxl-5">
                                    <div class="img-box">
                                        <img src="{{asset('web/images/rev.png')}}" class="img-fluid thumb" alt="">
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-7 col-lg-7 col-xl-7 col-xxl-7">
                                    <div class="desc">
                                        <p class="para">Here at <b>WeedEntertainment.com,</b> we strive to provide
                                            thoughtful honest strain reviews. We look for the best of the best, and give
                                            each strain a fair shake.</p>
                                        <p class="para">All of our strain reviews are conducted using the VaporCup
                                            Digital Vaporizer. If you would like to get your own VaporCup 2, head over
                                            to <a href="javascript:;" class="anchor">VaporCup.com.</a></p>

                                        <p class="para">Have a browse through the videos below, or come visit our<b><a
                                                    href="javascript:;" class="anchor">YouTube Channel.</a></b> <span
                                                class="fst-italic">(Dont forget to Like & Subscribe!!)</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="sec-youtube-videos">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 col-xxl-9">
                    <div class="y-tube-videos">
                        <div class="container pe-xxl-5 ps-xxl-5 pe-xl-5 ps-xl-5 pe-lg-5 ps-lg-5">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                    <div class="y-tube-banner">
                                        <div class="row align-items-center">
                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                                <div class="y-tube-flex">
                                                    <div class="img">
                                                        <img src="{{asset('web/images/unnamed.jpg')}}" class="img-fluid thumb" alt="">
                                                    </div>
                                                    <div class="y-tube-content">
                                                        <a href="javascript:;" class="head">Weed Entertainment</a>
                                                        <ul class="y-tube-ul">
                                                            <li class="yt-li">851 Videos</li>
                                                            <li class="yt-li">1.1M Views</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
                                                <div class="btn-grp">
                                                    <button type="submit" class="btn y-tube-btn"><i
                                                            class="fa-brands fa-youtube"></i> you tube</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                    <div class="row justify-content-end">
                                        <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                                            <div class="search">
                                                <form action="">
                                                    <input type="search" class="form-control search-cntrl"
                                                        placeholder="Search...">
                                                    <button type="submit" class="btn search-btn">
                                                        <i class="fa-regular fa-magnifying-glass"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                            <div class="y-tube-slider owl-carousel owl-theme" id="y-tube-slider">
                                            	@foreach($videos as $key => $video)
                                                <div class="item" data-dot="<button>{{++$key}}</button>">
                                                    <div class="videos-main">
                                                        <div class="row">
                                                        	@foreach($video as $val)
	                                                            <div
	                                                                class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4 col-xxl-4">
	                                                                <a href="{{route('video',$val['id'])}}" target="_blank"
	                                                                    class="y-tube-box">
	                                                                    <div class="img">
	                                                                        <img src="{{$val['thumbnail']}}"
	                                                                            class="img-fluid thumb" alt="">
	                                                                        <i class="fa-brands fa-youtube"></i>
	                                                                    </div>
	                                                                    <div class="desc">
	                                                                        <h6 class="head">{{$val['title']}}</h6>
	                                                                        <span class="date">4/11/2022</span>
	                                                                        <ul class="view-ul">
	                                                                            <li class="v-li">361 Views</li>
	                                                                            <li class="v-li">15 Comments</li>
	                                                                        </ul>
	                                                                    </div>
	                                                                </a>
	                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>


@endsection
