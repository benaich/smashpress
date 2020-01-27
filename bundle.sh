#! /bin/sh


## Helpers
ESC_SEQ="\x1b["
COL_RESET=$ESC_SEQ"39;49;00m"
COL_GREEN=$ESC_SEQ"32;01m"
COL_YELLOW=$ESC_SEQ"33;01m"

function bot() {
    echo -e "\n$COL_YELLOW\[._.]/$COL_RESET - "$1
}

## Arguments setup
bot "Hi! I'm going to bundle your wordpress website and generate an optimized version of it. Here I go..."

bot "I might need some information:"
read -r -p "What is your wordpress website url? " url
read -r -p "What is your current theme's name ? " parentTheme
read -r -p "Regex of files you want to exclue (default: jquery.js) ? " excludeRegex

excludeRegex="${excludeRegex:-jquery\.js}"
themeDir="smashpress-theme"

## Download page
curl -s $url -o 'page.html'

## Generate config.php to ignore js/css wordpress handles
jsHandles=( `cat page.html | grep 'jsHandles' | sed -e 's/jsHandles=(\(.*\))/\1/'` )
cssHandles=( `cat page.html | grep 'cssHandles' | sed -e 's/cssHandles=(\(.*\))/\1/'` )

ignoredJsRoutes=$(printf "\"%s\" => \"\/wp-content\/themes\/\$themeName\/dist\/silence.js\",\t" "${jsHandles[@]}")
ignoredCssRoutes=$(printf "\"%s\" => \"\/wp-content\/themes\/\$themeName\/dist\/silence.css\",\t" "${cssHandles[@]}")

configFile="$themeDir/src/config.php"
sed "s/<IGNORED_JS>/$ignoredJsRoutes/" templates/config.php.tmpl \
    | sed "s/<IGNORED_CSS>/$ignoredCssRoutes/" \
    | sed $'s/\t/\\\n\\\t/g' \
    > $configFile

## Generate style.css theme file
styleFile="$themeDir/style.css"
sed "s/<YOUR_PARENT_THEME>/$parentTheme/" templates/style.css.tmpl > $styleFile

## Extract used js/css files
js=(`cat page.html | grep -Eoi "<script [^>]+>" | grep -Eo "src=['\"][^'\"]+['\"]" | grep -Eo "(http|https)://[^'\"]+" | grep -Ev $excludeRegex`)
css=(`cat page.html | grep -Eoi "<link rel=['\"]stylesheet['\"] [^>]+>" | grep -Eo "href=['\"][^'\"]+['\"]" | grep -Eo "(http|https)://[^'\"]+" | grep -Ev $excludeRegex`)

## Prepare tmp and dist directories
rm -rf smashpress-theme/dist tmp page.html
mkdir -p smashpress-theme/dist tmp/{js,css}
touch smashpress-theme/dist/silence.css smashpress-theme/dist/silence.js

## Download js assets
bot "Download js assets"

for element in "${js[@]}"
do
    filename=`echo "$element" | cut -d / -f 5- | cut -d \? -f 1 | tr / _`
    curl -s $element -o tmp/js/$filename 
done

## Download css assets
bot "Download css assets"

for element in "${css[@]}"
do
    filename=`echo "$element" | cut -d / -f 5- | cut -d \? -f 1 | tr / _`
    curl -s $element -o tmp/css/$filename 
done

## Bundle everything
bot "Bundle everything"

bot "Bundling using gulp..."
yarn gulp
