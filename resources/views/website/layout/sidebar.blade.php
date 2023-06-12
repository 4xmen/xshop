

<div class="pt-2 bg-primary text-light" id="toggle-side">
    <h2 class="text-center">
        تنظیم صافی و ترتیب نمایش
    </h2>
</div>
<div class="side-box">
    <h2>
        دسته بندی
    </h2>
    <ul class="list-group">
        <li class="list-group-item">
            <a href="">دسته اصلی</a>
            <div class="mt-2"></div>
            <ul class="list-group">
                {!! App\Helpers\showCats([],'list-group-item','list-group') !!}
            </ul>
        </li>

    </ul>
</div>
