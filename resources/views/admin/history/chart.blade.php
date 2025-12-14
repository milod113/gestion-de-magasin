@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 p-6">
        <!-- Chart Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Historique des Prix et Quantités</h2>
                <p class="text-gray-600 dark:text-gray-300 mt-1">Évolution des données sur la période sélectionnée</p>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-2">
                <button id="toggleChartType" class="px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-md text-gray-700 dark:text-gray-300 text-sm hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                    Changer le type
                </button>
                <button id="exportChart" class="px-3 py-1 bg-blue-100 dark:bg-blue-900 rounded-md text-blue-700 dark:text-blue-300 text-sm hover:bg-blue-200 dark:hover:bg-blue-800 transition">
                    Exporter
                </button>
            </div>
        </div>

        <!-- Chart Container -->
        <div class="relative h-96 w-full">
            <canvas id="historyChart"></canvas>
        </div>

        <!-- Chart Legend -->
        <div class="mt-4 flex flex-wrap justify-center gap-4">
            <div class="flex items-center">
                <div class="w-4 h-4 bg-blue-500 rounded-full mr-2"></div>
                <span class="text-sm text-gray-700 dark:text-gray-300">Quantité</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-red-500 rounded-full mr-2"></div>
                <span class="text-sm text-gray-700 dark:text-gray-300">Prix</span>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('historyChart').getContext('2d');
        
        // Detect dark mode
        const darkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        // Chart colors
        const colors = {
            quantity: {
                light: 'rgba(54, 162, 235, 0.8)',
                dark: 'rgba(100, 200, 255, 0.8)'
            },
            price: {
                light: 'rgba(255, 99, 132, 0.8)',
                dark: 'rgba(255, 150, 180, 0.8)'
            },
            grid: {
                light: 'rgba(0, 0, 0, 0.1)',
                dark: 'rgba(255, 255, 255, 0.1)'
            },
            text: {
                light: '#666',
                dark: '#EEE'
            }
        };

        // Chart data
        const chartData = {
            labels: {!! json_encode($labels) !!},
            datasets: [
                {
                    label: 'Quantité',
                    data: {!! json_encode($quantites) !!},
                    backgroundColor: darkMode ? colors.quantity.dark : colors.quantity.light,
                    borderColor: darkMode ? colors.quantity.dark : colors.quantity.light,
                    borderWidth: 1,
                    yAxisID: 'y'
                },
                {
                    label: 'Prix',
                    data: {!! json_encode($prix) !!},
                    backgroundColor: darkMode ? colors.price.dark : colors.price.light,
                    borderColor: darkMode ? colors.price.dark : colors.price.light,
                    borderWidth: 1,
                    yAxisID: 'y1',
                    type: 'line',
                    tension: 0.3,
                    fill: false,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }
            ]
        };

        // Chart options
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    backgroundColor: darkMode ? 'rgba(30, 41, 59, 0.9)' : 'rgba(255, 255, 255, 0.9)',
                    titleColor: darkMode ? '#FFF' : '#333',
                    bodyColor: darkMode ? '#FFF' : '#333',
                    borderColor: darkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)',
                    borderWidth: 1,
                    padding: 12,
                    usePointStyle: true,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                if (context.dataset.label === 'Prix') {
                                    label += new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'DZD' }).format(context.parsed.y);
                                } else {
                                    label += context.parsed.y;
                                }
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        color: colors.grid[darkMode ? 'dark' : 'light'],
                        drawBorder: false
                    },
                    ticks: {
                        color: colors.text[darkMode ? 'dark' : 'light']
                    }
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Quantité',
                        color: colors.text[darkMode ? 'dark' : 'light']
                    },
                    grid: {
                        color: colors.grid[darkMode ? 'dark' : 'light'],
                        drawBorder: false
                    },
                    ticks: {
                        color: colors.text[darkMode ? 'dark' : 'light'],
                        callback: function(value) {
                            return Number(value).toLocaleString();
                        }
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Prix',
                        color: colors.text[darkMode ? 'dark' : 'light']
                    },
                    grid: {
                        drawOnChartArea: false,
                        drawBorder: false
                    },
                    ticks: {
                        color: colors.text[darkMode ? 'dark' : 'light'],
                        callback: function(value) {
                            return new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(value);
                        }
                    }
                }
            }
        };

        // Create chart
        let historyChart = new Chart(ctx, {
            type: 'bar',
            data: chartData,
            options: chartOptions
        });

        // Toggle chart type
        document.getElementById('toggleChartType').addEventListener('click', function() {
            const newType = historyChart.config.type === 'bar' ? 'line' : 'bar';
            historyChart.config.type = newType;
            
            // Adjust dataset types for combo chart
            historyChart.config.data.datasets.forEach(dataset => {
                if (dataset.label === 'Quantité') {
                    dataset.type = newType;
                }
            });
            
            historyChart.update();
            this.textContent = newType === 'bar' ? 'Voir en courbes' : 'Voir en barres';
        });

        // Export button
        document.getElementById('exportChart').addEventListener('click', function() {
            const link = document.createElement('a');
            link.download = 'historique-prix-quantite.png';
            link.href = document.getElementById('historyChart').toDataURL('image/png');
            link.click();
        });

        // Dark mode listener
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
            const darkMode = e.matches;
            
            // Update chart colors
            historyChart.data.datasets[0].backgroundColor = darkMode ? colors.quantity.dark : colors.quantity.light;
            historyChart.data.datasets[0].borderColor = darkMode ? colors.quantity.dark : colors.quantity.light;
            historyChart.data.datasets[1].backgroundColor = darkMode ? colors.price.dark : colors.price.light;
            historyChart.data.datasets[1].borderColor = darkMode ? colors.price.dark : colors.price.light;
            
            // Update options
            historyChart.options.scales.x.grid.color = colors.grid[darkMode ? 'dark' : 'light'];
            historyChart.options.scales.x.ticks.color = colors.text[darkMode ? 'dark' : 'light'];
            historyChart.options.scales.y.grid.color = colors.grid[darkMode ? 'dark' : 'light'];
            historyChart.options.scales.y.ticks.color = colors.text[darkMode ? 'dark' : 'light'];
            historyChart.options.scales.y.title.color = colors.text[darkMode ? 'dark' : 'light'];
            historyChart.options.scales.y1.ticks.color = colors.text[darkMode ? 'dark' : 'light'];
            historyChart.options.scales.y1.title.color = colors.text[darkMode ? 'dark' : 'light'];
            historyChart.options.plugins.tooltip.backgroundColor = darkMode ? 'rgba(30, 41, 59, 0.9)' : 'rgba(255, 255, 255, 0.9)';
            historyChart.options.plugins.tooltip.titleColor = darkMode ? '#FFF' : '#333';
            historyChart.options.plugins.tooltip.bodyColor = darkMode ? '#FFF' : '#333';
            
            historyChart.update();
        });
    });
</script>
@endsection