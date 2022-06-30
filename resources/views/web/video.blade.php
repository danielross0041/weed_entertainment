@extends('web.layouts.main')
@section('content')
<main>

    <section class="sec-youtube-detials">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 col-xxl-9">
                    <div class="y-tube-details">
                        <div class="container pe-xxl-5 ps-xxl-5 pe-xl-5 ps-xl-5 pe-lg-5 ps-lg-5">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                    <div class="video-player">
                                        <video class="video-control" muted controls>
                                            <source src="{{asset('web/images/HomepageHeroReel.mp4')}}" type="video/mp4">
                                        </video>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                    <div class="y-tube-video-name">
                                        <h6 class="title">{{$video->title}}</h6>
                                        {{--
                                        <ul class="share-ul">
                                            <li class="sl-li">519 Views</li>
                                            <li class="sl-li"><a class="share" href="javascript:;">share</a></li>
                                        </ul>
                                        --}}
                                    </div>
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
                                                            <li class="yt-li">Published at 5/3/2022</li>
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

                                        <div class="y-tube-details-more">
                                            <p>{{$video->description}}</p>
                                            <!-- <ul class="det-ul">
                                                <li class="d-li">Grand National Chronicles by Ted's Budz - April 2022
                                                </li>
                                                <li class="d-li">Weed Entertainment Strain Review</li>
                                            </ul> -->

                                            <!-- <div class="moreinfo" id="info1">
                                                <ul class="det-ul">
                                                    <li class="d-li">Name: Grand National Chronicles</li>
                                                    <li class="d-li">VaporCup Digital Vaporizer.</li>
                                                    <li class="d-li">Learn more about VaporCup at <a
                                                            href="javascript:;">http://www.vaporcup.com</a></li>
                                                </ul>

                                                <ul class="det-ul">
                                                    <li class="d-li">Come visit us at our Website:</li>
                                                    <li class="d-li"><a
                                                            href="javascript:;">http://www.WeedEntertainment.com</a>
                                                    </li>
                                                </ul>
                                            </div> -->

                                            <!-- <a class="more" target="1">show More</a> -->
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                    <!-- comment enter by user -->
                                    {{--
                                    <div class="comment">
                                        <ul class="comm-ul">
                                            <li class="li">
                                                <img src="{{asset('web/images/thumbnail.jpg')}}" class="comment-thumb" alt="">
                                            </li>
                                            <li class="li">
                                                <form action="">
                                                    <input type="text" class="form-control comment"
                                                        placeholder="Write your comment...">
                                                    <ul class="btn-ul">
                                                        <li class="btn-li">
                                                            <a href="javascript:;" class="anchor-btn">
                                                                cancel
                                                            </a>
                                                        </li>

                                                        <li class="btn-li">
                                                            <a href="javascript:;" class="anchor-btn">
                                                                comment
                                                            </a>
                                                        </li>

                                                    </ul>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                    --}}
                                    <!-- comment enter by user close-->

                                    <!-- comment posted by others -->
                                    @if(!$comments->isEmpty())
                                    @foreach($comments as $comment)
                                    <div class="pstd-comment">
                                        <ul class="pstd-ul">
                                            <li class="li">
                                                <img src="{{asset('web/images/thumbnail.jpg')}}" class="img" alt="">

                                                <div class="comm-desc">
                                                    <div class="name">
                                                        <span class="user-n">{{$comment->author}}</span>
                                                        {{--<span class="date-time">6 months ago</span>--}}
                                                    </div>
                                                    <p class="para"><?php echo (html_entity_decode($comment->comment));?> </p>
                                                </div>
                                            </li>
                                        </ul>

                                        <!-- user reply and like -->
                                        {{--
                                        <div class="reply-main">
                                            <span class="like-main">
                                                <a href="javascript:;" class="like-a">
                                                    <i class="fa-light fa-thumbs-up"></i> 36
                                                </a>
                                                <a href="javascript:;" class="like-a">
                                                    <i class="fa-light fa-thumbs-down"></i>
                                                </a>
                                                <a href="javascript:;" class="reply">reply</a>

                                                <!-- user comment box reply -->
                                                
                                                <div class="comment user_reply">
                                                    <ul class="comm-ul">
                                                        <li class="li">
                                                            <img src="{{asset('web/images/thumbnail.jpg')}}" class="comment-thumb"
                                                                alt="">
                                                        </li>
                                                        <li class="li">
                                                            <form action="">
                                                                <input type="text" class="form-control comment"
                                                                    placeholder="Write your comment...">
                                                                <ul class="btn-ul">
                                                                    <!-- <li class="btn-li">
                                                                        <a href="javascript:;"
                                                                            class="anchor-btn cancel">
                                                                            cancel
                                                                        </a>
                                                                    </li> -->

                                                                    <li class="btn-li">
                                                                        <a href="javascript:;" class="anchor-btn">
                                                                            reply
                                                                        </a>
                                                                    </li>

                                                                </ul>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                                
                                                <!-- user comment box reply -->
                                            </span>
                                        </div>
                                        --}}
                                        <!-- user reply and like close -->

                                        <!-- all reply on this comment -->
                                        <div class="reply-all">
                                            <a href="javascript:;" class="reply-all-anchor">{{sizeof($comment->replies)}} reply</a>
                                            <div class="all-replies">
                                                @foreach($comment->replies as $reply)
                                                <ul class="pstd-ul">
                                                    <li class="li">
                                                        <img src="{{asset('web/images/thumbnail.jpg')}}" class="img" alt="">

                                                        <div class="comm-desc">
                                                            <div class="name">
                                                                <span class="user-n">{{$reply->author}}</span>
                                                                {{--<span class="date-time">6 months ago</span>--}}
                                                            </div>
                                                            <p class="para"><?php echo (html_entity_decode($reply->reply));?></p>
                                                        </div>
                                                    </li>
                                                </ul>
                                                @endforeach
                                            </div>
                                        </div>
                                        <!-- all reply on this comment close -->
                                    </div>
                                    @endforeach
                                    @endif
                                    
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
