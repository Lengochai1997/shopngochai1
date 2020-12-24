<div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Người dùng mới (+{{ isset($userDay) ? $userDay : 0 }} hôm nay)</h6>
    </div>
    <!-- Card Body -->
    <div class="card-body text-center">
        <ul class="list-group">
            @if(isset($users_last) && count($users_last) > 0)
                @foreach($users_last as $user)
                    <li class="list-group-item">{{ $loop->index + 1 }} - {{ $user->name ? $user->name : $user->username }}</li>
                @endforeach
            @else
                <li class="list-group-item">Không có dữ liệu</li>
            @endif
        </ul>
    </div>
</div>
