# Tingle Form Plugin

The **Tingle Form** Plugin is for [Grav CMS](http://github.com/getgrav/grav). A standard GRAV form is included inside a tingle modal popup. Click on a button (created with a shortcode) and the form pops up. If a submit button is pressed on the form, it will be processed and the form disappears.

## Installation

Installing the Tingle Form plugin can be done in one of two ways. The GPM (Grav Package Manager) installation method enables you to quickly and easily install the plugin with a simple terminal command, while the manual method enables you to do so via a zip file.

### GPM Installation (Preferred)

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's terminal (also called the command line).  From the root of your Grav install type:

    bin/gpm install tingle-form

This will install the Tingle Form plugin into your `/user/plugins` directory within Grav. Its files can be found under `/your/site/grav/user/plugins/tingle-form`.

### Manual Installation

To install this plugin, just download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `tingle-form`. You can find these files on [GitHub](https://github.com/finanalyst/grav-plugin-tingle-form) or via [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/tingle-form

> NOTE: This plugin is a modular component for Grav which requires [Grav](http://github.com/getgrav/grav) and the [Error](https://github.com/getgrav/grav-plugin-error), [Form](https://github.com/getgrav/grav-plugin-form) and [Problems](https://github.com/getgrav/grav-plugin-problems) plugins to operate.

### Admin Plugin

If you use the admin plugin, you can install directly through the admin plugin by browsing the `Plugins` tab and clicking on the `Add` button.

## Configuration

Before configuring this plugin, you should copy the `user/plugins/tingle-form/tingle-form.yaml` to `user/config/plugins/tingle-form.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
```

Note that if you use the admin plugin, a file with your configuration, and named tingle-form.yaml will be saved in the `user/config/plugins/` folder once the configuration is saved in the admin.

## Usage

A standard `default.md` file (eg., as defined for the Quark theme) can be used. A form is defined in the page header (or elsewhere, see Form plugin documentation). The `[popup-form]` shortcode is placed in the content file, which creates a button that when clicked pops up the form content in a modal window.

### Shortcode and options
`[popup-form form=<formname> <other options>]<Button text>[/popup-form]`  
The parameter and options are:
1. **Button text** is the label to be placed on the popup button. It defaults to 'Click for form'.
1. `form` - This is mandatory and is the name of the form to be wrapped in the modal. If no `form` option is present, an error div is generated.
1. `closeText` - an option for the Tingle code. It labels the close button for a mobile. On a PC the value is 'x'. Defaults to 'Close'.
1.  `classes` - a string containing a comma delimited sequence of strings. Each sub-string is a class that will be added to the `div` wrapping the modal. It offers a way of customising the css.
1. `btnClass` - This string is added to the `class` attribute of the `button` calling the popup. It defaults to 'btn', which is the generic button class for the `Quark` theme.

The form is defined as given by the Form plugin documentation. It should contain at least one `Submit` button. When a `Submit` button is clicked, the form action is initiated and the form is removed.

## Example
This is the content of **user/pages/10.tingleform/default.md** file with a `Button` to popup a form defined in the file.
```
---
title: TingleForm
forms:
    APopupForm:
        action: /tingleform
        fields:
            - name: subject
              type: text
              label: Subject of message
              placeholder: Write your subject here
            - name: return
              type: email
              label: Return email address
              validate:
                required: true
                message: Please include a return address
            - name: content
              label: Content of the message
              type: textarea
              placeholder: Say something nice
              validate:
                required: true
                message: You have not sent a message
        buttons:
            - type: Submit
              value: Send this Email
            - type: Reset
              value: Reset the form
        process:
            - save:
                fileprefix: contact-
                dateformat: Ymd-His
                extension: txt
                body: "{% include 'forms/data.txt.twig' %}"
            - reset: true
---
# A page with a button

[popup-form form=APopupForm classes=" 'myclass1', 'myclass2' "]Click on Me[/popup-form]

```
### Notes

1. This example contains functionality described in the Form plugin. If an email is required, then the Email plugin needs to be installed.
1. The `form` parameter is mandatory and is the name of the **Form** defined in the frontmatter.
1. The optional `classes` parameter contains a string that is provided without filtering to the `tingle` **cssClass** parameter, which expects comma deliminated sequence of strings. Consequently it must be in the from `" 'class1' [ , 'class2'] "`. These classes are added to the `tingle` `div`.
1. If validation is required, and GRAV returns the form with a `<div class="toast-error">` containing validation error messaging, then the `tingle` form will be popped up automatically.

### Modular pages.

This plugin works with modular pages. The following is the content of `user/pages/08.modular/05._tingleitem/text.md` (using the Quark theme)
```
---
title: TingleItem
forms:
    APopupForm:
        action: /modular#tingleitem
        fields:
            - name: subject
              type: text
              label: Subject of message
              placeholder: Write your subject here
            - name: return
              type: email
              label: Return email address
              validate:
                required: true
                message: Please include a return address
            - name: content
              label: Content of the message
              type: textarea
              placeholder: Say something nice
              validate:
                required: true
                message: You have not sent a message
        buttons:
            - type: Submit
              value: Send this Email
            - type: Reset
              value: Reset the form
        process:
            - save:
                fileprefix: contact-
                dateformat: Ymd-His
                extension: txt
                body: "{% include 'forms/data.txt.twig' %}"
            - reset: true
---
# A page with a button

[popup-form form=APopupForm]Click on Me[/popup-form]
```
### Notes
1. The `action` field in the form is critical. It is 'modular' because that is the name of the route.
1. `#tingleitem` may be omitted, in which case after the form has been processed and disappears, the focus will return to the top of the modular page. By including `#tingleitem`, which is defined by the route associated with the text.md file, the focus returns to the position of the tingle-form on the page.

## Credits

- Robin Parisi, the [tingle](https://robinparisi.github.io/tingle/) developer.
- krzysztofgal, who wrote the [GravGdprPrivacySetupPlugin](https://github.com/krzysztofgal/GravGdprPrivacySetupPlugin), for inspiration.

## To Do
