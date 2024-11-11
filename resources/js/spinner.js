const originalFetch = window.fetch;
window.fetch = function() {
    document.getElementById('loadingSpinner').style.display = 'inline-block';
    return originalFetch.apply(this, arguments).finally(() => {
        document.getElementById('loadingSpinner').style.display = 'none';
    });
};
