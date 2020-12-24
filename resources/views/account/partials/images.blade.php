<div class="container m-t-20">
    <div class="c-content-tab-4 c-opt-3" role="tabpanel">
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="info">
                <ul class="c-tab-items" style="padding-right:5px;padding-left: 5px;">
                    <li class="text-center">
                        <b>Chi tiết tài khoản</b>
                        <div class="images_des">
                            @foreach(processImagesAccount($account['images']) as $image)
                                <img class="c-content-media-2 c-bg-img-center" width="100%" src="{{ strpos($image, 'upload/images_del') !== false ? asset('') . $image : $image }}"><br>
                            @endforeach
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
