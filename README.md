# Buttondown for Craft CMS
This plugin allow you to collect email addresses from your website and send them to your [Buttondown](https://buttondown.com/) newsletter.

Note that the plugin is not affiliated with Buttondown in any way - I personally use their service and wanted to create a plugin to make it easier to integrate with Craft CMS. 


![Screenshot](https://www.studioespresso.co/assets/buttondown-github-banner.png)


## Requirements
This plugin requires Craft CMS 5.6.0 or later.


## Installation
To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

```bash
# go to the project directory
cd /path/to/my-craft-project.dev

# tell Composer to install the plugin
composer require studioespresso/craft-buttondown

# tell Craft to install the plugin
./craft install/plugin buttondown
```

### Usage

The plugins needs an API key to connect to Buttondown. You can find your API key in your Buttondown account settings.

#### Basic subscriber form

In the simplest form, you only need an input called ``email``, you can post that to the ``buttondown/subscriber`` controller:
````twig
<form method="post">
    {{ csrfInput() }}
    {{ actionInput('buttondown/subscriber') }}
    {{ redirectInput('thanks-for-subscribing') }}
    
    <label for="email-address">{{ "Email address"|t }}</label>
    <input id="email-address" name="email" type="email" autocomplete="email" required>
                           
    <button type="submit">{{ "Subscribe"|t }}</button>
</form>
````

#### Fields & tags

Buttondown makes it very easy to add custom fields and tags to subscribers, simply add them as ``fields`` or ``tags`` to the form like the example below:

````twig
<form method="post">
    {{ csrfInput() }}
    {{ actionInput('buttondown/subscriber') }}
    {{ redirectInput('thanks-for-subscribing') }}
    
    {# Add custom fields #}
    <label for="firstName" class="sr-only">{{ "First Name"|t }}</label>
    <input id="firstName" name="fields[firstName]" type="text" autocomplete="firstName">
    
    <label for="email-address">{{ "Email address"|t }}</label>
    <input id="email-address" name="email" type="email" autocomplete="email" required>
            
    {# Add tags, hidden or not #}
    <input type="hidden" name="tags[]" value="{{ siteName }}">               
    <button type="submit">{{ "Subscribe"|t }}</button>
</form>
````