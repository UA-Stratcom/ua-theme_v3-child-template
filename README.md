# UA Theme v3.X Child Theme Template

This is a template for getting started with development for a child theme based on the 3rd generation of the University of Alabama WordPress theme.

## Getting Started

First, decide on a name for your child theme. If this is meant for a single site, it is recommended to use the site's subdomain in the name. For example, a child theme for the Strategic Communications site, would be called "Stratcomm Child Theme".

Next, create a text domain for your theme. This will be a variant of your theme's name without spaces or capital letters. Using the previous example, the text domain would be `stratcomm-child-theme`. The folder holding your theme should be renamed to match this text domain.

Next fill out the metadata in `style.css` using the examples included. Be sure to leave "Template" set to `ua-theme`. Then update the name of the stylesheet in `functions.php`, it is currently set to "child-theme-style" but should be renamed to include your theme's text domain with the `-style` suffix.

## Next Steps

You're now ready for child theme development. You can use child themes to create new page templates, override existing page templates, inject styles and/or scripts, create custom blocks, custom post types, and more. Below you'll find example solutions for common use cases.

You should take some time to review the [developer guidelines](https://web.ua.edu/developer/) for best practices. There is also extensive documentation for WordPress developers at [developer.wordpress.org](https://developer.wordpress.org/).

### Adding custom styles

The easiest way to add custom CSS to your site is through the site customizer. However, using a child theme to handle this has a few benefits.

You can load a custom stylesheet using the `wp_enqueue_style` function.

```php
function your_theme_register_styles() {
  wp_enqueue_style('your-style-name', get_stylesheet_directory_uri() . '/assets/your-styles.css', array(), null);
}

add_action('wp_enqueue_scripts', 'your_theme_register_styles');
```

It is highly recommended that you familiarize yourself with the [Minerva design system](https://web.ua.edu/design/) when writing your own styles. Try to use CSS variables from Minerva when possible.

### Injecting custom scripts

If you need to add additional javascript to your site, you can do so using a child theme. There are two ways to do this, depending on the source of the script.

If you're loading javascript from a CDN or a third party, you probably have a snippet that needs to be added to the footer. You can use the `wp_footer` action to add scripts just above the closing body tag on all page templates.

```php
function your_theme_wp_footer() {
  echo '<script></script>';
}
add_action('wp_footer', 'your_theme_wp_footer');
```

Otherwise, you can load a script from a local file.

```php
function your_theme_register_scripts() {
  wp_enqueue_script('your-script-name', get_stylesheet_directory_uri() . '/assets/your-script.js', array(), false, true);
}
add_action('wp_enqueue_scripts', 'your_theme_register_scripts');
```

### Additional headers and footers

The UA Theme has included a blank footer.php and header.php that can be safely overwritten to add content in the header and footer blocks. On every page template, `footer.php` will render inside the `<footer>` tag above the site footer. On every page template, `header.php` will render inside the `<header>` tag just below the site title bar. To override either of these files, create a new file with the same name at the root of your theme's folder.

### Creating new page templates

You can create a new page or post template by adding the template in the root of your theme's folder as a PHP file. Below is the minimum scaffold for a new template.

```php
<?php
/*
Template Name: Your Template
Template Post Type: page
*/
?>
<!doctype html>
<html <?php language_attributes(); ?> >
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?> >
    <?php wp_body_open(); ?>
    <div class="ua_minerva" id="ua_app">

      <header>
        <?php get_template_part( 'parts/brand-bar' ); ?>
        <?php get_template_part( 'parts/title-bar' ); ?>
        <?php get_header(); ?>
      </header>

      <main id="wp--skip-link--target" class="ua_page">
        <div class="ua_page_content is-layout-flow">
        </div>
      </main>
      <footer>
        <?php get_footer() ?>
        <?php get_template_part( 'parts/site-footer' ); ?>
        <?php get_template_part( 'parts/brand-footer' ); ?>
      </footer>
    </div>
    <?php wp_footer(); ?>
  </body>
</html>
```

You can designate the types of content the template is available for using the "Template Post Type" meta field. Change "page" in the below example to "post" to change it to a post template. You can also enable templates for multiple types with a comma separated list.

### Overriding templates

While not recommended, you can override one of the default page templates with your own by creating a PHP file of the same name in the root of your theme's folder.

## Things to keep in mind

With great power comes great responsibility. Some modifications made through a child theme can create conflicts with the parent theme. It is your responsibility to identify, avoid, and patch any such conflicts; as well as fix any bugs or unintentional behavior introduced by your child theme.

You should also take care that your child theme does not introduce a security vulnerability. Do not manipulate WordPress' input sanitization or login flow, and take extra care when manipulating roles and capabilities. When extending the customizer or theme options, you should ensure all user inputs are sanitized and validated before being saved to the database.
