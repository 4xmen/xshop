<nav id="panel-navbar">
    <ul>
        <li data-bs-toggle="tooltip" data-bs-placement="auto" data-bs-custom-class="custom-tooltip"
            data-bs-title="{{__("xShop")}}">
            <a href="{{route('welcome')}}" target="_blank">
                <i class="ri-home-smile-fill"></i>
            </a>
        </li>
        <li data-bs-toggle="tooltip" data-bs-placement="auto" data-bs-custom-class="custom-tooltip"
            data-bs-title="{{__("Shopping card")}}">
            <a href="#card">
                <i class="ri-shopping-cart-line"></i>
            </a>
            <ul id="card">
                <li>
                    <a href="{{route('admin.customer.index')}}">
                        <i class="ri-team-fill"></i>

                        {{__('Customers')}}
                    </a>
                </li>
                <li>
                    <a>
                        <i class="ri-file-list-3-fill"></i>
                        {{__('Invoices')}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.discount.index')}}">
                        <i class="ri-percent-fill"></i>
                        {{__('Discounts')}}
                    </a>
                </li>
            </ul>
        </li>
        <li data-bs-toggle="tooltip" data-bs-placement="auto" data-bs-custom-class="custom-tooltip"
            data-bs-title="{{__("Catalog")}}">
            <a href="#catalog">
                <i class="ri-store-line"></i>
            </a>
            <ul id="catalog">
                <li>
                    <a href="{{route('admin.product.index')}}">
                        <i class="ri-vip-diamond-fill"></i>
                        {{__('Products')}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.category.index')}}">
                        <i class="ri-box-3-fill"></i>
                        {{__('Categories')}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.prop.index')}}">
                        <i class="ri-file-list-3-fill"></i>
                        {{__("Properties meta")}}
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.transport.index') }}">
                        <i class="ri-truck-fill"></i>
                        {{__('Transports')}}
                    </a>
                </li>

            </ul>
        </li>
        <li data-bs-toggle="tooltip" data-bs-placement="auto" data-bs-custom-class="custom-tooltip"
            data-bs-title="{{__("Contents")}}">
            <a href="#contents">
                <i class="ri-pages-line"></i>
            </a>
            <ul id="contents">
                <li>
                    <a href="{{route('admin.post.index')}}">
                        <i class="ri-megaphone-fill"></i>
                        {{__('Post')}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.group.index')}}">
                        <i class="ri-book-3-fill"></i>
                        {{__('Groups')}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.adv.index')}}">
                        <i class="ri-threads-line"></i>
                        {{__("Advertise")}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.gallery.index')}}">
                        <i class="ri-gallery-fill"></i>
                        {{__("Galleries")}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.clip.index')}}">
                        <i class="ri-video-fill"></i>
                        {{__("Video clips")}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.attachment.index')}}">
                        <i class="ri-attachment-2"></i>
                        {{__("Attachments")}}
                    </a>
                </li>
            </ul>
        </li>
        <li data-bs-toggle="tooltip" data-bs-placement="auto" data-bs-custom-class="custom-tooltip"
            data-bs-title="{{__("Theme")}}">
            <a href="#themes">
                <i class="ri-palette-line"></i>
            </a>
            <ul id="themes">
                <li>
                    <a href="">
                        <i class="ri-list-check"></i>
                        {{__("Menus")}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.slider.index')}}">
                        <i class="ri-image-fill"></i>
                        {{__("Slider")}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.gfx.index')}}">
                        <i class="ri-color-filter-line"></i>
                        {{__("Graphic")}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.area.index')}}">
                        <i class="ri-paint-brush-line"></i>
                        {{__("Area design")}}
                    </a>
                </li>
            </ul>
        </li>
        <li data-bs-toggle="tooltip" data-bs-placement="auto" data-bs-custom-class="custom-tooltip"
            data-bs-title="{{__("Interaction")}}">
            <a href="#interaction">
                <i class="ri-chat-1-line"></i>
            </a>
            <ul id="interaction">
                <li>
                    <a href="{{route('admin.question.index')}}">
                        <i class="ri-question-mark"></i>
                        {{__('Questions')}}
                    </a>
                </li>

                <li>
                    <a href="{{route('admin.ticket.index')}}">
                        <i class="ri-mail-fill"></i>
                        {{__('Tickets')}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.comment.index')}}">
                        <i class="ri-chat-1-fill"></i>
                        {{__('Comments')}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.contact.index')}}">
                        <i class="ri-mail-unread-fill"></i>
                        {{__("Contact us")}}
                    </a>
                </li>

            </ul>
        </li>
        <li data-bs-toggle="tooltip" data-bs-placement="auto" data-bs-custom-class="custom-tooltip"
            data-bs-title="{{__("Managing")}}">
            <a href="#manage">
                <i class="ri-pie-chart-line"></i>
            </a>
            <ul id="manage">
                <li>
                    <a href="{{route('admin.user.index')}}">
                        <i class="ri-user-line"></i>
                        {{__("Users")}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.state.index')}}">
                        <i class="ri-map-line"></i>
                        {{__("States")}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.city.index')}}">
                        <i class="ri-map-2-line"></i>
                        {{__("City")}}
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="ri-bar-chart-2-line"></i>
                        {{__("Reports")}}
                    </a>
                </li>
                <li>
                    <a href="{{route('admin.adminlog.index')}}">
                        <i class="ri-list-check-3"></i>
                        {{__('Logs of admins')}}
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="ri-list-check-3"></i>
                        {{__('Logs of guests')}}
                    </a>
                </li>
                <li>
                    <a>
                        <i class="ri-global-fill"></i>
                        {{__("Languages")}}
                    </a>
                </li>
            </ul>
        </li>
        <li data-bs-toggle="tooltip" data-bs-placement="auto" data-bs-custom-class="custom-tooltip"
            data-bs-title="{{__("Setting")}}">
            <a href="{{route('admin.setting.index')}}">
                <i class="ri-settings-4-line"></i>
            </a>
        </li>
    </ul>
</nav>
