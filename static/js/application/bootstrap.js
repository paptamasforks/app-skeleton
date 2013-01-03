// Define routing rules
Route.set('admin', '<directory>(/<controller>(/<action>(/<id>)))', {directory: 'admin', id: '\\d+'})
    .defaults({
        directory: 'admin',
        controller: 'home',
        action: 'index'
    });

Route.set('default', '/<controller>(/<action>(/<id>))', {id: '\\d+'})
    .defaults({
        controller: 'home',
        action: 'index'
    });

// Set the default language
i18n.lang('en-us');

// Execute request
$(document).ready(function() {
    Request.execute();
});