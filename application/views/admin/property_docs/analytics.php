<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Analytics'; ?> - Admin</title>
    <?php $this->load->view('admin/components/css_links'); ?>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .stat-box {
            background: linear-gradient(135deg, #1F509A 0%, #153a75 100%);
            color: white;
            border-radius: 15px;
            padding: 25px 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(31, 80, 154, 0.2);
            height: 100%;
        }
        .stat-box.success { background: linear-gradient(135deg, #198754 0%, #146c43 100%); box-shadow: 0 4px 15px rgba(25, 135, 84, 0.2); }
        .stat-box.warning { background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%); color: #333; box-shadow: 0 4px 15px rgba(255, 193, 7, 0.2); }
        .stat-box.danger { background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%); box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2); }
        .stat-box h2 { font-size: 36px; font-weight: 800; margin-bottom: 5px; }
        .stat-box p { font-size: 14px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0; opacity: 0.9; }
        .chart-container { position: relative; height: 350px; width: 100%; }
        .dashboard-card { background: white; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); }
    </style>
</head>
<body>
    <?php $this->load->view('admin/components/sidebar'); ?>
    <div class="admin-wrapper">
        <?php $this->load->view('admin/components/header'); ?>

        <div class="container-fluid py-4 px-4">
            

            <?php $this->load->view('admin/property_docs/tabs'); ?>

            <div class="row g-4 mb-5">
                <div class="col-md-3">
                    <div class="stat-box">
                        <h2><?= $analytics['total'] ?></h2>
                        <p><i class="fa-solid fa-folder-open me-2"></i> Total Documents</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-box warning">
                        <h2><?= $analytics['pending'] ?></h2>
                        <p><i class="fa-solid fa-clock me-2"></i> Pending Reviews</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-box danger">
                        <h2><?= $analytics['expired'] ?></h2>
                        <p><i class="fa-solid fa-calendar-times me-2"></i> Expired Docs</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-box success">
                        <h2>
                            <?php 
                                $success_rate = $analytics['total'] > 0 ? round(($analytics['approved'] / $analytics['total']) * 100) : 0;
                                echo $success_rate . '%';
                            ?>
                        </h2>
                        <p><i class="fa-solid fa-check-circle me-2"></i> Success Rate</p>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="dashboard-card card-body h-100">
                        <h5 class="fw-bold mb-4">Documents by Category</h5>
                        <div class="chart-container">
                            <canvas id="typeChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dashboard-card card-body h-100">
                        <h5 class="fw-bold mb-4">Monthly Upload Trends</h5>
                        <div class="chart-container">
                            <canvas id="trendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php $this->load->view('admin/components/footer'); ?>
    </div>

    <?php $this->load->view('admin/components/js_links'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Type Doughnut Chart
            <?php
            $labels = [];
            $data = [];
            $bgColors = "['#1F509A', '#198754', '#ffc107', '#dc3545', '#0dcaf0', '#6f42c1', '#d63384']";
            
            if (!empty($analytics['chart_types'])) {
                foreach($analytics['chart_types'] as $ct) {
                    $labels[] = $ct->DocumentTitle ? $ct->DocumentTitle : 'Unknown';
                    $data[] = $ct->Count;
                }
            } else {
                $labels[] = 'No Documents Yet';
                $data[] = 1;
                $bgColors = "['#e9ecef']"; // Grey color for no data
            }
            ?>
            var ctx = document.getElementById('typeChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: <?= json_encode($labels) ?>,
                    datasets: [{
                        label: 'Documents',
                        data: <?= json_encode($data) ?>,
                        backgroundColor: <?= $bgColors ?>,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });

            // Trend Bar Chart
            <?php
            $trendLabels = [];
            $trendData = [];
            if(!empty($analytics['trends'])) {
                foreach($analytics['trends'] as $t) {
                    $monthName = date('M Y', mktime(0, 0, 0, $t->Month, 1, $t->Year));
                    $trendLabels[] = $monthName;
                    $trendData[] = $t->Count;
                }
            } else {
                $trendLabels[] = date('M Y');
                $trendData[] = 0;
            }
            ?>
            var trendCtx = document.getElementById('trendChart').getContext('2d');
            new Chart(trendCtx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode($trendLabels) ?>,
                    datasets: [{
                        label: 'Uploaded Documents',
                        data: <?= json_encode($trendData) ?>,
                        backgroundColor: '#1F509A',
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } }
                    }
                }
            });
        });
    </script>
</body>
</html>
