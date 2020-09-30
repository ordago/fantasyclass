@extends('layouts.student')

@section('content')
       <show-students-student :character-theme="{{ $class->character_theme }}" :students="{{ json_encode($students) }}" :theme="{{ $class->theme }}"></show-students-student>
@endsection

@push('scriptchat')
<script>
/* Chatbro Widget Embed Code Start */
function ChatbroLoader(chats,async){async=!1!==async;var params={embedChatsParameters:chats instanceof Array?chats:[chats],lang:navigator.language||navigator.userLanguage,needLoadCode:'undefined'==typeof Chatbro,embedParamsVersion:localStorage.embedParamsVersion,chatbroScriptVersion:localStorage.chatbroScriptVersion},xhr=new XMLHttpRequest;xhr.withCredentials=!0,xhr.onload=function(){eval(xhr.responseText)},xhr.onerror=function(){console.error('Chatbro loading error')},xhr.open('GET','//www.chatbro.com/embed.js?'+btoa(unescape(encodeURIComponent(JSON.stringify(params)))),async),xhr.send()}
// /* Chatbro Widget Embed Code End */
ChatbroLoader({encodedChatId: '94Un6'});
ChatbroLoader({
       chatTitle: "{{ $chat }}",
       parentEncodedChatId: '94Un6',
       siteDomain: "{{ $url }}",
       siteUserExternalId: "{{ auth()->user()->id }}-{{ $student->id }}",
       siteUserFullName: "{{ $student->name }}",
       siteUserAvatarUrl: "{{ env('APP_URL') }}{{ $student->avatar }}",
       signature: "{{ $chatbro }}",
});
console.log("{{$chatbro}}");
</script>
@endpush