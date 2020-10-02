@extends('layouts.teacher')

@section('content')
@php
$theme = $class->theme;
@endphp
<div class="">
  <!-- Utilities -->
  <show-students :groups="{{ $groups }}" :students="{{ $students }}" :classroom="{{ $class }}"></show-students>

</div>
@endsection

@push('scriptchat')
<script>
       /* Chatbro Widget Embed Code Start */
       function ChatbroLoader(chats,async){async=!1!==async;var params={embedChatsParameters:chats instanceof Array?chats:[chats],lang:navigator.language||navigator.userLanguage,needLoadCode:'undefined'==typeof Chatbro,embedParamsVersion:localStorage.embedParamsVersion,chatbroScriptVersion:localStorage.chatbroScriptVersion},xhr=new XMLHttpRequest;xhr.withCredentials=!0,xhr.onload=function(){eval(xhr.responseText)},xhr.onerror=function(){console.error('Chatbro loading error')},xhr.open('GET','//www.chatbro.com/embed.js?'+btoa(unescape(encodeURIComponent(JSON.stringify(params)))),async),xhr.send()}
       // /* Chatbro Widget Embed Code End */
       ChatbroLoader({
              chatTitle: "{{ $chat['title'] }}",
              parentEncodedChatId: "{{ $chat['chatbro_id'] }}",
              siteDomain: "{{ $chat['url'] }}",
              siteUserExternalId: "{{ $chat['id'] }}",
              siteUserFullName: "{{ $chat['name'] }}",
              siteUserAvatarUrl: "{{ $chat['avatar'] }}",
              permissions: ['delete'],
              signature: "{{ $chat['signature'] }}",
       });
</script>
@endpush