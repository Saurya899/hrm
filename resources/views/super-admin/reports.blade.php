<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraHMS - Reports & Analytics</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- ApexCharts CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <!-- Page Loader -->
    <div class="page-loader" id="page-loader">
        <div class="loader-spinner"></div>
    </div>

    <!-- Toast Notifications Container -->
    <div class="toast-container-custom" id="toast-container"></div>

    <div class="app-container">

        <!-- SIDEBAR -->
        @include('super-admin.sidebar')

        <!-- MAIN WRAPPER -->
        <main class="main-wrapper">

            <!-- TOP NAVBAR -->
            @include('super-admin.header')

            <!-- CONTENT BODY -->
            <div class="content-body">

                <!-- BREADCRUMB & HEADER -->
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <div>
                        <nav>
                            <ul class="breadcrumb-custom mb-1">
                                <li class="breadcrumb-item-custom"><a href="/super-admin/dashboard">Home</a></li>
                                <li class="breadcrumb-item-custom">Reports</li>
                            </ul>
                        </nav>
                        <h4 class="fw-bold mb-0">Analytics & Enterprise Reports</h4>
                    </div>

                    <!-- EXPORTS BUTTON BAR -->
                    <div class="d-flex gap-2">
                        <button class="btn btn-premium btn-sm px-3"
                            onclick="showToast('Export Executed', 'PDF statement compiling.', 'success')"><i
                                class="bi bi-file-earmark-pdf"></i> Export PDF</button>
                        <button class="btn btn-premium-outline btn-sm px-3"
                            onclick="showToast('Excel Sheet Prepared', 'Downloading Ledger_Report_2026.csv', 'success')"><i
                                class="bi bi-file-earmark-spreadsheet"></i> Export Excel</button>
                    </div>
                </div>

                <!-- SKELETON LOADER -->
                <div class="skeleton-wrapper row g-4 mb-4">
                    <div class="col-md-8">
                        <div class="glass-card skeleton" style="height: 400px;"></div>
                    </div>
                    <div class="col-md-4">
                        <div class="glass-card skeleton" style="height: 400px;"></div>
                    </div>
                </div>

                <!-- REAL CONTENT WRAPPER -->
                <div class="real-content-wrapper d-none">

                    <div class="row g-4">
                        <!-- LEFT COLUMN: LARGE APPOINTMENTS CHART -->
                        <div class="col-xl-8">
                            <div class="glass-card">
                                <h5 class="mb-4">OPD Admission & Clinic Productivity Trends</h5>
                                <div id="activity-reports-chart"></div>
                            </div>
                        </div>

                        <!-- RIGHT COLUMN: DRUG INVENTORY & LOW STOCK LABELS -->
                        <div class="col-xl-4">
                            <div class="glass-card h-100">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="mb-0">Critical Stocks Alert</h5>
                                    <span class="badge bg-danger">Pharmacy</span>
                                </div>

                                <div class="d-flex flex-column gap-3">
                                    <!-- Med Item 1 -->
                                    <div class="p-3 border border-light border-opacity-10 rounded-4 glass-sub-card">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="fw-bold mb-1">Amoxicillin Capsule 500mg</h6>
                                                <span class="custom-badge badge-danger">Low Stock: 14 boxes left</span>
                                            </div>
                                            <span class="badge bg-white bg-opacity-10 text-white">#PH-201</span>
                                        </div>
                                        <div
                                            class="mt-2 pt-2 border-top border-light border-opacity-10 d-flex justify-content-between small text-muted">
                                            <span>Expiry Date:</span>
                                            <span class="fw-semibold text-warning">2026-10-15</span>
                                        </div>
                                    </div>

                                    <!-- Med Item 2 -->
                                    <div class="p-3 border border-light border-opacity-10 rounded-4 glass-sub-card">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="fw-bold mb-1">Ibuprofen Oral Tablets</h6>
                                                <span class="custom-badge badge-warning">Restock Warning: 22
                                                    boxes</span>
                                            </div>
                                            <span class="badge bg-white bg-opacity-10 text-white">#PH-482</span>
                                        </div>
                                        <div
                                            class="mt-2 pt-2 border-top border-light border-opacity-10 d-flex justify-content-between small text-muted">
                                            <span>Expiry Date:</span>
                                            <span class="fw-semibold text-success">2027-02-10</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </main>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- ApexCharts JS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- Custom Main JS -->
    <script src="{{ asset('js/script.js') }}"></script>

    <!-- Activity Report Chart Configuration -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                var optionsActivity = {
                    series: [{
                        name: 'Admitted Inpatients',
                        data: [31, 40, 28, 51, 42, 109, 100]
                    }, {
                        name: 'Discharged Outpatients',
                        data: [11, 32, 45, 32, 34, 52, 41]
                    }],
                    chart: {
                        height: 330,
                        type: 'area',
                        background: 'transparent',
                        toolbar: { show: false }
                    },
                    colors: ['#6366f1', '#06b6d4'],
                    theme: {
                        mode: document.documentElement.getAttribute('data-theme') || 'dark'
                    },
                    dataLabels: { enabled: false },
                    stroke: { curve: 'smooth', width: 2 },
                    xaxis: {
                        type: 'datetime',
                        categories: ["2026-06-24T00:00:00.000Z", "2026-06-25T01:30:00.000Z", "2026-06-26T02:30:00.000Z", "2026-06-27T03:30:00.000Z", "2026-06-28T04:30:00.000Z", "2026-06-29T05:30:00.000Z", "2026-06-30T06:30:00.000Z"],
                        labels: { style: { colors: '#94a3b8' } }
                    },
                    yaxis: {
                        labels: { style: { colors: '#94a3b8' } }
                    },
                    tooltip: { x: { format: 'dd/MM/yy HH:mm' } },
                    legend: { labels: { colors: '#94a3b8' } },
                    grid: { borderColor: 'rgba(255, 255, 255, 0.05)' }
                };

                var chartActivity = new ApexCharts(document.querySelector("#activity-reports-chart"), optionsActivity);
                chartActivity.render();

                const themeToggle = document.getElementById('theme-toggle');
                if (themeToggle) {
                    themeToggle.addEventListener('click', () => {
                        setTimeout(() => {
                            chartActivity.updateOptions({
                                theme: { mode: document.documentElement.getAttribute('data-theme') }
                            });
                        }, 50);
                    });
                }
            }, 1200);
        });
    </script>
</body>

</html>