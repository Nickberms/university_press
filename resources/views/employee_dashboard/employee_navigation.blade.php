<div class="sidebar">
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('profile.show') }}" class="nav-link">
                    <i class="nav-icon fas fa-user-circle"></i>
                    <p>&nbsp;&nbsp;My Profile</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('dashboards.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p>&nbsp;&nbsp;Dashboard</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-clipboard-check"></i>
                    <p>&nbsp;&nbsp;Inventory Records
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    <li class="nav-item">
                        <a href="{{ route('batches.index') }}" class="nav-link">
                            <i class="fas fa-copy"></i>
                            <p>&nbsp;&nbsp;Manage Batches</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('ims.index') }}" class="nav-link">
                            <i class="fas fa-book"></i>
                            <p>&nbsp;&nbsp;Manage Masterlist</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('authors.index') }}" class="nav-link">
                            <i class="fas fa-pen-nib"></i>
                            <p>&nbsp;&nbsp;Manage Authors</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('categories.index') }}" class="nav-link">
                            <i class="fas fa-table"></i>
                            <p>&nbsp;&nbsp;Manage Categories</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('adjustment_logs.index') }}" class="nav-link">
                            <i class="fas fa-minus-circle"></i>
                            <p>&nbsp;&nbsp;Adjustment Logs</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-shopping-cart"></i>
                    <p>&nbsp;&nbsp;Sales Management
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: none;">
                    <li class="nav-item">
                        <a href="{{ route('purchases.index') }}" class="nav-link">
                            <i class="fas fa-tag"></i>
                            <p>&nbsp;&nbsp;Point of Sale</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('monitorings.index') }}" class="nav-link">
                            <i class="far fa-calendar-alt"></i>
                            <p>&nbsp;&nbsp;Daily Monitoring</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reports.index') }}" class="nav-link">
                            <i class="fas fa-chart-pie"></i>
                            <p>&nbsp;&nbsp;Generate Reports</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sales.index') }}" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <p>&nbsp;&nbsp;Top Sales</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>