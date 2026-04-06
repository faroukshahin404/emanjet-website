/**
* Main
*/

'use strict';

let menu,
animate;
document.addEventListener('DOMContentLoaded', function () {
// class for ios specific styles
if (navigator.userAgent.match(/iPhone|iPad|iPod/i)) {
document.body.classList.add('ios');
}

  // Fix Language Dropdown - Match toggle width exactly (ROOT SOLUTION)
  (function fixLanguageDropdown() {
    const dropdown = document.querySelector('.navbar-dropdown.dropdown-language');
    if (!dropdown) return;

    const toggle = dropdown.querySelector('.dropdown-toggle');
    const menu = dropdown.querySelector('.dropdown-menu');
    if (!toggle || !menu) return;

    const MIN_WIDTH = 160;
    const MAX_WIDTH = 220;

    const applyCorrectWidth = () => {
      // Get actual toggle width
      const toggleRect = toggle.getBoundingClientRect();
      const toggleWidth = toggleRect.width;

      // Calculate correct width: match toggle, but respect min/max
      const calculatedWidth = Math.max(MIN_WIDTH, Math.min(toggleWidth, MAX_WIDTH));

      // Apply width - EXACT match to toggle
      menu.style.setProperty('width', `${calculatedWidth}px`, 'important');
      menu.style.setProperty('min-width', `${calculatedWidth}px`, 'important');
      menu.style.setProperty('max-width', `${calculatedWidth}px`, 'important');

      // Force position: centered below button
      menu.style.setProperty('left', '50%', 'important');
      menu.style.setProperty('right', 'auto', 'important');
      menu.style.setProperty('transform', 'translateX(-50%)', 'important');
      menu.style.setProperty('margin-left', '0', 'important');
      menu.style.setProperty('margin-right', '0', 'important');
    };

    const handleShow = () => {
      // Use double requestAnimationFrame to ensure DOM is ready
      requestAnimationFrame(() => {
        requestAnimationFrame(applyCorrectWidth);
      });
    };

    // Listen to all dropdown events
    toggle.addEventListener('show.bs.dropdown', handleShow);
    toggle.addEventListener('shown.bs.dropdown', handleShow);

    // Watch for resize
    window.addEventListener('resize', () => {
      if (menu.classList.contains('show')) {
        applyCorrectWidth();
      }
    });

    // Watch for style changes from Popper
    const observer = new MutationObserver(() => {
      if (menu.classList.contains('show')) {
        applyCorrectWidth();
      }
    });

    observer.observe(menu, {
      attributes: true,
      attributeFilter: ['style', 'class']
    });
  })();
});

