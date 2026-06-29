<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Admin Dashboard'; ?> - Free Real Estate</title>
    <?php $this->load->view('admin/components/css_links'); ?>
</head>
<body>

    <?php $this->load->view('admin/components/sidebar'); ?>

    <div class="admin-wrapper">
        <?php $this->load->view('admin/components/header'); ?>

        <div class="container-fluid py-4 px-4">


            <!-- Top Metric Cards -->
            <div class="row g-4 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="dashboard-card border-start border-primary border-4 h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted text-uppercase fw-bold mb-2">Total Properties</h6>
                                <h3 class="mb-0 fw-bold">1,245</h3>
                            </div>
                            <div class="icon-box bg-primary text-white">
                                <i class="fa-solid fa-building"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="dashboard-card border-start border-success border-4 h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted text-uppercase fw-bold mb-2">Active Properties</h6>
                                <h3 class="mb-0 fw-bold">980</h3>
                            </div>
                            <div class="icon-box bg-success text-white">
                                <i class="fa-solid fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="dashboard-card border-start border-warning border-4 h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted text-uppercase fw-bold mb-2">Pending Approval</h6>
                                <h3 class="mb-0 fw-bold">45</h3>
                            </div>
                            <div class="icon-box bg-warning text-white">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="dashboard-card border-start border-info border-4 h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted text-uppercase fw-bold mb-2">Total Users</h6>
                                <h3 class="mb-0 fw-bold">3,560</h3>
                            </div>
                            <div class="icon-box bg-info text-white">
                                <i class="fa-solid fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="dashboard-card border-start border-danger border-4 h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted text-uppercase fw-bold mb-2">Rejected Properties</h6>
                                <h3 class="mb-0 fw-bold">12</h3>
                            </div>
                            <div class="icon-box bg-danger text-white">
                                <i class="fa-solid fa-ban"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="dashboard-card border-start border-dark border-4 h-100">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted text-uppercase fw-bold mb-2">Featured Properties</h6>
                                <h3 class="mb-0 fw-bold">85</h3>
                            </div>
                            <div class="icon-box bg-dark text-white">
                                <i class="fa-solid fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-md-12">
                    <div class="dashboard-card border-start border-secondary border-4 h-100 bg-light">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted text-uppercase fw-bold mb-2">Total Revenue</h6>
                                <h2 class="mb-0 fw-bold text-success">$125,430.00</h2>
                            </div>
                            <div class="icon-box bg-secondary text-white" style="width: 70px; height: 70px; font-size: 30px;">
                                <i class="fa-solid fa-sack-dollar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row g-4 mb-4">
                <div class="col-lg-8">
                    <div class="dashboard-card h-100">
                        <div class="card-body">
                            <h5 class="fw-bold mb-4">Monthly Revenue Graph</h5>
                            <div style="position: relative; height:300px; width:100%">
                                <canvas id="revenueChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="dashboard-card h-100">
                        <div class="card-body">
                            <h5 class="fw-bold mb-4">Property Views Analytics</h5>
                            <div style="position: relative; height:300px; width:100%">
                                <canvas id="viewsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="row g-4">
                <div class="col-12">
                    <div class="dashboard-card">
                        <div class="card-body">
                            <h5 class="fw-bold mb-4">Recent Activities</h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>User</th>
                                            <th>Action</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>2026-06-08 10:30 AM</td>
                                            <td>John Doe</td>
                                            <td>Submitted new property "Luxury Villa"</td>
                                            <td><span class="badge bg-warning">Pending</span></td>
                                        </tr>
                                        <tr>
                                            <td>2026-06-08 09:15 AM</td>
                                            <td>Jane Smith</td>
                                            <td>Upgraded to Premium Agent</td>
                                            <td><span class="badge bg-success">Completed</span></td>
                                        </tr>
                                        <tr>
                                            <td>2026-06-07 04:45 PM</td>
                                            <td>Admin</td>
                                            <td>Approved property #1024</td>
                                            <td><span class="badge bg-primary">Actioned</span></td>
                                        </tr>
                                        <tr>
                                            <td>2026-06-07 02:20 PM</td>
                                            <td>Mark Lee</td>
                                            <td>Reported a review</td>
                                            <td><span class="badge bg-danger">Open Ticket</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php $this->load->view('admin/components/footer'); ?>
    </div>

    <?php $this->load->view('admin/components/js_links'); ?>

    <!-- Initialize Placeholder Charts -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Revenue Chart
            const ctxRev = document.getElementById('revenueChart').getContext('2d');
            new Chart(ctxRev, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Revenue ($)',
                        data: [12000, 19000, 15000, 22000, 30000, 27430],
                        borderColor: '#1F509A',
                        backgroundColor: 'rgba(31, 80, 154, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    }
                }
            });

            // Views Chart
            const ctxViews = document.getElementById('viewsChart').getContext('2d');
            new Chart(ctxViews, {
                type: 'doughnut',
                data: {
                    labels: ['Houses', 'Apartments', 'Commercial'],
                    datasets: [{
                        data: [55, 30, 15],
                        backgroundColor: ['#1F509A', '#198754', '#ffc107'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%'
                }
            });
        });
    </script>
</body>
</html>
