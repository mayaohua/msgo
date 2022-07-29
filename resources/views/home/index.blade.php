@extends('layouts.home')
@section('head')
<title>号卡分销平台-星耀互联</title>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('home/css/numberCardDistribution.css') }}" />
@endsection
@section('content')
    <div class="banner banner-numberCardDistribution">
        <div class="wrap">
            <div class="banner-content">
                <p class="banner-title">号卡分销平台</p>
                <p class="banner-desc">全渠道号卡分销解决方案，助力企业构建号卡新零售平台， 提升企业变现能力</p>
                <p class="banner-link show-board">免费试用</p>
            </div>
        </div>
    </div>
    <div class="nav-wrap">
        <div class="page-nav">
            <ul class="wrap clear">
                <li class="page-nav-item active-nav">
                    <span>功能介绍</span>
                    <span class="line"></span>
                </li>
                <li class="page-nav-item">
                    <span>功能详解</span>
                    <span class="line"></span>
                </li>
                <li class="page-nav-item">
                    <span>收费标准</span>
                    <span class="line"></span>
                </li>
            </ul>
        </div>
    </div>
    <section class="section section1 section-bg">
        <div class="wrap">
            <h2 class="section-title3">功能完善的全链路支撑</h2>
            <div class="function-list clear">
                <div class="function-item box">
                    <img class="function-img" src="/home/img/icon1_1.png" />
                    <div class="function-info">
                        <p class="function-title">快速裂变分销</p>
                        <p class="function-text">可分配管理一、二级代理，清晰管理所有订单明细，配备专属推广链接</p>
                    </div>
                </div>
                <div class="function-item box">
                    <img class="function-img" src="/home/img/icon1_2.png" />
                    <div class="function-info">
                        <p class="function-title">上游通道对接</p>
                        <p class="function-text">支持接口、脚本等方式自动将订单提交至上游系统，免去人工整理订单带来的众多弊端</p>
                    </div>
                </div>
                <div class="function-item box">
                    <img class="function-img" src="/home/img/icon1_3.png" />
                    <div class="function-info">
                        <p class="function-title">靓号推荐</p>
                        <p class="function-text">无论专属号池或线上号池，均可实现在线实时获取推荐靓号，提升下单转化率</p>
                    </div>
                </div>
                <div class="function-item box">
                    <img class="function-img" src="/home/img/icon1_4.png" />
                    <div class="function-info">
                        <p class="function-title">电商小店</p>
                        <p class="function-text">一、二级代理均可对商品加价销售，可生成专属小店推广号卡、靓号等多类产品</p>
                    </div>
                </div>
                <div class="function-item box">
                    <img class="function-img" src="/home/img/icon1_5.png" />
                    <div class="function-info">
                        <p class="function-title">风控管理</p>
                        <p class="function-text">多种拦截规则避免恶意套卡、养卡等风险订单，规避业务风险</p>
                    </div>
                </div>
                <div class="function-item box">
                    <img class="function-img" src="/home/img/icon1_6.png" />
                    <div class="function-info">
                        <p class="function-title">电商收单</p>
                        <p class="function-text">系统支持一键自动同步天猫、拼多多、京东等电商平台订单并自动生产，并自动回传生产状态</p>
                    </div>
                </div>
                <div class="function-item box">
                    <img class="function-img" src="/home/img/icon1_7.png" />
                    <div class="function-info">
                        <p class="function-title">多维度数据分析</p>
                        <p class="function-text">全方位多维度大数据分析，实时监控店铺运营状态</p>
                    </div>
                </div>
                <div class="function-item box">
                    <img class="function-img" src="/home/img/icon1_8.png" />
                    <div class="function-info">
                        <p class="function-title">自主化配置</p>
                        <p class="function-text">系统交易均可配置专属收款方式，支持支付宝、微信支付</p>
                    </div>
                </div>
                <div class="function-item box">
                    <img class="function-img" src="/home/img/icon1_9.png" />
                    <div class="function-info">
                        <p class="function-title">营销工具</p>
                        <p class="function-text">话费充送、短信、切单等多种营销工具，满足多种营销场景</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="section-block">
            <div class="wrap clear">
                <img class="section-img" src="/home/img/img1.png" />
                <div class="section-info box">
                    <p class="info-border"></p>
                    <h4 class="info-title">快速裂变分销</h4>
                    <p class="info-text">代理自主注册、经销商批量创建快速生成代理推广资质，一、二级均提供独立管理后台，可获取专属推广链接、二维码快速收单</p>
                    <p class="use-btn show-board">免费试用</p>
                </div>
            </div>

        </div>
        <div class="section-block">
            <div class="wrap clear">
                <img class="section-img" src="/home/img/img2.png" />
                <div class="section-info box">
                    <p class="info-border"></p>
                    <h4 class="info-title">上游通道对接</h4>
                    <p class="info-text" style="width: 454px;">
                        平台提供定制化通道对接，上游无论采用接口、H5方式收单均由我司工程师介入开发实现订单自动收录、自动提交至上游系统，自动获取生产状态</p>
                    <p class="use-btn show-board">免费试用</p>
                </div>
            </div>
        </div>
        <div class="section-block">
            <div class="wrap clear">
                <img class="section-img" src="/home/img/img3.png" />
                <div class="section-info box">
                    <p class="info-border"></p>
                    <h4 class="info-title">靓号推荐</h4>
                    <p class="info-text">系统支持导入线下号码，线上自动获取上游号码库，通过系统规则筛选后展示给用户，连号、生日号、顺子号、生日号、情侣号多种规则</p>
                    <p class="use-btn show-board">免费试用</p>
                </div>
            </div>
        </div>
        <div class="section-block">
            <div class="wrap clear">
                <img class="section-img" src="/home/img/img4.png" />
                <div class="section-info box">
                    <p class="info-border"></p>
                    <h4 class="info-title">电商小店</h4>
                    <p class="info-text">一、二级均可自动生成专属H5店铺，代理可自主加价进行二次销售，灵活售后体系，极大提升代理积极性</p>
                    <p class="use-btn show-board">免费试用</p>
                </div>
            </div>
        </div>
        <div class="section-block">
            <div class="wrap clear">
                <img class="section-img" src="/home/img/img5.png" />
                <div class="section-info box">
                    <p class="info-border"></p>
                    <h4 class="info-title">风险控制</h4>
                    <p class="info-text">依托近千万数据防刷，高效识别恶意套卡刷单行为，自动拦截重复下单、异常年龄用户、高危地区、虚假身份证信息等多种恶意下单行为，灵活组合条件拦截无效恶意订单</p>
                    <p class="use-btn show-board">免费试用</p>
                </div>
            </div>
        </div>
        <div class="section-block">
            <div class="wrap clear">
                <img class="section-img" src="/home/img/img6.png" />
                <div class="section-info box">
                    <p class="info-border"></p>
                    <h4 class="info-title">电商收单</h4>
                    <p class="info-text">系统配置规则后一键同步各大电商平台订单，收录后自动提交至上游，并根据实际生产状态将生产结果回传至电商平台，极大提高生产效率</p>
                    <p class="use-btn show-board">免费试用</p>
                </div>
            </div>
        </div>
        <div class="section-block">
            <div class="wrap clear">
                <img class="section-img" src="/home/img/img7.png" />
                <div class="section-info box">
                    <p class="info-border"></p>
                    <h4 class="info-title">多维度分析</h4>
                    <p class="info-text">支持以日、周、月为单位全量监控订单数据，销量趋势一目了然，订单用户性别占比分析、年龄占比分析、单链接访问转化分析等多维度数据统计</p>
                    <p class="use-btn show-board">免费试用</p>
                </div>
            </div>
        </div>
        <div class="section-block">
            <div class="wrap clear">
                <img class="section-img" src="/home/img/img8.png" />
                <div class="section-info box">
                    <p class="info-border"></p>
                    <h4 class="info-title">自主化配置</h4>
                    <p class="info-text">经销商可自主配置独立收款账号，支持支付宝、微信主流支付方式，资金走向清晰，结合订单明细清晰管理资金</p>
                    <p class="use-btn show-board">免费试用</p>
                </div>
            </div>
        </div>
        <div class="section-block">
            <div class="wrap clear">
                <img class="section-img" src="/home/img/img9.png" />
                <div class="section-info box">
                    <p class="info-border"></p>
                    <h4 class="info-title">营销工具</h4>
                    <p class="info-text">话费充值送、短信促激活提醒、物流发货通知、自动切单等多种营销工具提升订单转化率，提升用户体验，拉长用户在网时长</p>
                    <p class="use-btn show-board">免费试用</p>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="section3-main section-bg">
            <h2 class="section-title3">平台收费标准</h2>
            <div class="charge-wrap">
                <div class="charge-block">
                    <div class="charge-head box">
                        <p class="version-name">包年版</p>
                        <p class="version-price">
                            <span class="version-money">24000</span>
                            <span class="version-spec">元/年</span>
                        </p>
                    </div>
                    <div class="charge-body box">
                        <div class="charge-item clear">
                            <img class="charge-img" src="/home/img/icon1.png" />
                            <div class="charge-info">
                                <p class="charge-title">每月赠送5万笔免费订单额度</p>
                                <p class="charge-text">(月额度不可累计使用，免费额度使用超出后每笔订单按照0.2元/笔收费)</p>
                            </div>
                        </div>
                        <div class="charge-item clear">
                            <img class="charge-img" src="/home/img/icon2.png" />
                            <div class="charge-info">
                                <p class="charge-title">全年赠送3次上游对接</p>
                                <p class="charge-text">（不区分接口、脚本，赠送次数超出后新增脚本类对接1000元/个，接口类对接800元/个）</p>
                            </div>
                        </div>
                        <div class="charge-item clear">
                            <img class="charge-img" src="/home/img/icon3.png" />
                            <div class="charge-info">
                                <p class="charge-title">定制化功能开发</p>
                                <p class="charge-text">（如系统存在定制化开发需求，按照500元/人/次提供报价方案）</p>
                            </div>
                        </div>
                        <div class="charge-item clear">
                            <img class="charge-img" src="/home/img/icon4.png" />
                            <div class="charge-info">
                                <p class="charge-title">不限制一级代理开放</p>
                                <p class="charge-text">（不限制创建一级代理数量）</p>
                            </div>
                        </div>
                        <div class="charge-item clear">
                            <img class="charge-img" src="/home/img/icon5.png" />
                            <div class="charge-info">
                                <p class="charge-title">支持配置独立收款账号</p>
                                <p class="charge-text">（支持配置独立微信、支付宝账号）</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="charge-block">
                    <div class="charge-head box">
                        <p class="version-name">包月版</p>
                        <p class="version-price">
                            <span class="version-money">2000</span>
                            <span class="version-spec">元/月</span>
                        </p>
                    </div>
                    <div class="charge-body box">
                        <div class="charge-item clear">
                            <img class="charge-img" src="/home/img/icon1.png" />
                            <div class="charge-info">
                                <p class="charge-title">每月赠送2万笔免费订单额度</p>
                                <p class="charge-text">（月额度不可累计使用，免费额度使用超出后每笔订单按照0.4元/笔收费）</p>
                            </div>
                        </div>
                        <div class="charge-item clear">
                            <img class="charge-img" src="/home/img/icon6.png" />
                            <div class="charge-info">
                                <p class="charge-title charge-title-gray">无赠送上游对接次数</p>
                                <p class="charge-text">（不区分接口、脚本，脚本类对接1000元/个接口类对接800元/个）</p>
                            </div>
                        </div>
                        <div class="charge-item clear">
                            <img class="charge-img" src="/home/img/icon3.png" />
                            <div class="charge-info">
                                <p class="charge-title">定制化功能开发</p>
                                <p class="charge-text">（如系统存在定制化开发需求，按照600元/人/次提供报价方案）</p>
                            </div>
                        </div>
                        <div class="charge-item clear">
                            <img class="charge-img" src="/home/img/icon4.png" />
                            <div class="charge-info">
                                <p class="charge-title">不限制一级代理开放</p>
                                <p class="charge-text">（不限制创建一级代理数量）</p>
                            </div>
                        </div>
                        <div class="charge-item clear">
                            <img class="charge-img" src="/home/img/icon7.png" />
                            <div class="charge-info">
                                <p class="charge-title charge-title-gray">不支持配置独立收款账号</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section3-bottom box">
            <p class="use-btn2 show-board">免费试用</p>
        </div>
    </section>
@endsection
@section('script')
<script src="/home/js/business.js" type="text/javascript" charset="utf-8"></script>
@endsection