@extends('layouts.app')

@section('title', '新增獎品')

@section('content')
    <h1 class="mb-4">新增獎品</h1>

    <form action="{{ route('prizes.store') }}" method="POST">
        @csrf
        <div class="mb-3"></div>
        <label for="name" class="form-label">獎品名稱</label>
        <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">數量</label>
            <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
        </div>
        <button type="submit" class="btn btn-primary">新增獎品</button>
    </form>
@endsection
