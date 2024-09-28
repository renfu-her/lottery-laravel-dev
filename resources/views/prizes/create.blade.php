@extends('layouts.app')

@section('title', '添加奖品')

@section('content')
<h1 class="mb-4">添加奖品</h1>

<form action="{{ route('prizes.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="name" class="form-label">奖品名称</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="mb-3">
        <label for="quantity" class="form-label">数量</label>
        <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
    </div>
    <button type="submit" class="btn btn-primary">添加奖品</button>
</form>
@endsection
