@extends('layouts.admin')
@section('title', 'Test Payment')
@section('content')
<h1>SIMPLE TEST</h1>
<p>Payment ID: {{ $payment->id }}</p>
<p>Order Number: {{ $payment->order->order_number }}</p>
<p>User Name: {{ $payment->order->user->name }}</p>
<p>Amount: Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
@endsection