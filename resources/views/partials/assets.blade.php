{{-- Compiled frontend assets served from public/build (built by Vite).
      This replaces the previous runtime Tailwind CDN script, which generated
      no CSS at all when the machine had no internet access and left every page
      unstyled (headers, navbars and sidebars invisible).

      After editing resources/css/app.css run:  npm run build
--}}
@vite(['resources/css/app.css'])
