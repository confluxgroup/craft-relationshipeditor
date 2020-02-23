# Relationship Editor plugin for Craft CMS 3.x

Allows element relationships to be modified from the front-end without re-submitting all selections.

Relationship Editor works with Entries, Users, Categories and Assets.

## Requirements

This plugin requires Craft CMS 3.0.0 or later.

## Installation

To install Relationship Editor, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require confluxgroup/craft-relationshipeditor

3. Install the plugin via `./craft install/plugin relationshipeditor` via the CLI, or in the Control Panel, go to Settings → Plugins and click the “Install” button for Relationship Editor.

You can also install Relationship Editor via the **Plugin Store** in the Craft Control Panel.

## Relationship Editor Overview

Craft CMS has powerful features to create and edit entries via frontend templates. However, editing element reltionship fields such as Entries, Users, Categories, and Tags fields can be tricky, since they will only save the related elements submitted in the request, so your frontend templates need to resubmit all of the previously-selected elements, making for more complicated frontend templates.

Relationship Editor provides a new action specifically for adding and removing elements from an element relationship field without having to resubmit all of the existing selections. 

You can use Relationship Editor to allow users to create wishlists, or other collections of elements quickly and easily in your frontend templates. The plugin respects the same editing permissions as Craft's native front end entry forms.

## Using Relationship Editor

Using Relationship Editor is simple. Just build a simple form in your Twig template. 

The `elementId` and `fieldHandle` fields are required as well as either `addIds` or `removeIds` which can be either a single field with a single element ID, or an array of multiple IDs.

```twig
<form method="post" accept-charset="UTF-8">
    {{ csrfInput() }}
    <input type="hidden" name="action" value="relationshipeditor/save">
    {{ redirectInput('path/to/redirect') }}
    
    {# the element containing the relationship you want to edit #}
    <input type="hidden" name="elementId" value="{{ yourElement.id }}">
    
    {# the handle of the relationship field you want to edit #}
    <input type="hidden" name="fieldHandle" value="relationshipFieldName">

    {# use an addIds field to indicate the element
    that should be added to the relationship #}
    <input type="hidden" name="addIds" value="123">

    {# use an addIds field as an array to indicate multiple elements
    that should be added to the relationship #}
    <input type="hidden" name="addIds[]" value="123">
    <input type="hidden" name="addIds[]" value="456">
    
    {# use an removeIds field to indicate the element
    that should be removed from the relationship #}
    <input type="hidden" name="removeIds" value="123">

    {# use an removeIds field as an array to indicate multiple elements
    that should be removed from the relationship #}
    <input type="hidden" name="removeIds[]" value="123">
    <input type="hidden" name="removeIds[]" value="456">

    <button type="submit">Submit</button>
</form>
```

Brought to you by [Conflux Group, Inc.](https://confluxgroup.com)
