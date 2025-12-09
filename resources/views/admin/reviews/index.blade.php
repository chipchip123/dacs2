@extends('admin.layouts.layout')

@section('styles')
<link rel="stylesheet" href="{{ asset('admin/css/review.css') }}">
@endsection

@section('content')

<h3 class="mb-4">Quản lý đánh giá sản phẩm</h3>

@include('admin.reviews.partials.filter')

@include('admin.reviews.partials.table')

@endsection

{{-- MODAL phải nằm ngoài content --}}
@section('modals')
@include('admin.reviews.partials.modals')
@endsection

@section('scripts')
<script src="{{ asset('admin/js/review.js') }}"></script>
@endsection
