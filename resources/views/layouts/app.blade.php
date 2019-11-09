<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <title>Dashboard</title>

    <style>#loader{transition:all .3s ease-in-out;opacity:1;visibility:visible;position:fixed;height:100vh;width:100%;background:#fff;z-index:90000}#loader.fadeOut{opacity:0;visibility:hidden}.spinner{width:40px;height:40px;position:absolute;top:calc(50% - 20px);left:calc(50% - 20px);background-color:#333;border-radius:100%;-webkit-animation:sk-scaleout 1s infinite ease-in-out;animation:sk-scaleout 1s infinite ease-in-out}@-webkit-keyframes sk-scaleout{0%{-webkit-transform:scale(0)}100%{-webkit-transform:scale(1);opacity:0}}@keyframes sk-scaleout{0%{-webkit-transform:scale(0);transform:scale(0)}100%{-webkit-transform:scale(1);transform:scale(1);opacity:0}}</style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=uvzft8zjxwr0vjm6tygqvrvkv2tb1lljzwf0zsi2sunkqhnv"></script>
    <script>
        tinymce.init({
          selector: '.text-editor'
        });
        </script>
  </head>
    <body class="app">
    <div id="loader">
      <div class="spinner"></div>
    </div>
    <script>
      window.addEventListener('load', () => {
        const loader = document.getElementById('loader');
        setTimeout(() => {
          loader.classList.add('fadeOut');
        }, 300);
      });
    </script>
    
    <div>
      
      @include('inc.sidebar')

      
      <div class="page-container">
        
        @include('inc.header')

        
        {{-- Flash messages needed --}}
        
        <main class="main-content bgc-grey-100">
          <div id="mainContent">
            @include('inc.messages')
            @yield('content')
          </div>
        </main>

        
        @include('inc.footer')
      </div>
    </div>

  <script type="text/javascript" src="{{ asset('/js/vendor.js') }}"></script>
  <script type="text/javascript" src="{{ asset('/js/bundle.js') }}"></script>
</body>
</html>
