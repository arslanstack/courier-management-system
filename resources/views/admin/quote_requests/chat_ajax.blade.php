@foreach($messages as $message)
<div class="chat-message {{$message->side}}">
    <img class="message-avatar" src="{{ asset('admin_assets/img/a1.jpg') }}" alt="">
    <div class="message">
        <a class="message-author" href="#"> {{$message->sender_user}} -  {{$message->sender_company}}</a>
        <span class="message-date"> {{$message->created_at}} </span>
        <span class="message-content">
            {{$message->message}}
        </span>
    </div>
</div>
@endforeach