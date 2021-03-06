# Form API 2 for websites

- This release required PHP 7.2 +
- For release PHP 5 - PHP 7.0 check [https://github.com/mickidum/forms-api2-php5](https://github.com/mickidum/forms-api2-php5)

Download this repo, unzip and you can rename it \
Upload this folder to your hosting(probably to public_html). \
Follow to steps below.

## First create admin account:

- Go to the forms-api2 folder (for example: 'your-domain-name.com/forms-api')
- Fill the username and password
- After send will be created .env file with hash credentials

## How to use

Two fields must be sent POST to '/forms-api2/api/leadsapi/newlead':

1. form_name_id -> "example_contact_form_name" (required)
2. form_name -> "Example contact form - homepage" (if missing or empty - "form_name_id" will be used as Form Name Label)

## Login

- path to login: 'path-to-forms-api2/crm'
- For changing username and password just delete .env and Go to the forms-api2 folder.

## Contact Form 7 Example:

Consider your site is 'your-domain-name.com' and 'forms-api2' folder is located in 'public_html' directory, then full path for new lead will be 'your-domain-name.com/forms-api2/api/leadsapi/newlead'.

In wordpress admin Contact form tab insert tags:

[hidden form_name_id "my_site_contacts_big_form"] \
[hidden form_name "My very big form on contacts page"]

### Add javascript hook to your 'js' file (wordpress):

<pre>
var host = window.location.origin;
jQuery('.wpcf7').on('wpcf7mailsent', function(event) {
	var inputs = event.detail.inputs;
	jQuery.post(host + '/forms-api2/api/leadsapi/newlead', inputs, function(data) {});
});
</pre>

## END
