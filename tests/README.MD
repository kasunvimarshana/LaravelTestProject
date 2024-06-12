```bash
# install laravel/ui
composer require laravel/ui
php artisan ui bootstrap
```

```bash
# upgrade bootstrap and add new popper.js version
npm install bootstrap@latest @popperjs/core --save-dev
```

```javascript
# resources/js/bootstrap.js:

window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');
    window.Popper = require('@popperjs/core');
    window.bootstrap = require('bootstrap');

} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// npm run dev
```

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>jQuery, popper.js, and Bootstrap</title>
    
    {{--    Load compiled CSS    --}}
    <link rel="stylesheet" href={{ asset('css/app.css') }}>
    
    {{--  popper.js CSS example  --}}
    <style>
        #tooltip {
            background: #333;
            color: white;
            font-weight: bold;
            padding: 4px 8px;
            font-size: 13px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

{{--  Test Bootstrap css  --}}
<div class="alert alert-success mt-5" role="alert">
    Boostrap 5 is working using laravel 8 mix!
</div>

{{--  popper.js HTML example  --}}
<button id="button" aria-describedby="tooltip">My button</button>
<div id="tooltip" role="tooltip">My tooltip</div>

{{--    Load compiled Javascript    --}}
<script src="{{ asset('js/app.js') }}"></script>
<script>
    //Test jQuery
    $(document).ready(function () {
        console.log('jQuery works!');

        //Test bootstrap Javascript
        console.log(bootstrap.Tooltip.VERSION);
    });

    //Test popper.js
    const button = document.querySelector('#button');
    const tooltip = document.querySelector('#tooltip');
    const popperInstance = Popper.createPopper(button, tooltip);
</script>

</body>
</html>
```