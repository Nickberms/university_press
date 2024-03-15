<div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
            <a href="{{ route('profile.show') }}" class="d-block">{{ Auth::user()->name }}</a>
        </div>
    </div>
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('dashboard.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        {{ __('Dashboard') }}
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-file"></i>
                    <p>
                        IMs
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    <li class="nav-item">
                        <a href="{{ route('batches.index') }}" class="nav-link">
                            <i class="fas fa-copy"></i>
                            <p>Batches</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('instructional_materials.index') }}" class="nav-link">
                            <i class="fas fa-book"></i>
                            <p>Masterlist</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('authors.index') }}" class="nav-link">
                            <i class="fas fa-users"></i>
                            <p>Authors</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('categories.index') }}" class="nav-link">
                            <i class="fas fa-table"></i>
                            <p>Categories</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-shopping-cart"></i>
                    <p>
                        Sales Management
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    <li class="nav-item">
                        <a href="{{ route('purchases.index') }}" class="nav-link">
                            <i class="fas fa-tag"></i>
                            <p>New Purchase</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="daily_monitoring" class="nav-link">
                            <i class="far fa-calendar-alt"></i>
                            <p> Daily Monitoring</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reports.index') }}" class="nav-link">
                            <i class="fas fa-chart-pie mr-1"></i>
                            <p>Sales Reports</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>