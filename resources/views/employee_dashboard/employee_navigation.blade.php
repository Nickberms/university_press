<div class="sidebar">
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('profile.show') }}" class="nav-link">
                    <i class="nav-icon fas fa-user-circle"></i>
                    <p>
                        My Profile
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('dashboard.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-clipboard-check"></i>
                    <p>
                        Inventory Records
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
                        <a href="{{ route('masterlist.index') }}" class="nav-link">
                            <i class="fas fa-book"></i>
                            <p>Masterlist</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('authors.index') }}" class="nav-link">
                            <i class="fas fa-pen-nib"></i>
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
                            <p>Purchases</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('monitoring.index') }}" class="nav-link">
                            <i class="far fa-calendar-alt"></i>
                            <p>Monitoring</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reports.index') }}" class="nav-link">
                            <i class="fas fa-chart-pie mr-1"></i>
                            <p>Reports</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>