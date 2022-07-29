@extends('layouts.market')
@section('head')
<title>欢迎加入星耀合伙人，开启你的赚钱之旅</title>
<style>
.content img{
    width: 100%;
    display:block;
}
.ql-editor{
    padding: 0 !important;
}
</style>
<link href="https://cdn.quilljs.com/1.3.4/quill.core.css" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.4/quill.snow.css" rel="stylesheet">
<link href="https://cdn.quilljs.com/1.3.4/quill.bubble.css" rel="stylesheet">
@endsection
@section('content')
<div id="container">
    <div class="content ">
        <div class='ql-editor'>{!! $page_content ? $page_content : '' !!}</div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    new Vue({
        el:"#app",
        data:{
            
        },
        methods: {
        }
    })
</script>
@endsection