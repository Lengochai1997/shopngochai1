<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <h4 class="modal-title">Lượt quay gần đây</h4>
</div>
<div class="modal-body">
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Người chơi</th>
            <th scope="col">Phần thưởng</th>
        </tr>
        </thead>
        <tbody>
            @foreach($histories as $history)
                <tr>
                    <td>{{ hiddenUsername($history->user->username) }}</td>
                    <td>{{ $history->result }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn c-theme-btn c-btn-border-2x c-btn-square c-btn-bold c-btn-uppercase" data-dismiss="modal">Đóng</button>
</div>

<script type="text/javascript">

</script>
