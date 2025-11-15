    // Initialize charts
    function initializeCharts() {
        // Prepare data
        const currencies = [@foreach($stats as $stat)'{{ $stat->currency }}',@endforeach];
        const counts = [@foreach($stats as $stat){{ $stat->count }},@endforeach];
        const totals = [@foreach($stats as $stat){{ $stat->total }},@endforeach];
        
        // Color palette
        const backgroundColors = [
            'rgba(79, 70, 229, 0.8)',
            'rgba(59, 130, 246, 0.8)',
            'rgba(16, 185, 129, 0.8)',
            'rgba(245, 158, 11, 0.8)',
            'rgba(239, 68, 68, 0.8)',
            'rgba(139, 92, 246, 0.8)'
        ];
        
        const borderColors = [
            'rgba(79, 70, 229, 1)',
            'rgba(59, 130, 246, 1)',
            'rgba(16, 185, 129, 1)',
            'rgba(245, 158, 11, 1)',
            'rgba(239, 68, 68, 1)',
            'rgba(139, 92, 246, 1)'
        ];
        
        // Donations by currency chart
        const donationsCtx = document.getElementById('donationsByCurrencyChart').getContext('2d');
        new Chart(donationsCtx, {
            type: 'bar',
            data: {
                labels: currencies,
                datasets: [{
                    label: 'Количество донатов',
                    data: counts,
                    backgroundColor: backgroundColors.slice(0, currencies.length),
                    borderColor: borderColors.slice(0, currencies.length),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
        
        // Amount by currency chart
        const amountCtx = document.getElementById('amountByCurrencyChart').getContext('2d');
        new Chart(amountCtx, {
            type: 'pie',
            data: {
                labels: currencies,
                datasets: [{
                    label: 'Сумма донатов',
                    data: totals,
                    backgroundColor: backgroundColors.slice(0, currencies.length),
                    borderColor: borderColors.slice(0, currencies.length),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }