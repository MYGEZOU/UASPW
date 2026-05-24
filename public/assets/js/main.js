// =========================================================================
// CUSTOM MINIMALIST TOAST SYSTEM
// =========================================================================
function showMinimalToast(type, message) {
    const container = document.getElementById('custom-toast-container');
    if (!container) return;
    
    const toast = document.createElement('div');
    toast.className = `minimal-toast toast-${type}`;
    
    let iconClass = 'fa-info';
    if (type === 'success') iconClass = 'fa-check';
    if (type === 'error') iconClass = 'fa-exclamation';
    
    toast.innerHTML = `
        <div class="toast-icon"><i class="fas ${iconClass}"></i></div>
        <div class="toast-content">${message}</div>
        <div class="toast-progress"></div>
    `;
    
    container.appendChild(toast);
    
    // Trigger animation
    setTimeout(() => { toast.classList.add('show'); }, 10);
    
    // Remove after 4s
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => { toast.remove(); }, 500);
    }, 4000);
}

// =========================================================================
// DASHBOARD SIDEBAR TOGGLE
// =========================================================================
function toggleSidebar(){
    const sb = document.getElementById('sidebar');
    const mw = document.getElementById('mainWrapper');
    if(window.innerWidth <= 768){
        sb.classList.toggle('mobile-open');
    } else {
        sb.classList.toggle('collapsed');
        mw.classList.toggle('expanded');
    }
}

function toggleNav(id){
    const el = document.getElementById(id);
    el.classList.toggle('open');
}

// =========================================================================
// GLOBAL EVENT LISTENER FOR DASHBOARD ACTIONS
// =========================================================================
document.addEventListener('DOMContentLoaded', function() {
    // Auto-open active submenu
    document.querySelectorAll('.nav-item').forEach(function(item){
        if(item.querySelector('.nav-link.active')){
            item.classList.add('open');
        }
    });

    // Tabs
    document.querySelectorAll('.nav-tab').forEach(function(tab){
        tab.addEventListener('click',function(){
            const target=this.dataset.tab;
            document.querySelectorAll('.nav-tab').forEach(t=>t.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(p=>p.classList.remove('active'));
            this.classList.add('active');
            const pane=document.getElementById(target);
            if(pane) pane.classList.add('active');
        });
    });
});

// =========================================================================
// SWEETALERT CONFIRMATION OVERRIDE
// =========================================================================
function handleConfirm(e) {
    let target = null;
    
    // Check if it's a click on an element with onclick="return confirm..."
    if (e.type === 'click') {
        target = e.target.closest('[onclick*="return confirm"]');
    } 
    // Check if it's a form submit with onsubmit="return confirm..."
    else if (e.type === 'submit') {
        if (e.target.hasAttribute('onsubmit') && e.target.getAttribute('onsubmit').includes('return confirm')) {
            target = e.target;
        }
    }

    if (!target) return;

    e.preventDefault();
    e.stopPropagation();

    let text = 'Apakah Anda yakin?';
    let match = target.getAttribute(e.type === 'submit' ? 'onsubmit' : 'onclick').match(/confirm\(['"]([^'"]+)['"]\)/);
    if (match) text = match[1];

    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Konfirmasi',
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF4B2B',
            cancelButtonColor: 'rgba(255,255,255,0.1)',
            confirmButtonText: 'Ya, Lanjutkan!',
            cancelButtonText: 'Batal',
            background: '#16213e',
            color: '#fff',
            backdrop: `rgba(0,0,10,0.6)`
        }).then((result) => {
            if (result.isConfirmed) {
                if (target.tagName.toLowerCase() === 'form') {
                    target.removeAttribute('onsubmit');
                    target.submit();
                } else if (target.tagName.toLowerCase() === 'a') {
                    window.location.href = target.href;
                } else if (target.tagName.toLowerCase() === 'button' && target.form) {
                    target.removeAttribute('onclick');
                    target.form.submit();
                }
            }
        });
    } else {
        if (confirm(text)) {
            if (target.tagName.toLowerCase() === 'form') {
                target.removeAttribute('onsubmit');
                target.submit();
            } else if (target.tagName.toLowerCase() === 'a') {
                window.location.href = target.href;
            } else if (target.tagName.toLowerCase() === 'button' && target.form) {
                target.removeAttribute('onclick');
                target.form.submit();
            }
        }
    }
}

document.addEventListener('click', handleConfirm, true);
document.addEventListener('submit', handleConfirm, true);
