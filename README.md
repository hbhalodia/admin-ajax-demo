# admin-ajax-demo
This is the example plugin for admin-ajax demo.

## Whats Done 📝 :
1. sub-menu page inside `settings` page.
2. call to ajax on button click to fetch recent 5 posts.
3. demo for admin-ajax in wp-admin.

## Hooks and fucntions used 🧮 :
1. Hooks :
  - admin_menu : to register the sub-menu inside settings page.
  - admin_enqueue_scripts : to resgister the and enqueue the js in admin side.
  - wp_ajax_admin_ajax_action : what to do on ajax action requested.
2. Functions :
  - add_options_page() : to register the sub-menu page.
  - wp_enqueue_script() : to enqueue the js file.
  - wp_localize_script() : to localize the enqueued script to and can easily used to translate strings inside js.
  - get_the_title() : to fetch the title of post based on id.
  - get_permalink() : to get the actual link of the post based on id.
