@extends('frontend.frontend-page-master')
@section('site-title')
    {{get_static_option('contact_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-title')
    {{get_static_option('contact_page_'.$user_select_lang_slug.'_name')}}
@endsection
@section('page-meta-data')
    <meta name="description" content="{{get_static_option('contact_page_'.$user_select_lang_slug.'_meta_description')}}">
    <meta name="tags" content="{{get_static_option('contact_page_'.$user_select_lang_slug.'_meta_tags')}}">
@endsection
@section('content')
    @if(!empty(get_static_option('contact_page_page_builder_status')))
        {!! \App\PageBuilder\PageBuilderSetup::render_frontend_pagebuilder_content_by_location('contactpage') !!}
    @else
        @include('frontend.partials.contact-page-content')
    @endif

@endsection
@section('scripts')
@if(!empty(get_static_option('site_google_captcha_v3_site_key')) && !empty(get_static_option('site_google_captcha_status')))
    <script
        src="https://www.google.com/recaptcha/api.js?render={{get_static_option('site_google_captcha_v3_site_key')}}"></script>
    <script>
        grecaptcha.ready(function () {
            grecaptcha.execute("{{get_static_option('site_google_captcha_v3_site_key')}}", {action: 'homepage'}).then(function (token) {
                document.getElementById('gcaptcha_token').value = token;
            });
        });
    </script>
@endif
@endsection