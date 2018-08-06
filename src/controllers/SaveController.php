<?php
/**
 * Relationship Modifier plugin for Craft CMS 3.x
 *
 * Allows element relationships to be modified from the front-end without re-submitting all selections.
 *
 * @link      https://confluxgroup.com
 * @copyright Copyright (c) 2018 Conflux Group, Inc.
 */

namespace confluxgroup\relationshipeditor\controllers;

use confluxgroup\relationshipeditor\RelationshipEditor;

use Craft;
use craft\web\Controller;
use craft\elements\Entry;
use craft\elements\Category;
use craft\elements\User;
use craft\elements\Asset;
use craft\web\Response;

/**
 * Save Controller
 *
 * @author    Conflux Group, Inc.
 * @package   RelationshipEditor
 * @since     1.0.0
 */
class SaveController extends Controller
{
    // Prevent anonymous access to the controller
    protected $allowAnonymous = false;

    public function actionIndex()
    {
        $this->requirePostRequest();
        
        $request = Craft::$app->getRequest();
        
        // get all the post variables
        $elementId = $request->getBodyParam('elementId');
        $fieldHandle = $request->getBodyParam('fieldHandle');
        $addIds = $request->getBodyParam('addIds');
        $removeIds = $request->getBodyParam('removeIds');

        // based on the element and field post vars, get the models for each
        $element = Craft::$app->elements->getElementById($elementId);
        $field = Craft::$app->fields->getFieldByHandle($fieldHandle);

        // Ensure user has access to edit this site
        if (Craft::$app->getIsMultiSite()) {
            $this->requirePermission('editSite:'.$element->siteId);
        }

        // Enforce element type specific permissions
        switch( get_class($element) )
        {
            case Entry::class:
                $this->_enforceEditEntryPermissions($element);
                break;
            case Category::class:
                $this->_enforceEditCategoryPermissions($element);
                break;
            case User::class:
                $this->_enforceEditUserPermissions($element);
                break; 
            case Asset::class:
                $this->_enforceEditAssetPermissions($element);
                break;
            default:
                return;            
        }

        // store the current ids
        $currentIds = $element->{$field->handle}->ids();

        // Do we have IDs to add?
        if(!empty($addIds))
        {
           // merge the add ids into the current ids
            $newIds = array_merge($currentIds, (array) $addIds); 
        }
        // Do we have IDs to remove?
        elseif(!empty($removeIds))
        {
            // remove the remove ids from the array
            $newIds = array_diff($currentIds, (array) $removeIds);
        }

        // save the new array of ids
        Craft::$app->relations->saveRelations($field, $element, $newIds);

        // return json if ajax request
        if ($request->isAjax) {
            Craft::$app->response->statusCode = 200;

            $response = Craft::$app->response;
            $response->format = Response::FORMAT_JSON;
            $response->data = [
                'success' => true,
                'message' => 'Relationship updated.'
            ];

            return $response;
        }

        // redirect
        $this->redirectToPostedUrl();
    }

    /**
     * Enforces Edit Category permissions.
     *
     * @param Category $category
     *
     */
    private function _enforceEditCategoryPermissions(craft\elements\Category $category)
    {
        // Make sure the user is allowed to edit categories in this group
        $this->requirePermission('editCategories:'.$category->groupId);
    }

    /**
     * Enforces Edit User permissions.
     *
     * @param User $user
     *
     */
    private function _enforceEditUserPermissions(craft\elements\User $user)
    {
        // If the user is trying to edit a user other than their own,
        // make sure they have permission to edit other users
        if (!$user->getIsCurrent()) {
            $this->requirePermission('editUsers');
        }
    }

    /**
     * Enforces Edit Entry permissions.
     *
     * @param Entry $entry
     *
     */
    private function _enforceEditEntryPermissions(craft\elements\Entry $entry)
    {
        $permissionSuffix = ':'.$entry->sectionId;
        $currentUser = Craft::$app->getUser()->getIdentity();

        // Require user to have permissions to edit this section
        $this->requirePermission('editEntries' . $permissionSuffix);

        // If it's another user's entry (and it's not a Single), make sure they have permission to edit those
        if (
            $entry->authorId != $currentUser->id &&
            $entry->getSection()->type !== 'Single'
        ) {
            $this->requirePermission('editPeerEntries' . $permissionSuffix);
            $this->requirePermission('publishPeerEntries:' . $permissionSuffix);
        }
    }

    /**
     * Enforces Edit Asset permissions.
     *
     * @param Asset $asset
     *
     */
    private function _enforceEditAssetPermissions(craft\elements\Asset $asset)
    {
        $this->requirePermission('saveAssetInVolume:'.$asset->volumeId);
    }
}
