@extends('layouts.app')

@section('title', '抽獎結果')

@section('content')
    <div class="container">
        <h1 class="mb-4">抽獎結果</h1>

        @if (isset($winner) && isset($prize))
            <div class="alert alert-success" role="alert">
                恭喜 <strong>{{ $winner->name }}</strong> 贏得了 <strong>{{ $prize->name }}</strong>!
            </div>
            <div class="card bg-dark text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">獲獎詳情</h5>
                    <p class="card-text">獲獎者: {{ $winner->name }}</p>
                    <p class="card-text">獎品: {{ $prize->name }}</p>
                    <p class="card-text">抽獎時間: {{ now()->format('Y-m-d H:i:s') }}</p>
                </div>
            </div>
        @else
            <div class="alert alert-warning" role="alert">
                抽獎未成功。可能是沒有可用的獎品或用戶。
            </div>
        @endif

        <a href="{{ route('prizes.index') }}" class="btn btn-primary">返回獎品列表</a>
        <a href="{{ route('lottery.winners') }}" class="btn btn-info ms-2">查看所有獲獎記錄</a>
    </div>

    @if (isset($winner) && isset($prize))
        @push('scripts')
            <script>
                // 簡單的禮花效果
                function createConfetti() {
                    const colors = ['#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff', '#00ffff'];
                    for (let i = 0; i < 100; i++) {
                        const confetti = document.createElement('div');
                        confetti.style.width = '10px';
                        confetti.style.height = '10px';
                        confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                        confetti.style.position = 'fixed';
                        confetti.style.left = Math.random() * 100 + 'vw';
                        confetti.style.top = '-10px';
                        confetti.style.borderRadius = '50%';
                        confetti.style.zIndex = '1000';
                        document.body.appendChild(confetti);

                        const animation = confetti.animate([{
                                transform: 'translateY(0)',
                                opacity: 1
                            },
                            {
                                transform: `translateY(${window.innerHeight}px)`,
                                opacity: 0
                            }
                        ], {
                            duration: Math.random() * 3000 + 2000,
                            easing: 'cubic-bezier(0,1,1,0)'
                        });

                        animation.onfinish = () => confetti.remove();
                    }
                }

                // 页面加载后触发礼花效果
                window.addEventListener('load', createConfetti);
            </script>
        @endpush
    @endif

@endsection
