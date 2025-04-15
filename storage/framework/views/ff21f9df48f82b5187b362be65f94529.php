

<?php $__env->startSection('title', 'Dashboard - Pengguna'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto mt-24 px-4">
    <h1 class="text-3xl font-bold text-orange-600">Selamat datang, <?php echo e(Auth::user()->Nama_Pengguna); ?>!</h1>
    <p class="mt-4 text-gray-700">Ini adalah dashboard khusus untuk pengguna.</p>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ahmad\Documents\Project\FoodSaver-SI4609-Kelompok3\resources\views/dashboard-user.blade.php ENDPATH**/ ?>