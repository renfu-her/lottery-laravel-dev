@extends('layouts.app')

@section('title', '獎品列表')

@section('content')
    <h1 class="mb-4">獎品列表</h1>
    <a href="{{ route('prizes.create') }}" class="btn btn-primary mb-3">添加獎品</a>
    <button id="startDraw" class="btn btn-success mb-3 ms-2">開始自動抽獎</button>

    <div id="drawResult" class="alert alert-info d-none" role="alert"></div>

    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>名稱</th>
                <th>總數量</th>
                <th>剩餘數量</th>
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
                            分配獎品
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @foreach ($prizes as $prize)
        <div class="modal fade" id="assignModal{{ $prize->id }}" tabindex="-1"
            aria-labelledby="assignModalLabel{{ $prize->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignModalLabel{{ $prize->id }}">分配 {{ $prize->name }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="關閉"></button>
                    </div>
                    <form action="{{ route('lottery.assign') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="prize_id" value="{{ $prize->id }}">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">選擇用戶</label>
                                <select name="user_id" id="user_id" class="form-select bg-dark text-light" required>
                                    @foreach (App\Models\User::doesntHave('winners')->get() as $user)
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

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            let isDrawing = false;
            let drawInterval;

            $('#startDraw').click(function() {
                if (!isDrawing) {
                    isDrawing = true;
                    $(this).text('停止抽獎').removeClass('btn-success').addClass('btn-danger');
                    drawInterval = setInterval(drawPrize, 3000); // 每秒抽一次獎
                } else {
                    stopDrawing();
                }
            });

            function stopDrawing() {
                isDrawing = false;
                $('#startDraw').text('開始自動抽獎').removeClass('btn-danger').addClass('btn-success');
                clearInterval(drawInterval);
            }

            function drawPrize() {
                $.get('{{ route('lottery.draw') }}', function(data) {
                    if (data.status === 'success') {
                        showWinnerIcon(data.winner, data.prize);
                        $('#drawResult').removeClass('d-none').text(`恭喜 ${data.winner} 贏得了 ${data.prize}!`);
                    } else if (data.status === 'finished') {
                        $('#drawResult').removeClass('d-none').text('抽獎已結束，沒有更多可用的獎品或用戶。');
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
