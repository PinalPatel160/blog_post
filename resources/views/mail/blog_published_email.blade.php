@component('mail::message')

# Hello, {{$user['name']}}

<h2>{{$blog_detail['title']}}</h2>

<p class="head">{{$blog_detail['sub_title']}}</p>
<p>{{ str_limit($blog_detail['description'], $limit = 150, $end = '...')}}</p>

@component('mail::button', ['url' => "/blogPost/".$blog_detail['id']])
Read More
@endcomponent

<p>Published by, {{$blog_detail['user']['name']}}</p>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
