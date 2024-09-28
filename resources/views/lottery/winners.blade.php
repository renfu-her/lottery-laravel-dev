@extends('layouts.app')

@section('title', '获奖记录')

@section('content')
    <div class="container">
        <h1 class="mb-4">获奖记录</h1>

        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>获奖者</th>
                    <th>奖品</th>
                    <th>获奖时间</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($winners as $winner)
                    <tr>
                        <td>{{ $winner->user->name }}</td>
                        <td>{{ $winner->prize->name }}</td>
                        <td>{{ $winner->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
