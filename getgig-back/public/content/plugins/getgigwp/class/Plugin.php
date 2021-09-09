<?php

namespace getgigwp;

use getgigwp\Messages;

class Plugin
{
    public function __construct()
    {
        // =============================================== //
        // ========= CREATING CUSTOM POST TYPES ========= //
        // ============================================= //
        // creating the annoucements cpt hook to execute function into construct
        add_action(
            'init',
            [$this, 'createAnnouncementPostType']
        );
        // creating the announcements types custom taxonomy hook to execute function into construct
        add_action(
            'init',
            [$this, 'createAnnouncementType']
        );
        // =============================================== //
        // ========= CREATING NEW ROLES TO BACK ========= //
        // ============================================= //
        add_role(
            'custom_editor',
            ("Custom Role Test"),
            array(
                'read' => true,  // true allows this capability
                'edit_posts' => true,
            )
        );
        add_role(
            'artist',
            ("Artiste"),
            array(
                'read' => true,  // true allows this capability
                'edit_posts' => true,
            )
        );
        add_role(
            'organizer',
            ("Organisateur"),
            array(
                'read' => true,  // true allows this capability
                'edit_posts' => true,
            )
        );
    }

    public function activate()
    {
        $model = new Messages();
        $model->createTable();
    }
    
    public function deactivate()
    {
        $model = new Messages();
        $model->dropTable();
    }
    
    public function createAnnouncementPostType() // Custom Post Type Creation
    {
        register_post_type(
            'announcements', //!
            // second argument les options pour configurer le post type
            [
                'label' => 'announcements', //!
                // option public true : le cpt est administrable dans le backoffice
                'public' => true,
                'hierarchical' => false,
                'menu_icon' => 'dashicons-hammer', //!
                // NOTICE WP PLUGIN, fonctionnalités activable poure un cpt :  ‘title’, ‘editor’, ‘comments’, ‘revisions’, ‘trackbacks’, ‘author’, ‘excerpt’, ‘page-attributes’, ‘thumbnail’, ‘custom-fields’, and ‘post-formats’.
                'show_in_rest'  => true,
                'supports' => [
                    'title',
                    'thumbnail', //! add_theme_support( 'post-thumbnails' ); dans themes/includes/theme-config.php
                    'editor',
                    // 'comments',
                    // 'revisions', //!
                    // 'trackbacks',
                    'author',
                    'excerpt',
                    // 'page-attributes',
                    'custom-fields', //Champ de lien entre ACF et le CPT
                    // 'post-formats' //!
                ]
            ]
        );
    }

    public function createAnnouncementType()
    {
        register_taxonomy(
            'Type',
            ['announcements'], // the Custom Post Type linked to the taxonomy
            [
                'label'         => 'Announcement Type',
                'hierarchical'  => true,
                'public'        => true,
                'show_in_rest'  => true,
                'supports'      => ['title']
            ]
        );
    }
}
