<nav id="navbar" class="">
    <ul>
        <li>
            <a href="{{ url('/') }}">
                <i class="ri-command-fill"></i>&nbsp;
                {{ config('app.name', 'Laravel') }}
            </a>
        </li>
        <li id="catalog" class="main-nav">
            <a>
                <i class="ri-apple-fill"></i>
                &nbsp;
                {{__("Catalog")}}
            </a>
            <ul>
                @if(auth()->user()->hasAnyAccess('product'))
                    <li id="product-li">
                        <a>
                            <i class="ri-vip-diamond-fill"></i>&nbsp;
                            {{__('Products')}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.product.index')}}">
                                    {{__('Products list')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.product.create')}}">
                                    {{__('New Product')}}
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('invoice'))
                    <li id="invoices-li">
                        <a>
                            <i class="ri-file-list-3-fill"></i>&nbsp;
                            {{__('Invoices')}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.invoice.index')}}">
                                    {{__('Invoices list')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.invoice.create')}}">
                                    {{__('New Invoice')}}
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('customer'))
                    <li>
                        <a>
                            <i class="ri-team-fill"></i>&nbsp;
                            {{__('Customers')}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.customer.index')}}">
                                    {{__('Customers list')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.customer.create')}}">
                                    {{__('New Customer')}}
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('discount'))
                    <li id="discount-li">
                        <a>
                            <i class="ri-percent-fill"></i>&nbsp;
                            {{__('Discounts')}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.discount.index')}}">
                                    {{__('Discounts list')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.discount.create')}}">
                                    {{__('New discount')}}
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('question'))
                    <li id="questions-li">
                        <a href="{{route('admin.question.index')}}">
                            <i class="ri-question-mark"></i>&nbsp;
                            {{__('Questions')}}
                        </a>
                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('ticket'))
                    <li id="tickets-li">
                        <a href="{{route('admin.ticket.index')}}">
                            <i class="ri-mail-fill"></i>&nbsp;
                            {{__('Tickets')}}
                        </a>
                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('cat'))
                    <li>
                        <a>
                            <i class="ri-box-3-fill"></i>&nbsp;
                            {{__('Product categories')}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.cat.index')}}">
                                    {{__('Product categories list')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.cat.create')}}">
                                    {{__('New Product category')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.cat.sort')}}">
                                    {{__('Product categories node')}}
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('transport'))

                    <li>
                        <a>
                            <i class="ri-truck-fill"></i>&nbsp;
                            {{__('Transports')}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.transport.index')}}">
                                    {{__('Transports list')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.transport.create')}}">
                                    {{__('New transport')}}
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('props'))
                    <li>
                        <a>
                            <i class="ri-file-list-3-fill"></i>&nbsp;
                            {{__("Properties meta")}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.props.index')}}">
                                    {{__("Properties list")}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.props.create')}}">
                                    {{__("New Property")}}
                                </a>
                            </li>
                        </ul>

                    </li>
                @endif
            </ul>
        </li>


        <li id="cms" class="main-nav">
            <a>
                <i class="ri-ie-fill"></i>&nbsp;
                &nbsp;
                {{__("Website contents")}}
            </a>
            <ul>
                @if(auth()->user()->hasAnyAccess('post'))
                    <li id="posts-li">
                        <a>
                            <i class="ri-megaphone-fill"></i>&nbsp;
                            {{__('Post')}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.post.index')}}">
                                    {{__('Post list')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.post.create')}}">
                                    {{__('New Post')}}
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('category'))
                    <li>
                        <a>
                            <i class="ri-book-3-fill"></i>&nbsp;
                            {{__('Categories')}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.category.index')}}">
                                    {{__('Categories list')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.category.create')}}">
                                    {{__('New category')}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.category.sort')}}">
                                    {{__('Categories node')}}
                                </a>
                            </li>
                        </ul>


                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('gallery'))


                    <li>
                        <a>
                            <i class="ri-gallery-fill"></i>&nbsp;
                            {{__("Galleries")}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.gallery.all')}}">
                                    {{--                           <i class="fa fa-list-alt"></i> --}}
                                    {{__("Gallery list")}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.gallery.create')}}">
                                    {{--                            <i class="fa fa-plus-square"></i>--}}
                                    {{__("New gallery")}}
                                </a>
                            </li>
                        </ul>

                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('clip'))
                    <li>
                        <a>
                            <i class="ri-video-fill"></i>&nbsp;
                            {{__("Video clips")}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.clip.index')}}">
                                    {{__("Video list")}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.clip.create')}}">
                                    {{__("New Video")}}
                                </a>
                            </li>
                        </ul>

                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('adv'))
                    <li>
                        <a>
                            <i class="ri-threads-line"></i>&nbsp;
                            {{__("Advertise")}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.adv.index')}}">
                                    {{__("Advertise list")}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.adv.create')}}">
                                    {{__("New Advertise")}}
                                </a>
                            </li>
                        </ul>

                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('menu'))
                    <li>
                        <a href="{{route('admin.menu.index')}}">
                            <i class="ri-list-check"></i>&nbsp;
                            {{__("Menus")}}
                        </a>
                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('props'))
                    <li>
                        <a>
                            <i class="ri-image-fill"></i>&nbsp;
                            {{__("Slider")}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.slider.index')}}">
                                    {{__("Slider list")}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.slider.create')}}">
                                    {{__("New Slider")}}
                                </a>
                            </li>
                        </ul>

                    </li>
                @endif
                @if(auth()->user()->hasAnyAccess('poll'))
                    <li>
                        <a>
                            <i class="ri-chat-poll-fill"></i>&nbsp;
                            {{__("Poll")}}
                        </a>
                        <ul>
                            <li>
                                <a href="{{route('admin.poll.index')}}">
                                    {{__("Polls list")}}
                                </a>
                            </li>
                            <li>
                                <a href="{{route('admin.poll.create')}}">
                                    {{__("New Poll")}}
                                </a>
                            </li>
                        </ul>

                    </li>
                @endif
            </ul>
        </li>

        @if(auth()->user()->hasAnyAccess('comment'))
            <li>
                <a href="{{route('admin.comment.index')}}">
                    <i class="ri-chat-1-fill"></i>&nbsp;
                    {{__('Comments')}}
                </a>
            </li>
        @endif
        @if(auth()->user()->hasAnyAccess('setting'))
            <li>
                <a href="{{route('admin.setting.index')}}">
                    <i class="ri-tools-fill"></i>&nbsp;
                    {{__("Setting")}}
                </a>
            </li>
        @endif
        @if(auth()->user()->hasAnyAccess('attachment'))
            <li>
                <a href="{{route('admin.attachment.index')}}">
                    <i class="ri-attachment-2"></i>&nbsp;
                    {{__("Attachments")}}
                </a>
            </li>
        @endif
        @if(auth()->user()->hasAnyAccess('contact'))
            <li>
                <a href="{{route('admin.contact.index')}}">
                    <i class="ri-mail-unread-fill"></i>&nbsp;
                    {{__("Contact us")}}
                </a>
            </li>
        @endif
        @if(auth()->user()->hasAnyAccess('logs'))
            <li>
                <a href="{{route('admin.logs.index')}}">
                    <i class="ri-list-check-3"></i>&nbsp;
                    {{__('Logs')}}
                </a>
            </li>
        @endif
        @if(auth()->user()->hasRole('super-admin'))
            <li>
                <a>
                    <i class="ri-folder-user-fill"></i>&nbsp;
                    {{__("Users")}}
                </a>
                <ul>
                    <li>
                        <a href="{{route('admin.user.all')}}">
                            {{--                           <i class="fa fa-list-alt"></i> --}}
                            {{__("Users list")}}
                        </a>
                    </li>
                    <li>
                        <a href="{{route('admin.user.create')}}">
                            {{--                            <i class="fa fa-plus-square"></i>--}}
                            {{__("New user")}}
                        </a>
                    </li>
                </ul>

            </li>
            @if(config('app.xlang'))
                <li>
                    <a>
                        <i class="ri-global-fill"></i>&nbsp;
                        {{__("Languages")}}
                    </a>
                    <ul>
                        <li>
                            <a href="{{route('admin.lang.index')}}">
                                {{--                           <i class="fa fa-list-alt"></i> --}}
                                {{__("Language list")}}
                            </a>
                        </li>
                        <li>
                            <a href="{{route('admin.lang.create')}}">
                                {{--                            <i class="fa fa-plus-square"></i>--}}
                                {{__("New language")}}
                            </a>
                        </li>
                        <li>
                            <a href="{{route('admin.lang.translate')}}">
                                {{--                            <i class="fa fa-plus-square"></i>--}}
                                {{__("Translates")}}
                            </a>
                        </li>
                    </ul>

                </li>
            @endif
        @endif

        @guest
            <li>
                <a href="{{ route('login') }}"> <i class="fa fas fa-sign-in"></i> {{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
                <li>
                    <a href="{{ route('register') }}"> <i class="fa fas fa-sign-in"></i> {{ __('Register') }}</a>
                </li>
            @endif
        @else
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    <i class="ri-logout-circle-r-fill"></i>&nbsp;
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                      style="display: none;">
                    @csrf
                </form>
            </li>
        @endguest

    </ul>

</nav>
