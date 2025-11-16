/**
 * Accessibility utilities for announcing actions to screen readers
 */

/**
 * Announce a message to screen readers via aria-live region
 * @param {string} message - The message to announce
 * @param {number} delay - Delay in ms before clearing (default 3000)
 */
export function announceToScreenReader(message, delay = 3000) {
    const liveRegion = document.getElementById('aria-live-region');
    if (!liveRegion) return;
    
    liveRegion.textContent = message;
    
    // Clear after delay to allow re-announcing same message
    setTimeout(() => {
        liveRegion.textContent = '';
    }, delay);
}

/**
 * Set up global announcement helper
 */
if (typeof window !== 'undefined') {
    window.announceToScreenReader = announceToScreenReader;
}
