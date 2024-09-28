@extends('layouts.app')

@section('title', '奖品列表')

@section('content')
<h1 class="mb-4">奖品列表</h1>
<a href="{{ route('prizes.create') }}" class="btn btn-primary mb-3">添加奖品</a>
<a href="{{ route('lottery.draw') }}" class="btn btn-success mb-3 ms-2">自动抽奖</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>名称</th>
            <th>总数量</th>
            <th>剩余数量</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        @foreach($prizes as $prize)
        <tr>
            <td>{{ $prize->name }}</td>
            <td>{{ $prize->quantity }}</td>
            <td>{{ $prize->remaining }}</td>
            <td>
                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#assignModal{{ $prize->id }}">
                    分配奖品
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@foreach($prizes as $prize)
<div class="modal fade" id="assignModal{{ $prize->id }}" tabindex="-1" aria-labelledby="assignModalLabel{{ $prize->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignModalLabel{{ $prize->id }}">分配 {{ $prize->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('lottery.assign') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="prize_id" value="{{ $prize->id }}">
                    <div class="mb-3">
                        <label for="user_id" class="form-label">选择用户</label>
                        <select name="user_id" id="user_id" class="form-select" required>
                            @foreach(App\Models\User::all() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-primary">分配</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
