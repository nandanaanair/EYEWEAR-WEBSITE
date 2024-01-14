
function createPopup(message) {
    jQuery('<div/>', {
        'id': 'custom-popup',
        'html': '<p>' + message + '</p>',
        'css': {
            'position': 'fixed',
            'top': '50%',
            'left': '50%',
            'transform': 'translate(-50%, -50%)',
            'padding': '20px',
            'background': '#fff',
            'border': '1px solid #ccc',
            'box-shadow': '0 0 10px rgba(0, 0, 0, 0.1)',
            'z-index': '1000'
        }
    }).appendTo('body');
}