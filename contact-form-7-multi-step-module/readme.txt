=== Webheadcoder Multi-Step Forms for Contact Form 7 ===
Contributors: webheadllc
Tags: contact form 7, multistep form, multi page form, form persistence
Requires at least: 4.7
Tested up to: 7.1
Stable tag: 4.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds multi-page, multi-step forms to Contact Form 7.

== Description ==

First released in 2013, Webheadcoder Multi-Step Forms for Contact Form 7 adds multi-step flows to forms by placing each step on a separate page, preserving submitted data between steps, and sending the completed email only from the designated step configured to send it.

See it in action at [https://webheadcoder.com/contact-form-7-multi-step-forms/](https://webheadcoder.com/contact-form-7-multi-step-forms/)

Requires [Contact Form 7](https://wordpress.org/plugins/contact-form-7/) (5.2 or above) by Rock Lobster Inc. (Takayuki Miyoshi).

**Usage**

1. Create one page or post for each step in your multi-step form process. If you have three steps, create three pages or posts. You will need their URLs when creating your forms.

2. Create a Contact Form 7 form.

3. Place your cursor at the end of the form.

4. On the "Form" tab of the Contact Form 7 form, click on the button named "multistep".

5. In the window that opens, select "First Step" if this is the first step of your multi-step form. If this is the last step, select "Last Step." All other checkboxes are optional.

6. The Next Page URL is the URL that contains your next form. If this form is the last step, you can leave the URL field blank.

7. Click "Insert Tag."

8. Save your completed form and place the form's shortcode into the appropriate page or post you created in step 1.

9. Repeat for **each form** in your multi-step form process.

10. On the last step, you may want to send an email. Select "Send Email" in step 5. On the Mail tab, enter mail-tags as you normally would. For example, if your first form has the field `your-email`, you can include `[your-email]` in the Mail tab on your last form. Contact Form 7 may flag this because `your-email` is not displayed on the current form; you can safely ignore that warning.


**Multistep Tag Options**

* **Name** - The name of this multistep form-tag.  This is required, but is currently not being used.

* **First Step** - Besides marking the first step of your multistep form, this allows any form to act as the first step and display when no previous data has been submitted. This is useful when you want some users to skip the first step.

* **Last Step** - Besides marking the last step of your multistep form, this clears the data from users' browsers. Once they submit this form, they will no longer see their data populate the forms.

* **Send Email** - If this is checked the form will send an email like a normal Contact Form 7 submission.

* **Skip Save** - If you use Flamingo or CFDB7 to save submissions to the database this prevents saving this form submission.

* **Next Page URL** - This is the URL your users will go to after the form is submitted.

`[multistep multistep-123 last_step send_email skip_save "/thank-you"]`

**Additional Tags**

`[multiform "your-name"]`
The `multiform` form-tag can be used to display a field from a previous step.  Replace `your-name` with the name of your field.  This is only for use on the Form tab, this tag will not work in the Mail tab.  

`[previous "Go Back"]`
The `previous` form-tag can be used to display a button to go to a previous step.  Replace `Go Back` with text you want to show in the button.


**Messages Tab**
When a visitor visits the fourth step in your multi-step form without completing the first step, the message "Please fill out the form on the previous page." is displayed. You can change this for each form in the Messages tab.


**What this plugin DOES NOT do:**  

* This plugin does not support file uploads on every form.  If you need to use file uploads make sure to place it on the last step.

* This plugin does not load another form on the same page.  It only works when the forms are on separate pages.  Many have asked to make it load via ajax so all forms can reside on one page.  This plugin does not support that.

**PRO Version**
If you expect to have a lot of data submitted through your multi-step forms, the Pro version may be able to help you better.  The PRO version uses Session Storage so it is able to handle roughly 1,000 times more data for your multiple forms.  In total it can handle about 5MB vs 4KB in the free version.  **Currently the Pro version REQUIRES the WordPress REST API and Contact Form 7 AJAX Submission to be enabled.**   

Another feature the Pro version offers is the ability to skip steps with the "Contact Form 7 - Conditional Fields plugin".  [Learn more here.](https://webheadcoder.com/contact-form-7-multi-step-forms/#pro)

== Source Code ==

The human-readable source for this plugin's minified JavaScript and compiled CSS is published at [https://github.com/coreyt808/webheadcoder-multi-step-forms-for-contact-form-7](https://github.com/coreyt808/webheadcoder-multi-step-forms-for-contact-form-7), with the unminified files in `assets-src/`. To rebuild the generated files in `resources/`, use Node.js 24 and run `composer install`, `npm ci`, and `npm run deploy`.
 
== External services ==

This plugin uses Freemius, an external service, for optional usage tracking and opt-in, licensing, account management, pricing, and purchase or upgrade functions. Freemius receives and processes information used for these functions. The free plugin remains usable if an administrator chooses "Skip" on the Freemius opt-in screen.

If an administrator opts in, the plugin can send the opted-in administrator's first name, last name, and email address; the plugin's version and state; the WordPress and PHP versions; the site language and website URL; and, when the administrator separately allows it, the list of installed plugins and themes.

Activating and maintaining a paid license sends the license and site or product information needed for license activation, account management, and update checks. A pricing or checkout connection is initiated only after an administrator explicitly selects a plugin-provided Upgrade or Purchase link and proceeds through the Freemius SDK-managed flow.

Learn more about [Freemius](https://freemius.com/), its [opt-in behavior](https://freemius.com/help/documentation/wordpress-sdk/features/opt-in-screen/), and its [data practices](https://freemius.com/privacy/data-practices/). Use of the service is subject to the [Freemius Terms of Service](https://freemius.com/terms/) and [Privacy Policy](https://freemius.com/privacy/).

== Frequently Asked Questions ==

= The Next button doesn't show up =
You still need a standard Contact Form 7 submit button on each step.

Add a submit tag like this:
`[submit "Next"]`

Also note: `multistep` is a hidden field. If content appears to disappear right after it, place the tag at the end of the form (or add a line break after it).

= I keep getting the "Please fill out the form on the previous page" message.  What's wrong? =
This message usually means step-tracking data is missing. Check these first:

1. Caching is blocking cookies. Exclude cookies named `cf7*` from cache behavior.
2. Form step URLs do not match protocol or domain. Every step must use the same domain and protocol. For example, if your first page uses `https://webheadcoder.com`, your second page cannot use `http://` or a subdomain.
3. The first form is missing `first_step` in its multistep tag, for example:
`[multistep multistep-123 first_step "/your-next-url/"]`

= Why are no values being passed from one form to the next form? =
If the page reloads on submit instead of using AJAX, Contact Form 7 JavaScript is not running correctly or the REST API is disabled.

Use Contact Form 7's troubleshooting guide:
[https://contactform7.com/why-isnt-my-ajax-contact-form-working-correctly/](https://contactform7.com/why-isnt-my-ajax-contact-form-working-correctly/)


= How can I show a summary of what the user entered or show fields from previous steps? =

`[multiform "your-name"]`  
Use the `multiform` tag to display values captured on earlier steps. Replace `your-name` with your field name.

= My form values aren't being sent in the email.  I get [multiform "your-name"] instead of the actual person's name. =
`multiform` is for the Form tab only.

For email content in the Mail tab, use standard CF7 mail-tags such as `[your-name]`, not `[multiform "your-name"]`.

Also confirm the last step includes the `multistep` tag.

= Can I have an email sent on the first step of the multi-step forms? =
Yes. Enable "Send Email" in the tag generator, or add `send_email` directly in the tag:
`[multistep multistep-123 first_step send_email "/your-next-url/"]`

= My forms are not working as expected.  What's wrong? =
Start with these checks:

- Confirm every step includes a `multistep` tag.
- Look for JavaScript errors from other plugins or themes that may block CF7 scripts.
- Temporarily deactivate other plugins and test again to isolate conflicts.

= Why "place your cursor at the end of the form" before inserting the multistep tag? =
`multistep` is a hidden field and intentionally adds minimal spacing. If another element is placed immediately after it, that element may appear hidden.

To avoid this, insert `multistep` at the end of the form or add a line break after the tag.

= How do I get Flamingo or CFDB7 to not save every form? =
Use the "Skip Save" option, or add `skip_save` in your multistep tag:
`[multistep multistep-123 skip_save "/your-next-url/"]`

= When checkbox fields are left unchecked they appear as [field-name] in the email.  How do I resolve this? =
Unchecked checkboxes are not submitted, so the final step may not know that field exists.

Add a hidden field with the same name on the last step, for example:
`[hidden field-name]`

This ensures the final step submits either the saved value or a blank value.

== Changelog ==

= 4.7 - August 2026 =
* renamed plugin for WordPress.org plugin compliance.  
* deprecated php sessions and restricted it from always loading.  
* cleaned up internationalization.  
* isolated freemius checkout.  
* added readable source link.  
* added option verification on server side.  
* added capability checks to the admin ajax handlers.  
* hardened pipe flow ids so new flows always get a server generated id.  
* escaped output of the field name in the PRO version.  

= 4.6.2 - July 2026 =
* added compatibility with Honeypot for Contact Form 7 and WP Armour so generated honeypot fields don't persist between steps.
* updated Freemius.  

= 4.6.1 - April 2026 =
* updated Freemius.  

= 4.6 - February 2026 =
* added capability to do pipes in dropdowns.  
* updated Freemius.  

= 4.5 - October 2025 =
* updated scopes to resolve conflicts with other themes and plugins.  
* removed getObject and setObject override in SessionStorage to avoid conflicts.  
* fixed free_text in checkbox and radios showing on every value.

= 4.4.4 - September 2025 =
* Internal build system updates
* updated to encapsulate code better and reduce plugin and theme conflicts.  
* fixed minor issues

= 4.4.3 - September 2025 =
* updated Freemius.  
* fixed form population when browser back button used.  

= 4.4.2 - January 2025 =
* updated Freemius.  

= 4.4.1 - November 2024 =
* fixed error when cookie has an array in it.  
* updated tag generator to be compatible with CF7 6.0.  
* updated Freemius.  

= 4.4 - May 2024 =
* fixed checkbox and radio free text not saving between forms.  
* Upped minimum CF7 version to 5.2.  
* updated Freemius.  

= 4.3.1 - July 2023 =
* fixed PHP warning.  
* updated Freemius.  

= 4.3 - June 2023 =
* added multiform form tags to Mail tab.  Thanks to @tkc49!  
* updated Freemius.  

= 4.2.1 - April 2023 =
* fixed PHP warning.  
* updated checkboxes to trigger the checked event when form is repopulated.  

= 4.2 - January 2023 =
* fixed multiform tags for CF7 5.7.3.  
* changed "form field" tag generator name to "multiform".  
* updated Freemius.  

= 4.1.92 - May 2022 =
* fixed values not saving across steps on Safari browsers.  

= 4.1.91 - March 2022 =
* updated Freemius to v2.4.3.  

= 4.1.9 - December 2021 =
* updated logo images to be within the plugin to comply with WordPress requirements.  

= 4.1.8 - December 2021 =
* security update:  HTML is now escaped when being output using the multiform tag.  Additional sanitization changes.  

= 4.1.7 - August 2021 =
* fixed next url to support external urls.  

= 4.1.6 - July 2021 =
* fixed conditional fields not trigerring after form population.  
* fixed 500 error due to conflict with Conditional Fields plugin expecting an array in cookie values.  

= 4.1.5 - April 2021 =
* fixed prev button not showing up when next url from previous form has a querystring in it.  
* fixed issue with cookie being set on non-multistep forms.  
* PRO: added compatibility for repeaters in Conditional Fields Pro.  

= 4.1.4 - March 2021 =
* fixed error when caching is enabled.  

= 4.1.2 - February 2021 =
* updated version to bust cache.  

= 4.1.1 - February 2021 =
* updated for CF7 5.4.
* updated freemius.  

= 4.1 - December 2020 =
* added sanitization similar to the core CF7 plugin.  

= 4.0.9 - November 2020 =
* updated freemius.  

= 4.0.8 - October 2020 =
* fixed values being saved when form submission is invalid.  

= 4.0.7 - August 2020 =
* fixed success message showing when not on the last step due to a change in Contact Form 7 v5.2.1.  
* added Skip Save for Advanced Contact form 7 DB plugin.  Thanks to @undersound.   

= 4.0.6 - June 2020 =
* PRO: fixed fields not going through when form ids were not in the right order.  

= 4.0.5 - May 2020 =
* PRO: fixed checkboxes not being passed on to next form.  

= 4.0.4 - May 2020 =
* PRO: fixed fields showing up out of order when viewed in Flamingo (part 2).  

= 4.0.3 - May 2020 =
* PRO: fixed fields showing up out of order when viewed in Flamingo.  

= 4.0.2 - March 2020 =
* fixed get_magic_quotes_gpc() deprecated warning when running PHP 7.4.  
* fixed slashes appearing in free version
* fixed previous button not showing when the multiform tag's next url doesn't match the page url because of a trailing slash.
* added a filter to fallback to sessions.  

= 4.0.1 - January 2020 =
* fixed issue where the multistep cookie was being set on non multistep forms.  

= 4.0 - December 2019 =
In Version 4.0 the format of the multistep form-tag has changed dramatically.  The old format is backwards compatible and will still work until January 2021.  Beyond that the old format is not guaranteed to work with newer versions.  More Info:  [https://webheadcoder.com/contact-form-7-multi-step-forms-update-4-0/](https://webheadcoder.com/contact-form-7-multi-step-forms-update-4-0/)

* added new multiform form-tag format to allow for options to send email and not save to database.  
* added customizable error on the Messages tab.  
* added admin notice to notify user of large form submissions.
* PRO: added compatibility to skip steps with the CF7 Conditional Fields plugin.  

= 3.2 - November 2019 =
* added review notice to get to know how users like this plugin.  
* fixed WP warning when CF7 is not installed.  
* updated freemius.

= 3.1.2 - September 2019 =
* added ability to skip over steps if it was previously submitted.  

= 3.1.1 - July 2019 =
* updated freemius.  

= 3.1 - April 2019 =
* fixed issue where CF7 MSM files still loaded even when WPCF7_LOAD_JS is set to false.  
* fixed success message not showing for forms with a wrapping inner element.
* fixed multi-select population.  
* updated how select is set so it can trigger javascript changes.  

= 3.0.9 - February 2019 =
* fixed issue where WPCF7_LOAD_JS is set to false and resulted in 302 error.  thanks to @zetoun17.
* security fix  

= 3.0.8 - July 2018 =
* added missing freemius files  

= 3.0.7 - July 2018 =
* updated freemius

= 3.0.6 - April 2018 =
* PRO: fixed "Cannot use a scalar value as an array" warning when CF7 Conditional Fields plugin is active.  

= 3.0.5 - April 2018 =
* PRO: fixed compatibility with Contact Form 7 Conditional Fields plugin to only show group that is supposed to show.  

= 3.0.4 - March 2018 =
* deprecated wpcf7_form_field_value filters.  
* added cf7msm_form_field_value filters.  

= 3.0.3 - February 2018 =
* PRO: fixed conditional fields (from the Conditional Fields for Contact Form 7 plugin) not showing in email.  

= 3.0.2 - February 2018 =
* fixed quotes in values causing errors.  
* added plugin action links.  

= 3.0.1 - January 2018 =
* fixed session storage not clearing after final step was submitted.  
* fixed form not hiding after final step was submitted.  Thanks to @tschodde.  

= 3.0 - December 2017 =
* changed internal field names to be prefixed with cf7msm.  
* added PRO version to handle long forms.  
* fixed minor issues.  

= 2.26 - December 2017 =
* updated i18n code.  

= 2.25 - September 2017 =
**Contact From 7 version 4.8 or above is required for this version**.  
* fixed incompatible JSON_UNESCAPED_UNICODE for PHP versions < 5.4.  

= 2.24 - September 2017 =
**Contact From 7 version 4.8 or above is required for this version**.  
* fixed not redirecting to next step on older iPad browsers.  
* fixed illegal offset exception warning.  
* added JSON_UNESCAPED_UNICODE for czech language.  

= 2.23 - June 2017 =
**Contact From 7 version 4.8 or above is required for this version**.  
* fixed back button on firefox.  
* fixed url not displaying correctly when it has the & symbol.  

= 2.22 - June 2017 =
**Contact From 7 version 4.8 or above is required for this version**.  
* fixed back button going back more than one step.  

= 2.21 - June 2017 =
**Contact From 7 version 4.8 or above is required for this version**.  
* fixed an issue where a notice occurred when using scan_form_tags on servers that displayed PHP notices.  


= 2.2 - June 2017 =
**Contact From 7 version 4.8 or above is required for this version**.  
* fixed back button not working when using with Contact Form 7 version 4.8.  
* fixed fields from previous steps not showing up when using with Contact Form 7 version 4.8.  
Thanks to @eddraw, updated deprecated functions.  

= 2.1 - March 2017 =
* Use Contact Form 7's built-in hidden form tag if version 4.6 or above is present.  

= 2.0.9 - March 2017 =
* fixed issue where using the `[multiform]` tag causes the field to blank out and not show in emails on certain servers.  


= 2.0.8 - February 2017 =
* added field_name and value to wpcf7_form_field_value filter.  


= 2.0.7 - January 2017 =
* fixed calls to deprecated CF7 functions.
* Increased minimum WP version to match CF7's specs.  


= 2.0.6 - December 2016 =
* Thanks to @eddraw for the updates!  
* added translation: add pot file.  
* fixed translation: use the name of the plugin as textdomain and load it.  


= 2.0.5 - September 2016 =
* added form id to wh_hide_cf7_step_message filter.  


= 2.0.4 - July 2016 =
* fixed plugin conflict.  


= 2.0.3 - May 2016 =
* fixed issue where server variables may not be defined.  added some support for strings to be translatable.  


= 2.0.2 - February 2016 =
* Fix previous button not showing class attribute.  


= 2.0.1 - February 2016 =
* Minor fix to detecting if previous form was filled.  


= 2.0 - February 2016 =
* Added Form Tags to Form Tag Generator.  No more needing to update the Additional Settings tab.  
* Added error alert when form is too large.  
* Fixed Deprecated: preg_replace() error message.  
* Fixed certain instances where the "Please fill out the form on the previous page" messages displayed unexpectedly.
* Fixed issue where it was possible to type in the url of the next step after receiving validation errors on the current step.  


= 1.6 - December 2015 =
* Added support for when contact form 7 ajax is disabled.

= 1.5 - December 2015 =
* Added support for free_text in checkboxes and radio buttons.

= 1.4.4 - November 2015 =
* fix empty checkboxes causing javascript error when going back.

= 1.4.3 - December 2014 =
* fix exclusive checkboxes not saving on back.  added version to javascript.

= 1.4.2 - December 2014 =
* fix radio button not saving on back. make sure its the last step before clearing cookies.

= 1.4.1 - November 2014 =
* Fixed bug where tapping the Submit button on the final step submits form even with validation errors.

= 1.4 - July 2014 =
* Updated to be compatible with Contact Form 7 version 3.9.

= 1.3.6 - November 2013 =
* Updated readme to be more readable.
* Fixed issue for servers with magic quotes turned off.  Fixes "Please fill out the form on the previous page" error.

= 1.3.5 - October 2013 =
* Fix:  Also detect contact-form-7-3rd-party-integration/hidden.php so no conflicts arise if both are activated.

= 1.3.4 - October 2013 =
* Fix:  Better detection of contact-form-7-modules plugin so no conflicts arise if both are activated.

= 1.3.3 - September 2013 =
* Fixed back button functionality.

= 1.3.2 - August 2013 =
* Some people are having trouble with cookies.  added 'cf7msm_force_session' filter to force to use session.

= 1.3.1 - August 2013 =
* Added checks to prevent errors when contact form 7 is not installed.

= 1.3 - August 2013 =
* Confused with the version numbers.  apparently 1.02 is greater than 1.1?

= 1.1 - August 2013 =
* renamed all function names to be more consistent.
* use cookies before falling back to session.
* added back shortcode so users can go back to previous step.

= 1.02 - April 2013 =
* updated version numbers.

= 1.01 - April 2013 =
* updated readme.

= 1.0 - April 2013 =
* Initial release.
