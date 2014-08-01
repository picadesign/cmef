# Tell compass where to find local extensions
# If you followed directions and ran 'gem install modular-scale' comment the next two lines out:
extensions_dir = "sass/assets/gumby/extensions"

Compass::Frameworks.register('modular-scale', :path => File.expand_path("#{extensions_dir}/modular-scale"))

#Project Settings
environment = :development
project_type = :stand_alone
preferred_syntax = :scss
output_style = :nested #:nested, :expanded, :compact, or :compressed.
line_comments = true

#Asset Paths
sass_dir = "sass"
css_dir = "stylesheets"
http_images_path = "//dev.pica.is/cmef/wp-content/themes/cmef/images/"
http_generated_images_path = "//dev.pica.is/cmef/wp-content/themes/cmef/images/"
generated_images_path = "/Applications/MAMP/htdocs/cmef/wp-content/themes/cmef/images/"
http_fonts_path = "//dev.pica.is/cmef/wp-content/themes/cmef/fonts/"
sprite_load_path = "/Applications/MAMP/htdocs/cmef/wp-content/themes/cmef/images/"