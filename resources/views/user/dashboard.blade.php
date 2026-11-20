@extends('layouts.user')

@section('title', 'Dashboard')
@section('heading', 'Hii, ' . explode(' ', auth()->user()->name)[0])

@section('content')
<div class="stats">
    <div class="card stat"><b>2</b><span>Trips planned</span></div>
    <div class="card stat"><b>3</b><span>Upcoming bookings</span></div>
    <div class="card stat"><b>2</b><span>Awaiting confirmation</span></div>
    <div class="card stat"><b>1</b><span>Trip completed</span></div>
</div>

<h2 style="margin:0;font-size:18px">Your recent trips</h2>

<div class="card trip">
    <div class="thumb"></div>
    <div class="info">
        <b>Ella Adventure</b><br>
        <small>10 to 13 Oct 2027 · 2 destinations · 3 days</small>
    </div>
    <span class="pill">Upcoming</span>
</div>
@endsection