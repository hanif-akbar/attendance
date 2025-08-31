<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Page navigation">
    <ul class="pagination pagination-modern justify-content-center mb-0">
        <?php if ($pager->hasPrevious()) : ?>
            <li class="page-item">
                <a href="<?= $pager->getFirst() ?>" aria-label="Halaman Pertama" class="page-link page-link-first">
                    <i class="bi bi-chevron-double-left"></i>
                    <span class="d-none d-sm-inline ms-1">Pertama</span>
                </a>
            </li>
            <li class="page-item">
                <a href="<?= $pager->getPrevious() ?>" aria-label="Halaman Sebelumnya" class="page-link">
                    <i class="bi bi-chevron-left"></i>
                    <span class="d-none d-sm-inline ms-1">Sebelumnya</span>
                </a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a href="<?= $link['uri'] ?>" class="page-link">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li class="page-item">
                <a href="<?= $pager->getNext() ?>" aria-label="Halaman Selanjutnya" class="page-link">
                    <span class="d-none d-sm-inline me-1">Selanjutnya</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
            <li class="page-item">
                <a href="<?= $pager->getLast() ?>" aria-label="Halaman Terakhir" class="page-link page-link-last">
                    <span class="d-none d-sm-inline me-1">Terakhir</span>
                    <i class="bi bi-chevron-double-right"></i>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>

<style>
.pagination-modern {
    --bs-pagination-padding-x: 0.75rem;
    --bs-pagination-padding-y: 0.5rem;
    --bs-pagination-font-size: 0.875rem;
    --bs-pagination-color: #6c757d;
    --bs-pagination-bg: #fff;
    --bs-pagination-border-width: 1px;
    --bs-pagination-border-color: #dee2e6;
    --bs-pagination-border-radius: 0.5rem;
    --bs-pagination-hover-color: #0056b3;
    --bs-pagination-hover-bg: #e9ecef;
    --bs-pagination-hover-border-color: #dee2e6;
    --bs-pagination-focus-color: #0056b3;
    --bs-pagination-focus-bg: #e9ecef;
    --bs-pagination-focus-box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    --bs-pagination-active-color: #fff;
    --bs-pagination-active-bg: #0d6efd;
    --bs-pagination-active-border-color: #0d6efd;
    --bs-pagination-disabled-color: #6c757d;
    --bs-pagination-disabled-bg: #fff;
    --bs-pagination-disabled-border-color: #dee2e6;
}

.pagination-modern .page-link {
    margin: 0 2px;
    border-radius: var(--bs-pagination-border-radius) !important;
    transition: all 0.2s ease-in-out;
    font-weight: 500;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.pagination-modern .page-link:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: transparent;
    color: white;
}

.pagination-modern .page-item.active .page-link {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: transparent;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    transform: translateY(-1px);
}

.pagination-modern .page-link-first,
.pagination-modern .page-link-last {
    font-weight: 600;
}

.pagination-modern .page-item.disabled .page-link {
    opacity: 0.5;
    cursor: not-allowed;
}

@media (max-width: 576px) {
    .pagination-modern {
        --bs-pagination-padding-x: 0.5rem;
        --bs-pagination-padding-y: 0.375rem;
        --bs-pagination-font-size: 0.75rem;
    }
    
    .pagination-modern .page-link {
        margin: 0 1px;
    }
}
</style>
