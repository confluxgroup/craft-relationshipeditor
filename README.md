# Relationship Editor plugin for Craft CMS 3.x

Allows element relationships to be modified from the front-end without re-submitting all selections.

Relationship Editor works with Entries, Users, Categories and Assets.

## Requirements

This plugin requires Craft CMS 3.0.0 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require /relationshipeditor

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Relationship Modifier.

## Relationship Editor Overview

-Insert text here-

## Using Relationship Editor

```twig
<form method="post" accept-charset="UTF-8">
    {{ csrfInput() }}
    <input type="hidden" name="action" value="relationshipeditor/save">
    {{ redirectInput('path/to/redirect') }}
    
    {# the element containing the relationship you want to edit #}
    <input type="hidden" name="elementId" value="{{ yourElement.id }}">
    
    {# the handle of the relationship field you want to edit #}
    <input type="hidden" name="fieldHandle" value="relationshipFieldName">

    {# use an addIds field or multiple fields to indicate elements
    that should be added to the relationship #}
    <input type="hidden" name="addIds" value="123">
    
    {# use an removeIds field or multiple fields to indicate elements
    that should be removed from the relationship #}
    <input type="hidden" name="removeIds" value="123">

    <button type="submit">Submit</button>
</form>
```

## Relationship Editor Roadmap

Some things to do, and ideas for potential features:

* Release it

Brought to you by [Conflux Group, Inc.](https://confluxgroup.com)
