  <!-- Page Body Start-->
  <div class="page-body-wrapper">

      <!-- Page Sidebar Start-->
      <div class="page-sidebar">
          <div class="main-header-left d-none d-lg-block" style="background-color: #3d3c3cfc;">
              <div class="logo-wrapper">
                  <a href="{{ route('super_admin.dashboard') }}">
                      <img class="d-none d-lg-block blur-up lazyloaded" style="width: 120px"
                          src="{{ asset('front_end_style/assets/images/logo.png') }}" alt="">
                  </a>
              </div>
          </div>
          <div class="sidebar custom-scrollbar">
              <a href="javascript:void(0)" class="sidebar-back d-lg-none d-block"><i class="fa fa-times"
                      aria-hidden="true"></i></a>
              <div class="sidebar-user">
                  <img class="img-40"
                      src="{{ asset(auth()->user()->profile_photo_path ?? 'dashboard_files/assets/images/dashboard/user3.jpg') }}"
                      alt="#">
                  <div>
                      <h6 class="f-14"> {{ isset(auth()->user()->name_en) ? auth()->user()->name_en : 'Undefined' }}
                      </h6>
                      <p>{{ isset(auth()->user()->email) ? auth()->user()->email : 'Undefined' }}</p>
                  </div>
              </div>
              <ul class="sidebar-menu">
                  <li>
                      <a class="sidebar-header" href="{{ route('super_admin.dashboard') }}">
                          <i data-feather="home"></i>
                          <span>Dashboard</span>
                      </a>
                  </li>


                  <li>
                      <a class="sidebar-header" href="javascript:void(0)">
                          <i data-feather="box"></i>
                          <span>pages</span>
                          <i class="fa fa-angle-right pull-right"></i>
                      </a>

                      <ul class="sidebar-submenu">
                          <li>
                              <a href="{{ route('super_admin.about_us-index') }}">
                                  <i class="fa fa-circle"></i>
                                  <span>About Us</span>
                              </a>
                          </li>
                          <li>
                              <a href="{{ route('super_admin.contact_us-index') }}">
                                  <i class="fa fa-circle"></i>
                                  <span>Contact Us</span>
                              </a>
                          </li>
                          <li>
                              <a href="{{ route('super_admin.contact_us-requests') }}">
                                  <i class="fa fa-circle"></i>
                                  <span>Contact Messages</span>
                              </a>
                          </li>
                          <li>
                              <a href="{{ route('super_admin.blogs-index') }}">
                                  <i class="fa fa-circle"></i>
                                  <span>Blogs</span>
                              </a>
                          </li>
                          <li>
                              <a href="{{ route('super_admin.sliders-index') }}">
                                  <i class="fa fa-circle"></i>
                                  <span>Sliders</span>
                              </a>
                          </li>
                          {{-- <li>
                              <a href="{{ route('super_admin.faqs-index') }}">
                                  <i class="fa fa-circle"></i>
                                  <span>FAQ</span>
                              </a>
                          </li> --}}
                          {{-- <li>
                              <a href="{{ route('super_admin.term_and_conditions-index') }}">
                                  <i class="fa fa-circle"></i>
                                  <span>Term & Conditions</span>
                              </a>
                          </li> --}}
                          {{-- <li>
                              <a href="{{ route('super_admin.privacy_policies-index') }}">
                                  <i class="fa fa-circle"></i>
                                  <span>Privacy Policy</span>
                              </a>
                          </li> --}}
                          {{-- <li>
                              <a href="{{ route('super_admin.banners-index') }}">
                                  <i class="fa fa-circle"></i>
                                  <span>Banners</span>
                              </a>
                          </li> --}}



                      </ul>
                  </li>

                  <li>
                      <a class="sidebar-header" href="javascript:void(0)">
                          <i data-feather="box"></i>
                          <span>Shop</span>
                          <i class="fa fa-angle-right pull-right"></i>
                      </a>

                      <ul class="sidebar-submenu">
                          <li>
                              <a href="{{ route('super_admin.mainCategories-index') }}">
                                  <i class="fa fa-circle"></i>
                                  <span>Main Categories</span>
                              </a>
                          </li>
                          <li>
                              <a href="{{ route('super_admin.subCategories-index') }}">
                                  <i class="fa fa-circle"></i>
                                  <span>Sub Categories</span>
                              </a>
                          </li>
                          <li>
                              <a href="{{ route('super_admin.products-index') }}">
                                  <i class="fa fa-circle"></i>
                                  <span>Products</span>
                              </a>
                          </li>
                          <li>
                              <a href="{{ route('super_admin.orders-index') }}">
                                  <i class="fa fa-circle"></i>
                                  <span>Orders</span>
                              </a>
                          </li>
                          <li>
                              <a href="{{ route('super_admin.brands-index') }}">
                                  <i class="fa fa-circle"></i>
                                  <span>Brands</span>
                              </a>
                          </li>
                          @if (isset($public_color_values_proparty) && $public_color_values_proparty->count() > 0)
                              @foreach ($public_color_values_proparty as $key => $public_color)
                                  @if ($public_color->values == 1)
                                      <li>
                                          <a href="{{ route('super_admin.colors-index') }}">
                                              <i class="fa fa-circle"></i>
                                              <span>Colors</span>
                                          </a>
                                      </li>
                                  @else
                                  @endif
                              @endforeach
                          @endif
                          @if (isset($public_size_values_proparty) && $public_size_values_proparty->count() > 0)
                              @foreach ($public_size_values_proparty as $key => $public_size)
                                  @if ($public_size->values == 1)
                                      <li>
                                          <a href="{{ route('super_admin.sizes-index') }}">
                                              <i class="fa fa-circle"></i>
                                              <span>Sizes</span>
                                          </a>
                                      </li>
                                  @else
                                  @endif
                              @endforeach
                          @endif

                          <li>
                              <a href="{{ route('super_admin.reviews-index') }}">
                                  <i class="fa fa-circle"></i>
                                  <span>Products Rating</span>
                              </a>
                          </li>
                      </ul>
                  </li>

                  <li>
                      <a class="sidebar-header" href="javascript:void(0)">
                          <i data-feather="box"></i>
                          <span>Users</span>
                          <i class="fa fa-angle-right pull-right"></i>
                      </a>

                      <ul class="sidebar-submenu">
                          <li>
                              <a href="{{ route('super_admin.users-index') }}">
                                  <i class="fa fa-circle"></i>
                                  <span> All Users</span>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li>
                      <a class="sidebar-header" href="javascript:void(0)">
                          <i data-feather="box"></i>
                          <span>Wallets</span>
                          <i class="fa fa-angle-right pull-right"></i>
                      </a>
                      <ul class="sidebar-submenu">
                          <li>
                              <a href="{{ route('super_admin.payment_wallets.index') }}">
                                  <i class="fa fa-circle"></i>
                                  <span> Payment wallets</span>
                              </a>
                          </li>
                          <li>
                              <a href="{{ route('super_admin.wallet-index') }}">
                                  <i class="fa fa-circle"></i>
                                  <span> Customers Wallets</span>
                              </a>
                          </li>
                          <li>
                              <a href="{{ route('super_admin.wallet_orders.index') }}">
                                  <i class="fa fa-circle"></i>
                                  <span> Wallet Withdrawals</span>
                              </a>
                          </li>
                          <li>
                              <a href="{{ route('super_admin.western_orders.index') }}">
                                  <i class="fa fa-circle"></i>
                                  <span> Western Withdrawals</span>
                              </a>
                          </li>
                      </ul>
                  </li>

                  {{-- <li>
                      <a class="sidebar-header" href="javascript:void(0)">
                          <i data-feather="box"></i>
                          <span>Promo Codes</span>
                          <i class="fa fa-angle-right pull-right"></i>
                      </a>

                      <ul class="sidebar-submenu">
                          <li>
                              <a href="{{ route('super_admin.promo_codes-index') }}">
                                  <i class="fa fa-circle"></i>
                                  <span>Promo Codes</span>
                              </a>
                          </li>
                      </ul>
                  </li> --}}

                  <li>
                      <a class="sidebar-header" href="javascript:void(0)">
                          <i data-feather="settings"></i>
                          <span>Settings</span>
                          <i class="fa fa-angle-right pull-right"></i>
                      </a>

                      <ul class="sidebar-submenu">
                          <li>
                              <a href="{{ route('super_admin.public_values-index') }}">
                                  <i class="fa fa-circle"></i>
                                  <span> Public Values</span>
                              </a>
                          </li>

                          <li>
                              <a href="{{ route('super_admin.countries.index') }}">
                                  <i class="fa fa-circle"></i>
                                  <span> Countries</span>
                              </a>
                          </li>

                      </ul>
                  </li>
                  <li>
                      <a class="sidebar-header" href="{{ route('super_admin.support_tickets-index') }}">
                          <i data-feather="home"></i>
                          <span>Support Tickets</span>
                      </a>
                  </li>


                  <li>
                      <a class="sidebar-header" href="{{ route('logout') }}"
                          onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                          <i data-feather="log-in"></i>
                          <span>Logout</span>
                      </a>
                  </li>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
              </ul>
          </div>
      </div>
      <!-- Page Sidebar Ends-->

      <!-- Right sidebar Start-->
      <div class="right-sidebar" id="right_side_bar">
          <div>
              <div class="container p-0">
                  <div class="modal-header p-l-20 p-r-20">
                      <div class="p-0 col-sm-8">
                          <h6 class="modal-title font-weight-bold">FRIEND LIST</h6>
                      </div>
                      <div class="p-0 col-sm-4 text-end">
                          <i class="me-2" data-feather="settings"></i>
                      </div>
                  </div>
              </div>
              <div class="mt-0 friend-list-search">
                  <input type="text" placeholder="search friend">
                  <i class="fa fa-search"></i>
              </div>
              <div class="p-l-30 p-r-30 friend-list-name">
                  <div class="chat-box">
                      <div class="people-list friend-list">
                          <ul class="list">
                              <li class="clearfix">
                                  <img class="rounded-circle user-image blur-up lazyloaded"
                                      src="assets/images/dashboard/user.jpg" alt="">
                                  <div class="status-circle online"></div>
                                  <div class="about">
                                      <div class="name">Vincent Porter</div>
                                      <div class="status">Online</div>
                                  </div>
                              </li>
                              <li class="clearfix">
                                  <img class="rounded-circle user-image blur-up lazyloaded"
                                      src="assets/images/dashboard/user1.jpg" alt="">
                                  <div class="status-circle away"></div>
                                  <div class="about">
                                      <div class="name">Ain Chavez</div>
                                      <div class="status">28 minutes ago</div>
                                  </div>
                              </li>
                              <li class="clearfix">
                                  <img class="rounded-circle user-image blur-up lazyloaded"
                                      src="assets/images/dashboard/user2.jpg" alt="">
                                  <div class="status-circle online"></div>
                                  <div class="about">
                                      <div class="name">Kori Thomas</div>
                                      <div class="status">Online</div>
                                  </div>
                              </li>
                              <li class="clearfix">
                                  <img class="rounded-circle user-image blur-up lazyloaded"
                                      src="assets/images/dashboard/user3.jpg" alt="">
                                  <div class="status-circle online"></div>
                                  <div class="about">
                                      <div class="name">Erica Hughes</div>
                                      <div class="status">Online</div>
                                  </div>
                              </li>
                              <li class="clearfix">
                                  <img class="rounded-circle user-image blur-up lazyloaded"
                                      src="assets/images/dashboard/user3.jpg" alt="">
                                  <div class="status-circle offline"></div>
                                  <div class="about">
                                      <div class="name">Ginger Johnston</div>
                                      <div class="status">2 minutes ago</div>
                                  </div>
                              </li>
                              <li class="clearfix">
                                  <img class="rounded-circle user-image blur-up lazyloaded"
                                      src="assets/images/dashboard/user5.jpg" alt="">
                                  <div class="status-circle away"></div>
                                  <div class="about">
                                      <div class="name">Prasanth Anand</div>
                                      <div class="status">2 hour ago</div>
                                  </div>
                              </li>
                              <li class="clearfix">
                                  <img class="rounded-circle user-image blur-up lazyloaded"
                                      src="assets/images/dashboard/designer.jpg" alt="">
                                  <div class="status-circle online"></div>
                                  <div class="about">
                                      <div class="name">Hileri Jecno</div>
                                      <div class="status">Online</div>
                                  </div>
                              </li>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- Right sidebar Ends-->
