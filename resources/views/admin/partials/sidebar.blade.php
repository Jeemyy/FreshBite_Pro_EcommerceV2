      <aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
          <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
              <i class="fe fe-x"><span class="sr-only"></span></i>
          </a>
          <nav class="vertnav navbar navbar-light">
              <!-- nav bar -->
              <div class="w-100 mb-4 d-flex">
                  <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ route('admin.index') }}">
                      <svg version="1.1" id="logo" class="navbar-brand-img brand-sm"
                          xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                          viewBox="0 0 120 120" xml:space="preserve">
                          <g>
                              <polygon class="st0" points="78,105 15,105 24,87 87,87 	" />
                              <polygon class="st0" points="96,69 33,69 42,51 105,51 	" />
                              <polygon class="st0" points="78,33 15,33 24,15 87,15 	" />
                          </g>
                      </svg>
                  </a>
              </div>
              <ul class="navbar-nav flex-fill w-100 mb-2">

                  {{-- Dashboard --}}
                  <x-Sidebar link="{{ route('admin.index') }}" icon="fe-home fe-16" title="Dashboard"></x-Sidebar>

              </ul>
              <p class="text-muted nav-heading mb-1">
                  <small>MANAGEMENT</small>
              </p>
              <ul class="navbar-nav flex-fill w-100 mb-2">

                  {{-- Orders --}}
                  <x-Sidebar link="{{ route('admin.orders.index') }}" icon="fe-shopping-bag"
                      title="Orders"></x-Sidebar>

                  {{-- Products --}}
                  <x-Sidebar link="{{ route('admin.products.index') }}" icon="fe-shopping-cart"
                      title="Products"></x-Sidebar>

                  {{-- Categories --}}
                  <x-Sidebar link="{{ route('admin.categories.index') }}" icon="fe-box fe-16"
                      title="Categories"></x-Sidebar>

              </ul>
              <p class="text-muted nav-heading mb-1">
                  <small>PAYMENTS & DELIVERY</small>
              </p>
              <ul class="navbar-nav flex-fill w-100 mb-2">

                  {{-- Payments --}}
                  <x-Sidebar link="{{ route('admin.payments.index') }}" icon="fe-credit-card"
                      title="Payments"></x-Sidebar>

                  {{-- Invoices --}}
                  <x-Sidebar link="{{ route('admin.invoices.index') }}" icon="fe-file-text"
                      title="Invoices"></x-Sidebar>

                  {{-- Deliveries --}}
                  <x-Sidebar link="{{ route('admin.deliveries.index') }}" icon="fe-truck"
                      title="Deliveries"></x-Sidebar>

              </ul>
              <p class="text-muted nav-heading mb-1">
                  <small>CONTENT</small>
              </p>
              <ul class="navbar-nav flex-fill w-100 mb-2">

                  {{-- About --}}
                  <x-Sidebar link="{{ route('admin.abouts.index') }}" icon="fe-info"
                      title="About"></x-Sidebar>

                  {{-- Testimonials --}}
                  <x-Sidebar link="{{ route('admin.testimonials.index') }}" icon="fe-archive"
                      title="Testimonials"></x-Sidebar>

                  {{-- News --}}
                  <x-Sidebar link="{{ route('admin.news.index') }}" icon="fe-monitor"
                      title="News"></x-Sidebar>

                  {{-- Contact Us --}}
                  <x-Sidebar link="{{ route('admin.contacts.index') }}" icon="fe-mail"
                      title="Contact Us"></x-Sidebar>

              </ul>
              <p class="text-muted nav-heading mb-1">
                  <small>ADMINISTRATION</small>
              </p>
              <ul class="navbar-nav flex-fill w-100 mb-2">

                  {{-- Roles --}}
                  <x-Sidebar link="{{ route('admin.roles.index') }}" icon="fe-shield"
                      title="Roles & Permissions"></x-Sidebar>

                  {{-- Admins --}}
                  <x-Sidebar link="{{ route('admin.admins.index') }}" icon="fe-users"
                      title="Admin Users"></x-Sidebar>

                  {{-- Reports --}}
                  <x-Sidebar link="{{ route('admin.reports.index') }}" icon="fe-bar-chart-2"
                      title="Reports"></x-Sidebar>

                  {{-- Settings --}}
                  <x-Sidebar link="{{ route('admin.settings.index') }}" icon="fe-settings"
                      title="Settings"></x-Sidebar>

                  {{-- Sales --}}
                  <x-Sidebar link="{{ route('admin.sales.index') }}" icon="fe-paperclip"
                      title="Sales"></x-Sidebar>

              </ul>
          </nav>
      </aside>
