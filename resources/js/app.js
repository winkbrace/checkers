require('./bootstrap');

// wait for images to load
window.onload = function() {
    require('./pieces');
    require('./board');
    require('./input');
};
