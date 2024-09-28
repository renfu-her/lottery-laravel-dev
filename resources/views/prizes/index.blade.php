@extends('layouts.app')

@section('title', '奖品列表')

@section('content')
    <h1 class="mb-4">奖品列表</h1>
    <a href="{{ route('prizes.create') }}" class="btn btn-primary mb-3">添加奖品</a>
    <button id="startDraw" class="btn btn-success mb-3 ms-2">开始自动抽奖</button>

    <div id="drawResult" class="alert alert-info d-none" role="alert"></div>

    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>名称</th>
                <th>总数量</th>
                <th>剩余数量</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prizes as $prize)
                <tr>
                    <td>{{ $prize->name }}</td>
                    <td>{{ $prize->quantity }}</td>
                    <td>{{ $prize->remaining }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                            data-bs-target="#assignModal{{ $prize->id }}">
                            分配奖品
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @foreach ($prizes as $prize)
        <!-- 保持原有的模态框代码不变 -->
    @endforeach

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    let isDrawing = false;
    let drawInterval;

    $('#startDraw').click(function() {
        if (!isDrawing) {
            isDrawing = true;
            $(this).text('停止抽奖').removeClass('btn-success').addClass('btn-danger');
            drawInterval = setInterval(drawPrize, 1000); // 每秒抽一次奖
        } else {
            stopDrawing();
        }
    });

    function stopDrawing() {
        isDrawing = false;
        $('#startDraw').text('开始自动抽奖').removeClass('btn-danger').addClass('btn-success');
        clearInterval(drawInterval);
    }

    function drawPrize() {
        $.get('{{ route('lottery.draw') }}', function(data) {
            if (data.status === 'success') {
                showWinnerIcon(data.winner, data.prize);
                $('#drawResult').removeClass('d-none').text(`恭喜 ${data.winner} 赢得了 ${data.prize}!`);
            } else if (data.status === 'finished') {
                $('#drawResult').removeClass('d-none').text('抽奖已结束，没有更多可用的奖品或用户。');
                stopDrawing();
            }
        });
    }

    function showWinnerIcon(winner, prize) {
        const icon = $('<div>')
            .addClass('winner-icon')
            .css({
                position: 'fixed',
                top: '50%',
                left: '50%',
                transform: 'translate(-50%, -50%)',
                backgroundColor: 'gold',
                borderRadius: '50%',
                width: '100px',
                height: '100px',
                display: 'flex',
                justifyContent: 'center',
                alignItems: 'center',
                zIndex: 9999
            })
            .html(`<span style="font-size: 40px">🏆</span>`);

        $('body').append(icon);

        setTimeout(() => {
            icon.fadeOut(500, function() {
                $(this).remove();
            });
        }, 3000);
    }
});
</script>
@endpush
