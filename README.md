This little tool helps you optimize the performance of your wordpress application by combining all the JS and CSS files your theme/plugins are using into one minified file using gulp.

# How to use it

## Step 1 - List enqueued scripts and styles handles in your wordPress frontend

- Add the content of `/src/handlesList.php` to your `function.php` file
- This will fetch the list enqueued scripts names (aka handles) used by your wordpress site. list them as comments in your html page. 

This step's  purpose is to expose the handle name of each asset your theme and plugins are using, which will be used later in `step#2` in order to 
to tell wordpress not to include them anymore.

## Step 2 - Generate the optimazied theme

In this step we will do the folowing:
- Extracts the assets (js/css files) used by your current theme and plugins
- Bundles all into two minimized files bundle.js and bundle.css
- Extracts the wordpress handle names used by your current theme and plugins
- Extends your current theme in order to ignore your all the js/css files currently used and use the optimized ones instead
- Generate an optimazed version of your wordpress theme

You simply need to run the commands below on your terminal:

```bash
git clone git@github.com:benaich/smashpress.git
cd smashpress
make bundle
```

You will be asked for the wordpress url you want to optimize and the name of the active theme.

## Step 3 - Use smashpress-theme

- You need to use `smashpress-theme` as your primary theme in order to apply all the optimization you have just configured
- Check that everything is working as expected
- Mesure your page spped with and without `smashpress-theme` to see the difference in [google pagespeed](https://developers.google.com/speed/pagespeed/insights/)

