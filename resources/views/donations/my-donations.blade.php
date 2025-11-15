<script>
    // Close modal when clicking outside of it
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('donation-modal');
        const editModal = document.getElementById('edit-donation-modal');
        const form = document.getElementById('donation-form');
        const editForm = document.getElementById('edit-donation-form');
        const currencySelect = document.getElementById('currency');
        const editCurrencySelect = document.getElementById('edit-currency');
        const currencySymbol = document.getElementById('currency-symbol');
        const editCurrencySymbol = document.getElementById('edit-currency-symbol');
        
        // Initialize charts if stats are available
        @if($stats->count() > 0)
        initializeCharts();
        @endif
        
        if (modal) {
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        }
        
        if (editModal) {
            editModal.addEventListener('click', function(event) {
                if (event.target === editModal) {
                    editModal.classList.add('hidden');
                }
            });
        }
        
        // Update currency symbol when currency changes
        if (currencySelect && currencySymbol) {
            currencySelect.addEventListener('change', function() {
                currencySymbol.textContent = this.value || 'Выберите валюту';
            });
        }
        
        if (editCurrencySelect && editCurrencySymbol) {
            editCurrencySelect.addEventListener('change', function() {
                editCurrencySymbol.textContent = this.value || 'Выберите валюту';
            });
        }
        
        // Handle form submission with AJAX
        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                // Clear previous errors
                clearErrors();
                
                const formData = new FormData(form);
                const submitButton = form.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;
                
                // Show loading state
                submitButton.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Создание...';
                submitButton.disabled = true;
                
                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (response.ok && result.success) {
                        // Success - close modal and reload page
                        modal.classList.add('hidden');
                        window.location.reload();
                    } else if (result.errors) {
                        // Validation errors
                        displayErrors(result.errors);
                    } else {
                        // Other errors
                        alert(result.message || 'Ошибка при создании доната');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Ошибка при создании доната');
                } finally {
                    // Restore button state
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                }
            });
        }
        
        // Handle edit form submission with AJAX
        if (editForm) {
            editForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                // Clear previous errors
                clearEditErrors();
                
                const formData = new FormData(editForm);
                const donationId = document.getElementById('edit-donation-id').value;
                const submitButton = editForm.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;
                
                // Show loading state
                submitButton.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Сохранение...';
                submitButton.disabled = true;
                
                try {
                    const response = await fetch(`/donations/${donationId}`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-HTTP-Method-Override': 'PUT'
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (response.ok && result.success) {
                        // Success - close modal and reload page
                        editModal.classList.add('hidden');
                        window.location.reload();
                    } else if (result.errors) {
                        // Validation errors
                        displayEditErrors(result.errors);
                    } else {
                        // Other errors
                        alert(result.message || 'Ошибка при обновлении доната');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Ошибка при обновлении доната');
                } finally {
                    // Restore button state
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                }
            });
        }
    });
    
    // Clear form errors
    function clearErrors() {
        document.getElementById('currency-error').classList.add('hidden');
        document.getElementById('amount-error').classList.add('hidden');
        document.getElementById('description-error').classList.add('hidden');
    }
    
    // Display form errors
    function displayErrors(errors) {
        if (errors.currency) {
            document.getElementById('currency-error').textContent = errors.currency[0];
            document.getElementById('currency-error').classList.remove('hidden');
        }
        if (errors.amount) {
            document.getElementById('amount-error').textContent = errors.amount[0];
            document.getElementById('amount-error').classList.remove('hidden');
        }
        if (errors.description) {
            document.getElementById('description-error').textContent = errors.description[0];
            document.getElementById('description-error').classList.remove('hidden');
        }
    }
    
    // Clear edit form errors
    function clearEditErrors() {
        document.getElementById('edit-currency-error').classList.add('hidden');
        document.getElementById('edit-amount-error').classList.add('hidden');
        document.getElementById('edit-description-error').classList.add('hidden');
    }
    
    // Display edit form errors
    function displayEditErrors(errors) {
        if (errors.currency) {
            document.getElementById('edit-currency-error').textContent = errors.currency[0];
            document.getElementById('edit-currency-error').classList.remove('hidden');
        }
        if (errors.amount) {
            document.getElementById('edit-amount-error').textContent = errors.amount[0];
            document.getElementById('edit-amount-error').classList.remove('hidden');
        }
        if (errors.description) {
            document.getElementById('edit-description-error').textContent = errors.description[0];
            document.getElementById('edit-description-error').classList.remove('hidden');
        }
    }
    
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
    
    // Open edit modal with donation data
    function openEditModal(id, currency, amount, description) {
        document.getElementById('edit-donation-id').value = id;
        document.getElementById('edit-currency').value = currency;
        document.getElementById('edit-amount').value = amount;
        document.getElementById('edit-description').value = description || '';
        document.getElementById('edit-currency-symbol').textContent = currency || 'Выберите валюту';
        document.getElementById('edit-donation-modal').classList.remove('hidden');
    }
    
    // Delete donation
    function deleteDonation(id) {
        if (confirm('Вы уверены, что хотите удалить этот донат?')) {
            fetch(`/donations/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'Ошибка при удалении доната');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ошибка при удалении доната');
            });
        }
    }
</script>
@endsection