(function () {
// Initialize menu
//-----------------

let layoutMenuEl = document.querySelectorAll('#layout-menu');
layoutMenuEl.forEach(function (element) {
menu = new Menu(element, {
orientation: 'vertical',
closeChildren: false
});
// Change parameter to true if you want scroll animation
window.Helpers.scrollToActive((animate = false));
window.Helpers.mainMenu = menu;
});

// Initialize menu togglers and bind click on each
let menuToggler = document.querySelectorAll('.layout-menu-toggle');
menuToggler.forEach(item => {
// Ensure button is clickable
item.style.pointerEvents = 'auto';
item.style.cursor = 'pointer';

// Function to toggle menu
const toggleMenu = function(event) {
  event.preventDefault();
  event.stopPropagation();

  // Check if we're on mobile
  const isSmallScreen = window.Helpers && window.Helpers.isSmallScreen
    ? window.Helpers.isSmallScreen()
    : window.innerWidth < 1200;

  if (isSmallScreen) {
    // For mobile, toggle layout-menu-expanded class
    const layoutWrapper = document.querySelector('.layout-wrapper');
    const htmlEl = document.documentElement;
    const bodyEl = document.body;
    const isExpanded = (layoutWrapper && layoutWrapper.classList.contains('layout-menu-expanded')) ||
      htmlEl.classList.contains('layout-menu-expanded') ||
      bodyEl.classList.contains('layout-menu-expanded');

    if (isExpanded) {
      // Close
      if (layoutWrapper) layoutWrapper.classList.remove('layout-menu-expanded');
      htmlEl.classList.remove('layout-menu-expanded');
      bodyEl.classList.remove('layout-menu-expanded');
    } else {
      // Open
      if (layoutWrapper) layoutWrapper.classList.add('layout-menu-expanded');
      htmlEl.classList.add('layout-menu-expanded');
      bodyEl.classList.add('layout-menu-expanded');
    }
  } else {
    // For desktop, use Helpers.toggleCollapsed
    if (window.Helpers && typeof window.Helpers.toggleCollapsed === 'function') {
      window.Helpers.toggleCollapsed();
    }
  }
};

// Add click handler to the button itself
item.addEventListener('click', toggleMenu, true); // Use capture phase

// Also handle clicks on links inside
const link = item.querySelector('a, .nav-link');
if (link) {
  link.style.pointerEvents = 'auto';
  link.style.cursor = 'pointer';
  link.addEventListener('click', toggleMenu, true); // Use capture phase
}
});

// Display menu toggle (layout-menu-toggle) on hover with delay
let delay = function (elem, callback) {
  let timeout = null;
  elem.onmouseenter = function () {
    // Set timeout to be a timer which will invoke callback after 300ms (not for small screen)
    if (!Helpers.isSmallScreen()) {
      timeout = setTimeout(callback, 300);
    } else {
      timeout = setTimeout(callback, 0);
    }
  };
  elem.onmouseleave = function () {
    // Clear any timers set to timeout
    document.querySelector('.layout-menu-toggle').classList.remove('d-block');
    clearTimeout(timeout);
  };
};

if (document.getElementById('layout-menu')) {
  delay(document.getElementById('layout-menu'), function () {
    // not for small screen
    if (!Helpers.isSmallScreen()) {
      document.querySelector('.layout-menu-toggle').classList.add('d-block');
    }
  });
}

// Display in main menu when menu scrolls
let menuInnerContainer = document.getElementsByClassName('menu-inner');
let menuInnerShadow = document.getElementsByClassName('menu-inner-shadow')[0];
if (menuInnerContainer.length > 0 && menuInnerShadow) {
  menuInnerContainer[0].addEventListener('ps-scroll-y', function () {
    if (this.querySelector('.ps__thumb-y').offsetTop) {
      menuInnerShadow.style.display = 'block';
    } else {
      menuInnerShadow.style.display = 'none';
    }
  });
}

    // Init helpers & misc
    // --------------------

    // Init BS Tooltip
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Accordion active class
    const accordionActiveFunction = function (e) {
    if (e.type == 'show.bs.collapse' || e.type == 'show.bs.collapse') {
    e.target.closest('.accordion-item').classList.add('active');
    } else {
    e.target.closest('.accordion-item').classList.remove('active');
    }
    };

    const accordionTriggerList = [].slice.call(document.querySelectorAll('.accordion'));
    const accordionList = accordionTriggerList.map(function (accordionTriggerEl) {
    accordionTriggerEl.addEventListener('show.bs.collapse', accordionActiveFunction);
    accordionTriggerEl.addEventListener('hide.bs.collapse', accordionActiveFunction);
    });

    // Auto update layout based on screen size
    window.Helpers.setAutoUpdate(true);

    // Toggle Password Visibility
    window.Helpers.initPasswordToggle();

    // Speech To Text
    window.Helpers.initSpeechToText();

    // Manage menu expanded/collapsed with templateCustomizer & local storage
    //------------------------------------------------------------------

    // If current layout is horizontal OR current window screen is small (overlay menu) than return from here
    if (window.Helpers.isSmallScreen()) {
    return;
    }

    // If current layout is vertical and current window screen is > small

    // Auto update menu collapsed/expanded based on stored state or default
    // Check localStorage for stored collapse state
    const storedCollapsed = localStorage.getItem('sidebarCollapsed');
    // If state is stored, use it; otherwise default to collapsed (true)
    const shouldCollapse = storedCollapsed !== null ? storedCollapsed === 'true' : true;
    window.Helpers.setCollapsed(shouldCollapse, false);

    // Sidebar Collapse Persistence
    //------------------------------------------------------------------
    const SIDEBAR_COLLAPSE_KEY = 'sidebarCollapsed';

    // Get stored collapse state from localStorage
    function getStoredCollapseState() {
    const stored = localStorage.getItem(SIDEBAR_COLLAPSE_KEY);
    if (stored === null) return null;
    return stored === 'true';
    }

    // Set collapse state in localStorage
    function setStoredCollapseState(collapsed) {
    localStorage.setItem(SIDEBAR_COLLAPSE_KEY, collapsed ? 'true' : 'false');
    }

    // Initialize sidebar collapse state
    function initSidebarCollapse() {
    // Wait for Helpers to be available
    if (typeof window.Helpers === 'undefined') {
    setTimeout(initSidebarCollapse, 100);
    return;
    }

    // Skip on small screens (mobile) - let Helpers handle it naturally like English
    if (window.Helpers.isSmallScreen()) {
    return;
    }

    // Restore the state from localStorage (main.js already does this, but this is a backup)
    // This ensures state is restored even if main.js hasn't run yet
    const storedState = getStoredCollapseState();

    // Only restore if there's a stored state and it differs from current state
    if (storedState !== null) {
    const currentState = window.Helpers.isCollapsed();
    if (storedState !== currentState) {
    setTimeout(function() {
    window.Helpers.setCollapsed(storedState, false);
    }, 100);
    }
    }

    // Override toggleCollapsed to save state
    const originalToggleCollapsed = window.Helpers.toggleCollapsed;
    window.Helpers.toggleCollapsed = function(animate) {
    // Call original function
    originalToggleCollapsed.call(this, animate);

    // Save the new state after a short delay to ensure state is updated
    setTimeout(function() {
    const isCollapsed = window.Helpers.isCollapsed();
    setStoredCollapseState(isCollapsed);
    }, animate ? 350 : 50);
    };

    // Also override setCollapsed to save state
    const originalSetCollapsed = window.Helpers.setCollapsed;
    window.Helpers.setCollapsed = function(collapsed, animate) {
    // Call original function
    originalSetCollapsed.call(this, collapsed, animate);

    // Save the state
    setStoredCollapseState(collapsed);
    };
    }

    // Initialize sidebar collapse persistence
    initSidebarCollapse();
    })();

    // Theme Toggle Script
    (function() {
    'use strict';

    // Function to initialize theme toggle
    function initThemeToggle() {
    // Get theme toggle button
    const themeToggle = document.getElementById('theme-toggle');
    if (!themeToggle) {
    console.warn('Theme toggle button not found');
    return;
    }

    // Get current theme from localStorage or default to 'light'
    const getStoredTheme = () => {
    const stored = localStorage.getItem('theme');
    return stored || 'light';
    };

    const setStoredTheme = (theme) => {
    localStorage.setItem('theme', theme);
    };

    // Set theme
    const setTheme = (theme) => {
    // Set theme attribute on html element
    document.documentElement.setAttribute('data-bs-theme', theme);
    setStoredTheme(theme);

    // Update icon
    const icon = themeToggle.querySelector('i');
    if (icon) {
    if (theme === 'dark') {
    icon.classList.remove('bx-moon');
    icon.classList.add('bx-sun');
    } else {
    icon.classList.remove('bx-sun');
    icon.classList.add('bx-moon');
    }
    }
    };

    // Initialize theme on page load
    const currentTheme = getStoredTheme();
    setTheme(currentTheme);

    // Toggle theme on click
    themeToggle.addEventListener('click', function(e) {
    e.preventDefault();
    e.stopPropagation();

    const currentTheme = getStoredTheme();
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    setTheme(newTheme);
    });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initThemeToggle);
    } else {
    // DOM is already ready
    initThemeToggle();
    }
    })();

    // Select Hover Enhancement
    (function() {
    'use strict';

    // Get primary color from CSS variable
    function getPrimaryColor() {
    const root = document.documentElement;
    const primaryColor = getComputedStyle(root).getPropertyValue('--bs-primary').trim();
    return primaryColor || '#696cff';
    }

    // Get secondary color from CSS variable
    function getSecondaryColor() {
    const root = document.documentElement;
    const secondaryColor = getComputedStyle(root).getPropertyValue('--bs-secondary').trim();
    return secondaryColor || '#8592a3';
    }

    // Convert hex to rgb
    function hexToRgb(hex) {
    const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
    r: parseInt(result[1], 16),
    g: parseInt(result[2], 16),
    b: parseInt(result[3], 16)
    } : null;
    }

    // Enhance select dropdowns with hover effect
    function enhanceSelectHover() {
    const selects = document.querySelectorAll('.form-select, select');
    const primaryColor = getPrimaryColor();
    const secondaryColor = getSecondaryColor();
    const rgb = hexToRgb(secondaryColor);

    selects.forEach(function(select) {
    // Set accent-color for browser native hover (use secondary) - Force apply
    select.style.setProperty('accent-color', secondaryColor, 'important');
    select.setAttribute('style', select.getAttribute('style') + ' accent-color: ' +
    secondaryColor + ' !important;');

    // Add mouseenter event to change border color (use secondary for hover)
    select.addEventListener('mouseenter', function() {
    this.style.borderColor = secondaryColor;
    });

    // Add mouseleave event to reset border color
    select.addEventListener('mouseleave', function() {
    if (!this.matches(':focus')) {
    this.style.borderColor = '';
    }
    });

    // Keep border color on focus (use primary for focus)
    select.addEventListener('focus', function() {
    this.style.borderColor = primaryColor;
    this.style.accentColor = secondaryColor;
    });

    // Reset on blur if not hovering
    select.addEventListener('blur', function() {
    if (!this.matches(':hover')) {
    this.style.borderColor = '';
    }
    });

    // Try to style options on change
    select.addEventListener('change', function() {
    // Force re-render to apply accent-color
    const temp = this.style.display;
    this.style.display = 'none';
    this.offsetHeight; // Trigger reflow
    this.style.display = temp;
    });
    });

    // Inject style for option hover (use secondary color) with maximum specificity
    // Only apply to light theme, not dark theme
    if (rgb) {
    // Remove existing style if any
    const existingStyle = document.getElementById('select-hover-style');
    if (existingStyle) {
    existingStyle.remove();
    }

    const style = document.createElement('style');
    style.id = 'select-hover-style';
    style.textContent = `
    /* Maximum specificity for option hover - Light theme only */
    :root:not([data-bs-theme="dark"]) select.form-select option:hover,
    :root:not([data-bs-theme="dark"]) select option:hover,
    :root:not([data-bs-theme="dark"]) .form-select option:hover,
    :root:not([data-bs-theme="dark"]) option:hover {
    background-color: ${secondaryColor} !important;
    background: ${secondaryColor} !important;
    color: #fff !important;
    }
    :root:not([data-bs-theme="dark"]) select.form-select option:focus,
    :root:not([data-bs-theme="dark"]) select option:focus,
    :root:not([data-bs-theme="dark"]) .form-select option:focus,
    :root:not([data-bs-theme="dark"]) option:focus {
    background-color: ${secondaryColor} !important;
    background: ${secondaryColor} !important;
    color: #fff !important;
    }
    :root:not([data-bs-theme="dark"]) select.form-select option:active,
    :root:not([data-bs-theme="dark"]) select option:active,
    :root:not([data-bs-theme="dark"]) .form-select option:active,
    :root:not([data-bs-theme="dark"]) option:active {
    background-color: ${secondaryColor} !important;
    background: ${secondaryColor} !important;
    color: #fff !important;
    }
    `;
    document.head.appendChild(style);
    }
    }

    // Watch for dynamically added select elements
    function watchForNewSelects() {
    const secondaryColor = getSecondaryColor();
    const observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
    mutation.addedNodes.forEach(function(node) {
    if (node.nodeType === 1) { // Element node
    // Check if the added node is a select
    if (node.tagName === 'SELECT' || node.classList.contains('form-select')) {
    node.style.setProperty('accent-color', secondaryColor, 'important');
    }
    // Check for selects inside the added node
    const selects = node.querySelectorAll ? node.querySelectorAll('.form-select, select') : [];
    selects.forEach(function(select) {
    select.style.setProperty('accent-color', secondaryColor, 'important');
    });
    }
    });
    });
    });

    observer.observe(document.body, {
    childList: true,
    subtree: true
    });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
    enhanceSelectHover();
    // Watch for new select elements added dynamically
    watchForNewSelects();
    });
    } else {
    enhanceSelectHover();
    watchForNewSelects();
    }
    })();

    // Utils
    function isMacOS() {
    return /Mac|iPod|iPhone|iPad/.test(navigator.userAgent);
    }
