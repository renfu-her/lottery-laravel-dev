@extends('layouts.app')

@section('title', '獲獎記錄')

@section('content')
    <div class="container">
        <h1 class="mb-4">獲獎記錄</h1>

        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>獲獎者</th>
                    <th>獎品</th>
                    <th>獲獎時間</th>
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
