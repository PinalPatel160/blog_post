@component('mail::message')
# Hello, {{$blog_detail['user_name']}}
{{$blog_detail['title']}}
{{$blog_detail['sub_title']}}
{{$blog_detail['description']}}


@component('mail::button', ['url' => "/blogPost/"])
Read More
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
