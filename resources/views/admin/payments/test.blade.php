@extends('layouts.admin')

@section('title', 'Detail Pembayaran')

@section('content')
    <h1>TEST - Payment Detail Page</h1>
    <p>Payment ID: {{ $payment->id }}</p>
    <p>Order: {{ $payment->order->order_number }}</p>
    <p>User: {{ $payment->order->user->name }}</p>
@endsection