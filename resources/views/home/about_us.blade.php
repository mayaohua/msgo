@extends('layouts.home')
@section('head')
<title>关于我们-星耀互联</title>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('home/css/aboutUs.css') }}" />
@endsection
@section('content')
    <div class="banner banner-about">
        <div class="wrap">
            <div class="banner-inner">
                <div class="banner-text-wrap">
                    <p class="banner-title banner-text-space">万物连接助手</p>
                    <p class="banner-desc banner-desc-en">ALL THINGS CAN BE CONNECTED</p>	
                </div>
                
            </div>
        </div>
    </div>
    <section class="about-main clear">
        <div class="about-item">
            <p class="about-item-title">01丨倡导更为便捷的通信连接方式</p>
            <p class="about-item-text" style="margin-top: 54px;">张家川县星耀科技工作室致力于用技术与创新力为国内中小企业带来赋能，公司以“5G+数字营销”为主旨理念，以广告服务、数字产品分发、SAAS服务平台、号卡分销平台为基础围绕企业需求提供安全可靠的技术支撑服务。</p>
        </div>
        <div class="about-item" style="width: 280px;">
            <p class="about-item-title">02丨使命</p>
            <p class="about-item-text">为客户、员工及股东创造价值。</p>
        </div>
        <div class="about-item" style="width: 240px;">
            <p class="about-item-title">03丨愿景</p>
            <p class="about-item-text">成为5G营销行业标杆企业。</p>
        </div>
    </section>
    {{-- <div class="team">
        <div class="team-title">我们的团队</div>
        <p class="team-desc">星耀是一家以技术为成长驱动的公司，星耀重视人才积累，以人才积累作为核心目标，立志提供完善的人才培养计划及空间，共同创造美好价值</p>
        <a href="https://jobs.51job.com/all/co4733822.html" class="join-btn">加入我们</a>
        <p class="team-text">热招岗位:JAVA&nbsp;&nbsp;数据&nbsp;&nbsp;运营&nbsp;&nbsp;剪辑师&nbsp;&nbsp;信息流优化师&nbsp;&nbsp;编导&nbsp;&nbsp;客服</p>
    </div> --}}
@endsection
@section('script')

@endsection