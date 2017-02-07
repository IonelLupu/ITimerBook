<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ $page['title'] or 'Page title...' }}
        <small>{{ $page['subTitle'] or '' }}</small>

    </h1>
    {{--<ol class="breadcrumb">--}}
    {{--<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>--}}
    {{--<li><a href="#">Tables</a></li>--}}
    {{--<li class="active">Simple</li>--}}
    {{--</ol>--}}
    {{--<ul class="breadcrumb">--}}
    {{--<li>--}}
    {{--<i class="fa fa-home"></i>--}}
    {{--<a href="{{route('Dashboard')}}">Home</a>--}}
    {{--</li>--}}
    {{--@for($i = 0; $i <= count(Request::segments()); $i++)--}}
    {{--@if( Request::segment($i) )--}}
    {{--<li>--}}
    {{--<a href="">{{ ucfirst( Request::segment($i) ) }}</a>--}}
    {{--@if($i < count(Request::segments()) & $i > 0)--}}
    {{--{!!'<i class="fa fa-angle-right"></i>'!!}--}}
    {{--@endif--}}
    {{--</li>--}}
    {{--@endif--}}
    {{--@endfor--}}
    {{--</ul>--}}
</section>