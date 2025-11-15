<?php $__env->startSection('header'); ?>
    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        Мои донаты
    </h2>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 shadow-sm sticky top-16 z-40">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-5">
                <h1 class="text-3xl font-bold text-gray-900">Мои донаты</h1>
                <div class="grid grid-cols-3 gap-5 text-base">
                    <?php
                        $totalDonations = $stats->sum('count');
                        $totalAmount = $stats->sum('total');
                        $currenciesCount = $stats->count();
                    ?>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900"><?php echo e($totalDonations); ?></div>
                        <div class="text-gray-500">Всего</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-indigo-600"><?php echo e($currenciesCount); ?></div>
                        <div class="text-gray-500">Валюты</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600"><?php echo e(number_format($totalAmount, 2, '.', ' ')); ?></div>
                        <div class="text-gray-500">Сумма</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Add Donation Button -->
        <div class="mb-10">
            <button onclick="document.getElementById('donation-modal').classList.remove('hidden')" 
                    class="w-full sm:w-auto bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Создать донат
            </button>
        </div>

        <!-- Stats Overview -->
        <?php if($stats->count() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyStats): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-bold text-white"><?php echo e($currencyStats->currency); ?></h3>
                            <div class="bg-white bg-opacity-20 rounded-full p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Кол-во</p>
                                <p class="text-xl font-bold"><?php echo e($currencyStats->count); ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Сумма</p>
                                <p class="text-xl font-bold"><?php echo e(number_format($currencyStats->total, 2, '.', ' ')); ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Среднее</p>
                                <p class="text-xl font-bold"><?php echo e(number_format($currencyStats->average, 2, '.', ' ')); ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Макс.</p>
                                <p class="text-xl font-bold"><?php echo e(number_format($currencyStats->max, 2, '.', ' ')); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-10">
                <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['title' => 'Нет донатов','description' => 'Начните с создания своего первого доната!','icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>','actionText' => 'Создать донат','actionUrl' => '#','actionOnclick' => 'document.getElementById(\'donation-modal\').classList.remove(\'hidden\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Нет донатов','description' => 'Начните с создания своего первого доната!','icon' => '<svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>','action-text' => 'Создать донат','action-url' => '#','action-onclick' => 'document.getElementById(\'donation-modal\').classList.remove(\'hidden\')']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Recent Donations -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Последние донаты</h2>
            </div>
            <?php if($recentDonations->count() > 0): ?>
                <div class="divide-y divide-gray-100">
                    <?php $__currentLoopData = $recentDonations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="p-6 hover:bg-gray-50 transition">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <div class="bg-indigo-100 rounded-full p-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-semibold text-lg"><?php echo e($donation->formatted_amount); ?></span>
                                        <span class="bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                            <?php echo e($donation->currency); ?>

                                        </span>
                                    </div>
                                    <?php if($donation->description): ?>
                                        <p class="text-gray-600 mt-1"><?php echo e(Str::limit($donation->description, 60)); ?></p>
                                    <?php endif; ?>
                                    <p class="text-gray-500 text-sm mt-1"><?php echo e($donation->created_at->format('d.m.Y H:i')); ?></p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                    Завершён
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="p-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Нет донатов</h3>
                    <p class="mt-1 text-gray-500">У вас пока нет донатов для отображения.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Donation Form Modal -->
<div id="donation-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md transform transition-all">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-900">Новый донат</h2>
                <button onclick="document.getElementById('donation-modal').classList.add('hidden')" 
                        class="text-gray-500 hover:text-gray-700 rounded-full p-1 hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form action="<?php echo e(route('donations.store')); ?>" method="POST" id="donation-form">
                <?php echo csrf_field(); ?>
                <div class="mb-5">
                    <label for="currency" class="block text-sm font-medium text-gray-700 mb-2">Валюта</label>
                    <select name="currency" id="currency" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3">
                        <option value="USD">USD - Доллар США</option>
                        <option value="EUR">EUR - Евро</option>
                        <option value="BTC">BTC - Биткойн</option>
                        <option value="ETH">ETH - Эфириум</option>
                        <option value="RUB">RUB - Российский рубль</option>
                        <option value="UAH">UAH - Украинская гривна</option>
                    </select>
                </div>
                
                <div class="mb-5">
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Сумма</label>
                    <div class="relative">
                        <input type="number" step="0.01" name="amount" id="amount" 
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 pl-4"
                               placeholder="0.00" required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <span class="text-gray-500 sm:text-sm" id="currency-symbol">USD</span>
                        </div>
                    </div>
                </div>
                
                <div class="mb-5">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Описание (опционально)</label>
                    <textarea name="description" id="description" rows="3" 
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3"
                              placeholder="Описание доната..."></textarea>
                </div>
                
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('donation-modal').classList.add('hidden')"
                            class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                        Отмена
                    </button>
                    <button type="submit" 
                            class="px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Создать донат
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Close modal when clicking outside of it
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('donation-modal');
        const form = document.getElementById('donation-form');
        const currencySelect = document.getElementById('currency');
        const currencySymbol = document.getElementById('currency-symbol');
        
        if (modal) {
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        }
        
        // Update currency symbol when currency changes
        if (currencySelect && currencySymbol) {
            currencySelect.addEventListener('change', function() {
                currencySymbol.textContent = this.value;
            });
        }
        
        // Handle form submission with AJAX
        if (form) {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
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
                    
                    if (response.ok) {
                        const result = await response.json();
                        if (result.success) {
                            // Success - close modal and reload page
                            modal.classList.add('hidden');
                            window.location.reload();
                        } else {
                            alert(result.message || 'Ошибка при создании доната');
                        }
                    } else {
                        const error = await response.json();
                        alert(error.message || 'Ошибка при создании доната');
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
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\maksi\OneDrive\Documents\GitHub\todo-app\resources\views/donations/my-donations.blade.php ENDPATH**/ ?>