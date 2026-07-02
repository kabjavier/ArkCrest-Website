// Sidebar Toggle - Standalone
(function() {
    'use strict';
    
    console.log('🔧 Sidebar Toggle: Loading...');
    
    function initSidebarToggle() {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');
        const toggleIcon = document.getElementById('toggleIcon');
        
        console.log('🔧 Elements found:', {
            sidebar: !!sidebar,
            toggleBtn: !!toggleBtn,
            toggleIcon: !!toggleIcon
        });
        
        if (!sidebar || !toggleBtn) {
            console.error('❌ Sidebar or toggle button not found!');
            return;
        }
        
        // Make sure sidebar starts expanded
        sidebar.classList.add('sidebar-expanded');
        sidebar.classList.remove('sidebar-collapsed');
        
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('🔧 Toggle button clicked!');
            
            const isExpanded = sidebar.classList.contains('sidebar-expanded');
            console.log('🔧 Current state: ' + (isExpanded ? 'EXPANDED' : 'COLLAPSED'));
            
            if (isExpanded) {
                // Collapse it
                sidebar.classList.remove('sidebar-expanded');
                sidebar.classList.add('sidebar-collapsed');
                sidebar.style.width = '70px';
                
                if (toggleIcon) {
                    toggleIcon.style.transform = 'rotate(180deg)';
                    toggleIcon.style.transition = 'transform 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                }
                
                console.log('✅ Sidebar COLLAPSED');
            } else {
                // Expand it
                sidebar.classList.remove('sidebar-collapsed');
                sidebar.classList.add('sidebar-expanded');
                sidebar.style.width = '260px';
                
                if (toggleIcon) {
                    toggleIcon.style.transform = 'rotate(0deg)';
                    toggleIcon.style.transition = 'transform 0.4s cubic-bezier(0.4, 0, 0.2, 1)';
                }
                
                console.log('✅ Sidebar EXPANDED');
            }
            
            console.log('🔧 New classes:', sidebar.className);
            console.log('🔧 New width:', sidebar.style.width);
        });
        
        console.log('✅ Sidebar toggle initialized successfully!');
    }
    
    // Try multiple times to ensure it loads
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSidebarToggle);
    } else {
        initSidebarToggle();
    }
    
    setTimeout(initSidebarToggle, 100);
    setTimeout(initSidebarToggle, 500);
    
    // Mobile drawer behavior — matches the single 1024px breakpoint in dashboard.css
    function initMobileSidebar() {
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        const menuBtn = document.getElementById('mobileMenuToggle');
        if (!sidebar || !backdrop || !menuBtn) return;

        function openDrawer() {
            sidebar.classList.add('mobile-open');
            backdrop.classList.add('active');
            document.body.classList.add('drawer-open');
        }
        function closeDrawer() {
            sidebar.classList.remove('mobile-open');
            backdrop.classList.remove('active');
            document.body.classList.remove('drawer-open');
        }

        menuBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            sidebar.classList.contains('mobile-open') ? closeDrawer() : openDrawer();
        });

        backdrop.addEventListener('click', closeDrawer);

        // Close drawer after tapping a nav link (mobile/tablet only)
        sidebar.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 1024) closeDrawer();
            });
        });

        // If the window is resized past the drawer breakpoint while open, reset state
        window.addEventListener('resize', function() {
            if (window.innerWidth > 1024 && sidebar.classList.contains('mobile-open')) {
                closeDrawer();
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMobileSidebar);
    } else {
        initMobileSidebar();
    }

    // Auto-wrap any table that doesn't already have a scroll container,
    // so it always gets horizontal/vertical scrollbars instead of being clipped.
    function autoWrapTables() {
        const knownWrapperClasses = ['tbl-wrap', 'table-wrapper', 'table-container', 'tbl-scroll', 'auto-scroll-wrap'];
        document.querySelectorAll('table').forEach(function(table) {
            let parent = table.parentElement;
            let alreadyWrapped = false;
            while (parent) {
                if (knownWrapperClasses.some(c => parent.classList && parent.classList.contains(c))) {
                    alreadyWrapped = true;
                    break;
                }
                parent = parent.parentElement;
            }
            if (!alreadyWrapped) {
                const wrapper = document.createElement('div');
                wrapper.className = 'auto-scroll-wrap';
                table.parentNode.insertBefore(wrapper, table);
                wrapper.appendChild(table);
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', autoWrapTables);
    } else {
        autoWrapTables();
    }

})();