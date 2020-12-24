<!-- Account -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#list-category-global" aria-expanded="true" aria-controls="list-category-global">
        <i class="fas fa-fw fa-list"></i>
        <span>Tài khoản Game</span>
    </a>
    <div id="list-category-global" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ asset('admin/account/account') }}">Danh sách</a>
            <a class="collapse-item" href="{{ asset('admin/account/account/create?type=1') }}">Thêm TK Liên Quân</a>
            <a class="collapse-item" href="{{ asset('admin/account/account/create?type=2') }}">Thêm TK Free Fire</a>
        </div>
    </div>
</li>

<!-- Random -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#random" aria-expanded="true" aria-controls="random">
        <i class="fas fa-fw fa-list"></i>
        <span>Tài khoản Random</span>
    </a>
    <div id="random" class="collapse" aria-labelledby="random" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ asset('admin/random/list-account') }}">Danh sách</a>
        </div>
    </div>
</li>
