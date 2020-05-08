<?php
/**
 * Relationship Editor plugin for Craft CMS 3.x
 *
 * Allows element relationships to be modified from the front-end without re-submitting all selections.
 *
 * @link      https://confluxgroup.com
 * @copyright Copyright (c) 2018 Conflux Group, Inc.
 */

namespace confluxgroup\relationshipeditor;


use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;

/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 *
 * @author    Conflux Group, Inc.
 * @package   RelationshipEditor
 * @since     1.0.0
 *
 */
class RelationshipEditor extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * Static property that is an instance of this plugin class so that it can be accessed via
     * RelationshipEditor::$plugin
     *
     * @var RelationshipEditor
     */
    public static $plugin;

    /**
     * @var bool
     */
    public static $craft30 = false;

    // Public Properties
    // =========================================================================

    /**
     * To execute your plugin’s migrations, you’ll need to increase its schema version.
     *
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * Set our $plugin static property to this class so that it can be accessed via
     * RelationshipEditor::$plugin
     *
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

         self::$craft30 = version_compare(Craft::$app->getVersion(), '3.1', '<=');
        
    }

    // Protected Methods
    // =========================================================================

}
