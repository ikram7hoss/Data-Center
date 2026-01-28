@extends('layouts.internal')

@section('content')
<h1>Mes Notifications</h1>

@if($notifications->isEmpty())
    <p>Aucune notification pour le moment.</p>
@else
    <ul style="list-style: none; padding: 0;">
        @foreach($notifications as $notif)
            <li style="padding: 15px; margin-bottom: 10px; border: 1px solid #ddd; border-left: 5px solid {{ $notif->status == 'unread' ? '#007bff' : '#ccc' }}; background: {{ $notif->status == 'unread' ? '#f0f7ff' : '#fff' }};">
                <strong>{{ $notif->title }}</strong> 
                <small style="float: right;">{{ $notif->created_at->format('d/m/Y H:i') }}</small>
                <p>{{ $notif->message }}</p>
                
                @if($notif->status == 'unread')
                    <form action="{{ route('internal.notifications.read', $notif->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" style="font-size: 0.8em;">Marquer comme lu</button>
                    </form>
                @endif
            </li>
        @endforeach
    </ul>
@endif
@endsection

