

<div class="pt-2 text-muted" id="toggle-side">
        <h5 class="text-center py-3">
            تنظیم صافی و ترتیب نمایش
        </h5>
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
